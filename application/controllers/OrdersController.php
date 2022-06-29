<?php

require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  OrderModel OrderModel
 * @property  ServiceModel ServiceModel
 * @property  SmsModel SmsModel
 */
class OrdersController extends CI_Controller
{

	public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
		$this->load->model("SampleCollectorModel");
    }

	public function index()
	{
		// $this->load->view('welcome_message');
	}

	public function serviceOrder($service_id,$rescheduleData = '')
	{
		if (!isset($service_id)) {
			redirect("/");
		}
		delete_cookie('unauthorized-service-order');
		$this->load->model("ServiceModel");
		$resultObject = $this->ServiceModel->getServiceDetails($service_id);
		$data = array("service_id" => $service_id);
		if ($resultObject->totalCount === 1) {
			$service_name = $resultObject->data->service_name;
			$actual_price = $resultObject->data->service_rate;
			$discount_price = $resultObject->data->discount;
			$sale_price = $resultObject->data->sale_price;
			$data["service_name"] = $service_name;
			$data["service_rate"] = $actual_price;
			$data["service_discount"] = $discount_price;
			$data["service_sale"] = $sale_price;
		}

		if ($rescheduleData !=''){
			$data['e_patient_name'] = $rescheduleData->patient_name;
			$data['e_patient_number'] = $rescheduleData->patient_number;
			$data['e_location'] = $rescheduleData->location;
			$data['e_schedule_date'] = $rescheduleData->schedule_date;
			$data['e_schedule_time'] = $rescheduleData->schedule_time;
			$data['e_orderPid'] = $rescheduleData->id;
			$data['e_userId'] = $rescheduleData->patient_id;
			$data['action'] = 'edit';
		}else{
			$data['e_patient_name'] = '';
			$data['e_patient_number'] = '';
			$data['e_location'] = '';
			$data['e_schedule_date'] = '';
			$data['e_schedule_time'] = '';
			$data['e_orderPid'] = '';
			$data['e_userId'] = '';
			$data['action'] = 'add';
		}

		$this->load->view('order/serviceOrder', $data);
	}

	public function covidPCRHome()
	{
		$this->load->view('service/covid');
	}

	public function basicHealthTest()
	{
		$this->load->view('service/basic_health_test');
	}

	public function completeHealthTest()
	{
		$this->load->view('service/complete_health_test');
	}

	public function lenLenTest()
	{
		$this->load->view('service/len_len_test');
	}


	public function placeOrder()
	{
		$myOrderSession = array();
		$myOrder = new stdClass();
		$myOrder->patient_name = $this->input->post('patient_name');
		$myOrder->patient_number = $this->input->post('patient_number');
		$myOrder->service_id = $this->input->post('hdnServiceId');
		$myOrder->service_name = $this->input->post('hdnServiceName');
		$myOrder->service_price = $this->input->post('hdnServicePrice');
		$myOrder->service_discount = $this->input->post('hdnServiceDiscount');
		$myOrder->service_sale_price = $this->input->post('hdnServiceSalePrice');
		$myOrder->schedule_time = $this->input->post('pic_schedule_time_h');
		$myOrder->schedule_date = $this->input->post('pic_schedule_date_h');
		$myOrder->schedule_full_date = $this->input->post('pic_schedule_full_date_h');
		$myOrder->location = $this->input->post('serviceBookingLocation');
		if (!($this->session->user_session)) {
			array_push($myOrderSession, $myOrder);
			$this->session->page_session = $myOrderSession;
			set_cookie("unauthorized-service-order",$myOrder->service_id,84000,'',"/");
			$response['userLogStatus'] = 0;
			$response["status"] = 201;
		} else {
			$cartSession = $this->session->cart_session;
			if (is_array($cartSession)) {
				foreach($cartSession as $key => $value) {
					if ($value->location != $myOrder->location) {
						array_splice($cartSession, $key);
					}
				}
				array_push($cartSession, $myOrder);
			} else {
				$cartSession = array($myOrder);
			}
			$this->session->cart_session = $cartSession;
			$setSession = 'set';
			$response['userLogStatus'] = 1;
			$response["status"] = 200;
		}
		$response["data"] = $myOrderSession;
		echo json_encode($response);
	}

//	public function insertOrder()
//	{
//		$patientId = $this->session->user_session->id;
//		$payment_mode = $this->input->post('paymentMode');
//		$address_id = $this->input->post('address_id');
//
//
//		$order_id = 'ORD-000001';
//		$last_id = $this->OrderModel->getLastOrder('SELECT order_id from order_master order by id desc limit 1');
//		$userAddress = $this->OrderModel->getUserAddress('SELECT * from customer_address where user_id = ' . $patientId);
//
//		$userAddressDetails = $userAddress->data[0];
//
//		$orderIdString = $last_id->data[0]->order_id;
//		$orderArr = array();
//
//		$grouped_types = array();
//
////		foreach($this->session->cart_session as $type){
////			$grouped_types[$type['type']][] = $type;
////		}
//
//		if (!empty($last_id->data[0])) {
//			$arrOrderString = explode("-", $orderIdString);
//			$number = (int)$arrOrderString[1] + 1;
//			$n2 = str_pad((int)$arrOrderString[1] + 1, 5, 0, STR_PAD_LEFT);
//			$order_id = 'ORD-' . ($n2);
//		}
//		$orderDataQuery = 'select om.*,sm.service_name,sm.service_rate,sm.service_type,rm.ts_code,rm.ts_desc,rm.tc_code,rm.result,rm.ref,rm.flag,rm.unit from order_master om join serveices sm on sm.id = om.service_id join report_master rm on rm.order_id = om.id where om.order_id = "' . $order_id . '" and om.patient_id = ' . $patientId;
//		$OrderDataReciept = $this->OrderModel->getOrderData($orderDataQuery);
//		//		$rowCount = count($this->session->cart_session);
//		$arrOrderMobile = array();
//		if (!empty($this->session->cart_session)) {
//			$service_total = 0;
//			$discount_total = 0;
//			foreach ($this->session->cart_session as $orderSummaryRow) {
//				$service_total += (int)$orderSummaryRow->service_sale_price;
//				$discount_total += (int)$orderSummaryRow->service_discount;
//
//				// check is sample collector available
//				// by location and service schedule date time
//
//				// 1:payment pending;  == 0
//				// 2:complete;         == 0
//				// 3:cancel;           == 0
//				// 4:payment failed;   == 0
//				// 5:payment Completed; == 1
//				// 6:pending due to sample collection; == 1
//				// 7:sample collected (ongoing) == 0
//
////				$sampleCollector =$this->OrderModel->
////				_rawQuery("select group_concat(sample_collector) as collectors from order_master where
////							   schedule_date='$orderSummaryRow->schedule_full_date' and
////							   schedule_time='$orderSummaryRow->schedule_time' and
////							   status in (5,6) and sample_collector is not null
////							   ");
////
////					if($sampleCollector->totalCount > 0){
////						$collectors = $sampleCollector->data[0]->collectors;
////						if($collectors !=null){
////							$freeCollectors= $this->OrderModel->_rawQuery("select id from sample_collector where id not in ($collectors)");
////							if($freeCollectors->totalCount >0){
////
////							}
////
////						}else{
////							$freeCollectors= $this->OrderModel->_rawQuery("select id from sample_collector limit 1");
////
////							var_dump($freeCollectors);
////						}
////
////					}
//				if (!(in_array($orderSummaryRow->patient_number, $arrOrderMobile))){
//					array_push($arrOrderMobile,$orderSummaryRow->patient_number);
//				}
//
//				$rowArr = array(
//					"order_id" => $order_id,
//					"patient_id" => $patientId,
//					"patient_name" => $orderSummaryRow->patient_name,
//					"patient_number" => $orderSummaryRow->patient_number,
//					"service_id" => $orderSummaryRow->service_id,
//					"address_id" => $address_id,
//					"schedule_time" => $orderSummaryRow->schedule_time,
//					"schedule_date" => $orderSummaryRow->schedule_full_date,
//					"location" => $orderSummaryRow->location,
//					"status" => 1,
//					"payment_mode" => $payment_mode,
//					"price" => $orderSummaryRow->service_sale_price,
//					"discount" => $orderSummaryRow->service_discount,
//					"created_on" => date("Y-m-d H:i:s"),
//					"created_by" => $patientId
//
//				);
//				array_push($orderArr, $rowArr);
//				$grand_total = $service_total - $discount_total;
//			}
////			$order_insert=false;
//			$order_insert = $this->OrderModel->orderInsert("order_master", $orderArr);
////			SampleCollector = $this->OrderModel->getSampleCollectorDetails($getOrderDetails->data[0]->sample_collector);
//			//$this->session->getSampleCollectorDetails = $getSampleCollector;
//			//			$last_id = $first_id + ($rowCount-1);
//			//			echo $first_id;die();
//			$response = array();
//			if ($order_insert) {
//
//				if ($payment_mode !== 'COD') {
//					$arrPaymentData = array(
//						"order_id" => $order_id,
//						"amount" => $grand_total,
//						"card_holde_name" => $this->input->post("card_holde_name"),
//						"card_expiry" => $this->input->post('card_expiry'),
//						"card_number" => $this->input->post('card_number'),
//						"card_type" => $this->input->post('card_type'),
//						"transaction_date" => date('Y-m-d'),
//						"transaction_status" => 1,
//						"created_on" => date('Y-m-d'),
//						"created_by" => $patientId
//					);
//					$payment_transaction = $this->OrderModel->transactionInsert("card_payment_transaction", $arrPaymentData);
//					if ($payment_transaction) {
//						$this->session->unset_userdata('cart_session');
//						$this->session->unset_userdata('page_session');
//						//						alert(base_url())
//						$this->session->orderSummary = array();
//						$this->session->set_userdata('orderIds', $first_id);
//						$this->session->orderDataDetails = $OrderDataReciept;
//						$response["status"] = 200;
//						$response['payment_transaction_resp'] = $payment_transaction;
//						$response["msg"] = "Order Placed successfully 1";
//						$response['order_id'] = $order_id;
//// SMS functionality
//						$sender = 'Sukaii';
//						$msg = "Your order placed successfully";
//						$mobile = $arrOrderMobile;//implode(', ',$arrOrderMobile);
//						$sentSmsRegister = $this->sendSMSFunctionality($sender,$mobile,$msg);
//						$objSentSmsRegister = json_decode($sentSmsRegister);
//						$smsStatus = (int)$objSentSmsRegister->code;
//						$response["smsResp"] = $smsStatus;
//						if ($smsStatus == 0){
//							$response["smsBody"] = $objSentSmsRegister->detail;
//						}else{
//							$response["smsBody"] = $objSentSmsRegister->detail;
//						}
//
//					} else {
//						$response["status"] = 201;
//						$response["msg"] = "Payment Failed";
//						echo json_encode($response);
//						exit();
//					}
//				} else {
//					$this->session->unset_userdata('cart_session');
//					$this->session->unset_userdata('page_session');
//
//					// SMS functionality
//					$sender = 'Sukaii';
//					$msg = "Your order placed successfully";
//					$mobile = $arrOrderMobile; // implode(', ',$arrOrderMobile);
//					$sentSmsRegister = $this->sendSMSFunctionality($sender,$mobile,$msg);
//					$objSentSmsRegister = json_decode($sentSmsRegister);
//					$smsStatus = (int)$objSentSmsRegister->code;
//					$response["smsResp"] = $smsStatus;
//					if ($smsStatus == 0){
//						$response["smsBody"] = $objSentSmsRegister->detail;
//					}else{
//						$response["smsBody"] = $objSentSmsRegister->detail;
//					}
//
//					$response['order_id'] = $order_id;
//					$response["status"] = 200;
//					$response["msg"] = "Order Placed successfully 2";
//				}
////				$this->orderedMail($this->session->user_session->email, $order_id);
//			} else {
//				$response["status"] = 201;
//				$response["msg"] = "Order not Placed";
//			}
//		} else {
//			$response["status"] = 201;
//			$response["msg"] = "No data to insert";
//		}
//		echo json_encode($response);
//	}


	public function insertOrder()
	{
		$patientId = $this->session->user_session->id;
		$payment_mode = $this->input->post('paymentMode');
		$address_id = $this->input->post('address_id');

		$return = array();
		foreach($this->session->cart_session as $orderRow) {
			$return[$orderRow->location][] = $orderRow;
		}
		foreach ($return as $mainRow){

			$order_id = 'ORD-000001';
			$last_id = $this->OrderModel->getLastOrder('SELECT order_id from order_master order by id desc limit 1');
			$userAddress = $this->OrderModel->getUserAddress('SELECT * from customer_address where user_id = ' . $patientId);

			$userAddressDetails = $userAddress->data[0];

			$orderIdString = $last_id->data[0]->order_id;
			$orderArr = array();
			if (!empty($last_id->data[0])) {
				$arrOrderString = explode("-", $orderIdString);
				$number = (int)$arrOrderString[1] + 1;
				$n2 = str_pad((int)$arrOrderString[1] + 1, 5, 0, STR_PAD_LEFT);
				$order_id = 'ORD-' . ($n2);
			}
			$orderDataQuery = 'select om.*,sm.service_name,sm.service_rate,sm.service_type,rm.ts_code,rm.ts_desc,rm.tc_code,rm.result,rm.ref,rm.flag,rm.unit from order_master om join serveices sm on sm.id = om.service_id join report_master rm on rm.order_id = om.id where om.order_id = "' . $order_id . '" and om.patient_id = ' . $patientId;
			$OrderDataReciept = $this->OrderModel->getOrderData($orderDataQuery);
			//		$rowCount = count($this->session->cart_session);
			$arrOrderMobile = array();
			if (!empty($mainRow)) {
				$service_total = 0;
				$discount_total = 0;
				foreach ($mainRow as $orderSummaryRow){
					$service_total += (int)$orderSummaryRow->service_sale_price;
					$discount_total += (int)$orderSummaryRow->service_discount;
					if (!(in_array($orderSummaryRow->patient_number, $arrOrderMobile))){
						array_push($arrOrderMobile,$orderSummaryRow->patient_number);
					}

					$rowArr = array(
						"order_id" => $order_id,
						"patient_id" => $patientId,
						"patient_name" => $orderSummaryRow->patient_name,
						"patient_number" => $orderSummaryRow->patient_number,
						"service_id" => $orderSummaryRow->service_id,
						"address_id" => $address_id,
						"schedule_time" => $orderSummaryRow->schedule_time,
						"schedule_date" => $orderSummaryRow->schedule_full_date,
						"location" => $orderSummaryRow->location,
						"status" => 1,
						"payment_mode" => $payment_mode,
						"price" => $orderSummaryRow->service_sale_price,
						"discount" => $orderSummaryRow->service_discount,
						"created_on" => date("Y-m-d H:i:s"),
						"created_by" => $patientId

					);
					array_push($orderArr, $rowArr);
					$grand_total = $service_total - $discount_total;
				}
				$order_insert = $this->OrderModel->orderInsert("order_master", $orderArr);
				$response = array();
				if ($order_insert) {

					if ($payment_mode !== 'COD') {
//						$arrPaymentData = array(
//							"order_id" => $order_id,
//							"amount" => $grand_total,
//							"card_holde_name" => $this->input->post("card_holde_name"),
//							"card_expiry" => $this->input->post('card_expiry'),
//							"card_number" => $this->input->post('card_number'),
//							"card_type" => $this->input->post('card_type'),
//							"transaction_date" => date('Y-m-d'),
//							"transaction_status" => 1,
//							"created_on" => date('Y-m-d'),
//							"created_by" => $patientId
//						);
//						$payment_transaction = $this->OrderModel->transactionInsert("card_payment_transaction", $arrPaymentData);
//						if ($payment_transaction) {
							$this->session->unset_userdata('cart_session');
							$this->session->unset_userdata('page_session');
							//						alert(base_url())
							$this->session->orderSummary = array();
//							$this->session->set_userdata('orderIds', $first_id);
							$this->session->orderDataDetails = $OrderDataReciept;
//							$response["status"] = 200;
//							$response['payment_transaction_resp'] = $payment_transaction;
//							$response["msg"] = "Order Placed successfully";
//							$response['order_id'] = $order_id;
// SMS functionality
//							$sender = 'Sukaii';
//							$msg = "Your order placed successfully";
//							$mobile = $arrOrderMobile;//implode(', ',$arrOrderMobile);
//							$sentSmsRegister = $this->sendSMSFunctionality($sender,$mobile,$msg);
//							$objSentSmsRegister = json_decode($sentSmsRegister);
//							$smsStatus = (int)$objSentSmsRegister->code;
//							$response["smsResp"] = $smsStatus;
//							if ($smsStatus == 0){
//								$response["smsBody"] = $objSentSmsRegister->detail;
//							}else{
//								$response["smsBody"] = $objSentSmsRegister->detail;
//							}

//						} else {
//							$response["status"] = 201;
//							$response["msg"] = "Payment Failed";
//							echo json_encode($response);
//							exit();
//						}
						$response["status"] = 200;
						$response["redirect"]="create-checkout-session/".$order_id."/".$patientId;
						$response["msg"] = "Order Placed successfully";
					} else {
						$this->session->unset_userdata('cart_session');
						$this->session->unset_userdata('page_session');

						// SMS functionality
						$sender = 'Sukaii';
						$msg = "Your order placed successfully";
						$mobile = $arrOrderMobile; // implode(', ',$arrOrderMobile);
						$sentSmsRegister = $this->sendSMSFunctionality($sender,$mobile,$msg);
						$objSentSmsRegister = json_decode($sentSmsRegister);
						$smsStatus = (int)$objSentSmsRegister->code;
						$response["smsResp"] = $smsStatus;
						if ($smsStatus == 0){
							$response["smsBody"] = $objSentSmsRegister->detail;
						}else{
							$response["smsBody"] = $objSentSmsRegister->detail;
						}
						$response["redirect"]="";
						$response['order_id'] = $order_id;
						$response["status"] = 200;
						$response["msg"] = "Order Placed successfully";
					}
//				$this->orderedMail($this->session->user_session->email, $order_id);
				}
			}else{
				$response["status"] = 201;
				$response["msg"] = "No data";
			}

		}

		echo json_encode($response);
	}


	public function orderedMail($to, $order_id)
	{
		$data = $this->getReceiptDetails($order_id);
		$mailBody = $this->getMailFormat(
			$data['grandTotal'],
			$data['userAddress'],
			$data['orderDate'],
			$data['orderNumber'],
			$data['paymentMode'],
			$data['service_det'],
			$data['total_div']
		);
		$this->load->model("SmsModel");
		return $this->SmsModel->sendMail($to, "Thank you to for Booking sukaii Service", $mailBody);
	}

	function getReceiptDetails($orderId)
	{
		$patientId = $this->session->user_session->id;
		$userDataQuery = 'SELECT um.*,ca.* FROM users_master um join customer_address ca on ca.user_id = um.id where um.id = ' . $patientId;
		$orderDataQuery = 'select om.*,sm.discount,sm.sale_price,sm.service_name,sm.service_rate,sm.service_type from order_master om join serveices sm on sm.id = om.service_id  where om.order_id = "' . $orderId . '" and om.patient_id = ' . $patientId;
		$patientData = $this->OrderModel->getPatientData($userDataQuery);
		$OrderData = $this->OrderModel->getOrderData($orderDataQuery);
		$orderDetails = '';
		$service_det = '';

		$service_total = 0;
		$discount_total = 0;
		$homeServiceFee = 0;
		$orderDate = '';
		$orderNumber = '';
		$paymentMode = '';
		$tax = 0;
		$userData = $patientData->data[0];
		$userAddress = $userData->line_1 . ',' . $userData->line_2 . ',' . $userData->line_3 . ',' . $userData->line_4;

		foreach ($OrderData->data as $orderRow) {
			$service_total += (int)$orderRow->service_rate;
			$discount_total += (int)$orderRow->discount;

			$service_det .= '<div class="product-details" style="display: flex; justify-content: space-between; align-items: center;">
					<div class="product-name-image" style="display: flex; flex-direction: row;">
						<div style="display: flex; flex-direction: column; justify-content: space-between; margin-left: .5rem;">
							<div><span class="p-name" style="display: block;"><b>' . $orderRow->service_name . '</b></span></div>
						</div>
					</div>
					<div class="product-price">
						<h6>' . $orderRow->service_rate . '</h6>
					</div>
				</div>';
			$requested_date = $orderRow->created_on;

			$orderDate = $orderRow->created_on;
			$orderNumber = $orderRow->order_id;
			$paymentMode = $orderRow->payment_mode;
		}
		$grandTotal = (int)$service_total - (int)$discount_total;
		$total_div = '<div class="billing">
							<div style="margin-bottom: .5rem; display: flex; justify-content: space-between;"><span>Subtotal</span><span class="font-weight-bold">THB ' . $service_total . '</span></div>
							<div style="display: flex; justify-content: space-between; margin-bottom: .5rem;"><span>Home Service fee</span><span><b>THB ' . $homeServiceFee . '</b></span></div>
							<div style="display: flex; justify-content: space-between; margin-bottom: .5rem;"><span>Tax</span><span><b>THB ' . $tax . '</b></span></div>
							<div style="display: flex; justify-content: space-between; margin-bottom: .5rem;"><span style="color: #28a745!important;">Discount</span><span style="color: #28a745!important;"><b>THB ' . $discount_total . '</b></span></div>
							<hr>
							<div style="display: flex; justify-content: space-between; margin-bottom: .25rem;"><span><b style="font-family:var(--primaryText)">Total</b></span><span style="color: #28a745!important;"><b style="font-family:var(--primaryText)">THB ' . $grandTotal . '</b></span></div>
						</div>';
		//		echo $orderDetails;
		//		exit();
		$data['orderDetails'] = $orderDetails;
		$data['patientData'] = $patientData->data;
		$data['last_q'] = $orderDataQuery;
		$data['service_det'] = $service_det;
		$data['total_div'] = $total_div;
		$data['grandTotal'] = $grandTotal;
		$data['orderDate'] = $orderDate;
		$data['orderNumber'] = $orderNumber;
		$data['paymentMode'] = $paymentMode;
		$data['userAddress'] = $userAddress;
		return $data;
	}

	public function getMailFormat($grandTotal, $userAddress, $orderDate, $orderNumber, $paymentMode, $service_det, $total_div)
	{
		return '
		<!DOCTYPE html>
		<html lang="en">		
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Thank you to for Booking sukaii Service</title>
			</head>		
			<body style="padding: 0px; margin: 0px;">
				<div style="display: flex; justify-content: space-between; padding: 0px 10px; box-shadow: 0px 1px 6px 0px lightgrey;">
					<a href="' . base_url() . '"> <img src="' . base_url() . 'assets/images/sukaii_transparent_logo.png" alt="Sukaii" style="max-width: 125px; width: 100%; height: 53px;"></a>
					<h5>Total Amount : <span>' . $grandTotal . '</span></h5>
				</div>
				<div class="container" style="margin: 0.25rem 0rem; border: 0px solid black;">
					<div class=" row" style="display: flex; justify-content: center;">
						<div class="col-md-10">
							<div class="receipt" style="background-color: white; padding: 1rem; border-radius: 3px;">
							<h6 class="name" style="margin:.5rem 0rem">Shipping Address</h6>
							<span style="font-size: 12px; color: rgba(0,0,0)!important;">' . $userAddress . '</span><br>
							<span style="font-size: 12px; color: rgba(0,0,0,.5)!important;">your order has been confirmed and will be shipped in two days</span>
							<hr>
							<div class="order-details" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
								<div><span style="display: block; font-size:12px; ">Order date</span><span><b >' . $orderDate . '</b></span></div>
								<div><span style="display: block; font-size:12px; ">Order number</span><span><b>' . $orderNumber . '</b></span></div>
								<div><span style="display: block; font-size:12px; ">Payment method</span><span><b>' . $paymentMode . '</b></span></div>					
							</div>
							<hr>
							' . $service_det . '
							<div class="amount row" style="margin-top:1rem">								
								<div class="col-sm-6">
									' . $total_div . '
			
								</div>
							</div>
							<span style="display: block; margin-top: 1rem; font-size: 15px; color: rgba(0,0,0,.5)!important;">We will be sending a service confirmation email when the service is completed!</span>
							<hr>
							<div class="footer" style="display: flex; justify-content: space-between; align-items: baseline;">
								<div class="thanks"><span style="display: block;"><b>Thanks for Book <br> Service</b></span><span>Sukaii team</span></div>
								<div class="d-flex flex-column justify-content-end align-items-end" style="display: flex; justify-content: space-between; align-items: center;"><span style="display: block;"><b>Need Help?</b><br>Call - 974493933</span></div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</body>
		</html>
		';
	}

	public function updateOrderStatus()
	{
		$data = array(
			"status" => 1
		);
		$where = array("order_id" => "ORD-000001", "service_id" => "1084");
		$orderStatus = $this->OrderModel->orderUpdate("order_master", $data, $where);

		if ($orderStatus) {
			$response["status"] = 200;
			$response["msg"] = "Order Updated successfully";
		} else {
			$response["status"] = 201;
			$response["msg"] = "Order not updated";
		}

		echo json_encode($response);
	}

	public function orderSummary($id = null)
	{

//		$return = array();
//		foreach($this->session->cart_session as $orderRow) {
//			$return[$orderRow->location][] = $orderRow;
//		}
//		foreach ($return as $mainRow){
//			foreach ($mainRow as $innserRow){
//				echo $innserRow->location."<br>";
//			}
//		}
//
//		exit();
//		var_dump($this->session->cart_session);

		if (!isset($this->session->user_session)) {
			redirect("/");
		}
		$user_id = $this->session->user_session->id;
		$where = array("user_id" => $user_id, "status" => 1);

		if (!is_null($id)) {
			delete_cookie('authorized-service-order');
			$where["id"] = $id;
		}else{
			 set_cookie('authorized-service-order',"serviceOrder",84000,"","/");
		}

		$resultObject = $this->OrderModel->_select("customer_address", $where);

		$this->load->view('order/OrderSummary', array("userAddress" => $resultObject));
	}

	public function viewCart($id = null)
	{

		if (!isset($this->session->user_session)) {
			redirect("/");
		}
		$user_id = $this->session->user_session->id;
		$where = array("user_id" => $user_id, "status" => 1);
		if (isset($id)) {
			$where["id"] = $id;
		}
		$serviceQuery = 'SELECT * FROM serveices where id >=1481';

		$resultObject = $this->OrderModel->_select("customer_address", $where);
		$serviceData = $this->OrderModel->_rawQuery($serviceQuery);

		$this->load->view('order/cartPage', array("userAddress" => $resultObject, "serviceData" => $serviceData));
	}

	public function getTimeSlot()
	{

		$schedule_date = $this->input->post('scheduleDate');
		$service_id = $this->input->post('service_id');
		$hdnLocation = $this->input->post('hdnLocation');

		$getOrderPerslot = $this->MasterModel->_select('schedule_setup_master', array('id'=>1),"*",true);
		$getOrderPerslotData = $getOrderPerslot->data;
		$perSlotCount = $getOrderPerslotData->per_slot_count;
		$service_orders = $this->OrderModel->_rawQuery('select * from order_master where
 service_id=' . $service_id . ' and location="' . $hdnLocation . '" and schedule_date="' . $schedule_date . '" and status in (1,5,6,7)');

//		$time = array('07.00 AM', '07.30 AM', '08.00 AM', '08.30 AM', '09.00 AM', '09.30 AM', '10.00 AM', '10.30 AM', '11.00 AM', '11.30 AM', '12.00 PM', '12.30 PM', '01.00 PM', '01.30 PM', '02.00 PM', '02.30 PM', '03.00 PM', '03.30 PM', '04.00 PM', '04.30 PM');
		$time = $this->timeslot();
		$timeSchedule = '';
		$response['raw'] = $service_orders;
		foreach ($time as $row) {
			$getAllOrders = $this->MasterModel->countAll('order_master', array('schedule_time'=>$row,'schedule_date'=>$schedule_date));

			$time_status = '';
			$timeSchedule_status = 0;
			$timeSchedule_cursor_pointer = 'ponter';

			$disableTimeSlotColor = '';
			$disableTimeSlotPointer = '';
			$slotNotAllow = 'slotAllow';
			if($getAllOrders >= $perSlotCount){
				$disableTimeSlotColor = 'grey';
				$disableTimeSlotPointer = 'not-allowed';
				$timeSchedule_cursor_pointer = 'not-allowed';
				$slotNotAllow = 'slotNotAllow';
				$timeSchedule_status = 1;
			}

			if ($service_orders->totalCount > 0) {
				foreach ($service_orders->data as $scheduleTime) {


					if($getAllOrders >= $perSlotCount){
//					if ($scheduleTime->schedule_time == $row ) {
						$time_status = 'disableTime';
						$timeSchedule_status = 1;
						$timeSchedule_cursor_pointer = 'not-allowed';
						break;
					}
				}
			}
			$function_str = "getScheduleTime('" . $row . "'," . $timeSchedule_status . ",'" . $schedule_date . "',this,'".$slotNotAllow."')";
			$timeSchedule .= '<div class="col-3 mb-2">
             <div class="rounded text-center schudule_time schudule_time_div '.$slotNotAllow.' ' . $time_status . '" style="cursor:' . $disableTimeSlotPointer . ';" onclick="' . $function_str . '">
                 <small class="schedule_time_text" style="font-weight: 500;cursor:' . $timeSchedule_cursor_pointer . ';" attr-status="' . $timeSchedule_status . '"> ' . $row . '</small>
             </div>
         </div>';
		}
		if ($timeSchedule != '') {
			$response['status'] = 200;
			$response['body'] = $timeSchedule;
		} else {
			$response['status'] = 201;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
		// return view('mobile/covid_pcr_booking_form', array('time_schedule' => $service_orders));
	}

	public function myBookings()
	{
		$this->load->view('order/myBooking');
	}

	public function getMyBookings()
	{

		$response = array();
		$user_id = $this->session->user_session->id;
		$query = 'SELECT om.*,om.id as orderPid,sm.service_name,sm.service_id,sm.id as servicePid,sm.service_rate,(SELECT concat(line_1,"|",line_2,"|",line_3,"|",line_4) FROM customer_address where id = om.address_id) as customer_address FROM order_master om join serveices sm on sm.id = om.service_id where om.patient_id = ' . $user_id . ' group by order_id order by om.id desc';
		$myBookingsData = $this->OrderModel->getMyBookings($query);
		$response['dataOrder'] = $myBookingsData;
		$myBooking = '';
		if ($myBookingsData) {
			if ($myBookingsData->totalCount > 0) {

				foreach ($myBookingsData->data as $value) {
					// echo json_encode($value);
					// echo '<br>';
					// 1:payment pending;2:complete;3:cancel;4:payment failed;5:payment Completed; 6:pending due to sample collection; 7:sample collected (ongoing)
					$ViewReport = '';

					$verifyOtp = '';
					$sampleCollector = 'Sample Collector allocated soon';
					if ($value->allocation_status != 0 && $value->sample_collector != NULL){
						$sampleCollectorQ = $this->MasterModel->_select("sample_collector",array("id"=>$value->sample_collector),$select="*",true);
						$sampleCollectorData = $sampleCollectorQ->data;
						if($sampleCollectorData){
							$sampleCollector = $sampleCollectorData->name;
						}

					}
					$rescheduleOrder = '';
					if ($value->status == 5 && $value->allocation_status == 0 && $value->payment_mode !='COD'){
						$rescheduleOrder = '<div class="mt-1 report text-right">
		            	<a href="'.base_url().'rescheduleOrder/'.$value->servicePid.'/'.$value->orderPid.'/'.$value->order_id.'"> <span class="small"><i class="fa-solid fa-rectangle-xmark pr-2" style="font-size: 18px;"></i>Reschedule Order</span></a>
		        		</div>';
					}

					if ($value->status == 1) {
						$status_text = 'On Going';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = '<div class="mt-1 report text-right">
		            	<a onclick="cancelOrder(\'' . $value->order_id . '\')"> <span class="small"><i class="fa-solid fa-rectangle-xmark pr-2" style="font-size: 18px;"></i>Cancel Order</span></a>
		        		</div>';
					} else if ($value->status == 2) {
						$ViewReport = '<div class="mt-1 report text-right">
		            	<a href="' . base_url() . 'viewReciept/' . $value->order_id . '/' . $user_id . '" target="_blank"> <span class="small"><i class="fa-clipboard-list fa-solid pr-2" style="font-size: 18px;"></i>View Report</span></a>
		        		</div>';
						$status_text = 'Completed';
						$status_btn = 'text-success';
					} else if ($value->status == 3) {
						$status_text = 'Cancelled';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = "";
					} else if ($value->status == 4) {
						$status_text = 'Payment Failed';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = "";
					} else if ($value->status == 5) {
						$status_text = 'Payment Completed';
						$status_btn = 'text-success';
					}else {
						$status_text = 'On Going';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = '<div class="mt-1 report text-right">
		            	<a onclick="cancelOrder(\'' . $value->order_id . '\')"> <span class="small"><i class="fa-solid fa-rectangle-xmark pr-2" style=" font-size: 18px;"></i>Cancel Order</span></a>
		        		</div>';
					}
					if ($value->status == 6) {
						$verifyOtp = '<div class="mt-1 report text-right">
							<span class="small" data-toggle="modal" data-target="#enterOTPModel" id="verifyOTP" onclick="verifyOtpModal('.$value->id .',\''.$value->order_id.'\',\''.$value->patient_number.'\')"><i class="fa-solid fa-pen-to-square pr-2"  style="font-size: 18px; color: #00b3b7;"></i>Verify OTP</span>
						</div>';
					 }
					$customer_addressArr = explode("|",$value->customer_address);
					$customer_addressArr = array_filter($customer_addressArr);
					$customer_address = implode("<br>",$customer_addressArr);

					$orderTotalAmount = $value->service_rate - $value->discount;
					$myBooking.= '<div class="container pt-3 pb-0" style="border-bottom: 2px solid gray;">
					<div class="row">
						<div class="align-items-center col-12 d-flex justify-content-between small"
							style="font-family: var(--primaryText);">
							<div class="test_name">
								<h6 style="font-size: .9rem;" class="mb-0 font-weight-bold">' . $value->service_name . '</h6>
								<small class="text-muted" style="font-size: 11px; ">' . $value->created_on . '</small>
							</div>
							<button type="button" class="btn px-2 small btn-sm ' . $status_btn . '"
								style="background-color: #e5e3e3; padding: .15rem;"><small>' . $status_text . '</small></button>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="image_section ">
								<div class="name">
									<a id="OrderNumber'. $value->id .'" onclick="openorderdetails(\'openExtradetails'.$value->id.'\')" style="text-decoration: none; color: #00b3b7;">
										<p class="font-weight-bold my-2">'. $value->order_id .'<span class="ml-1"><i
													class="fa-solid fa-chevron-down"></i></span></p>
									</a>
									<p class="mb-2">'.$sampleCollector.'</p>
								</div>
			
							</div>
						</div>
						
					</div>
				   
					<div class=" pb-3 " id="openExtradetails'. $value->id .'" style="display: none;">
						<div class="row">
							<div class="col-12">
								<div class="d-flex">
									<span class="mr-2"><i class="fa-solid fa-location-crosshairs"
											style="color: #00b3b7;"></i></span>
									<p class="mb-0" style="font-size: smaller;">'.$customer_address.'</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="align-items-end col-12 d-flex justify-content-between">
								<div class="">
									<div class="totalAmount font-weight-bold">
										'.$orderTotalAmount.'
									</div>
									<div class="paymentStatus">
										<div style="background-color: #e5e3e3; padding: .15rem;" class=" px-2  badge '. $status_btn .'">'. $status_text .'</div>
									</div>
								</div>
								<div class="mt-1 report text-right">
								' . $ViewReport . ' 
								</div>
								'.$rescheduleOrder.'
							</div>
						</div>
					</div>
				</div>';

					}

				$response['status'] = 200;
				$response['data'] = $myBooking;
			} else {
				$response['status'] = 200;
				$response['data'] = 'No bookings yet';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = 'Something went worng';
		}

		echo json_encode($response);
	}


	public function getRecipet($orderId, $patientId)
	{
		$userDataQuery = 'SELECT um.*,ca.* FROM users_master um join customer_address ca on ca.user_id = um.id where um.id = ' . $patientId;
		$orderDataQuery = 'select om.*,(select service_name from serveices where id =service_id) as service_name,rm.ts_code,rm.ts_desc,rm.tc_code,rm.result,rm.ref,rm.flag,rm.unit
 from order_master om join report_master rm on rm.order_id = om.order_id where om.order_id  = "' . $orderId . '" and om.patient_id = ' . $patientId;
		$patientData = $this->OrderModel->getPatientData($userDataQuery);
		$OrderData = $this->OrderModel->getOrderData($orderDataQuery);
		$orderDet = $this->db->query('select om.service_id,(SELECT s.service_name FROM serveices s where s.id  = om.service_id) as serviceName from order_master om where om.order_id = "'.$orderId.'"')->result();
		$orderDetails = '';
		$requested_date = '';
		$reported_date = '';
		$printed_date = '';
		$lan = '';
		$tableOrderDet = '';


		foreach ($orderDet as $rowOrderDet) {
			$tableOrderDet .= '<p class="testPara" style=""><div class="row" style="">
            <div class="col-md-12">
	                <div class="text-center topicName">
	                    <span class="btn font-weight-bold text-center text-light mb-3"
	                        style="padding: 4px 18px; background-color: #ec0d8f; border-radius: 22px; font-weight: 600; cursor: default;"> '.$rowOrderDet->serviceName.' </span>
	                </div>
	            </div>
	        </div>
	        <div class="row mb-5">
	            <div class="col-12">

	                <table class="table table-borderless">
	                    <thead>
	                        <tr>
	                            <th class="sec1_h" scope="col">Investigation</th>
	                            <th class="sec1_h" scope="col">status</th>
	                            <th class="sec1_h" scope="col">Result</th>
	                            <th class="sec1_h" scope="col">UNIT</th>
	                            <th class="sec1_h" scope="col"> Normal Range</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        ';

			foreach ($OrderData->data as $orderRow) {
				if ($rowOrderDet->service_id == $orderRow->service_id) {
					$tableOrderDet .= '<tr>
						<th class="sec2_h" scope="row">' . $orderRow->ts_desc . '</th>
						<td class="sec2_v_l" style="font-size: 12px !important;">-</th>
						<td class="sec2_v_l" style="font-size: 12px !important;">' . $orderRow->result . '</td>
						<td class="sec2_v_l" style="font-size: 12px !important;">' . $orderRow->unit . '</td>
						<td class="sec2_v_l" style="font-size: 12px !important;">' . $orderRow->ref . '</td>
					</tr>';
				}

				$requested_date = $orderRow->created_on;
			}
			$tableOrderDet .= '
	                    </tbody>
	                </table>
	            </div>
	        </div></p>';
		}

		$data['requested'] = $requested_date;
		$data['reported'] = $reported_date;
		$data['printed'] = $printed_date;
		$data['patientData'] = $patientData->data;
		$data['lan'] = $lan;
		$data['last_q'] = $orderDataQuery;
		$data['orderDetails'] = $tableOrderDet;
		return $data;
	}
	public function viewReciept($orderId, $patient_id)
	{
		$data = $this->getRecipet($orderId, $patient_id);
		$this->getPDFView($data['patientData'], $data["orderDetails"], $data["requested"], $data["reported"], $data["printed"], $data["lan"]);
		//$this->load->view('order/reciept', $data);
	}

	public function viewPaymentRecieptDetails($orderId)
	{
		$data = $this->getReceiptDetails($orderId);
		$this->load->view('order/viewPaymentRecieptDetails', $data);
	}

	public function viewPaymentReciept($orderId)
	{
		$patientId = $this->session->user_session->id;
		$userDataQuery = 'SELECT um.*,ca.* FROM users_master um join customer_address ca on ca.user_id = um.id where um.id = ' . $patientId;
		$orderDataQuery = 'select om.*,sm.discount,sm.sale_price,sm.service_name,sm.service_rate,sm.service_type from order_master om join serveices sm on sm.id = om.service_id  where om.order_id = "' . $orderId . '" and om.patient_id = ' . $patientId;
		$patientData = $this->OrderModel->getPatientData($userDataQuery);
		$OrderData = $this->OrderModel->getOrderData($orderDataQuery);
		$orderDate = '';
		$collectorDetails = '';
		$collectorId = '';
		$servicesDataSummary = '';
		if ($OrderData->totalCount > 1) {
			foreach ($OrderData->data as $row) {
				$servicesDataSummary = '<div class="">
							<h6 style="font-size: .9rem;" class="mb-0 font-weight-bold">Your ordered number of services </h6>
							
						</div>';
						// <small class="text-muted" style="font-size: 11px; ">' . $row->created_on . '</small>
				$orderDate = $row->created_on;
				$collectorId = $row->sample_collector;
				break;
			}
		} else {
			foreach ($OrderData->data as $row) {
				$servicesDataSummary = '<div class="">
							<h6 style="font-size: .9rem;" class="mb-0 font-weight-bold">' . $row->service_name . '</h6>
							<small class="text-muted" style="font-size: 11px; ">' . $row->created_on . '</small>
						</div>';
				$orderDate = $row->created_on;
				$collectorId = $row->sample_collector;
			}
		}
//		$patientData = $this->OrderModel->getSampleCollectorDetails($collectorId);
//		$patientDetailsRow = $patientData->data[0];
		$collectorDetails = '<img src="'.base_url().'assets/images/user_icon.png" class=" rounded" style="width:15%;" alt="">
				<div class="name pl-3">
					<p class="small font-weight-bold mb-0 ">Will be allocate soon.</p>
				
				</div>';

		$data['servicesDataSummary'] = $servicesDataSummary;
		$data['orderDate'] = $orderDate;
		$data['orderId'] = $orderId;
		$data['collectorDetails'] = $collectorDetails;
		$this->load->view('order/paymentReciept', $data);
	}

	public function getAllOrders()
	{
		$filterColumn = $this->input->post('filterColumn');
		$filterValue = $this->input->post('filterValue');
		$where=array();
		if(!is_null($filterColumn) && !is_null($filterValue)){
			$where = array($filterColumn => $filterValue);
		}
		$select = array(
			"om.id", "om.order_id", "(select name from users_master where id = om.patient_id) as user_name", "om.patient_name", "om.patient_number",
			"sum(om.price) as total_price", "sum(om.discount) as total_discount",
			" (select group_concat(service_name) from serveices where id in (select service_id from order_master where order_id = om.order_id)) as service_name",
			"(select group_concat(line_1,' ',line_2,' ',line_3,' ',line_4) from customer_address where id= om.address_id) as address",
			"om.schedule_time", "om.schedule_date", "om.location", "om.payment_mode", "om.status", "om.patient_id"
		);

		$searchColumn = array("patient_name", "order_id");
		$orderColumn = array("om.id", "name", "om.order_id");
		$metaData = $this->OrderModel->getRows(
			$_POST,
			$where,
			$select,
			"order_master om",
			$searchColumn,
			$orderColumn,
			array("om.id" => "desc"),
			"om.order_id"
		);
		$last_q = $this->db->last_query();
		$filterCount = $this->OrderModel->countFiltered(
			$_POST,
			"order_master",
			$where,
			$searchColumn,
			$orderColumn,
			array("id" => "desc")
		);
		$totalCount = $this->OrderModel->countAll("order_master", $where);

		$response = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $filterCount,
			"recordsFiltered" => $totalCount,
			"data" => $metaData,
			"last_q" => $last_q,
		);
		echo json_encode($response);
	}

	public function changeOrderStatus()
	{
		$id = $this->input->post("id");
		$resultObject = $this->OrderModel->orderUpdate(array("active_status" => 0), $id);
		if ($resultObject->status) {
			$response['status'] = 200;
			$response['body'] = "successfully save";
		} else {
			$response['status'] = 201;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function deleteOrder()
	{
		$id = $this->input->post("id");
		$resultObject = $this->OrderModel->orderUpdate("order_master", array("active_status" => 0), array("order_id" => $id));
		if ($resultObject->status) {
			$response['status'] = 200;
			$response['body'] = "successfully deleted..";
		} else {
			$response['status'] = 201;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function deleteSampleCollector()
	{
		$id = $this->input->post("id");
		$resultObject = $this->OrderModel->partnerUpdate("sample_collector", array("status" => 0), array("id" => $id));

		if ($resultObject->status) {
			$this->OrderModel->partnerUpdate("sample_collector_mapping_location", array("status" => 0), array("sample_collector_id" => $id));
			$response['status'] = 200;
			$response['body'] = "successfully deleted";
			// $resultObjectLocation = $this->OrderModel->allocatedLocationUpdate("sample_collector_mapping_location",array("active_status" => 0), array("id" => $id));
		} else {
			$response['status'] = 201;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function uploadExcelFile()
	{
		$this->load->view('order/uploadExcel');
	}






	public function updateOrderStatusOnUpload()
	{
		$order_id = $this->input->post('orderID');
		$table = 'order_master';
		$data = array("status" => 2);
		$where = array("order_id" => $order_id);
		$result = $this->OrderModel->orderUpdate($table, $data, $where);
		if ($result) {
			$response["status"] = 200;
			$response["msg"] = "Order Completed";
		} else {
			$response["status"] = 201;
			$response["msg"] = "Something went wrong";
		}
	}

	public function updateCart()
	{
		$SId = $this->input->post('SId');
		$ServiceName = $this->input->post('ServiceName');
		$ServiceRate = $this->input->post('ServiceRate');
		$ServiceDiscount = $this->input->post('ServiceDiscount');
		$ServiceSalePrice = $this->input->post('ServiceSalePrice');

		$arrOrderItems = $this->session->cart_session;
		$cartObjectToCopy = (array)$arrOrderItems[0];
		$cartObjectToCopy['service_id'] = $SId;
		$cartObjectToCopy['service_name'] = $ServiceName;
		$cartObjectToCopy['service_price'] = $ServiceRate;
		$cartObjectToCopy['service_discount'] = $ServiceDiscount;
		$cartObjectToCopy['service_sale_price'] = $ServiceSalePrice;
		array_push($arrOrderItems, (object)$cartObjectToCopy);
		$this->session->cart_session = $arrOrderItems;
		$response["status"] = 200;
		echo json_encode($response);
	}


	public function removeCartItem()
	{
		$service_id = $this->input->post("serviceID");

		$OrderItems = $this->session->cart_session;
		$updateOrderItems = array();
		$count = 0;
		foreach ($OrderItems as $index => $item) {
			if ($item->service_id == $service_id) {
				if ($count == 0) {
					$count = 1;
					continue;
				}
			}
			array_push($updateOrderItems, $item);
		}
		$this->session->cart_session = $updateOrderItems;
		$response["status"] = 200;
		echo json_encode($response);
	}


	function getPDFView($patientData, $orderDetails, $requested, $reported, $printed, $lan)
	{

		$ageGender = (isset($patientData[0]->age) && isset($patientData[0]->gender)) ? $patientData[0]->age . " " . $patientData[0]->gender : " ";
		$ref = isset($patientData[0]->ref) ? $patientData[0]->ref : " ";
		$orderD = $orderDetails != "" ? $orderDetails : "";
		$baseUrl = base_url();
		$html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukaii</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css"> -->
    <link rel="stylesheet" href="">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- box icons link  -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href=\'https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css\' rel=\'stylesheet\'>

</head>
<style>
	@import url("https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap");
	@page {
		margin: 350px 0px 0px 0px;
		padding: 20px 00px 0px 0px;
		font-family: Lato;
		background-color: #f7f7f7 !important;
	}
	@font-face {
	  font-family: "lato";
	  font-style: normal;
	  font-weight: normal;
	  src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format(\'truetype\');
	}
	body {
		font-size: 14px;
		margin: 0px; 
		padding: 0px 10px 0px 0px;
		background-color: #f7f7f7;
	}
    .container-fluid {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
        box-shadow: 1px 1px 19px 0px lightgrey;
    }

    p {
        margin-bottom: 0%;
    }


    .row {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .col-12 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }

    .h-100 {
        height: 100%;
    }

    .w-100 {
        width: 100%;
    }

    .mx-5 {
        margin-left: 3rem;
        margin-right: 3rem;
    }

    .px-2 {
        padding-left: .5rem;
        padding-right: .5rem;
    }

    .py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .position-relative {
        position: relative;
    }

    .font-weight-bold {
        font-weight: 600;
    }

    .col-6 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }

    .col-md-5 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }

    .col-md-7 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }

    .ml-2 {
        margin-left: .5rem;
    }

    .text-center {
        text-align: center;
    }

    .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .text-light {
        color: #f8f9fa !important;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .mb-5 {
        margin-bottom: 3rem;
    }

    .table {
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        width: 100% !important;	
    }

    .table th,
    .table td {
        border: none !important;
        padding: 6px 6px 3px 6px;
        font-size: 15px !important;
        text-align: center;
        line-height: 10px;
    }
	td.dr_td{
		vertical-align: top;
	}
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }
    }


    .nameSection {
        width: 100%;
        border: 2px solid #0ab3b2;
        display: flex;
        font-weight: 600;
        padding: 10px 10px;
        border-radius: 18px;
        position: relative;
        top: -40px;
        

    }

    .section_1,
    .section_2 {
        width: 100%;
    }

    .rows {
        width: 100%;
        display: flex;
        margin-bottom: 3px;
    }

    .key {
        width: 30%;
    }

    .key,
    .value {
        width: 70%;
    }
    .section_1 td, .section_2 td{
        text-align: left;
    }
    .sec1_h{
    	font-size: 16px !important;
    	font-weight: 600 !important;
    }
    .sec1_v{
    	font-size: 14px !important;
    	font-weight: 500 !important;
    }
    .sec2_table_h{
    	font-size: 14px !important;
    	font-weight: 600 !important;
    }
    .sec2_h{
    	font-size: 16px !important;
    	font-weight: 500 !important;
    }
    .sec2_v{
    	font-size: 14px !important;
    	font-weight: 400 !important;
    }
    .sec2_v_l{
    	font-size: 10px !important;
    }
    .sec3_h{
    	font-size: 12px !important;
    	font-weight: 600 !important;
    }
    .sec3_v{
    	font-size: 11px !important;
    	font-weight: 500 !important;
    }
    .sec4_l{
    	font-size: 12px !important;
    	font-weight: 500 !important;
    }
    header { height: 350px; position: fixed; top: -350px; left: 0px; right: 0px;}
	footer{
                
                position: fixed; 	
                bottom: 0cm; 
                left: 0cm; 	
                right: 0cm;
                height: 9cm;	
    }
   	
    p.testPara {page-break-after: always; }
    p.testPara:first-child { page-break-after: auto; margin-top: 0px !important;}
    p.testPara:last-child { page-break-after: never; }  	
</style>

<body>
<header>
	<div class="row" style="height: 225px;">
            <div class="col-12 h-100">
                <img src="http://localhost/sukaii_new/assets/mimages/sukaiiReportHeaderReport.jpeg" class="w-100 h-100" alt="">
            </div>
        </div>
        <div class="container_" style="background-color: #f7f7f7;padding: 0px 40px 0px 20px;height: 125px;">
        <div class="nameSection" style="margin-bottom: 10px;">
            <div class="section_1">
                <table class="table ">
                
                    <tbody>
                      <tr>
                        <td class="sec1_h" style="width: 20%;">Voucher</td>
                        <td class="sec1_v" style="width: 30%;">: 12345</td>
                        <td class="sec1_h" style="width: 20%;">Coll. Date & Time</td>
                        <td class="sec1_v" style="width: 30%;">: 06-Jan-2022 <span class="ml-2">10.56.32 AM</span></td>
                      </tr>
                      <tr>
                        <td class="sec1_h" style="width: 20%;">MR No.</td>
                        <td class="sec1_v" style="width: 30%;">: 12345</td>
                        <td class="sec1_h" style="width: 20%;">Requested</td>	
                        <td class="sec1_v" style="width: 30%;">:  <span>' . $requested . '</span></td>
                      </tr>
                      <tr>
                        <td class="sec1_h" style="width: 20%;">Name</td>
                        <td class="sec1_v" style="width: 30%;">: <b>' . $patientData[0]->name . '</b></td>
                        <td class="sec1_h" style="width: 20%;">Reported</td>
                        <td class="sec1_v" style="width: 30%;">: <span class="ml-2">' . $reported . '</span></td>
                      </tr>
                      <tr>
                        <td class="sec1_h" style="width: 20%;">Age / Sex</td>
                        <td class="sec1_v" style="width: 30%;">: ' . $ageGender . '</td>
                        <td class="sec1_h" style="width: 20%;">Printed</td>
                        <td class="sec1_v" style="width: 30%;">: <span class="ml-4">' . $printed . '</span></td>
                      </tr>
                      <tr>
                        <td class="sec1_h" style="width: 20%;">Refferred By</td>
                        <td class="sec1_v" style="width: 30%;">: ' . $ref . '</td>
                        <td class="sec1_h" style="width: 20%;">Lan</td>
                        <td class="sec1_v" style="width: 30%;">: <span class="ml-5 pl-1">' . $lan . '</span></td>
                      </tr>
                      </tr>
                    </tbody>
                  </table>	
            </div>
           
        </div>
</div>
        
</header>
 <footer>	
   		 <div class="row" style="justify-content: space-around; width: 90%; margin: auto; margin-bottom: 2rem;">
        
			<table style="width: 100%;padding: 0px;">
				<tr>
					<td class="dr_td" style="width: 25%;">
					<p class="sec3_h" style=""><b>Dr. Tanuja Bhattacharya (MD)</b></p>
					<p class="sec1_v" style="margin-top: 4px;"><small>Consultant Microbiologist</small></p>
					</td>
					<td class="dr_td" style="width: 25%;"><p class="sec3_h" style=""><b>Dr. sulgna Ray (Pal)</b></p>
						<p class="sec3_h" style=""><b>Ph D. (BioChemistry)</b></p>
                		<p class="sec1_v" style="margin-top: 4px;"><small>Consultant Biochemist</small></p>
					</td>
					<td class="dr_td" style="width: 25%;"><p  class="sec3_h" style=""><b>Dr. Swati Agrawal (Pal)</b></p>
						<p class="sec3_h" style=""><b>MBBS DCP</b></p>
                		<p class="sec1_v" style="margin-top: 4px;"><small>Consultant Pathologist</small></p>
					</td>
					<td class="dr_td" style="width: 25%;"><p class="sec3_h" style=""><b>Dr. Sandeep Agrawal (Pal)</b></p>
					<p class="sec3_h" style=""><b>MD Pathology</b></p>
						<p class="sec1_v" style="margin-top: 4px;"><small>Tested By</small></p>
						<p class="sec1_v" style="margin-top: 4px;"><small>typed By</small></p>
						<p class="sec1_v" style="margin-top: 4px;"><small>Checked By</small></p></td>
				</tr>
			</table>
            
        </div>
        <div class="row"
            style="width: 90%; font-weight: 600; padding-left: 2.5rem; padding-bottom: .5rem; margin-bottom: 1.4rem;">
            <div class="col-md-12 sec4_l" style="">
                <p>Registered Office : This is dummy address,kindly do not read it. Registered Office : This is dummy address,kindly do not read it.</p>
                <p>Registered Office : This is dummy address,kindly do not read it. Registered Office : This is dummy address,kindly do not read it.</p>
                <p>Registered Office : This is dummy address,kindly do not read it. Registered Office : This is dummy address,kindly do not read it.</p>
                <p>Registered Office : This is dummy address,kindly do not read it. Registered Office : This is dummy address,kindly do not read it.</p>	
            </div>
        </div>
    <div class="row">
            <div class="col-md-12 py-1 text-center mt-3" style="background-color: #0eb3b6; width: 100%; padding: 9px;">
                <span>Email : info@sukaii.com</span>
                <span class="" style="margin-left: 1rem;">Website : www.sukaii.com</span>

            </div>
        </div>
</footer>
    
        
        
        <main style="">
        <div class="container">
        
       	'.$orderD.' 
       	
    </div>
		</main>
       
        
        
   
';

		$html .= '</body></html>';
		ini_set("memory_limit", "999M");
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setBasePath(APPPATH);
		$dompdf->set_option('isHtml5ParserEnabled', true);
		$dompdf->set_option('allow_url_fopen', true);
//		$customPaper = array(0, 0, 445, 625);
//		$dompdf->set_paper($customPaper);
		$dompdf->setPaper('A4', 	'portrait');
		$dompdf->render();
		$pdf_name = "Report_pdf" . (strtotime(date("Y-m-d h:i:s")));
		$dompdf->stream($pdf_name, array("Attachment" => 0));
	}

	public function sampleCollector()
	{
		$data['location'] = $this->MasterModel->_rawQuery("select * from sukai_service_location");
		$this->load->view('admin/sampleCollector',$data);
	}

	public function getSampleData()
	{
	/*	select sc.*,(select group_concat(scml.location_id ) from sample_collector_mapping_location scml where scml.sample_collector_id = sc.id ) as locationids,
(select group_concat(sslt.location_name) from sukai_service_location sslt where FIND_IN_SET(sslt.id, (select group_concat(scml.location_id ) from sample_collector_mapping_location scml where scml.sample_collector_id = sc.id ))) as locationName
from sample_collector sc */

		$where = array("sc.status" => 1);
		$select = array("sc.*,(select group_concat(scml.location_id ) from sample_collector_mapping_location scml where scml.sample_collector_id = sc.id ) as locationids,
(select group_concat(sslt.location_name) from sukai_service_location sslt where FIND_IN_SET(sslt.id, (select group_concat(scml.location_id ) from sample_collector_mapping_location scml where scml.sample_collector_id = sc.id ))) as locationName");
		$searchColumn = array("name", "email", "mobile");
		$orderColumn = array("id", "name");
		$metaData = $this->SampleCollectorModel->getRows($_POST, $where, $select, "sample_collector sc",$searchColumn, $orderColumn, array("id" => "desc"));
		$filterCount = $this->SampleCollectorModel->countFiltered($_POST, "sample_collector sc", $where, $searchColumn, $orderColumn,
			array("id" => "desc"));
		$totalCount = $this->SampleCollectorModel->countAll("sample_collector sc", $where);
		// print_r($metaData);
		$response = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $filterCount,
			"recordsFiltered" => $totalCount,
			"data" => $metaData
		);
		echo json_encode($response);
	}


	public function editSampleCollector()
	{
		$id = $this->input->post('id');
		$data = $this->SampleCollectorModel->get_by_id($id);
		echo json_encode($data);
	}


	public function sendSMSFunctionality($sender,$mobile,$msg){
		$mobileNumbers = implode(', ',$mobile);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://portal-otp.smsmkt.com/api/send-message',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"api_key:90fe84cb9cc936c69ac77dff57723b9c",
				"secret_key:qNCDd53jfbbksy3s",
			),
			CURLOPT_POSTFIELDS => json_encode(array(
				"message" => $msg,
				"phone" => $mobileNumbers,
				"sender" => $sender,
			)),
		));
		$SMSresponse = curl_exec($curl);
		curl_close($curl);
		return $SMSresponse;
	}


	public function sampleCollectersOrders()
	{
		$this->load->view('order/sampleCollectorsOrder');
	}

	public function getsampleCollectorsOrder()
	{
		$orderType = $this->input->post('filter');
		if ($orderType == 'og'){
			$orderStatus = ' AND status= 7';
		}else if($orderType == 'po'){
			$orderStatus = ' AND (status = 5 OR status = 6)';
		}else if($orderType == 'co'){
			$orderStatus = ' AND status = 2';
		}else{
			$orderStatus = '';
		}

		$response = array();
		$user_id = $this->session->user_session->id;

		$query = 'select om.*,
(select sm.service_name from serveices sm where sm.id = om.service_id) as service_name,
(select sm1.service_id from serveices sm1 where sm1.id = om.service_id) as service_id,
(select sm2.service_rate from serveices sm2 where sm2.id = om.service_id) as service_rate,
(SELECT CONCAT(ca.line_1,", " , ca.line_2,", ", ca.line_3,", ", ca.line_4) FROM customer_address ca where ca.id = om.address_id) as addr
 from order_master om where om.sample_collector = '.$user_id.' '.$orderStatus.'   group by order_id';
		$myBookingsData = $this->OrderModel->getMyBookings($query);
		$myBooking = '';
		if ($myBookingsData) {
			if ($myBookingsData->totalCount > 0) {
				$myBooking.='<div class="tab-pane fade show active" style="background-color: white;" id="AllOrdersSection" role="tabpanel" aria-labelledby="AllOrders">';

				foreach ($myBookingsData->data as $value) {
					// echo json_encode($value);
					// echo '<br>';`
					// 1:payment pending;2:complete;3:cancel;4:payment failed;5:payment Completed; 6:pending due to sample collection; 7:sample collected (ongoing)
//					$verifyOtp = '<div class="mt-1 report text-right">
//							<span class="small" data-toggle="modal" data-target="#enterOTPModel" id="verifyOTP" onclick="verifyOtpModal('.$value->id .',\''.$value->order_id.'\',\''.$value->patient_number.'\')"><i class="fa-solid fa-pen-to-square pr-2"  style="font-size: 18px; color: #00b3b7;"></i>Verify OTP</span>
//						</div>';
					$verifyOtp = '';
					if ($value->status == 6  && $value->order_otp != '' && $value->order_otp != NULL) {
						$verifyOtp = '';
						// $verifyOtp = '<div class="mt-1 report text-right">
						// 	<span class="small" data-toggle="modal" data-target="#enterOTPModel" id="verifyOTP" onclick="verifyOtpModal('.$value->id .',\''.$value->order_id.'\',\''.$value->patient_number.'\')"><i class="fa-solid fa-pen-to-square pr-2"  style="font-size: 18px; color: #00b3b7;"></i>Verify OTP</span>
						// </div>';
					}

					$ViewReport = '<div class="mt-1 report text-right">
		            <a href="' . base_url() . 'viewReciept/' . $value->order_id . '/'.$user_id.'" target="_blank"> <span class="small"><i class="fa-clipboard-list fa-solid pr-2" style="font-size: 18px;"></i>View Report</span></a>
		        </div>';
					if ($value->status == 1) {
						$status_text = 'On Going';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = '';
					} else if ($value->status == 2) {
						$status_text = 'Completed';
						$status_btn = 'text-success';
					} else if ($value->status == 3) {
						$status_text = 'Cancel';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = "";
					} else if ($value->status == 4) {
						$status_text = 'Payment Failed';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = "";
					} else if ($value->status == 5) {
						$status_text = 'Completed';
						$status_btn = 'text-success';
					}
					// else if ($value->status == 6) {
					// 	$status_text = 'Sample Collection Pending';
					// 	$status_btn = 'sukaii_pink_color';
					// }
					else {
						$status_text = 'On Going';
						$status_btn = 'sukaii_pink_color';
						$ViewReport = '';
					}
					$otp_btn = '';
					if ($value->status !=2 && $value->status != 3 && $value->status != 4 && $value->status != 7){
						$otp_btn = '<div class="btn btn-light btn-sm font-weight-bold '.$status_btn.'" id="genrateOTPbtn" data-toggle="modal" data-target="#otpGn" style="background-color: #e5e3e3;" onclick="generateOtp('.$value->id.',\'btnOtp'.$value->id.'\',\''.$value->order_id.'\',\''.$value->patient_number.'\')">
						<small id="btnOtp'.$value->id.'">OTP</small>
					</div>';
					}

					$myBooking .='<div class="tab-pane fade show active" style="background-color: white;" id="AllOrdersSection" role="tabpanel" aria-labelledby="AllOrders">
		<div class="container py-3 Completed" style="border-bottom: 2px solid gray;">
			<div class="row">
				<div class="align-items-center col-12 d-flex justify-content-between small" style="font-family: var(--primaryText);">
					<div class="test_name">
						<h6 style="font-size: .9rem;" class="mb-0 font-weight-bold">'.$value->service_name.'</h6>
						<small class="text-muted" style="font-size: 11px; ">'.$value->schedule_date.' '. $value->schedule_time.'</small>
					</div>
					<button type="button" class="btn px-2 '.$status_btn.' small btn-sm" style="background-color: #e5e3e3; padding: .15rem;"><small>'.$status_text.'</small></button>
				</div>
			</div>
			<div class="row">
				<div class="align-items-center justify-content-between col-12 d-flex mt-2">
					<div class="image_section  align-items-center" style="width: 100%;">
						<div class="name d-flex">
							<span style="color: #00b3b7;" class="mr-2"><i class="fa-solid fa-user"></i></span>
							<p class="small font-weight-bold mb-0 ">'.$value->patient_name.'</p>
						</div>
						<div class="name d-flex">
							<span style="color: #00b3b7;" class="mr-2"><i class="fa-solid fa-map-location-dot"></i></span>
							<p class="small font-weight-bold mb-0 text-muted">'.$value->location.'</p>
						</div>
						<div class="name d-flex">
							<span style="color: #00b3b7;" class="mr-2"><i class="fa-solid fa-location-crosshairs"></i></span>
							<small>'.$value->addr.'</small>
						</div>
						<div class="name d-flex">
							<span style="color: #00b3b7;" class="mr-2"></span>
							<small>'.$verifyOtp.'</small>
						</div>
						
					</div>
					'.$otp_btn.'
					<div class="small resendOTP"></div>
				</div>
			</div>
		</div>';

				}
				$myBooking.='</div>';

				$response['status'] = 200;
				$response['data'] = $myBooking;
			} else {
				$response['status'] = 200;
				$response['data'] = '<div class="container mt-3">
		<p class="border mb-0 p-2 rounded small py-2 text-center sukaii_pink_color normal_text"
		   style="background-color: var(--iconbgColor)">
				No order available</p>
	</div>';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = 'Something went worng';
		}

		echo json_encode($response);
	}

	public function verifyOtp()
	{
		$this->load->model("MasterModel");
		$id = $this->input->post('id');
		$otp = $this->input->post('otp');
		$resultObject = $this->MasterModel->_select("order_master",array("id" => $id),"*",true);
		if($resultObject->totalCount > 0){
			$otpFromDB = $resultObject->data->order_otp;
			$OTPDate = $resultObject->data->otp_created_on;
			$orderId = $resultObject->data->order_id;
			if($otpFromDB == $otp){
				$dbtimestamp = strtotime($OTPDate);
				$to_time = strtotime($OTPDate);
				$from_time = strtotime(date("Y-m-d H:i:s"));
				$total_min = round(abs($to_time - $from_time) / 60,2);
				if ($total_min > 15){
					$response["status"]=201;
					$response["body"]="OTP Expired please regenerate";
				}else{
					$data = array(
						"order_otp_status"=>1,
						"status"=>7,
					);
					$resultObject = $this->MasterModel->_update('order_master', $data, array("order_id"=>$orderId));
					if($resultObject){
						$response["status"]=200;
						$response["body"]="OTP verified";
					}else{
						$response["status"]=201;
						$response["body"]="OTP not verified";
					}
				}

//				$curDate = date();

//				_select("order_master",array("id" => $id),"*",true);
			}else{
				$response["status"]=201;
				$response["body"]="OTP not verified";
			}
		}else{
			$response["status"]=201;
			$response["body"]="Order Not Found";
		}
		echo json_encode($response);
	}


	public function timeslot(){
		$timeslots = $this->MasterModel->_select("schedule_setup_master",array("id"=>1),"*",true);
		$timeslots_data = $timeslots->data;
		$starttime = $timeslots_data->schedule_start_time;//schedule start time
		$endtime = $timeslots_data->schedule_end_time;//schedule end time
		$durationtime = $timeslots_data->slot_duration;//schedule duration time

		$interval = $durationtime*60; // Interval in seconds

		$date_first     = date('Y-m-d')." ".$starttime." AM";
		$date_second    = date('Y-m-d')." ".$endtime." PM";

		$time_first     = strtotime($date_first);//strtotime($date_first);
		$time_second    = strtotime($date_second);//strtotime($date_second);
		$timeArr = array();
		for ($i = $time_first; $i < $time_second; $i += $interval) {
			array_push($timeArr,date('h.i A', $i));
		}
		return $timeArr;
	}



	public function getAllOrdersFilters()
	{
		$location = $this->input->post("location");
		$where = array("active_status" => 1,"location"=>$location);
		$select = array(
			"om.id", "om.order_id", "(select name from users_master where id = om.patient_id) as user_name", "om.patient_name", "om.patient_number",
			"sum(om.price) as total_price", "sum(om.discount) as total_discount",
			" (select group_concat(service_name) from serveices where id in (select service_id from order_master where order_id = om.order_id)) as service_name",
			"(select group_concat(line_1,' ',line_2,' ',line_3,' ',line_4) from customer_address where id= om.address_id) as address",
			"om.schedule_time", "om.schedule_date", "om.location", "om.payment_mode", "om.status", "om.patient_id"
		);

		$searchColumn = array("patient_name", "order_id", "contact", "address", "registration_type", "gender");
		$orderColumn = array("om.id", "name", "om.order_id");
		$metaData = $this->OrderModel->getRows(
			$_POST,
			$where,
			$select,
			"order_master om",
			$searchColumn,
			$orderColumn,
			array("om.id" => "desc"),
			"om.order_id"
		);
		$last_q = $this->db->last_query();
		$filterCount = $this->OrderModel->countFiltered(
			$_POST,
			"order_master",
			$where,
			$searchColumn,
			$orderColumn,
			array("id" => "desc")
		);
		$totalCount = $this->OrderModel->countAll("order_master", $where);

		$response = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $filterCount,
			"recordsFiltered" => $totalCount,
			"data" => $metaData,
			"last_q" => $last_q,
		);
		echo json_encode($response);
	}


	public function cancelOrder(){
		$orderId = $this->input->post('orderId');
		$data = array(
			"status"=>3,
		);
		$where = array("order_id"=>$orderId);
		$cancelOrder = $this->MasterModel->_update('order_master', $data, $where);
		$response = array();
		if ($cancelOrder){
			$response['status'] = 200;
			$response['body'] = 'Order has been cancel';
		}else{
			$response['status'] = 201;
			$response['body'] = 'Something went wrong';
		}
		echo json_encode($response);
	}

	public function rescheduleOrder($serviceId,$orderPid,$orderId){
		$orderQuery = $this->MasterModel->_select('order_master', array("id"=>$orderPid),$select = "*",true);
//		var_dump($orderQuery);
		$orderQueryData = $orderQuery->data;
		$this->serviceOrder($serviceId,$orderQueryData);
	}
	public function updateOrder(){

		$response = array();
		$orderPid = $this->input->post("hdnOrderPid");
		$updateData = array(
			"patient_name"=>$this->input->post("patient_name"),
			"patient_number"=>$this->input->post("patient_number"),
			"schedule_time"=>$this->input->post("pic_schedule_time_h"),
			"schedule_date"=>$this->input->post("pic_schedule_date_h"),
			"updated_on"=> date('Y-m-d H:i:s'),
			"updated_by"=>$this->input->post("hdnUserId"),
			"location"=>$this->input->post("serviceBookingLocation"),
		);
		$where = array("id"=>$orderPid);
		$table = "order_master";
		$update = $this->MasterModel->_update($table, $updateData, $where);
		if ($update){
			$response['status'] = 200;
			$response['data'] = "Updated Successfully";
		}else{
			$response['status'] = 201;
			$response['data'] = "Update fail";
		}

		echo json_encode($response);
	}

}
