<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("class.smtp.php");
include("class.phpmailer.php");
class Welcome extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		//$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		$this->outputData['title'] = SITE_NAME.': Tutorials';
		$this->outputData['msg'] = '';
		$tutorialData = $this->My_model->exequery("SELECT * FROM `tbl_tutorial_admin` WHERE `status`=1");
		//	myPrint($tutorialData);die;
		$this->outputData['tutorialData'] = $tutorialData;
		
		$this->load->view('newweb/welcome_view',$this->outputData);
	}

}