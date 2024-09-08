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
		$cond="";
		if($this->input->get('name_ref'))
		{
			$vr="LIKE '%".$this->input->get('name_ref')."%'";
			$ijd=explode("JS", $this->input->get('name_ref'));
			if(count($ijd)>1)
				$ijd=$ijd['1'];
			else
				$ijd=0;
			$ijd=intval($ijd);
			$ijd>0?$ijd="OR tbl_job_seekers.ID ='".$ijd."'":$ijd='';
			$cond.=" AND ( first_name $vr OR last_name $vr $ijd )";
		}
		if($this->input->get('email'))
		{
			$vr="LIKE '%".$this->input->get('email')."%'";
			$cond.=" AND ( email $vr )";
		}
		if($this->input->get('gender'))
		{
			$vr="LIKE '%".$this->input->get('gender')."%'";
			$cond.=" AND ( gender $vr )";
		}
		if($this->input->get('city'))
		{
			$vr="LIKE '%".$this->input->get('city')."%'";
			$cond.=" AND ( tbl_job_seekers.city $vr )";
		}
		if($cond=="")
		{
			$result_applied_jobs = $this->applied_jobs_model->get_applied_job_by_employer_id($this->session->userdata('user_id'), 1000000000, 1);
		}
		else
		{
			$result_applied_jobs=$this->db->query("SELECT tbl_seeker_applied_for_job.dated AS applied_date,tbl_job_seekers.ID AS job_seeker_ID, tbl_job_seekers.*,tbl_seeker_applied_for_job.*,tbl_post_jobs.* FROM tbl_seeker_applied_for_job INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID WHERE tbl_post_jobs.employer_ID='".$this->session->userdata('user_id')."' ".$cond."
		ORDER BY tbl_seeker_applied_for_job.ID DESC")->result();
		}

		

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$i=1;
		
		$sheet->setCellValueByColumnAndRow(1,$i, lang('Ref.'));
		$sheet->setCellValueByColumnAndRow(2,$i, lang('Candidate Name'));
		$sheet->setCellValueByColumnAndRow(3,$i, lang('Job Title'));
		$sheet->setCellValueByColumnAndRow(4,$i, lang('Applied Date'));
		
		$i=2;

		foreach ($result_applied_jobs as $job){
			$sheet->setCellValueByColumnAndRow(1,$i, "#JS".str_repeat("0",5-strlen($job->job_seeker_ID)).$job->job_seeker_ID);
			$sheet->setCellValueByColumnAndRow(2,$i, $job->first_name.' '.$job->last_name);
			$sheet->setCellValueByColumnAndRow(3,$i,  $job->job_title);
			$sheet->setCellValueByColumnAndRow(4,$i, date_formats($job->applied_date, 'M d, Y'));


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

