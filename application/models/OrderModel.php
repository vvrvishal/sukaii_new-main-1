<?php
require_once 'MasterModel.php';
class OrderModel extends MasterModel
{
	public function orderInsert($table, $data){
		// $this->load->model('master_model');
		return $this->db->insert_batch($table, $data);
	}

	public function orderUpdate($table, $data,$where){
		return $this->_update($table,$data,$where);
	}

	public function partnerUpdate($table, $data,$where){
		return $this->_update($table,$data,$where);
	}
	
	public function allocatedLocationUpdate($table, $data,$where){
		return $this->_update($table,$data,$where);
	}
	
	public function getOrders($tableName, $where, $select = "*"){
		return $this->_select($tableName, $where, $select = "*", $type = true);
	}

	public function getLastOrder($sql){
		return $this->_rawQuery($sql);
	}
	public function getScheduleTime($where){
		return $this->_select('order_master',$where);
	}

	public function getMyBookings($sql){
		return $this->_rawQuery($sql);
	}
	public function getPatientData($sql){
		return $this->_rawQuery($sql);
	}

	public function getOrderData($sql){
		return $this->_rawQuery($sql);
	}
	public function getUserAddress($sql){
		return $this->_rawQuery($sql);
	}

	public function transactionInsert($table,$arrPaymentData){
		return $this->_insert($table, $arrPaymentData);
	}

	public function getOrderDetails($first_id){
		$sql = 'select * from order_master where id = '.$first_id;
		return $this->_rawQuery($sql);
	}

	public function getSampleCollectorDetails($first_id){
		$sql = 'select * from sample_collector where id = '.$first_id;
		return $this->_rawQuery($sql);
	}

//	public function updateOrder($orderId){
//		$sql = 'select * from sample_collector where id = '.$first_id;
//		return $this->_rawQuery($sql);
//	}



}
