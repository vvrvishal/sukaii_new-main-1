<?php

require_once 'MasterModel.php';
class AdminModel extends MasterModel
{

	public function getDashboardData()
	{
		return $this->_select("customer_address", array("user_id" => $user_id, "status" => 1),"*",false);
	}

	public function deleteAddress($id,$user_id)
	{
		return $this->_update("customer_address", array("status" => 0), array("id" => $id,"user_id"=>$user_id));
	}


}
