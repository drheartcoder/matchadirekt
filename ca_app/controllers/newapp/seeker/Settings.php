<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		/*error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
		$data=array();
		
		$data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);

		$this->outputData['data'] = $data;
		$this->load->view('application/seeker/settings_view',$this->outputData);
	}

	public function show_applications(){

		$data['ads_row'] = $this->ads;
		$data['title'] = SITE_NAME.': My Jobs';

		$result_applied_jobs = $this->My_model->exequery("SELECT tbl_seeker_applied_for_job.ID as applied_id,  tbl_seeker_applied_for_job.job_ID, tbl_seeker_applied_for_job.dated AS applied_date, tbl_post_jobs.job_title, tbl_companies.company_name 
					FROM `tbl_seeker_applied_for_job`
					INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
					INNER JOIN tbl_companies ON tbl_companies.ID=tbl_post_jobs.company_ID
					WHERE tbl_seeker_applied_for_job.seeker_ID=".$this->sessUserId." 
				    AND tbl_post_jobs.sts<>'archive' ORDER BY tbl_seeker_applied_for_job.ID DESC 
					");
		$this->outputData['data'] = $result_applied_jobs;
		$this->load->view('application/seeker/application_list_view',$this->outputData);

	}

	public function request(){

		$this->outputData['data'] = $data;
		$this->load->view('application/seeker/request_view',$this->outputData);

	}

	public function request_detail(){

		$this->outputData['data'] = $data;
		$this->load->view('application/seeker/request_detail_view',$this->outputData);

	}

	




	
}
