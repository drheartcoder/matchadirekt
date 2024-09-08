<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calender extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
        //echo $this->sessUserId;exit;
    }
	public $outputData = array();

	public function index($redirectTo = 0){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$update = $this->db->query("UPDATE `calendar` SET `isNew`=0,`isView`=1 WHERE  id_job_seeker = ".$this->sessUserId);

		$data = $this->My_model->selTableData('calendar',"","id_job_seeker = ".$this->sessUserId);
		$this->outputData['redirectTo'] = $redirectTo;
		$this->outputData['data'] = $data;
		$this->load->view('application/seeker/calender_view',$this->outputData);
	}

}
