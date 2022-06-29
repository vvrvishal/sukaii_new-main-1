<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  AdminModel AdminModel
 * @property  MasterModel MasterModel
 */
class AdminController extends CI_Controller
{

	public function index()
	{
		//
	}

	public function _dashboard()
	{

		$this->load->model("AdminModel");

		$User = $this->AdminModel->_select("users_master", array("status" => 1), "count(id) as total");
		$partner = $this->AdminModel->_select("partner_master", array("status" => 1), "count(id)  as total");
		$enquiry = $this->AdminModel->_select("user_enquiry", array("status" => 1), "count(id)  as total");
		$order = $this->AdminModel->_select("order_master", array("active_status" => 1),
			array(
				"sum( case when status =6 || status =7 then 1 else 0 end) as on_going",
				"sum( case when status =1 || status =5 then 1 else 0 end) as pending",
				"sum( case when status =2 then 1 else 0 end) as completed ",
				"sum( case when status =3 then 1 else 0 end) as cancel",
				"sum( case when status =4 then 1 else 0 end) as payment_failed",
				"sum(1) as total"
			));


		$data = array(
			"user" => $User->data->total,
			"partner" => $partner->data->total,
			"enquiry" => $enquiry->data->total,
			"orders" => $order->data->total,
			"ongoing" => $order->data->on_going,
			"pending" => $order->data->pending,
			"completed" => $order->data->completed,
			"cancel" => $order->data->cancel,
			"payment_failed" => $order->data->payment_failed,
		);
		$this->load->view('admin/dashboard', $data);
	}

	public function userDetails()
	{
		$this->load->view('admin/user_details');
	}

	public function cardPaymentDetails()
	{
		$this->load->view('admin/card_payment_details');
	}

	public function customerAddressDetails()
	{
		$this->load->view('admin/customer_address');
	}

	public function orderDetails()
	{
		$this->load->view('admin/order_details');
	}

	public function packageDetails()
	{
		$this->load->view('admin/package_details');
	}

	public function partnerDetails()
	{
		$this->load->view('admin/partner_details');
	}

	public function reportDetails()
	{
		$this->load->view('admin/reports_details');
	}

	public function sampleCollecters()
	{
		$this->load->view('admin/sample_collecters');
	}

	public function servicesDetails()
	{
		$this->load->view('admin/services_details');
	}

	public function userEnquiryDetails()
	{
		$this->load->view('admin/user_enquiry_details');
	}

	public function sampleCollectorForm()
	{
		$this->load->view('admin/sampleCollector');
	}

	public function saveSampleCollector()
	{
		$usernamePrefix = 'ssc_';
		$sampleId = $this->input->post('sampleId');
		$name = $this->input->post('name_input');
		$email = $this->input->post('email_input');
		$sampleCollectorPassword = $this->input->post('password_input');
		$phone = $this->input->post('phone_input');
		$address = $this->input->post('sampleCollectorAddress');
		$uploadPath = 'uploads';
		$fileName = 'IDProof';
		$sampleCollectorUserName = strtolower(str_replace(' ', '', $usernamePrefix.$name));

		$this->load->model("MasterModel");
		$fileResult = $this->MasterModel->upload_multiple_file($uploadPath, $fileName);
		$filePath = "";
		if ($fileResult["status"] == 200) {
			$filePath = $fileResult["body"][0];
		}
		$response["file"] =$fileResult;
		$userCheck = $this->MasterModel->_select("sample_collector",array("email"=>$email,"status"=>1),"*",true);
		if ($userCheck->totalCount > 0 && $sampleId == ""){
			$response["status"] = 201;
			$response["body"] = "User already exists";
		}else{
			if ($sampleId=="") {
				$data = array(
					"name" => $name,
					"email" => $email,
					"mobile" => $phone,
					"address" => $address,
					"id_proof" => $filePath,
					"username"=>$sampleCollectorUserName,
					"password"=>$sampleCollectorPassword,
					"status"=>1
				);
				// insert
				$resultObject = $this->MasterModel->_insert("sample_collector", $data);

				if ($resultObject->status) {
					$response["status"] = 200;
					$response["body"] = "create successfully";
					if($this->input->post('allocated_location') == null || $this->input->post('allocated_location') == ""){
						$response["status"] = 202;
						$response["body"] = "Please selecct locations..";
					}
					foreach($this->input->post('allocated_location') as $allocated){
						$row['sample_collector_id'] = $resultObject->inserted_id;
						$row['location_id'] = $allocated;
						$row['status'] = 1;
						$resultObjectLocation = $this->MasterModel->_insert("sample_collector_mapping_location", $row);
						if($resultObjectLocation){
							$response["status"] = 200;
							// $response["body"] = "locations allocated successfully";
						}
						else
						{
							$response["status"] = 201;
							$response["body"] = "Failed to save location";
						}
					}
				} else {
					$response["status"] = 201;
					$response["body"] = "Failed to save";
				}
			} else {
				$data = array(
					"name" => $name,
					"email" => $email,
					"password"=>$sampleCollectorPassword,
					"mobile" => $phone,
					"address" => $address,
					"id_proof" => $filePath,
					"status"=>1
				);
				// update
				$resultObject = $this->MasterModel->_update("sample_collector", $data, array("id" => $sampleId));
				$this->MasterModel->_delete("sample_collector_mapping_location", array("sample_collector_id" => $sampleId));
				foreach($this->input->post('allocated_location') as $allocated){
					$row['sample_collector_id'] = $sampleId;
					$row['location_id'] = $allocated;
					$row['status'] = 1;

					$resultObjectLocation = $this->MasterModel->_insert("sample_collector_mapping_location", $row, array("sample_collector_id" => $sampleId));
					if($resultObjectLocation){
						$response["status"] = 200;
						$response["body"] = "locatons allocation updated successfully";
					}
					else
					{
						$response["status"] = 201;
						$response["body"] = "Failed to update location";
					}
				}
				if ($resultObject->status) {
					$response["status"] = 200;
					$response["body"] = "update successfully";
				} else {
					$response["status"] = 201;
					$response["body"] = "Failed to save";
				}
			}
		}

		echo json_encode($response);
	}


	public function deleteSampleRecord()
	{
		$id = $this->input->post('id');
		$resultObject = $this->MasterModel->_delete("sample_collector", array("id" => $id));
		if ($resultObject->status) {
			$response["status"] = 200;
			$response["body"] = "Delete successfully";
		} else {
			$response["status"] = 201;
			$response["body"] = "Failed to delete";
		}
		echo json_encode($response);
	}

	public function getSampleCollector(){

		$id = $this->input->post('id');
		$resultObject = $this->MasterModel->_rawQuery("select sc.*,(select group_concat(scml.location_id ) from 
		sample_collector_mapping_location scml where scml.sample_collector_id = sc.id ) as locationids,
		(select group_concat(sslt.location_name) from sukai_service_location sslt where 
		FIND_IN_SET(sslt.id, (select group_concat(scml.location_id ) from sample_collector_mapping_location scml where scml.sample_collector_id = sc.id ))) as locationName
		from sample_collector sc where id='$id'");

		if($resultObject->totalCount >0){
			$response["status"]=200;
			$response["body"]=$resultObject->data;
		}else{
			$response["status"]=404;
			$response["body"]="Not Found";
		}
		echo json_encode($response);
	}

	//sample collector allocation

	public function orderAllocation(){
		$this->load->view('admin/orderAllocation');
	}
	public function getOrdersTimeSlots(){
		$selectedDate = $this->input->post("selectedDate");
		$resultObject = $this->MasterModel->_rawQuery("SELECT * FROM `order_master` WHERE `schedule_date` = '".$selectedDate."'");
		$getOrderPerslot = $this->MasterModel->_select('schedule_setup_master', array('id'=>1),"*",true);
		$perSlotCount = $getOrderPerslot->data->per_slot_count;

//		$time = array('07.00 AM', '07.30 AM', '08.00 AM', '08.30 AM', '09.00 AM', '09.30 AM', '10.00 AM', '10.30 AM', '11.00 AM', '11.30 AM', '12.00 PM', '12.30 PM', '01.00 PM', '01.30 PM', '02.00 PM', '02.30 PM', '03.00 PM', '03.30 PM', '04.00 PM', '04.30 PM');
		$time = $this->timeslot();
		$timeSchedule = '';

		foreach ($time as $row) {
			$getAllOrders = $this->MasterModel->countAll('order_master', array('schedule_time'=>$row,'schedule_date'=>$selectedDate));
			$getAllAllocatedOrders = $this->MasterModel->countAll('order_master', array('schedule_time'=>$row,'schedule_date'=>$selectedDate,'allocation_status'=>1));
			$halfAllocatedOrder = ceil($getAllOrders/2);

			$slotColor = '';
			$isOrderBook='';

			if ($getAllOrders == 0){
				$slotColor = '';
				$isOrderBook = $slotColor;
			}else if ($getAllAllocatedOrders != 0 && $getAllAllocatedOrders < $getAllOrders){
				$slotColor = 'orange';
				$isOrderBook = $slotColor;
			}else if($getAllOrders != 0 && $getAllAllocatedOrders == $getAllOrders){
				$slotColor = 'grey';
				$isOrderBook = $slotColor;
			}else{
				$slotColor = '#4bc6c882';
				$isOrderBook = $slotColor;
			}
			$time_status = '';
			$timeSchedule_status = 0;
			$timeSchedule_cursor_pointer = 'ponter';
			$time_status = 'disableTime';
			$timeSchedule_status = 1;

			$function_str = '';
			foreach ($resultObject->data as $orderRow){


				if($row == $orderRow->schedule_time) {
					$function_str = "getScheduleOrders('modalOrderAllocation','" . $row . "','" . $selectedDate . "',this)";
					break;
				}
			}

			$timeSchedule .= '<div class="col-3 border py-1 " style="background: '.$isOrderBook.'">
             <div class="rounded text-center schudule_time schudule_time_div ' . $time_status .'" style="cursor:' . $timeSchedule_cursor_pointer . ';" onclick="' . $function_str . '">
                 <small class="schedule_time_text" style="font-weight: 500;cursor:' . $timeSchedule_cursor_pointer . ';" attr-status="' . $timeSchedule_status . '"> ' . $row . '</small>
             </div>
         </div>';
		}

		if($resultObject->totalCount >0){
			$response["status"]=200;
			$response['timeSchedule'] = $timeSchedule;
			$response['timeSchedule'] = $timeSchedule;
			$response['selectedDate'] = $selectedDate;
			$response["body"]=$resultObject;
		}else{
			$response['timeSchedule'] = '<div class="col-3 border py-1 ">No orders for this date</div>';
			$response["status"]=404;
			$response["body"]="Not Found";
		}
		echo json_encode($response);
	}

	public function getOrdersForAllocation(){
		$date = $this->input->post('date');
		$slot = $this->input->post('slot');
		$resultObject = $this->MasterModel->_rawQuery("SELECT * FROM `order_master` WHERE `schedule_date` = '".$date."' AND schedule_time = '".$slot."' group by order_id");
		$response["OrderData"] = $resultObject;
		if ($resultObject->totalCount > 0){

//		order dropdown
			if ($resultObject->totalCount > 0){
				$orderDropdown = '<select><option value="">Please Select Order</option>';
				foreach ($resultObject->data as $OrderDataRow){
					$orderDropdown .= '<option value="'.$OrderDataRow->order_id.'">'.$OrderDataRow->order_id.'</option>';
				}
				$orderDropdown .= '</select>';
			}else{
				$orderDropdown = '<select><option value="">No Orders</option></select>';
			}
//		sample collector dropdown


			$orderTableAllocation = '<table class="table">
			<thead>
				<tr>
					<th>Order</th>
					<th>Patient Name</th>
					<th>Contact</th>
					<th>Location</th>
					<th>Sample Collector</th>
					<th>Action</th>
				</tr>
			</thead><tbody>';
			$count = 1;
			foreach ($resultObject->data as $OrderDataRow){

				$nurseBtnId = "nurseBtn".$count;
				$nurseBtnIdTd = "tdNurseBtn".$count;
				$onclickEvent= 'onclick="getNurse(\''.$OrderDataRow->order_id.'\',\''.$count.'\',\''.$date.'\',\''.$slot.'\',\''.$nurseBtnId.'\',\''.$nurseBtnIdTd.'\',0)"';
//				$onclickEvent = 'onclick="getNurse(1,\''.$OrderDataRow->order_id.'\'','.$count.',\''.$date.'\',"'.$slot.'");';
//				$sampleCollectorDropdown = $this->getSampleCollectorDropdown($OrderDataRow->sample_collector,$OrderDataRow->order_id,$count,$date,$slot);
				$allocationCheckBtn = '';
				if ($OrderDataRow->allocation_status == 1){
					$sample_collector = $this->MasterModel->_select("sample_collector", array("id"=>$OrderDataRow->sample_collector), $select = "*", true)->data;
					$sampleCollectorDropdown = '<span class="btn btn-sm btn-lght"> '.$sample_collector->name.'</span>';
					$allocationCheckBtn = '';
				}else{
					$sampleCollectorDropdown = '<button class="btn btn-sm btn-success" '.$onclickEvent.' id="'.$nurseBtnId.'" >Select Nurse</button>';
					$allocationCheckBtn = '<i class="fa fa-check" id="allocateUser'.$count.'"></i>';
				}

				$orderTableAllocation .= '<tr>
				<td>'.$OrderDataRow->order_id.'</td>
				<td>'.$OrderDataRow->patient_name.'</td>
				<td>'.$OrderDataRow->patient_number.'</td>
				<td>'.$OrderDataRow->location.'</td>
				<td id="'.$nurseBtnIdTd.'">'.$sampleCollectorDropdown.'</td>
				<td>
					'.$allocationCheckBtn.'
				</td>
			</tr>';
				$count++;
			}
			$orderTableAllocation .= '</tbody></table>';
			$response["status"]=200;
			$response["body"]=$orderTableAllocation;
			$response["orderTableAllocation"]=$orderTableAllocation;
		}else{
			$response["status"]=201;
			$response["body"]='Something went wrong!';
		}

		echo json_encode($response);
	}

	public function getSampleCollectorDropdown(){
		$user_id = $this->input->post('user_id');
		$order_id = $this->input->post('order_id');
		$count = $this->input->post('count');
		$date = $this->input->post('date');
		$slot = $this->input->post('slot');
		$tableName = "order_master";
		$where = array("schedule_time"=>$slot,"schedule_date"=>$date,"order_id"=>$order_id);
		$allocatedSampleCpllectorIds = $this->MasterModel->_select($tableName, $where, $select = "*", true);
		$allocatedSampleCpllectorIds2 = $this->MasterModel->_select($tableName, $where, $select = "group_concat(sample_collector) as sample_collector", true);
//		$this->MasterModel->_rawQuery("select group_concat(sample_collector) as sample_collector from order_master where schedule_time='".$slot."' and schedule_date = '".$date."'");
		$alocatedSampleCollectorData = $allocatedSampleCpllectorIds->data;
		$alocatedSampleCollectorData2 = $allocatedSampleCpllectorIds2->data;
		$response['allocatedSampleC'] = $allocatedSampleCpllectorIds;
		$alocatedSampleCollectorIds = $alocatedSampleCollectorData2->sample_collector;
		$location = $alocatedSampleCollectorData->location;
		$locationIdQ = $this->MasterModel->_select('sukai_service_location', array('location_name'=>$location), $select = "*", true);
		$locationIdData = $locationIdQ->data;
		$locationId = $locationIdData->id;

//			$this->MasterModel->_rawQuery("select group_concat(sample_collector) as sampleCollector from order_master where schedule_time = '".$slot."' AND schedule_date = '".$date."'");
		if ($alocatedSampleCollectorIds != null){
			$alocatedSampleCollectorIds = $alocatedSampleCollectorIds;

//			$resultSampleCollectorObject = $this->MasterModel->_rawQuery("SELECT * FROM sample_collector where id NOT IN(".$alocatedSampleCollectorIds.") and status = 1");
			$query = 'SELECT scml.*,(select name from sample_collector sc where sc.id = scml.sample_collector_id and sc.status=1 ) sample_collector,
(select status from sample_collector sc where sc.id = scml.sample_collector_id and sc.status=1 ) sample_collector_status
 FROM sample_collector_mapping_location scml where scml.location_id = '.$locationId.' and scml.status = 1 
 and scml.sample_collector_id is not null and scml.sample_collector_id NOT IN ('.$alocatedSampleCollectorIds.')';
			$resultSampleCollectorObject = $this->MasterModel->_rawQuery($query);
		}else{
//			$resultSampleCollectorObject = $this->MasterModel->_rawQuery("SELECT * FROM sample_collector where status = 1");
			$query = 'SELECT scml.*,(select name from sample_collector sc where sc.id = scml.sample_collector_id and sc.status=1 ) sample_collector,
(select status from sample_collector sc where sc.id = scml.sample_collector_id and sc.status=1  ) sample_collector_status 
 FROM sample_collector_mapping_location scml where scml.location_id = '.$locationId.' and scml.status = 1 and scml.sample_collector_id is not null';
			$resultSampleCollectorObject = $this->MasterModel->_rawQuery($query);
		}
		if($resultSampleCollectorObject->totalCount > 0){
			$selectCollecterId = 'sampleCollector'.$count;
			$setOnclickFunctionSmpleSollector = 'onchange="setAllocationValue(\'allocateUser'.$count.'\',\''.$selectCollecterId.'\',\''.$order_id.'\',\'sampleCollector'.$count.'\',\''.$date.'\',\''.$slot.'\')"';
			$sampleCollectorDropdown = '<select class="form-control text-dark" id="sampleCollector'.$count.'" '.$setOnclickFunctionSmpleSollector.'><option value="">Select Sample Collectors</option>';
			$response['resultSampleCollectorObject'] = $resultSampleCollectorObject;
			foreach ($resultSampleCollectorObject->data as $rowSampleCollector){
				if($rowSampleCollector->sample_collector !== null){
					$sampleCollectorDropdown .= '<option value="'.$rowSampleCollector->sample_collector_id.'">'.$rowSampleCollector->sample_collector.'</option>';
				}
			}
			$sampleCollectorDropdown .= '</select>';
		}else{
			$sampleCollectorDropdown = '<select><option value="">No Sample Collectors</option></select>';
		}
		$response['status'] = 200;
		$response['body'] = $sampleCollectorDropdown;
		echo json_encode($response);
	}

	public function getSampleCollectorDropdownWithoutSelected($user_id,$order_id,$count,$date,$slot,$selectedSampleCollector){
		$tableName = "order_master";
		$where = array("schedule_time"=>$slot,"schedule_date"=>$date);
		$allocatedSampleCpllectorIds = $this->MasterModel->_select($tableName, $where, $select = "*", true);
		$alocatedSampleCollectorData = $allocatedSampleCpllectorIds->data;
		$alocatedSampleCollectorIds = $alocatedSampleCollectorData->sample_collector;
//		$response['data'] = $alocatedSampleCollectorIds;
//		echo json_encode($response);
//		exit();
//			$this->MasterModel->_rawQuery("select group_concat(sample_collector) as sampleCollector from order_master where schedule_time = '".$slot."' AND schedule_date = '".$date."'");
		if ($alocatedSampleCollectorIds != null){
			$alocatedSampleCollectorIds = $alocatedSampleCollectorIds;
//			$resultSampleCollectorObject = $this->MasterModel->_rawQuery("SELECT * FROM sample_collector where status = 1 and id !=".$user_id);
			$resultSampleCollectorObject = $this->MasterModel->_rawQuery("SELECT * FROM sample_collector where id NOT IN(".$alocatedSampleCollectorIds.") and status = 1");

		}else{
			$resultSampleCollectorObject = $this->MasterModel->_rawQuery("SELECT * FROM sample_collector where status = 1");
		}
		if($resultSampleCollectorObject->totalCount > 0){
			$selectCollecterId = 'sampleCollector'.$count;
			$setOnclickFunctionSmpleSollector = 'onchange="setAllocationValue(\'allocateUser'.$count.'\',\''.$selectCollecterId.'\',\''.$order_id.'\',\'sampleCollector'.$count.'\')"';
			$sampleCollectorDropdown = '<select id="sampleCollector'.$count.'" '.$setOnclickFunctionSmpleSollector.'><option value="">Select Sample Collectors</option>';
			foreach ($resultSampleCollectorObject->data as $rowSampleCollector){
				$sampleCollectorDropdown .= '<option value="'.$rowSampleCollector->id.'">'.$rowSampleCollector->name.'</option>';
			}
			$sampleCollectorDropdown .= '</select>';
		}else{
			$sampleCollectorDropdown = '<select><option value="">No Sample Collectors</option></select>';
		}
		return $sampleCollectorDropdown;
	}

	public function SetOrderAllocationToSampleCollector(){
		$orderId = $this->input->post("orderId");
		$sampleCollector = $this->input->post("sampleCollector");
//		_update($table, $data, $where)
		$table = "order_master";
		$where = array("order_id"=>$orderId);
		$data = array("status"=>6,"allocation_status"=>1,"sample_collector"=>$sampleCollector);
		$allocation = $this->MasterModel->_update($table, $data, $where);
		if ($allocation){
			$response["status"]=200;
			$response["body"]="Allocation Successfully Done.";
		}else{
			$response["status"]=201;
			$response["body"]="Something went wrong.";
		}
		echo json_encode($response);
	}

	public function dashboard()
	{
		$this->load->model("AdminModel");
		$User = $this->AdminModel->_select("users_master", array("status" => 1), "count(id) as total");
		$partner = $this->AdminModel->_select("partner_master", array("status" => 1), "count(id)  as total");
		$enquiry = $this->AdminModel->_select("user_enquiry", array("status" => 1), "count(id)  as total");
		$order = $this->AdminModel->_select("order_master", array("active_status" => 1),
			array(
				'patient_name',
				'service_id',
				"sum( case when status =6 || status =7 then 1 else 0 end) as on_going",
				"sum( case when status =1 || status =5 then 1 else 0 end) as pending",
				"sum( case when status =2 then 1 else 0 end) as completed ",
				"sum( case when status =3 then 1 else 0 end) as cancel",
				"sum( case when status =4 then 1 else 0 end) as payment_failed",
				"sum(1) as total"
			));
		$newOrders['ongoing'] = $this->MasterModel->_rawQuery("select id,order_id,location,schedule_time,schedule_date,patient_name from order_master where status=5 OR status=6 ORDER BY schedule_date LIMIT 5 ");
		$newOrders['completed'] = $this->MasterModel->_rawQuery("select id,order_id,location,schedule_time,schedule_date,patient_name from order_master where status=2 ORDER BY schedule_date LIMIT 5 ");
		$row = array(
			"user" => $User->data->total,
			"partner" => $partner->data->total,
			"enquiry" => $enquiry->data->total,
			"orders" => $order->data->total,
			"ongoing" => $order->data->on_going,
			"pending" => $order->data->pending,
			"completed" => $order->data->completed,
			"cancel" => $order->data->cancel,
			"payment_failed" => $order->data->payment_failed,
		);
		// $data = array_merge($orders,$row);
		$this->load->view('admin/dashboard', $newOrders);
	}
	//heramb
//	public function search()
//	{
//		$this->load->model("AdminModel");
//		$dateFrom = $this->input->post('date_from');
//		$dateTo = $this->input->post('date_to');
//		$this->load->model("AdminModel");
//
//		$User = $this->AdminModel->_select("users_master", array("status" => 1), "count(id) as total");
//		$partner = $this->AdminModel->_select("partner_master", array("status" => 1), "count(id)  as total");
//		$enquiry = $this->AdminModel->_select("user_enquiry", array("status" => 1), "count(id)  as total");
//		$query = $this->MasterModel->_rawQuery("select
//
//				sum( case when status =6 || status =7 then 1 else 0 end) as on_going,
//				sum( case when status =1 || status =5 then 1 else 0 end) as pending,
//				sum( case when status =2 then 1 else 0 end) as completed ,
//				sum( case when status =3 then 1 else 0 end) as cancel,
//				sum( case when status =4 then 1 else 0 end) as payment_failed,
//				sum(1) as total
//			 from order_master where created_on BETWEEN '$dateFrom' AND '$dateTo'");
//		//  print_r($query->data);
//
//		foreach($query->data as $data){
//			// print_r($data->on_going);
//			$row = array(
//				"user" => $User->data->total,
//				"partner" => $partner->data->total,
//				"enquiry" => $enquiry->data->total,
//				"orders" => $data->total,
//				"ongoing" => $data->on_going,
//				"pending" => $data->pending,
//				"completed" => $data->completed,
//				"cancel" => $data->cancel,
//				"payment_failed" => $data->payment_failed,
//			);
//		}
//		echo json_encode($row);
//		// print_r($row);
//		// $this->load->view('admin/dashboard',$row);
//	}

	public function search()
	{
		$this->load->model("AdminModel");
		$dateFrom = $this->input->post('date_from');
		$dateTo = $this->input->post('date_to');
		$this->load->model("AdminModel");

		$User = $this->AdminModel->_select("users_master", array("status" => 1), "count(id) as total");
		$partner = $this->AdminModel->_select("partner_master", array("status" => 1), "count(id)  as total");
		$enquiry = $this->AdminModel->_select("user_enquiry", array("status" => 1), "count(id)  as total");
		$query = $this->MasterModel->_rawQuery("select	
				sum( case when status =6 || status =7 then 1 else 0 end) as on_going,
				sum( case when status =1 || status =5 then 1 else 0 end) as pending,
				sum( case when status =2 then 1 else 0 end) as completed ,
				sum( case when status =3 then 1 else 0 end) as cancel,
				sum( case when status =4 then 1 else 0 end) as payment_failed, 
				sum(1) as total
			 from order_master where schedule_date BETWEEN '$dateFrom' AND '$dateTo'");

		foreach($query->data as $data){
			if($data->total==null){
				$row = array(
					"user" => $User->data->total,
					"partner" => $partner->data->total,
					"enquiry" => $enquiry->data->total,
					"orders" => 0,
					"ongoing" => 0,
					"pending" => 0,
					"completed" => 0,
					"cancel" => 0,
					"payment_failed" => 0,
				);
			}
			else{
				// print_r($data->on_going);
				$row = array(
					"user" => $User->data->total,
					"partner" => $partner->data->total,
					"enquiry" => $enquiry->data->total,
					"orders" => $data->total,
					"ongoing" => $data->on_going,
					"pending" => $data->pending,
					"completed" => $data->completed,
					"cancel" => $data->cancel,
					"payment_failed" => $data->payment_failed,
				);
			}
		}
		echo json_encode($row);
		// print_r($row);
		// $this->load->view('admin/dashboard',$row);
	}

	public function dashboardData()
	{
		$dateFrom = date('Y-m-d',strtotime("-90 days"));
		$today = date('Y-m-d');
		$this->load->model("AdminModel");
		$User = $this->AdminModel->_select("users_master", array("status" => 1), "count(id) as total");
		$partner = $this->AdminModel->_select("partner_master", array("status" => 1), "count(id)  as total");
		$enquiry = $this->AdminModel->_select("user_enquiry", array("status" => 1), "count(id)  as total");
		$query = $this->MasterModel->_rawQuery("select
			
				sum( case when status =6 || status =7 then 1 else 0 end) as on_going,
				sum( case when status =1 || status =5 then 1 else 0 end) as pending,
				sum( case when status =2 then 1 else 0 end) as completed ,
				sum( case when status =3 then 1 else 0 end) as cancel,
				sum( case when status =4 then 1 else 0 end) as payment_failed, 
				sum(1) as total
			 from order_master where created_on BETWEEN '$dateFrom' AND '$today'");
		//  print_r($query->data);
		foreach($query->data as $data){
			// print_r($data->on_going);
			$row = array(
				"user" => $User->data->total,
				"partner" => $partner->data->total,
				"enquiry" => $enquiry->data->total,
				"orders" => $data->total,
				"ongoing" => $data->on_going,
				"pending" => $data->pending,
				"completed" => $data->completed,
				"cancel" => $data->cancel,
				"payment_failed" => $data->payment_failed,
			);
		}
		echo json_encode($row);
	}

	public function getScheduleData()
	{
		// $id = $this->input->post('id');
		$resultObject = $this->MasterModel->_select("schedule_setup_master",array("id"=>1));
		if($resultObject->totalCount >0){
			$response["status"]=200;
			$response["body"]=$resultObject->data;
		}else{
			$response["status"]=404;
			$response["body"]="Not Found";
		}
		echo json_encode($response);
	}

	public function testForm()
	{
		$this->load->view('admin/testForm');
	}

	public function saveFormData()
	{
		$schedule_start_time = $this->input->post('schedule_start_time');
		$schedule_end_time = $this->input->post('schedule_end_time');
		$slot_duration = $this->input->post('slot_duration');
		$per_slot_count = $this->input->post('per_slot_count');

		$dateSchedule_start_time = date('h:i', strtotime($schedule_start_time));
		$dateschedule_end_time = date('h:i', strtotime($schedule_end_time));
		$this->load->model("MasterModel");
		$data = array(
			"schedule_start_time" => $dateSchedule_start_time,
			"schedule_end_time" => $dateschedule_end_time,
			"slot_duration" => $slot_duration,
			"per_slot_count" => $per_slot_count,
		);
		$resultObject = $this->MasterModel->_update("schedule_setup_master", $data, array("id" => 1));
		if ($resultObject->status) {
			$response["status"] = 200;
			$response["body"] = "update successfully";
		} else {
			$response["status"] = 201;
			$response["body"] = "Failed to save";
		}

		echo json_encode($response);
	}
	public function tableData()
	{
		$resultObject = $this->MasterModel->_select("schedule_setup_master",array("id"=>1));
		if($resultObject->totalCount >0){
			$response["status"]=200;
			$response["body"]=$resultObject->data;
		}else{
			$response["status"]=404;
			$response["body"]="Not Found";
		}
		echo json_encode($response);
	}

	public function saveOtp()
	{
		$id = $this->input->post('id');
		$otp = $this->input->post('otp');
		$data = array("order_otp"=>$otp,"order_otp_status"=>0,"otp_created_on"=>date('Y-m-d H:i:s'));
//		$resultObject = $this->MasterModel->_update("order_master", $data, array("id" => $id));

//		echo "1";exit();
		$getOrderDetails = $this->MasterModel->_select("order_master",array("id" => $id),"*", true);
		$getOrderDetailsData = $getOrderDetails->data;
		$resultObject = $this->MasterModel->_update("order_master", $data, array("order_id" => $getOrderDetailsData->order_id));
		// print_r($resultObject);
		if ($resultObject->status) {
			$mobile = $getOrderDetailsData->patient_number;
			$orderId = $getOrderDetailsData->order_id;
			$patient_name = $getOrderDetailsData->patient_name;
			$msg = $otp." is OTP for your sample collector verification, OTP valid for 30 minutes. Please enter OTP to verify sample collector.";
			$sender = 'Sukaii';

			$sentSmsRegister = $this->sendSMSFunctionality($sender,$mobile,$msg);
			$objSentSmsRegister = json_decode($sentSmsRegister);
			$smsStatus = (int)$objSentSmsRegister->code;
			$response["smsResp"] = $smsStatus;
			if ($smsStatus == 0){
				$response["smsBody"] = $objSentSmsRegister->detail;
			}else{
				$response["smsBody"] = $objSentSmsRegister->detail;
			}

			$response["patientName"] = $patient_name;
			$response["order_id"] = $orderId;
			$response["status"] = 200;
			$response["body"] = "update successfully";
		} else {
			$response["status"] = 201;
			$response["body"] = "Failed to save";
		}
		echo json_encode($response);
	}

	public function fileUploadNotification(){
		$id = $this->input->post('order_id');
//		$getOrderDetails = $this->MasterModel->_select("order_master",array("order_id" => $id),"*", true);
		$getOrderDetails = $this->MasterModel->_select("order_master",array("order_id"=>$id),"patient_number as ContactNumber",true);
		$response["orderBody"] =  $getOrderDetails->data->ContactNumber;
		$getOrderDetailsData = $getOrderDetails->data;
		if ($getOrderDetails->totalCount > 0) {
			$mobile = $getOrderDetailsData->ContactNumber;
			$msg = "Your report has been uploaded please download it";
			$sender = 'Sukaii';

			$sentSmsRegister = $this->sendSMSFunctionality($sender, $mobile, $msg);
			$objSentSmsRegister = json_decode($sentSmsRegister);
			$smsStatus = (int)$objSentSmsRegister->code;
			$response["smsResp"] = $smsStatus;
			if ($smsStatus == 0) {
				$response["smsBody"] = $objSentSmsRegister->detail;
			} else {
				$response["smsBody"] = $objSentSmsRegister->detail;
			}
		} else {
			$response["smsBody"] = "Patient Number not found";
		}
		echo json_encode($response);
	}

	public function sendSMSFunctionality($sender,$mobile,$msg){
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
				"phone" => $mobile,
				"sender" => $sender,
			)),
		));
		$SMSresponse = curl_exec($curl);
		curl_close($curl);
		return $SMSresponse;
	}

	public function cancelOrderAllocation(){
		$orderPrimaryId = $this->input->post('orderPrimaryId');
		$data = array(
			"status"=>5,
			"allocation_status"=>0,
			"sample_collector"=>''
		);
		$where = array("id"=>$orderPrimaryId);
		$resultObject = $this->MasterModel->_update("order_master", $data, $where);
		if ($resultObject->status) {
			$response["status"] = 200;
			$response["body"] = "Allocation cancel successfully";
		} else {
			$response["status"] = 201;
			$response["body"] = "Allocation cancel failed";
		}
		echo json_encode($response);
	}

	public function timeslot(){
		$timeslots = $this->MasterModel->_select("schedule_setup_master",array("id"=>1),"*",true);
		$timeslots_data = $timeslots->data;
		$starttime = $timeslots_data->schedule_start_time;//"08:15 AM";
		$endtime = $timeslots_data->schedule_end_time;//"08:15 AM";
		$durationtime = $timeslots_data->slot_duration;//"08:15 AM";

		$interval = $durationtime*60; // Interval in seconds

		$date_first     = date('Y-m-d')." ".$starttime." AM";
		$date_second    = date('Y-m-d')." ".$endtime." PM";

		$time_first     = strtotime($date_first);//strtotime($date_first);
		$time_second    = strtotime($date_second);//strtotime($date_second);
		$timeArr = array();
		for ($i = $time_first; $i <= $time_second; $i += $interval) {
			array_push($timeArr,date('h.i A', $i));
		}
		return $timeArr;
	}

	public function sendIssue()
	{
		$admin = "";
		$user = $this->session->user_session->name;
		$message = $this->input->post('issueText');
		if($message==""){
			$response['status'] = 202;
			$response['body'] = "Please enter something";
		}
		else{
			$response['status'] = 200;
			$response['body'] = "Your message sent successfully...";
			// $body=$this->queryMailFormat($user,$message);
			// $this->load->model("SmsModel");
			// return $this->SmsModel->sendMail($admin,"Query Mail",$body);
		}
		echo json_encode($response);
	}
}
