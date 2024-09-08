<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Application extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index($redirectTo = 0){
		$this->db->query("UPDATE `tbl_seeker_applied_for_job` SET `isNew`=0,`isView`=1 WHERE  employer_ID = ".$this->sessUserId);
		$fieldArray = "tbl_seeker_applied_for_job.ID,tbl_seeker_applied_for_job.seeker_ID,tbl_seeker_applied_for_job.job_ID,tbl_seeker_applied_for_job.dated,tbl_seeker_applied_for_job.employer_ID, tbl_job_seekers.first_name, tbl_job_seekers.email, tbl_post_jobs.job_title";
		$applicationData = $this->My_model->exequery("SELECT ".$fieldArray." FROM `tbl_seeker_applied_for_job` LEFT JOIN tbl_job_seekers ON tbl_seeker_applied_for_job.seeker_ID = tbl_job_seekers.ID LEFT JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID WHERE tbl_seeker_applied_for_job.employer_ID = ".$this->sessUserId);
		//myPrint($applicationData);exit;	
		$this->outputData['applicationData'] = $applicationData;
		$this->outputData['redirectTo'] = $redirectTo;
		$this->load->view('newweb/employer/application_list_view',$this->outputData);
	}

	


}
