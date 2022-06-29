<?php
require 'vendor/autoload.php';
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  OrderModel OrderModel
 */
class ExcelController extends CI_Controller
{

	public function index()
	{
		// $this->load->view('welcome_message');
	}

	function fileToUpload()
	{
		$fileName = 'report_file';
		$order_id = $this->input->post("order_id");
		$patient_id = $this->input->post("patient_id");

		$uploadPath = 'uploads';
		$response = $this->upload_multiple_file_new($uploadPath, $fileName, "");
		if ($response["status"] == 200) {
			if (count($response["body"]) > 0) {
				$path = $response["body"][0];
				$object = PHPExcel_IOFactory::load($path);
				$worksheet = $object->getActiveSheet();
				$highestRow = $worksheet->getHighestRow();
				$service_id = 1481;
				$ExcelArray = array();
				for ($i = 2; $i <= $highestRow; $i++) {
					$TScode = $object->getActiveSheet()->getCell('N' . $i)->getValue();
					$TsDesc = $object->getActiveSheet()->getCell('O' . $i)->getValue();
					$TCcode = $object->getActiveSheet()->getCell('P' . $i)->getValue();
					$Tcdesc = $object->getActiveSheet()->getCell('Q' . $i)->getValue();
					$result = $object->getActiveSheet()->getCell('R' . $i)->getValue();
					$ResultRef = $object->getActiveSheet()->getCell('S' . $i)->getValue();
					$resultFlag = $object->getActiveSheet()->getCell('T' . $i)->getValue();
					$resultUnit = $object->getActiveSheet()->getCell('U' . $i)->getValue();
					$data = array(
						"patient_id" => $patient_id,
						"service_id" => $service_id,
						"ts_code" => $TScode,
						"ts_desc" => $TsDesc,
						"tc_code" => $TCcode,
						"result" => $result,
						"ref" => $ResultRef,
						"flag" => $resultFlag,
						"unit" => $resultUnit,
						"order_id" => $order_id,
					);
					array_push($ExcelArray, $data);
				}

				if (count($ExcelArray) > 0) {

					$result = $this->db->insert_batch('report_master', $ExcelArray);
					if ($result == true) {
						$response['order_id']= $order_id;
						$response['status'] = 200;
						$response['body'] = "Added Successfully";
					} else {
						$response['status'] = 201;
						$response['body'] = "Something Went Wrong";
					}
				} else {
					$response['status'] = 201;
					$response['body'] = "No Data Found in Excel";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Something Went Wrong";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "File Not Upload";
		}

		echo json_encode($response);
	}

	function check_file_exist($upload_path)
	{
		$filesnames = array();

		foreach (glob('./' . $upload_path . '/*.*') as $file_NAMEEXISTS) {
			$file_NAMEEXISTS;
			$filesnames[] = str_replace("./" . $upload_path . "/", "", $file_NAMEEXISTS);
		}
		return $filesnames;
	}


	function upload_multiple_file_new($upload_path, $inputname, $combination = "")
	{
		$combination = (explode(",", $combination));
		$check_file_exist = $this->check_file_exist($upload_path);
		if (isset($_FILES[$inputname]) && $_FILES[$inputname]['error'] != '4') {
			$files = $_FILES;
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = '*';
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
						if (in_array("2", $combination)) {
							$date = date('Y-m-d H:i:s');
							$randomdata = strtotime($date);
							$fileName = $randomdata . $fileName;
						}
						$images[] = $fileName;
						$config['file_name'] = $fileName;
						$this->upload->initialize($config);
						$up = $this->upload->do_upload($inputname);
						$dataInfo[] = $this->upload->data();
					}
					$file_with_path = array();
					foreach ($dataInfo as $row) {
						$raw_name = $row['raw_name'];
						$file_ext = $row['file_ext'];
						$file_name = $raw_name . $file_ext;
						if (!empty($file_name)) {
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
