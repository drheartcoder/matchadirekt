<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		$data = $this->My_model->selTableData("calendar","notes,date,id_employer,id_job_seeker","id_employer = ".$this->sessUserId);	
		/*$data['ads_row'] = $this->ads;
		$data['chat_url'] = '';
		
		$invitedCandidates= $this->My_model->exequery("SELECT `tbl_requests_info`.*, tbl_job_seekers.first_name, tbl_job_seekers.email FROM `tbl_requests_info` LEFT JOIN tbl_job_seekers ON tbl_requests_info.jobseeker_id = tbl_job_seekers.ID where tbl_requests_info.employer_id =" .$this->sessUserId);
		//echo $this->db->last_query();exit;
		//myPrint($invitedCandidates);exit;*/
		$this->outputData['data'] = $data;
		$this->load->view('application/employer/calendar_view',$this->outputData);
	}

}
