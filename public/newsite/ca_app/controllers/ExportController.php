<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'libraries/phpspreadsheet/src/Bootstrap.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class ExportController extends CI_Controller {

	private $exportPath;
	public function __construct() {
		parent::__construct();
	   $this->load->database();

	   $this->exportPath=FCPATH.'Export';
	   

    }

	public function toxls($type){

		if(method_exists ($this , $type)){
			call_user_func(array($this , $type));
		}else{
			die();
		}
		 					
	}



	private function applications(){
		$user_id=$this->session->userdata('user_id');

		$result_applied_jobs = $this->applied_jobs_model
									->get_applied_job_by_employer_id($user_id, 100000,1);

		

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$i=1;
		
		$sheet->setCellValueByColumnAndRow(1,$i, lang('ID'));
		$sheet->setCellValueByColumnAndRow(2,$i, lang('job Title'));
		$sheet->setCellValueByColumnAndRow(3,$i, lang('First Name'));
		$sheet->setCellValueByColumnAndRow(4,$i, lang('Last Name'));
		
		$i=2;

		foreach ($result_applied_jobs as $job){
			$sheet->setCellValueByColumnAndRow(1,$i, $job->ID);
			$sheet->setCellValueByColumnAndRow(2,$i, $job->job_title);
			$sheet->setCellValueByColumnAndRow(4,$i, $job->first_name);
			$sheet->setCellValueByColumnAndRow(5,$i, $job->last_name);


			$i++;
		}
		 
		$writer = new Xlsx($spreadsheet);
		$name="Application".date('Y-m-d H-i-s').".xlsx";

		$this->SaveandDownload($writer,$name);
		

		
	}


	static function SaveandDownload($objWriter,$name){
	    $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
	    $objWriter->save($filePath);

		$data = file_get_contents($filePath);
		force_download($name, $data);
		exit;
		 
	}

}

