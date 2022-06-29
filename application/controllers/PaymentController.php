<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

require 'vendor/autoload.php';


/**
 * @property  OrderModel OrderModel
 */
class PaymentController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("OrderModel");
	}


	public function paymentGetaway($order_id,$customer_id)
	{
		if(!is_null($order_id)&& !is_null($customer_id)) {

			$orderDetails = $this->OrderModel->_select("order_master",array("active_status"=>1,"order_id"=>$order_id),
				array("price","discount","(select service_name from serveices where id = order_master.service_id) as service_name"),false);

			if($orderDetails->totalCount > 0){
				$stripe=Stripe::setApiKey('sk_test_51KirF5ETMwKqj6WHR3PfeWWlhT1lyQBJQv1qQZoMeKvALhRB04MPADTQ94cUpLPyDQQRo4QsADnePPR15HK2NdoX00oXJep6ES');
				$product_data =array();

				foreach ($orderDetails->data as $service){
					$total=(float)$service->price-(float)$service->discount;
					$product= Product::create(array('name' => $service->service_name));
					$price = Price::create(array(
						'product' => $product->id,
						'unit_amount' => $total*100,
						'currency' => 'thb',
					));
					array_push($product_data,array("price"=>$price->id,
						'quantity' => 1));
				}
				$emailId = $this->getEmailId($customer_id);
				$session = Session::create(array(
					'line_items' => array(
						$product_data
					),
					'mode' => 'payment',
					'success_url' => 'https://sukaii.com/onsuccess?session_id={CHECKOUT_SESSION_ID}',
					'cancel_url' => 'https://sukaii.com/oncancel',
					'metadata' => array("order_id" => $order_id, "customer_id" => $customer_id),
					'emailId'=>$emailId
				));
				redirect($session->url);
			}

		}else{
			redirect("/");
		}
	}

	function getEmailId($customer_id){
		$userDetails = $this->OrderModel->_select("users_master",array("id"=>$customer_id),
			array("email"),true);
			return $userDetails->data->email;
	}

	public function onsuccess(){
		Stripe::setApiKey('sk_test_51KirF5ETMwKqj6WHR3PfeWWlhT1lyQBJQv1qQZoMeKvALhRB04MPADTQ94cUpLPyDQQRo4QsADnePPR15HK2NdoX00oXJep6ES');
		try {
			$session = Session::retrieve($this->input->get('session_id'));
			$metadata = $session->metadata;
			if(!is_null($metadata->order_id)){
				$this->OrderModel->_update("order_master",array("status"=>5,"active_status"=>1),array("order_id"=>$metadata->order_id));
				redirect("viewPaymentReciept/".$metadata->order_id);
			}else{
				echo "Payment failed";
			}
		} catch (ApiErrorException $e) {
			log_message("error","Payment success page error");
			log_message("error",$e);
			echo "Payment failed";
		}

	}
	public function oncancel(){
		$emailId = $this->session->userdata('emailId');
		$mailBody = $this->getMailFormatFailedPayment();
		$this->load->model("SmsModel");
		$this->SmsModel->sendMail($emailId, "Thank you to for Booking sukaii Service", $mailBody);
		redirect("orderSummary");
	}

	public function getMailFormatFailedPayment()
	{
		return '
		<!DOCTYPE html>
		<html lang="en">		
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Thank you to for choosing sukaii Service</title>
			</head>		
			<body style="padding: 0px; margin: 0px;">
				
				<div class="container" style="margin: 0.25rem 0rem; border: 0px solid black;">
					<div class=" row" style="display: flex; justify-content: center;">
						<div class="col-md-10">
						<p>Your payment is failed</p>
						<small>Don\'t worry. We\'ll try your payment again over the next few days.</small>
</div>
					</div>
				</div>
			</body>
		</html>
		';
	}
}
