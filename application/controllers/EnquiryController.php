<?php


/**
 * @property  EnquiryModel EnquiryModel
 * @property  SmsModel SmsModel
 */
class EnquiryController extends CI_Controller
{

	public function saveEnquiry()
	{

		$name = $this->input->post("enquiry_person_name");
		$mobile = $this->input->post("enquiry_person_mobile");
		$services = $this->input->post("enquiry_services");
		$location = $this->input->post("enquiry_location_value");

		if (!is_null($name) && !is_null($mobile) && !is_null($services) && !is_null($location)) {
			$this->load->model("EnquiryModel");
			$this->load->model("SmsModel");

			$data = array("name" => $name,
				"mobile" => $mobile,
				"services" => $services,
				"location" => $location);
			$resultObject = $this->EnquiryModel->addEnquiry($data);
			$this->SmsModel->sendSMS($mobile, array('name' => $name, 'otp' => '1233', 'time' => date('H:i:s'),'center'=>'vashi','room'=>'1','bed'=>'1','company'=>'gbtech'), '1107164205399035078',3);
			if ($resultObject->status) {
				$response['status'] = 200;
				$response['body'] = "successfully save";
			} else {
				$response['status'] = 201;
				$response['body'] = "No Data Found";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required value missing";
		}
		echo json_encode($response);
	}


	public function getAllEnquiries()
	{
		$this->load->model("EnquiryModel");
		$where = array("status" => 1);
		$select = array("*");
		$searchColumn = array("name", "location", "services", "mobile");
		$orderColumn = array("id", "name");
		$metaData = $this->EnquiryModel->getRows($_POST, $where, $select, "user_enquiry",
			$searchColumn, $orderColumn, array("id" => "desc"));
		$filterCount = $this->EnquiryModel->countFiltered($_POST, "user_enquiry", $where, $searchColumn, $orderColumn,
			array("id" => "desc"));
		$totalCount = $this->EnquiryModel->countAll("user_enquiry", $where);

		$response = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $filterCount,
			"recordsFiltered" => $totalCount,
			"data" => $metaData,
		);
		echo json_encode($response);
	}

	public function deleteEnquiry(){
		if(!is_null($this->input->post("id")))
		{
			$this->load->model("EnquiryModel");
			$id= $this->input->post("id");
			$resultObject=$this->EnquiryModel->deleteEnquiry(array("id"=>$id));
			if ($resultObject->status) {
				$response['status'] = 200;
				$response['body'] = "successfully deleted";
			} else {
				$response['status'] = 201;
				$response['body'] = "No Data Found";
			}
		}
		else{
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}



}
