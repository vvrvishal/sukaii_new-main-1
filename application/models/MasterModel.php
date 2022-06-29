<?php


class MasterModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $sql query which you want to execute
	 * @return stdClass witch properties of totalCount and data of query result
	 */
	function _rawQuery($sql)
	{
		$resultObject = new stdClass();
		try {
			$query = $this->db->query($sql, FALSE);
			$result = $query->result();
			if (is_array($result)){
				if (count($result) > 0) {
					$resultObject->totalCount = count($result);
					$resultObject->data = $result;
				} else {
					$resultObject->totalCount = 0;
					$resultObject->data = array();
				}
			}else{
				$resultObject->totalCount = $this->db->affected_rows();
			}
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->totalCount = 0;
			$resultObject->data = array();
		}
		return $resultObject;
	}

	/**
	 * @param $table String table name
	 * @param $data array values
	 * @return stdClass object of status and last insert id
	 */
	function _insert($table, $data)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert($table, $data);
			$resultObject->inserted_id = $this->db->insert_id();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	/**
	 * @param $table String the table name
	 * @param $data  array you want to update
	 * @param $where array where update record
	 * @return stdClass object with property of status
	 */
	function _update($table, $data, $where)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->set($data)->where($where)->update($table);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	/**
	 * @param $table String the table name
	 * @param $data  array you want to update including where column name
	 * @param $key String where column name
	 * @return stdClass object with property of status
	 */
	function _updateBatch($table, $data, $key)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->update_batch($table, $data, $key);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}


	/**
	 * @param $table String the table name
	 * @param $where array where delete record
	 * @return stdClass object with property of status
	 */
	function _delete($table, $where)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->where($where)->delete($table);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}


	/**
	 * @param $tableName String table name
	 * @param $where array of condition
	 * @param $select array|String of columns
	 * @param $type true for single row and false for multiple rows
	 * @return stdClass object with property of totalCount and data
	 */
	function _select($tableName, $where, $select = "*", $type = true)
	{

		$resultObject = new stdClass();
		try {
			if ($type) {
				$result = $this->db->select($select)->where($where)->get($tableName)->row();
				if ($result != null) {
					$resultObject->totalCount = 1;
					$resultObject->data = $result;
				} else {
					$resultObject->totalCount = 0;
					$resultObject->data = $result;
				}
			} else {
				$result = $this->db->select($select)->where($where)->get($tableName)->result();
				$resultObject->totalCount = count($result);
				if (count($result) > 0) {
					$resultObject->data = $result;
				} else {
					$resultObject->data = array();
				}
			}
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $e) {
			$resultObject->totalCount = 0;
			$resultObject->data = null;
		}
		return $resultObject;
	}

	public function getRows($postData, $where, $select, $table, $column_search, $column_order, $order, $group_by = null, $where_or = null, $having = null, $customWhereCondition = null)
	{

		$this->_get_datatables_query($postData, $table, $column_search, $column_order, $order, $group_by);
		if ($having != null) {
			if (!empty($having)) {
				$this->db->having($having['column'], $having['value']);
			}

		}
		if ($postData['length'] != -1) {
			$this->db->limit($postData['length'], $postData['start']);
		}
//		$this->where = $where;


		if($where_or != null){
			$this->db->where($where);
			$this->db->or_where($where_or);
		}else{
			$this->db->where($where);
			if ($customWhereCondition != null)
				$this->db->where($customWhereCondition);
		}

		$query = $this->db->select($select)->get();

		//echo $this->db->last_query();
		return $query->result();
	}

	/*
	 * Count all records
	 */

	public function countAll($table, $where,$customWhereCondition=null)
	{
		if($customWhereCondition !=null){
			$this->db->where($customWhereCondition);
		}
		$this->db->where($where)->from($table);
		return $this->db->count_all_results();
	}

	public function countFiltered($postData, $table, $where, $column_search, $column_order, $order,$customWhereCondition=null,$having=null,$select =null)
	{
		$this->_get_datatables_query($postData, $table, $column_search, $column_order, $order);
		if($where !=null){
			$this->db->where($where);
		}
		if($customWhereCondition !=null){
			$this->db->where($customWhereCondition);
		}
		if ($having != null) {
			if (!empty($having)) {
				$this->db->having($having['column'], $having['value']);
			}

		}
		if($select != null){
			$this->db->select($select);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	/*
	 * Perform the SQL queries needed for an server-side processing requested
	 * @param $_POST filter data based on the posted parameters
	 */

	public function _get_datatables_query($postData, $table, $column_search, $column_order, $order, $group_by = null)
	{

		$this->db->from($table);
		$i = 0;
		// loop searchable columns
		foreach ($column_search as $item) {
			// if datatable send POST for search
			if ($postData['search']['value']) {
				// first loop
				if ($i === 0) {
					// open bracket
					$this->db->group_start();
					$this->db->like($item, $postData['search']['value']);
				} else {
					$this->db->or_like($item, $postData['search']['value']);
				}
				// last loop
				if (count($column_search) - 1 == $i) {
					// close bracket
					$this->db->group_end();
				}
			}
			$i++;
		}
		if ($group_by != null) {
			$this->db->group_by($group_by);
		}
		if (isset($postData['order'])) {
			$column = (int)$postData['order']['0']['column'];
			if (count($column_order) > $column)
				$this->db->order_by($column_order[$column], $postData['order']['0']['dir']);
		} else if (count($order)>0) {

			$this->db->order_by(key($order), $order[key($order)]);

		}
	}


	function sendEmail($to, $subject, $message)
	{
		$from_email = 'value@gbtech.in'; //change this to yours
		$this->load->library('email');
		//configure email settings
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.gbtech.in'; //smtp host name
		$config['smtp_port'] = '587'; //smtp port number 587 on server
		$config['smtp_user'] = $from_email;
		$config['smtp_pass'] = 'gbtech@2019'; //$from_email password
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n"; //use double quotes
		$this->email->initialize($config);

		//send mail
		$this->email->from($from_email, 'RMT Team');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			return true;
		} else {
			return false;
		}
	}

	/*
	 * @param number, message
	 */

	public function sendSMS($number,$templateData,$template,$templateID=1){
		$username="bharatmishra1";
		$password ="bharat@100";
		$sender="GLDBRZ";
		$message="";
		$postData = array(
			'user' => "bharatmishra1",
			'password'=>"bharat@100",
			'mobile' =>$number,
			'sender' => $sender,
			'type' => '3'
		);
		switch ($templateID){
			case 1:
				$postData["template_id"]=$template;
				$postData['message'] = "".$templateData['name']." has been admitted in the ".$templateData['center']." and has been allotted ".$templateData['bed']." in ".$templateData['room']." -Gold Berries";
				break;
			case 2:
				$postData["template_id"]=$template;
				$postData['message'] = "".$templateData['name']." has been transferred to ".$templateData['center']." in ".$templateData['bed']." in ".$templateData['room']." -Gold Berries";
				break;
			case 3:
				$postData["template_id"]=$template;
				$postData['message'] = "Treatment has been started for ".$templateData['otp']." -Gold Berries";
				$postData['message'] = "OTP for Login Transaction on ".$templateData['company']." is ".$templateData['otp']." and valid till ".$templateData['time'].".Do not share this OTP to anyone for security reasons -Gold Berries";
				break;
		}

		$client = new Client();
		$response = $client->request('GET', 'http://api.bulksmsgateway.in/sendmessage.php', array(
			'query' =>$postData
		));
		return $response->getBody();

	}

	/*
 * return file name
 *
 */

	function check_file_exist($upload_path)
	{
		$filesnames = array();

		foreach (glob('./' . $upload_path . '/*.*') as $file_NAMEEXISTS) {
			$file_NAMEEXISTS;
			$filesnames[] = str_replace("./" . $upload_path . "/", "", $file_NAMEEXISTS);
		}
		return $filesnames;
	}

	function upload_multiple_file($upload_path, $inputname, $combination = "")
	{

		$combination = (explode(",", $combination));

		$check_file_exist = $this->check_file_exist($upload_path);
		if (isset($_FILES[$inputname]) && $_FILES[$inputname]['error'] != '4') {

			$files = $_FILES;
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = '*';
//            $config['max_size'] = '20000000';    //limit 10000=1 mb
			$config['remove_spaces'] = true;
			$config['overwrite'] = false;

			$this->load->library('upload', $config);

			if (is_array($_FILES[$inputname]['name'])) {
				$count = count($_FILES[$inputname]['name']); // count element
				$files = $_FILES[$inputname];
				$images = array();
				$dataInfo = array();
				if ($count > 0) {
					if (in_array("1", $combination)) {
						for ($j = 0; $j < $count; $j++) {
							$fileName = $files['name'][$j];
							if (in_array($fileName, $check_file_exist)) {
								$response['status'] = 201;
								$response['body'] = $fileName . " Already exist";
								return $response;
							}
						}
					}
					$inputname = $inputname . "[]";
					for ($i = 0; $i < $count; $i++) {
						$_FILES[$inputname]['name'] = $files['name'][$i];
						$_FILES[$inputname]['type'] = $files['type'][$i];
						$_FILES[$inputname]['tmp_name'] = $files['tmp_name'][$i];
						$_FILES[$inputname]['error'] = $files['error'][$i];
						$_FILES[$inputname]['size'] = $files['size'][$i];
						$fileName = $files['name'][$i];
						//get system generated File name CONCATE datetime string to Filename
						if (in_array("2", $combination)) {
							$date = date('Y-m-d H:i:s');
							$randomdata = strtotime($date);
							$fileName = $randomdata . $fileName;
						}
						$images[] = $fileName;

						$config['file_name'] = $fileName;

						$this->upload->initialize($config);
						$up = $this->upload->do_upload($inputname);
						//var_dump($up);
						$dataInfo[] = $this->upload->data();
					}
					//var_dump($dataInfo);

					$file_with_path = array();
					foreach ($dataInfo as $row) {
						$raw_name = $row['raw_name'];
						$file_ext = $row['file_ext'];
						$file_name = $raw_name . $file_ext;
						if(!empty($file_name)){
							$file_with_path[] = $upload_path . "/" . $file_name;
						}
					}
					if (count($file_with_path) > 0) {
						$response['status'] = 200;
						$response['body'] = $file_with_path;
					} else {
						$response['status'] = 201;
						$response['body'] = $file_with_path;
					}
					return $response;
				} else {
					$response['status'] = 201;
					$response['body'] = array();
					return $response;
				}
			} else {
				$response['status'] = 201;
				$response['body'] = array();
				return $response;
			}
		} else {
			$response['status'] = 201;
			$response['body'] = array();
			return $response;
		}
	}
}
