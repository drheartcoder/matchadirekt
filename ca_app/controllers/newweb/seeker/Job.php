<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("class.smtp.php");
include("class.phpmailer.php");
class Job extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();
	public function index(){
		$resData  = array();
		$job_seeker_skills = $this->job_seekers_model->get_grouped_skills_by_seeker_id($this->sessUserId);
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
		$countOfJob = 0;
		$data =array();
		if(isset($result_jobs) && $result_jobs != ""){
			$countOfJob = count($result_jobs);
			$resData = $result_jobs;
		}
		$data['countOfJob'] = $countOfJob;
		$data['resData'] = $resData;
		$this->load->view('newweb/seeker/job_tiles_view',$data);
	}

	public function apply($jId = 0){
		
		if($jId == 0){
			$jobId = $_POST['jobId'];
		} else {
			$jobId = $jId;
		}

		$seekerData = $this->My_model->exequery("SELECT tbl_job_seekers.first_name, tbl_job_seekers.expected_salary, tbl_seeker_resumes.file_name,  tbl_seeker_resumes.is_uploaded_resume FROM `tbl_job_seekers` left JOIN `tbl_seeker_resumes` ON tbl_job_seekers.ID = tbl_seeker_resumes.seeker_ID WHERE tbl_job_seekers.ID = ".$this->sessUserId);
		/*myPrint($seekerData );
		echo $jobId;exit;*/
		if(isset($seekerData) && $seekerData != "" &&  $jobId >0){
			if($seekerData[0]->expected_salary != "" && $seekerData[0]->file_name != "" && $seekerData[0]->is_uploaded_resume) {
				$current_date_time = date("Y-m-d H:i:s");
				$jobData = $this->My_model->getSingleRowData("tbl_post_jobs","","ID = ".$jobId);
				/*echo $this->db->last_query();exit;
				$row = $this->posted_jobs_model->get_active_posted_job_by_id( $jobData->employer_ID);*/
				//myPrint($jobData);exit;
				//apply for the job
				$insertData = array();
				$insertData['seeker_ID'] = $this->sessUserId;
				$insertData['job_ID'] = $jobId;
				$insertData['expected_salary'] = $seekerData[0]->expected_salary;
				$insertData['dated'] = $current_date_time;
				$insertData['employer_ID'] = $jobData->employer_ID;
				$insertData['file_name'] = $seekerData[0]->file_name;
				$this->applied_jobs_model->add_applied_job($insertData);

				//Move resume file from resumes to application 
				$job_application_path = realpath(APPPATH . '../public/uploads/candidate/applied_job/');
				$real_path_of_file = realpath(APPPATH . '../public/uploads/candidate/resumes/');

				copy($real_path_of_file.'/'.$seekerData[0]->file_name ,$job_application_path.'/'.$seekerData[0]->file_name);
				
				//Sending email
				$row_email = $this->email_model->get_records_by_id(5);
				$config = array();
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$data_array = $this->posted_jobs_model->get_active_posted_job_by_id($jobId );
				$seeker_id = $this->custom_encryption->encrypt_data($this->sessUserId);

				$subject = str_replace('{JOB_TITLE}', $data_array->job_title, $row_email->subject);

				$config = $this->email_drafts_model->email_configuration();
				$mail_message = $this->email_drafts_model->apply_job($seeker_id, $row_email->content, $data_array);
				/*$this->email->initialize($config);

				$this->email->initialize($config);
				//$this->email->clear(TRUE);
				$this->email->from("bixma@agoujil.com", "BiXma Job System");
				$this->email->to($data_array->employer_email);
				
				$this->email->subject($subject);
				$this->email->message($mail_message);     
				$this->email->send();*/

				
				if($jId == 0){
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->Host = MAILERHOST;
					$mail->Username = MAILERUSER;
					$mail->Password = MAILERPASS; 
					$mail->From = "bixma@agoujil.com";
					$mail->FromName = "BiXma Job System";
					$mail->AddAddress($data_array->employer_email,"Company");
					$mail->Subject =$subject;
					$mail->Body = $mail_message;
					$mail->WordWrap = 50;
					$mail->IsHTML(true);
					/*$mail->SMTPSecure = 'tls';
					$mail->Port = 587;*/
					$mail->Port = 25;
						
					$mail->Send();
					echo 1;
				}
				else 
					redirect(WEBURL.'/seeker/home');
			} else {
				if($jId == 0){
					echo 0;
				}
				else 
					redirect(WEBURL.'/seeker/home');
			}
		} else {
			if($jId == 0){
				echo 0;
			}
			else 
				redirect(WEBURL.'/seeker/home');
		}
	}

	public function reject(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		//$seekerData = $this->job_seekers_model->get_job_seeker_by_id($this->sessUserId);
		
		//myPrint();
		$jobId = $_POST['jobId'];
		$seekerData = $this->My_model->exequery("SELECT tbl_job_seekers.first_name, tbl_job_seekers.expected_salary, tbl_seeker_resumes.file_name,  tbl_seeker_resumes.is_uploaded_resume FROM `tbl_job_seekers` left JOIN `tbl_seeker_resumes` ON tbl_job_seekers.ID = tbl_seeker_resumes.seeker_ID WHERE tbl_job_seekers.ID = ".$this->sessUserId);
		if(isset($seekerData) && $seekerData != ""){
			if($seekerData[0]->expected_salary != "" && $seekerData[0]->file_name != "" && $seekerData[0]->is_uploaded_resume) {
				//Move resume file from resumes to application 
				$current_date_time = date("Y-m-d H:i:s");
				//apply for the job
				$insertData = array();
				$insertData['seeker_ID'] = $this->sessUserId;
				$insertData['job_ID'] = $jobId;
				$insertData['dated'] = $current_date_time;
				$insert = $this->My_model->insert("tbl_seeker_rejected_for_job",$insertData);
				if($insert){
					echo 1;
				}
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}
	}
	public function wishlist(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		//$seekerData = $this->job_seekers_model->get_job_seeker_by_id($this->sessUserId);
		
		//myPrint();
		$jobId = $_POST['jobId'];
		$seekerData = $this->My_model->exequery("SELECT tbl_job_seekers.first_name, tbl_job_seekers.expected_salary, tbl_seeker_resumes.file_name,  tbl_seeker_resumes.is_uploaded_resume FROM `tbl_job_seekers` left JOIN `tbl_seeker_resumes` ON tbl_job_seekers.ID = tbl_seeker_resumes.seeker_ID WHERE tbl_job_seekers.ID = ".$this->sessUserId);
		if(isset($seekerData) && $seekerData != ""){
			if($seekerData[0]->expected_salary != "" && $seekerData[0]->file_name != "" && $seekerData[0]->is_uploaded_resume) {
				//Move resume file from resumes to application 
				$current_date_time = date("Y-m-d H:i:s");
				//apply for the job
				$insertData = array();
				$insertData['seeker_ID'] = $this->sessUserId;
				$insertData['job_ID'] = $jobId;
				$insertData['dated'] = $current_date_time;
				$insert = $this->My_model->insert("tbl_seeker_wishlisted_job",$insertData);
				if($insert){
					echo 1;
				}
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}
	}
	
	public function wishlist_jobs(){
		$wishlistedJobs = $this->My_model->exequery("SELECT `tbl_seeker_wishlisted_job`.*,tbl_post_jobs.job_title,tbl_post_jobs.company_ID,tbl_post_jobs.industry_ID,(SELECT company_name from tbl_companies where ID = tbl_post_jobs.company_ID ) company_name  FROM `tbl_seeker_wishlisted_job` LEFT JOIN tbl_post_jobs ON tbl_seeker_wishlisted_job.job_ID = tbl_post_jobs.ID WHERE seeker_ID =  ".$this->sessUserId);
		//myPrint($wishlistedJobs);
		$this->outputData['wishlistedJobs'] = $wishlistedJobs;
		$this->load->view('newweb/seeker/wishlisted_jobs_view',$this->outputData);
	}

	public function remove_wishlist_jobs($id = 0){
		$delete = $this->My_model->del("tbl_seeker_wishlisted_job","ID = ".$id);
		if($delete){
			redirect(WEBURL.'/seeker/job/wishlist-jobs');
		}
	}

	public function job_full_post(){
		//echo 1;exit;
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
 		//$this->outputData['data'] = $data;
		$this->load->view('newweb/seeker/job_full_post_view',$this->outputData);
	}

	public function job_location(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$jobId = $_POST['jobId'];	

		$compID = $this->My_model->getSingleRowData("tbl_post_jobs","company_ID","ID=".$jobId);
		$compData = $this->My_model->getSingleRowData("tbl_companies","latitude,longitude","ID = ".$compID->company_ID);
		if(isset($compData) && $compData != "" ){

			if( $compData->latitude > 0 && $compData->longitude > 0){
				echo $compData->latitude.','. $compData->longitude;
			} else{
				echo 0;
			}
		} else{
			echo 0;
		}

	}
}
