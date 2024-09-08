<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tutorials extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index($id = 0){

	//$tutorialData = $this->My_model->selTableData("tbl_tutorials","","status=1");
	$tutorialData = $this->My_model->exequery("SELECT tbl_tutorials.*,tbl_job_industries.industry_name  FROM `tbl_tutorials` left JOIN tbl_job_industries ON tbl_tutorials.industry_ID = tbl_job_industries.ID where `tbl_tutorials`.status=1");

	//myPrint($tutorialData);die;

		$this->outputData['tutorialData'] = $tutorialData;	
		$this->load->view('application/seeker/tutorials_view',$this->outputData);
	}

	public function tutorial_details($id=0){
		
		$tutorialData = $this->My_model->exequery("SELECT tbl_tutorials.*,tbl_job_industries.industry_name  FROM `tbl_tutorials` left JOIN tbl_job_industries ON tbl_tutorials.industry_ID = tbl_job_industries.ID where `tbl_tutorials`.status=1 AND `tbl_tutorials`.ID =".$id);
		$this->outputData['tutorialData'] = $tutorialData[0];	
		//myPrint($tutorialData);die;


		$this->load->view('application/seeker/tutorial_detail_view',$this->outputData);

	}

}
