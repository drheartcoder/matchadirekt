<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invitations extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index($redirectTo = 0){
		
		$data['ads_row'] = $this->ads;
		$data['chat_url'] = '';
		$this->db->query("UPDATE `tbl_requests_info` SET `isNewlyAccepted`=0 WHERE  employer_id = ".$this->sessUserId);
		$invitedCandidates= $this->My_model->exequery("SELECT `tbl_requests_info`.*, tbl_job_seekers.first_name, tbl_job_seekers.email FROM `tbl_requests_info` LEFT JOIN tbl_job_seekers ON tbl_requests_info.jobseeker_id = tbl_job_seekers.ID where tbl_requests_info.employer_id =" .$this->sessUserId);
		//echo $this->db->last_query();exit;
		//myPrint($invitedCandidates);exit;
		$this->outputData['redirectTo'] = $redirectTo;
		$this->outputData['invitedCandidates'] = $invitedCandidates;
		$this->load->view('newweb/employer/invitation_view',$this->outputData);
	}


	public function delete_invitation($id = 0){
		$delete = $this->My_model->del("tbl_requests_info","ID = ".$id);
		if($delete){
			redirect(WEBURL.'/employer/invitations');
		}
	}

	public function add_event($seekerId=0){
		$date = trim($_POST['txtDate'])." ".trim($_POST['txtTime']);
		$notes = trim($_POST['txtNote']);
		$employer = $this->sessUserId;
		if($seekerId=="" || $employer=="" || $date=="" || $notes==""){
			redirect(WEBURL."/employer/invitations/manage_schedule/".$employer."/".$seekerId);
			return;
		}
		$this->db->query("INSERT INTO calendar ( `id_employer`, `id_job_seeker`,`applicationId`, `notes`, `date`) VALUES ('$employer', '$seekerId','$applicationId', '$notes', '$date')");
		//
		redirect(WEBURL."/employer/calender");
	}

	public function update_event(){
		$date = trim($_POST['txtDate'])." ".trim($_POST['txtTime']);
		$notes = trim($_POST['txtNote']);
		$id_calendar = trim($_POST['calId']);
		$this->db->query("UPDATE calendar SET notes='$notes',date='$date' WHERE id_calendar='$id_calendar'");
		redirect(WEBURL."/employer/invitations");
	}

	public function manage_schedule($employer_id = 0, $jobseeker_id = 0){
		$data['ads_row'] = $this->ads;
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		// $decrypted_id = $this->custom_encryption->decrypt_data($id);
		$candidateDetails = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$jobseeker_id);
		$latest_job_title = $this->My_model->getSingleRowData('tbl_seeker_experience',"","seeker_ID = ".$jobseeker_id);	

		$this->outputData['candidateDetails'] = $candidateDetails;
		$this->outputData['employer_id'] = $employer_id;
		$this->outputData['jobseeker_id'] = $jobseeker_id;
		$this->outputData['latest_job_title'] = $latest_job_title;
		$this->load->view('newweb/employer/invited_schedule_meeting_view',$this->outputData);
	}
}
