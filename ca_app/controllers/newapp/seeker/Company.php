<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Company extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$data=array();
		
		$data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);

		$this->outputData['data'] = $data;
		$this->load->view('application/seeker/job_provider_company_view',$this->outputData);
	}	
	public function detail($employerId = 0,$redirectTo = 0){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$compDetails = $this->employers_model->get_employer_by_id($employerId);

		$postedJobs = $this->My_model->exequery("SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo	FROM `tbl_post_jobs` AS pj INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID WHERE pj.company_ID=".$compDetails->company_ID." AND  pc.sts = 'active' AND pj.deleted=0 ORDER BY ID DESC");
		
		$this->outputData['comp']	=$compDetails;
		$this->outputData['postedJobs']	=$postedJobs;
		$this->outputData['redirectTo']	=$redirectTo;

	/*	myPrint($comp);
		myPrint($postedJobs);*/
		$this->load->view('application/seeker/job_provider_company_view',$this->outputData);
	}
}
