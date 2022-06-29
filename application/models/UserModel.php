<?php

require_once 'MasterModel.php';

class UserModel extends MasterModel
{

	public function getUserDetails($table,$where)
	{
		if ($table == 'users_master'){
			return $this->_select("users_master", $where,array("id", "name", "email", "contact", "address",  "user_type","registration_type", "token_id"));
		}else{
			return $this->_select("sample_collector", $where,array("id", "name", "email", "mobile as contact", "address", "3 as user_type","1 as registration_type", "12345 as token_id"));
		}

	}


	public function checkUserExists($where)
	{
		return $this->_select("users_master", $where,"*",true);
	}

	public function addUser($data)
	{
		return $this->_insert("users_master", $data);
	}

	public function updateUser($data, $id)
	{
		return $this->_update("users_master", $data, array("id" => $id));
	}


}
