<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Seeker_library {	
	
	public $outputdata 	= array();


	public function get_chat_count(){
		//echo 1;exit;
		$CI = & get_instance();	

		$newMsgCount = $CI->My_model->selTableData("tbl_conversation","count(id_conversation) msgCount"," id_job_seeker = ".$CI->sessUserId." AND isNewForSeeker = 1");
		//myPrint($newMsgCount);exit;
		return $newMsgCount[0]->msgCount;
	}

	public function get_notification_count(){
		$CI = & get_instance();	
		$inviteDataCount = 0;
		$eventDataCount = 0;
		$todaysDataCount = 0;
		$inviteData = $CI->My_model->SelTableData("tbl_requests_info","count(ID) inviteCount","jobseeker_id = ".$CI->sessUserId." AND isNew = 1 AND isView = 0");
		$eventData = $CI->My_model->SelTableData("calendar","count(id_calendar) eventCount","id_job_seeker = ".$CI->sessUserId." AND isNew = 1 AND isView = 0");
		$todaysData = $CI->My_model->SelTableData("calendar","count(id_calendar) todayCount","id_job_seeker = ".$CI->sessUserId." AND DATE(`date`) = CURDATE()");
		if(isset($inviteData) && $inviteData != ""){
			$inviteDataCount = $inviteData[0]->inviteCount;
		}
		if(isset($eventData) && $eventData != ""){
			$eventDataCount = $eventData[0]->eventCount;
		}
		if(isset($todaysData) && $todaysData != ""){
			$todaysDataCount = $todaysData[0]->todayCount;
		}

		return ($inviteDataCount	+	$eventDataCount	+	$todaysDataCount);
	}
}