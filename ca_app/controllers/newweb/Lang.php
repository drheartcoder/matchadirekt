<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'libraries/phpspreadsheet/src/Bootstrap.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Lang extends CI_Controller {

	private $exportPath;
	public function __construct() {
		parent::__construct();
    }

	public function index($lang){

		if($lang!=''){
			$_SESSION['site_lang']= $lang;

			$row = $this->db->query("SELECT * FROM tbl_lang WHERE abbreviation='$lang'")->result()['0'];

			$_SESSION['direction']=$row->rtl;


		}else{
			$_SESSION['site_lang']="";
			$_SESSION['direction']="ltr";
		}

		if($_GET['url'])
		{
			redirect($_GET['url']);
		}
		redirect($this->agent->referrer());
		//		$referred_from = $this->session->userdata('referred_from');
		//		redirect($referred_from, 'refresh');
		// 		redirect($_SERVER['HTTP_REFERER']);
		//		$this->session->has_userdata('some_name');	
	}
}