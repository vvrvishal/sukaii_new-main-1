<?php

require_once 'MasterModel.php';
class CardModel extends MasterModel
{


	public function getAllCards($patientId){
		$sql = 'select * from card_details where user_id = '.$patientId;
		return $this->_rawQuery($sql);
	}
	public function checkCardExists($cardNymber){
		$sql = 'select * from card_details where card_number = '.$cardNymber;
		return $this->_rawQuery($sql);
	}
	public function addCard($data)
	{
		return $this->_insert("card_details", $data);
	}


}
