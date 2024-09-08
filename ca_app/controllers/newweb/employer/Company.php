<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class COMPANY extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();
	public function index(){

		$compDetails = $this->employers_model->get_employer_by_id($this->sessUserId);
		//$data['row'] = $row;
		//echo $this->sessCompanyId;
		//myPrint($compDetails);die;
		
		$jobApplied="SELECT 
				tbl_post_jobs.job_title,
				tbl_seeker_applied_for_job.dated AS applied_date,
				tbl_job_seekers.ID AS job_seeker_ID, 
				tbl_job_seekers.*,tbl_seeker_applied_for_job.*,
				tbl_post_jobs.* 
			FROM 
				tbl_seeker_applied_for_job 
			INNER JOIN 
				tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID 
			INNER JOIN 
				tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID 
			WHERE 
				tbl_seeker_applied_for_job.deleted=0
			AND
				tbl_post_jobs.employer_ID='".$this->sessUserId."' ".$cond."
		ORDER BY 
			tbl_seeker_applied_for_job.ID DESC";

			$result_applied_jobs=$this->db->query($jobApplied)->result();
		
		$seekerDatils['result_applied_jobs']= $result_applied_jobs;

		//myPrint($seekerDatils);die;

		$result_posted_jobs = $this->My_model->exequery("SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo	FROM `tbl_post_jobs` AS pj INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID WHERE pj.company_ID=".$compDetails->company_ID." AND pj.sts IN ('active', 'inactive', 'pending', 'archive') AND pc.sts = 'active' AND pc.sts <> 'archive' and pj.deleted=0 ORDER BY ID DESC");
		 $currentJobs['result_posted_jobs'] = $result_posted_jobs;


		


	$this->outputData['compDetails']=$compDetails;	
	$this->outputData['seekerDatils']=$seekerDatils['result_applied_jobs'];
	$this->outputData['currentJobs']=$currentJobs['result_posted_jobs'];
	//myPrint($currentJobs);die;

	$this->load->view('newweb/employer/my_company_view',$this->outputData);
	}

	public function emp_full_post(){

		

		$this->load->view('newweb/employer/emp_full_post_view');
		
	}
}
