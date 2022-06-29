<?php

require_once 'MasterModel.php';
class PartnerModel extends MasterModel
{

	public function addPartner($data)
	{
		return $this->_insert("partner_master", $data);
	}

	public function updatePartner($data,$where)
	{
		return $this->_update("partner_master", $data,$where);
	}

	public function getPartner($where)
	{
		return $this->_select("partner_master", $where);
	}

	public function getPartners($where)
	{
		return $this->_select("partner_master", $where, "*", false);
	}

}
