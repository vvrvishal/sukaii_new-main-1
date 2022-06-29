<?php

require_once 'MasterModel.php';
class ServiceModel extends MasterModel
{

	public function getServiceDetails($id){
		return $this->_select("serveices",array("id"=>$id,"status"=>1));
	}



}
