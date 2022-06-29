<?php

require_once 'MasterModel.php';
class EnquiryModel extends MasterModel
{


	public function addEnquiry($data){
		return $this->_insert("user_enquiry",$data);
	}

	public function deleteEnquiry($where){
		return $this->_update("user_enquiry",array("status"=>0),$where);
	}

	public function getEnquires(){
		return $this->_select("user_enquiry",array("status"=>1),"*",false);
	}

}
