<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	
	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		
		//Job Seeker Skils
		$job_seeker_skills = $this->job_seekers_model->get_grouped_skills_by_seeker_id($this->sessUserId	);
		$skills = explode(',',@$job_seeker_skills);
		
		$skill_qry='';
		if($skills){
			foreach($skills as $sk){
				$skill_qry.=" OR required_skills LIKE '%".trim($sk)."%'";
			}
		}
		else {
			$skill_qry.= " required_skills LIKE '%".trim($skills)."%'";
		}
		
		$skill_qry = ltrim($skill_qry,'OR ');
		
		//Jobs by skills
		$result_jobs = $this->posted_jobs_model->get_matching_searched_jobs($skill_qry, 50, 0);
		$appliedJobs = array();
		$rejectedJobs = array();
		$wishlistedJobs = array();
		$appliedJobs = $this->My_model->selTableData("tbl_seeker_applied_for_job","job_ID","seeker_ID = ".$this->sessUserId);
		$rejectedJobs = $this->My_model->selTableData("tbl_seeker_rejected_for_job","job_ID","seeker_ID = ".$this->sessUserId);
		$wishlistedJobs = $this->My_model->selTableData("tbl_seeker_wishlisted_job","job_ID","seeker_ID = ".$this->sessUserId);
		$excludedJobsArray = array();

		if(isset($appliedJobs) && $appliedJobs != "" ){
			$excludedJobsArray = array_merge($excludedJobsArray,$appliedJobs);
		} 
		if(isset($rejectedJobs) && $rejectedJobs != ""){
			$excludedJobsArray  = array_merge($excludedJobsArray,$rejectedJobs);
		} 
		if(isset($wishlistedJobs) && $wishlistedJobs != ""){
			$excludedJobsArray =  array_merge($excludedJobsArray,$wishlistedJobs);
		}
		$finalExclude = array();
		$resData = array();
		if(isset($excludedJobsArray) && $excludedJobsArray != ""){
			foreach($excludedJobsArray as $exclude){
				array_push($finalExclude, $exclude->job_ID );
			}
			
		}
		if(isset($result_jobs) && $result_jobs != ""){
			$dataString = "";
			$i =count($result_jobs);
			foreach($result_jobs as $job){
				if(!in_array($job->ID, $finalExclude)){
					array_push($resData, $job);	
				}
			}
		}
		$data['resData'] = $resData;
		$data['countOfJob'] = count($resData);
		$this->load->view('newweb/seeker/job_tiles_view',$data);
	}

	public function action(){
		if($_POST['btnReject']){
			echo 'reject';
			myPrint($_POST);exit;
		}
	}

	public function get_count_of_matching_jobs(){
		$job_seeker_skills = $this->job_seekers_model->get_grouped_skills_by_seeker_id($this->sessUserId	);
		$skills = explode(',',@$job_seeker_skills);
		
		$skill_qry='';
		if($skills){
			foreach($skills as $sk){
				$skill_qry.=" OR required_skills LIKE '%".trim($sk)."%'";
			}
		}
		else {
			$skill_qry.= " required_skills LIKE '%".trim($skills)."%'";
		}
		
		$skill_qry = ltrim($skill_qry,'OR ');
		
		//Jobs by skills
		$result_jobs = $this->posted_jobs_model->get_matching_searched_jobs($skill_qry, 50, 0);

		echo count($result_jobs);
	}	

	public function job_details($jid = 0, $returnTo = 0){
		$data =array();
		$jobData=$this->db->query("SELECT *,tbl_employers.city AS emp_city,tbl_employers.country AS emp_country,tbl_post_jobs.ID AS JID, tbl_post_jobs.dated AS dated from tbl_post_jobs
								LEFT JOIN tbl_companies ON tbl_post_jobs.company_ID=tbl_companies.ID
								LEFT JOIN tbl_employers ON tbl_post_jobs.employer_ID=tbl_employers.ID
								LEFT JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
								WHERE tbl_post_jobs.ID = ".$jid)->result();
		$isAlreadyApplied = $this->My_model->selTableData('tbl_seeker_applied_for_job',"","seeker_ID = ".$this->sessUserId." AND job_ID = ".$jid);
		//myPrint($jobData);

		if($returnTo == 3){
			$this->db->query("UPDATE `tbl_seeker_notification` SET `isNew`=0 WHERE  seekerId = ".$this->sessUserId." AND jobId = ".$jid);
		}
		$data['jobData'] = $jobData[0];
		$data['returnTo'] = $returnTo;
		$data['isAlreadyApplied'] = $isAlreadyApplied;
		//myPrint($data);exit;
		$this->load->view('newweb/seeker/job_detail_view',$data);
	}

	public function get_list_of_matching_jobs(){
		//Job Seeker Skils
		$job_seeker_skills = $this->job_seekers_model->get_grouped_skills_by_seeker_id($this->sessUserId	);
		$skills = explode(',',@$job_seeker_skills);
		
		$skill_qry='';
		if($skills){
			foreach($skills as $sk){
				$skill_qry.=" OR required_skills LIKE '%".trim($sk)."%'";
			}
		}
		else {
			$skill_qry.= " required_skills LIKE '%".trim($skills)."%'";
		}
		
		$skill_qry = ltrim($skill_qry,'OR ');
		
		//Jobs by skills
		$result_jobs = $this->posted_jobs_model->get_matching_searched_jobs($skill_qry, 50, 0);
		$appliedJobs = array();
		$rejectedJobs = array();
		$wishlistedJobs = array();
		$appliedJobs = $this->My_model->selTableData("tbl_seeker_applied_for_job","job_ID","seeker_ID = ".$this->sessUserId);
		$rejectedJobs = $this->My_model->selTableData("tbl_seeker_rejected_for_job","job_ID","seeker_ID = ".$this->sessUserId);
		$wishlistedJobs = $this->My_model->selTableData("tbl_seeker_wishlisted_job","job_ID","seeker_ID = ".$this->sessUserId);
		$excludedJobsArray = array();

		if(isset($appliedJobs) && $appliedJobs != "" ){
			$excludedJobsArray = array_merge($excludedJobsArray,$appliedJobs);
		} 
		if(isset($rejectedJobs) && $rejectedJobs != ""){
			$excludedJobsArray  = array_merge($excludedJobsArray,$rejectedJobs);
		} 
		if(isset($wishlistedJobs) && $wishlistedJobs != ""){
			$excludedJobsArray =  array_merge($excludedJobsArray,$wishlistedJobs);
		}

		$finalExclude = array();
		if(isset($excludedJobsArray) && $excludedJobsArray != ""){
			foreach($excludedJobsArray as $exclude){
				array_push($finalExclude, $exclude->job_ID );
			}
			
		}
		if(isset($result_jobs) && $result_jobs != ""){
			$dataString = "";
			$i =count($result_jobs);
			foreach($result_jobs as $job){
				if(!in_array($job->ID, $finalExclude)){
					$dataString .= '<li class="tiles-li-'.$i.' tc-card"><div class="accept-reject-span"><span class="spnLeft text-danger" style="align-content: left; opacity: 0">Reject <input type="hidden" name="spnLeftId" id="spnLeftId" value="'.$job->ID.'"></span> <span class="spnRight text-blue" style="align-content: right; opacity: 0">Accept <input type="hidden" name="spnRIghtId" id="spnRightId" value='.$job->ID.'></span></div><a href="'.WEBURL.'/seeker/home/job-details/'.$job->ID.'"><div class="card tile py-3"><div class="card-body pt-0 pb-3 px-3"><h5 class="card-title mb-1">Company Name '.$job->company_name.'</h5><h6 class="card-subtitle text-blue mb-2"><span class="text-d-grey">'. date('d M Y', strtotime($job->dated)).' </span>Design and Development</h6><ul class="list-unstyled mb-2"><li class="media align-items-center mb-1"> <img class="mr-2" src="'.STATICAPPSEEKERURL.'/images/location.svg"><div class="media-body"> <h6 class="mt-0 mb-0 font-reg text-d-grey">'.$job->city.'.</h6></div> </li> <li class="media align-items-center mb-1"><img class="mr-2" src="'.STATICAPPSEEKERURL.'/images/currency.svg"><div class="media-body"><h6 class="mt-0 mb-0 font-reg text-d-grey">$ '.$job->pay.'</h6> </div></li><li class="media align-items-center mb-1"><img class="mr-2" src="'.STATICAPPSEEKERURL.'/images/certificate.svg"><div class="media-body"> <!--<h6 class="mt-0 mb-0 font-reg text-d-grey">1+ Years Experience</h6>--></div></li> </ul> <h6 class="mb-2">Required Skills</h6> <ul class="skills-list list-inline mb-2">';
	                    $skillArray = explode(',', $job->required_skills);
	                    if(isset($skillArray) && $skillArray != ""){
	                    	foreach($skillArray as $skill){
	                    		 $dataString .= '<li class="list-inline-item">'.$skill.'</li>';	
	                    	}
	                    }
	                    $dataString .= ' </ul><div class="about-summary"> <h6 class="mb-2">About Company</h6> <p>'.$job->job_description.'</p> </div> </div></div></a></li>'; 
	                    $i--;	
				}
			}
		}
		if($dataString != ""){
			echo $dataString;
		} else {
			$dataString .= '<li class="tc-card"><div class="card tile py-3"><div class="card-body pt-0 pb-3 px-3"><h5 class="card-title mb-1">No New Jobs Available </h5>  </div> </div></div></li>';
			echo $dataString;
		}
	}
}
