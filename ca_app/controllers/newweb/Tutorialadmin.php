<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tutorialadmin extends CI_Controller {
	
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
		$msg="";

		$data['title'] = SITE_NAME.': Manage Tutorials';
		$data['msg'] = '';
		$tutorialData = $this->My_model->exequery("SELECT * FROM `tbl_tutorial_admin` WHERE `status`=1");
	//	myPrint($tutorialData);die;
		$this->outputData['tutorialData'] = $tutorialData;
		
		if($this->session->userdata('sessIsJobSeeker') == 1){
		$this->load->view('newweb/seeker/tutorials_by_admin_view',$this->outputData);
		}else if($this->session->userdata('sessIsEmployer') == 1){
		$this->load->view('newweb/employer/tutorial_by_admin_view',$this->outputData);
			}
		}

	public function tutorial_details($id=0){

		$tutorialData = $this->My_model->exequery("SELECT * FROM `tbl_tutorial_admin` WHERE tutId =".$id);
		//myPrint($tutorialData);die;
		$this->outputData['tutorialData'] = $tutorialData[0];	


		if($this->session->userdata('sessIsJobSeeker') == 1){
		$this->load->view('newweb/seeker/tutorial_detail_admin_view',$this->outputData);
		}else if($this->session->userdata('sessIsEmployer') == 1){
		$this->load->view('newweb/employer/tutorial_detail_admin_view',$this->outputData);
			}

		
	}
	
}