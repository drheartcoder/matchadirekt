<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		//when seker apply for job

		$data = array();
		$seekerApplied = $this->My_model->selTableData("tbl_seeker_applied_for_job","employer_ID employer, seeker_ID seeker, job_ID, dated,(select employer_ID from tbl_post_jobs where ID = job_ID) employer_ID, (select first_name from tbl_job_seekers where ID = seeker) seekerName,  (select job_title from tbl_post_jobs where ID = job_ID) jobTitle"," employer_ID = ".$this->sessUserId." AND tbl_seeker_applied_for_job.isView = 0 AND tbl_seeker_applied_for_job.isNew = 1");
		
		$seekerAcceptRequest =$this->My_model->selTableData("tbl_requests_info","tbl_requests_info.ID,tbl_requests_info.jobseeker_id seeker, dated, (select first_name from tbl_job_seekers where ID = seeker) seekerName, ","employer_id = ".$this->sessUserId." AND isNewlyAccepted = 1");
		$otherNotification =$this->My_model->selTableData("tbl_employer_notification","tbl_employer_notification.*, (select first_name from tbl_job_seekers where ID = seekerId) seekerName, ","employerId = ".$this->sessUserId." AND isNew = 1");

		if(isset($seekerApplied) && $seekerApplied != ""){
			foreach($seekerApplied as $a){
				$a->notType = "applied";
			}
			$data = array_merge($data, $seekerApplied);
		}
		if(isset($seekerAcceptRequest) && $seekerAcceptRequest != ""){
			foreach($seekerAcceptRequest as $a){
				$a->notType = "accepted";
			}
			$data = array_merge($data, $seekerAcceptRequest);
		}
		if(isset($otherNotification) && $otherNotification != ""){
			foreach($otherNotification as $a){
				$a->notType = $a->notificationFor;
			}
			$data = array_merge($data, $otherNotification);
		}
		
		$this->outputData['data']= $data;
		//myPrint($otherNotification);exit;
		$this->load->view('newweb/employer/notification_list_view',$this->outputData);
	}

	public function delete_notifications(){
		$this->db->query("UPDATE `tbl_seeker_applied_for_job` SET `isNew`=0,`isView`=1 WHERE  employer_ID = ".$this->sessUserId);
		$this->db->query("UPDATE `tbl_requests_info` SET `isNewlyAccepted`=0 WHERE  employer_id = ".$this->sessUserId);
		$this->db->query("UPDATE `tbl_employer_notification` SET `isNew`=0 WHERE  employerId = ".$this->sessUserId);
		redirect(WEBURL."/employer/notification");
	}

}
