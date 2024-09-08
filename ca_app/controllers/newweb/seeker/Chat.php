<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$data=array();
		
		$data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);

		$this->outputData['data'] = $data;
		$this->load->view('application/seeker/chat_view',$this->outputData);
	}






	
}
