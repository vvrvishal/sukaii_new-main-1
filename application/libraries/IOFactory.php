
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

//require_once APPPATH . "PHPExcel/PHPExcel/IOFactory.php";
require_once APPPATH."vendor\phpoffice\PHPExcel/Classes/PHPExcel.php";

class IOFactory extends PHPExcel_IOFactory {

	public function __construct() {
		parent::__construct();
	}

}

?>
