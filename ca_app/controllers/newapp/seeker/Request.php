<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Request extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index($redirectTo = 0){
		$update = $this->db->query("UPDATE `tbl_requests_info` SET `isNew`=0,`isView`=1 WHERE  jobseeker_id = ".$this->sessUserId);
		$data = $this->My_model->selTableData('tbl_requests_info',"","jobseeker_id = ".$this->sessUserId,"ID desc");
		$this->outputData['data'] = $data;
		$this->outputData['redirectTo'] = $redirectTo;
		$this->load->view('application/seeker/request_view',$this->outputData);
	}

	public function accept($id=0){
		$sts = "approuved";
		$updateData = array();
		$updateData['sts'] = $sts;
		$updateData['isNewlyAccepted'] = 1;
		$update = $this->My_model->update("tbl_requests_info",$updateData,"ID= ".$id);
		redirect(APPURL."/seeker/request");
	}
	
	public function reject($id=0){
		 $sts = "not approuved";
		 $updateData = array();
		 $updateData['sts'] = $sts;
		 $updateData['isNewlyAccepted'] = 0;
		 $update = $this->My_model->update("tbl_requests_info",$updateData,"ID= ".$id);
		 redirect(APPURL."/seeker/request");
		
	}





	
}
