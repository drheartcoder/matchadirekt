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
		$data=array();

		$inviteData = $this->My_model->SelTableData("tbl_requests_info","ID ID, employer_id employer, jobseeker_id seeker, dated, (select first_name from tbl_employers where ID = employer) employerName,  (select company_ID from tbl_employers where ID = employer) companyId, (select company_name from tbl_companies where ID = companyId) companyName ","jobseeker_id = ".$this->sessUserId." AND isNew = 1 AND isView = 0");
		$eventData = $this->My_model->SelTableData("calendar","id_calendar ID,id_employer employer,id_job_seeker seeker, date dated , (select first_name from tbl_employers where ID = employer) employerName,  (select company_ID from tbl_employers where ID = employer) companyId, (select company_name from tbl_companies where ID = companyId) companyName ","id_job_seeker = ".$this->sessUserId." AND isNew = 1 AND isView = 0");
		$todaysData = $this->My_model->SelTableData("calendar","id_calendar ID,id_employer employer,id_job_seeker seeker, date dated , (select first_name from tbl_employers where ID = employer) employerName,  (select company_ID from tbl_employers where ID = employer) companyId, (select company_name from tbl_companies where ID = companyId) companyName ","id_job_seeker = ".$this->sessUserId." AND DATE(`date`) = CURDATE()");

		if(isset($eventData ) && $eventData  != ""){
			foreach($eventData  as $ev){
				$ev->notType= "allEvent";
			}
			$data = array_merge($data,$eventData);
		}
		if(isset($inviteData) && $inviteData != ""){
			foreach($inviteData as $in){
				$in->notType= "invite";
			}
			$data = array_merge($data,$inviteData);
		}
		if(isset($todaysData ) && $todaysData  != ""){
			foreach($todaysData  as $ev){
				$ev->notType= "todayEvent";
			}
			$data = array_merge($data,$todaysData);
		}

		$this->outputData['data'] = $data;
		$this->load->view('application/seeker/notification_list_view',$this->outputData);
	}

	public function delete_notifications(){
		$this->db->query("UPDATE `tbl_requests_info` SET `isNew`=0,`isView`=1 WHERE  jobseeker_id = ".$this->sessUserId);
		$this->db->query("UPDATE `calendar` SET `isNew`=0,`isView`=1 WHERE  id_job_seeker = ".$this->sessUserId);
		redirect(APPURL."/seeker/notification");
	}

}
