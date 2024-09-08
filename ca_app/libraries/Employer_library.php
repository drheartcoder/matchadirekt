<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employer_library {	
	
	public $outputdata 	= array();


	public function get_chat_count(){
		//echo 1;exit;
		$CI = & get_instance();	

		$newMsgCount = $CI->My_model->selTableData("tbl_conversation","count(id_conversation) msgCount"," id_employer = ".$CI->sessUserId." AND isNewForEmployer = 1");
		
		return $newMsgCount[0]->msgCount;
	}

	public function get_notification_count(){
		//echo 1;exit;
		$CI = & get_instance();	
		$seekerAppliedCount = 0;
		$seekerAcceptRequestCount = 0;
		$seekerApplied = $CI->My_model->selTableData("tbl_seeker_applied_for_job","count(ID) seekerCount"," employer_ID = ".$CI->sessUserId." AND tbl_seeker_applied_for_job.isView = 0 AND tbl_seeker_applied_for_job.isNew = 1");
		
		$seekerAcceptRequest =$CI->My_model->selTableData("tbl_requests_info","count(ID) seekerCount","employer_id = ".$CI->sessUserId." AND isNewlyAccepted = 1");
		if(isset($seekerApplied) && $seekerApplied != ""){
			$seekerAppliedCount = $seekerApplied[0]->seekerCount;
		}
		if(isset($seekerAcceptRequest) && $seekerAcceptRequest != ""){
			$seekerAcceptRequestCount = $seekerAcceptRequest[0]->seekerCount;
		}
		//echo ($seekerAppliedCount	+	$seekerAcceptRequestCount);exit;
		return ($seekerAppliedCount	+	$seekerAcceptRequestCount);
	}
}