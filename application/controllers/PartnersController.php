<?php


/**
 * @property  PartnerModel PartnerModel
 * @property  input input
 * @property  CustomerAddressModel CustomerAddressModel
 * @property  session session
 */

class PartnersController extends CI_Controller
{

	/**
	 * UserController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("PartnerModel");
	}

	public function index()
	{
		$this->load->view("partner/index");
	}

	public function addPartners()
	{
		$name = $this->input->post("name_input");
		$company_name = $this->input->post("Company_name_input");
		$designation = $this->input->post("designation_input");
		$company_email = $this->input->post("company_email_input");
		$company_phone = $this->input->post("company_phone_input");
		$company_services = $this->input->post("company_services_input");
		$comment = $this->input->post("comment_input");

		if (!is_null($name) && !is_null($company_name) && !is_null($company_email) && !is_null($designation)
			&& !is_null($company_phone) && !is_null($company_services)) {
			$data = array(
				"name" => $name, "company_name" => $company_name,
				"designation" => $designation, "company_email" => $company_email,
				"company_phone" => $company_phone, "company_services" => $company_services,
				"comment" => $comment
			);
			$resultObject = $this->PartnerModel->addPartner($data);

			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = "Save successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed to save";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "something went wrong";
		}

		echo json_encode($response);


	}

	public function getAllPartner()
	{
		$where = array("status" => 1);
		$select = array("*");

		$searchColumn = array("name", "company_name", "designation", "company_email","company_phone","company_services");
		$orderColumn = array("id", "name","company_name");
		$metaData = $this->PartnerModel->getRows($_POST, $where, $select, "partner_master",
			$searchColumn, $orderColumn, array("id" => "desc"));
		$filterCount = $this->PartnerModel->countFiltered($_POST, "partner_master", $where, $searchColumn, $orderColumn,
			array("id" => "desc"));
		$totalCount = $this->PartnerModel->countAll("partner_master", $where);

		$response = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $filterCount,
			"recordsFiltered" => $totalCount,
			"data" => $metaData,
		);
		echo json_encode($response);
	}

	public function inactivePartner(){
		$id= $this->input->post("id");
		$resultObject=$this->PartnerModel->updatePartner(array("status"=>1),array("id"=>$id));
		if ($resultObject->status) {
			$response['status'] = 200;
			$response['body'] = "successfully save";
		} else {
			$response['status'] = 201;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function deletePartner(){
		if(!is_null($this->input->post("id")))
		{
			$id= $this->input->post("id");
			$resultObject=$this->PartnerModel->updatePartner(array("status"=>0),array("id"=>$id));
			if ($resultObject->status) {
				$response['status'] = 200;
				$response['body'] = "successfully save";
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
