<?php


/**
 * @property  UserModel UserModel
 * @property  CustomerAddressModel CustomerAddressModel
 * @property  SmsModel SmsModel
 */
class UserController extends CI_Controller
{

	/**
	 * UserController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("UserModel");
		$this->load->model("CustomerAddressModel");
	}

	public function index()
	{
		$this->load->view("");
	}

	public function userProfileMenus()
	{
		if(!isset($this->session->user_session)){
			redirect("/login");
		}
		$this->load->view("UserProfile/user_profile");
	}

	public function helpCenter()
	{
		$this->load->view("UserProfile/help_center");
	}

	public function createAddress()
	{
		$redirectTo= get_cookie('authorized-service-order');
		$data["backToOrder"] =$redirectTo;
		$this->load->view("UserProfile/save_address",$data);
	}

	public function userManageAddress($id=null)
	{

		if(!isset($this->session->user_session)){
			redirect("/login");
		}
		$data = array();
		if(!is_null($id)){
			$redirectTo= get_cookie('authorized-service-order');
			if(is_null($redirectTo)){
				$redirectTo = "";
				if($id == "one"){
					$redirectTo = "serviceOrder";
				}
			}
			$data["backToOrder"] =$redirectTo;
		}else{
			$data["backToOrder"] ="";
		}
		$user_id = $this->session->user_session->id;
		$resultObject = $this->CustomerAddressModel->getUserAllAddress($user_id);


		$data["addressDetails"] = $resultObject->data;
		
		$this->load->view("UserProfile/manage_address", $data);
	}


	public function login()
	{
		$redirectTo = get_cookie('unauthorized-service-order');
		if(is_null($redirectTo)){
			$redirectTo = "";
		}
		$this->load->view("LoginReg/login",array("redirectTo"=>$redirectTo));
	}

	public function register()
	{
		$this->load->view("LoginReg/register");
	}

	public function loginVerification()
	{

		$username = $this->input->post("email");
		$password = $this->input->post("password");
		$token_id = $this->input->post("token_id");
		$type = $this->input->post("registrationType");
		$userType = '';
		$userSessionData = null;

		if (is_null($token_id)) {
			if (strpos($username, 'ssc_') === 0) {
				$table = 'sample_collector';
				$resultObject = $this->UserModel->getUserDetails($table,array("username" => $username, "password" => $password,"status"=>1));
			}else{
				$table = 'users_master';
				$resultObject = $this->UserModel->getUserDetails($table,array("email" => $username, "password" => $password,"status"=>1));
			}
//			$resultObject = $this->UserModel->getUserDetails(array("email" => $username, "password" => $password,"status"=>1));
			$sessionData = $this->getUserAddressHome($resultObject);

			if (is_null($sessionData)) {
				$response["status"] = 201;
				$response["body"] = "Invalid username and password";
				echo json_encode($response);
				exit();
			} else {
				$userType = $resultObject->data->user_type;
				$userSessionData = $sessionData;
			}
		} else {
			if (strpos($username, 'ssc_') === 0) {
				$table = 'sample_collector';
				$resultObject = $this->UserModel->getUserDetails($table,array("username" => $username, "password" => $password,"status"=>1));

				$name = $this->input->post("name");
				$userData = array("name" => $name, "email" => $username, "token_id" => $token_id, "registration_type" => $type, "user_type" => 3, "contact	" => "", "address" => "");
				$userType = 3;
			}else{
				$table = 'users_master';
				$resultObject = $this->UserModel->getUserDetails($table,array("email" => $username, "password" => $password,"status"=>1));

				$name = $this->input->post("name");
				$userData = array("name" => $name, "email" => $username, "token_id" => $token_id, "registration_type" => $type, "user_type" => 2, "contact	" => "", "address" => "");
				$userType = 2;
			}

//			$resultObject = $this->UserModel->getUserDetails(array("email" => $username, "token_id" => $token_id, "registration_type" => $type));
			$sessionData = $this->getUserAddressHome($resultObject);
			if (is_null($sessionData)) {

				$insertOperation = $this->UserModel->addUser($userData);
//				$this->registrationMail($username,$name);
				if ($insertOperation->status) {
					$userData["id"] = $insertOperation->inserted_id;
					$userSessionData = (object)$userData;
				} else {
					$response["status"] = 201;
					$response["body"] = "Invalid username and password";
					echo json_encode($response);
					exit();
				}
			} else {
				$userType = $resultObject->data->user_type;
				$userSessionData = $sessionData;
			}
		}
		$this->session->user_session = $userSessionData;
		$this->session->cart_session = array();
		$response["status"] = 200;
		$response["body"] = "login Successfully!";
		$response["userType"] = $userType;

		echo json_encode($response);
	}


	function registerUser()
	{

		$userSessionData = null;
		$name = $this->input->post("full_name");
		$mobile = $this->input->post("mobile");
		$email = $this->input->post("email");
		$gender = $this->input->post("gender");
		$password = $this->input->post("password");

		if (!is_null($name) && !is_null($mobile) && !is_null($email)
			&& !is_null($gender) && !is_null($password)) {
			$userCheck = $this->UserModel->checkUserExists(array("email"=>$email));
			if ($userCheck->totalCount > 0){
				$response["status"] = 201;
				$response["body"] = "User already exists";
			}else{
				$data = array(
					"name" => $name,
					"email" => $email,
					"password" => $password,
					"registration_type" => 1,
					"user_type" => 2,
					"contact" => $mobile,
					"gender" => $gender
				);
				$resultObject = $this->UserModel->addUser($data);

//			$emailResult=$this->registrationMail($email,$name);
				if ($resultObject->status) {
					$resultObject = $this->MasterModel->_select('users_master',array("id"=>$resultObject->inserted_id));
//					$this->->getUserDetails('users_master',array("id" => $resultObject->inserted_id));
					$this->session->user_session = $resultObject->data;
					//Support version greater than or equal 7.X.X
					$sender = 'Sukaii';
					$msg = "Thank you for register";
					$sentSmsRegister = $this->sendSMSFunctionality($sender,$mobile,$msg);
					$objSentSmsRegister = json_decode($sentSmsRegister);
					$smsStatus = (int)$objSentSmsRegister->code;
					$response["smsResp"] = $smsStatus;
					if ($smsStatus == 0){
						$response["smsBody"] = $objSentSmsRegister->detail;
					}else{
						$response["smsBody"] = $objSentSmsRegister->detail;
					}

					$response["status"] = 200;
					$response["body"] = "Save successfully";
				} else {
					$response["status"] = 201;
					$response["body"] = "Failed to save";
				}
			}


		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid username and password";
		}
		echo json_encode($response);
	}

	function getUserAddressHome($resultObject)
	{
		if ($resultObject->totalCount === 1) {
			$userSessionData = $resultObject->data;
			$addressResult = $this->CustomerAddressModel->getUserAddress($userSessionData->id);
			if ($addressResult->totalCount === 1) {
				$userSessionData->address = $addressResult->data;
			}
			return $userSessionData;
		} else {
			return null;
		}
	}

	public function getUserAddress()
	{

		$user_id = $this->session->user_session->id;
		$resultObject = $this->CustomerAddressModel->getUserAllAddress($user_id);
		if ($resultObject->totalCount > 0) {
			$response["status"] = $resultObject->data;
			$response["body"] = array();
		} else {
			$response["status"] = 201;
			$response["body"] = array();
		}
		echo json_encode($response);
	}


	public function addUserAddress()
	{
		$line1 = $this->input->post("line_1");
		$line2 = $this->input->post("line_2");
		$line3 = $this->input->post("line_3");
		$line4 = $this->input->post("line_4");
		$lat = $this->input->post("location_lat");
		$long = $this->input->post("location_long");
		$address_name = $this->input->post("address_name_h");
		$user_id = $this->session->user_session->id;

		if (!is_null($address_name) && !is_null($user_id)) {
			$data = array("line_1" => $line1, "line_2" => $line2, "line_3" => $line3, "line_4" => $line4,
				"location_long" => $long, "location_lat" => $lat,
				"address_name" => $address_name, "user_id" => $user_id
			);
			$resultObject = $this->CustomerAddressModel->addAddress($data);
			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = "Save successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed to save";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}


	public function deleteUserAddress()
	{

		$id = $this->input->post("address_id");
		$user_id = $this->session->user_session->id;

		$resultObject = $this->CustomerAddressModel->deleteAddress($id, $user_id);

		if ($resultObject->status) {
			$response["status"] = 200;
			$response["body"] = "Save successfully";
		} else {
			$response["status"] = 201;
			$response["body"] = "Failed to save";
		}
		echo json_encode($response);
	}

	public function logout()
	{

		$this->session->sess_destroy();

		redirect();
	}

	public function getAllUser()
	{
		$where = array("status" => 1);
		$select = array("*");
		$searchColumn = array("name", "email", "contact", "address","registration_type","gender");
		$orderColumn = array("id", "name","email");
		$metaData = $this->UserModel->getRows($_POST, $where, $select, "users_master",
			$searchColumn, $orderColumn, array("id" => "desc"));
		$filterCount = $this->UserModel->countFiltered($_POST, "users_master", $where, $searchColumn, $orderColumn,
			array("id" => "desc"));
		$totalCount = $this->UserModel->countAll("users_master", $where);

		$response = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $filterCount,
			"recordsFiltered" => $totalCount,
			"data" => $metaData,
		);
		echo json_encode($response);
	}

	public function deleteUser(){
		if(!is_null($this->input->post("id")))
		{
			$id= $this->input->post("id");
			$resultObject=$this->UserModel->updateUser(array("status"=>0),$id);
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

	public function registrationMail($to,$name){
		$body=$this->getMailFormat($name,$to);
		$this->load->model("SmsModel");
		return $this->SmsModel->sendMail($to,"Thank you to for registration at sukaii",$body);
	}

	public function getMailFormat($name,$username){
		return '
		<!DOCTYPE html>
		<html lang="en">
		
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>thank you for your registration at Sukaii</title>
		</head>
		<body style="padding: 0px; margin: 0px;">
		<p style="padding: 1rem; text-align: justify;">Dear '.$name.' ,<br> Welcome, We thank you for your registration at Sukaii website.<br><br> Your user id is <b>'.$username.'</b><br><br>        
        You will use this user id given above for booked all your services on <a href="https://sukaii.ecovisrkca.com">Sukaii.</a><br><br> The user id cannot be changed and hence we recommend that you store this email for your future reference.<br><br> We understand
        that you have read and agreed to the Terms and Conditions as applicable for transactions on our site. You can now book your services online. We hope to offer you a uniquely pleasant experience in planning and booking your servises with the
        <a href="sukaii.ecovisrkca.com">Sukaii</a>. We look forward to having you use our services regularly. In case you require any further assistance, please mail us at <a href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin"><b>admin@suakii.com</b></a>        or call us at 24*7 Hrs. Customer Support at <b>888777666554</b>.</p>
   
		';
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

	public function forgotPasswordMailFormat($name,$email)
	{
		return '
		<!DOCTYPE html>
		<html lang="en">
		
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Reset password</title>
		</head>
		<body style="padding: 0px; margin: 0px;">
		<p style="padding: 1rem; text-align: justify;">Dear '.$name.' ,<br>Click on the link below to reset your password <a href="'.base_url().'forgetPasswordLink/'.$email.'">Sukaii.</a><br><br> The user id cannot be changed and hence we recommend that you store this email for your future reference.<br><br> We understand
        that you have read and agreed to the Terms and Conditions as applicable for transactions on our site. You can now book your services online. We hope to offer you a uniquely pleasant experience in planning and booking your servises with the
        <a href="sukaii.ecovisrkca.com">Sukaii</a>. We look forward to having you use our services regularly. In case you require any further assistance, please mail us at <a href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin"><b>admin@suakii.com</b></a>        or call us at 24*7 Hrs. Customer Support at <b>888777666554</b>.</p>
   
		';
	}

	public function forgotPassword()
	{
		$email = $this->input->post('email');
//		$emailencrypted = $email;
		//forgotPassword

		$emailencrypted = base64_encode($email);

		$resultObject = $this->UserModel->getUserDetails('users_master',array("email" => $email));
		$sessionData = $this->getUserAddressHome($resultObject);
		if($email==""){
			$response["status"] = 202;
			$response["body"] = "Email should not be blank";
		}
		else if(is_null($sessionData)) {
			$response["status"] = 201;
			$response["body"] = "Invalid username and password";
			// echo json_encode($response);
			// redirect("/login");
		}
		else{
			$response["status"] = 200;
			$response["body"] = "User found..";
//			 $body=$this->forgotPasswordMailFormat($email,$emailencrypted);
//			 $this->load->model("SmsModel");
//			 return $this->SmsModel->sendMail($resultObject->name,"Reset password",$body);
			// echo json_encode($response);
		}
		echo json_encode($response);
	}
	public function forgetPasswordLink()
	{
		$email_enc = $this->uri->segment('2');
		// print_r($this->input->get('$1'));
		$decrypted_email = base64_decode($email_enc);
		$resultObject = $this->UserModel->getUserDetails('users_master',array("email" => $decrypted_email));
		$sessionData = $this->getUserAddressHome($resultObject);
		if (is_null($sessionData)) {
			$response["status"] = 201;
			$response["body"] = "Invalid username";
			echo json_encode($response);
			// redirect("/login");
		}
		else{
			$response["status"] = 200;
			$response["body"] = "User found..";
		}
	}

	public function changePassword()
	{
		$email = $this->input->post("email");
		$password = $this->input->post("newPassword");
		$resultObject = $this->MasterModel->_update("users_master", array("password"=>$password), array("email" => $email));
		if ($resultObject->status) {
			$resultObject1 = $this->MasterModel->_select("users_master",array("email" => $email));
			$response["pass"] = $resultObject1;
			$response["status"] = 200;
			$response["body"] = "update successfully";
		} else {
			$response["status"] = 201;
			$response["body"] = "Failed to save";
		}
		echo json_encode($response);
	}
}

