<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Testsummernote extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    public $outputData = array();
	public function index(){

		
		$this->load->view('admin/testSummernote_view', $this->outputData);
		return;
	}

		public function add_tutorial($edId = 0){

		//$this->outputData['result_industries'] = $this->industries_model->get_all_industries();

			 $current_date_time = date("Y-m-d H:i:s");
			if(isset($_POST['btnSubmitSumm'])){
				myPrint($_POST);die;
		 	// $job_desc = $this->input->post('hiddeninput');
		 	// $job_desc = str_replace("'", "", $job_desc);
		 	// $job_desc = str_replace(";", "", $job_desc);
		 	$insertData=array();
		// 	$insertData['industry_ID'] = trim($_POST['selCompIndustry']);
		 	//$insertData['tutName']=trim($_POST['txtTutorialName']);
		 	$insertData['tutDescrip']=trim($_POST['content']);
		 	//$insertData['tutDescrip']=$job_desc;
		 	$insertData['status']= 1;
		 	$insertData['createdOn']=$current_date_time;

		 	$insert = $this->My_model->insert("tbl_tutorial_admin",$insertData);
		 	if($insert){
		 		redirect(base_url('admin/tutorials'));
		 		// /redirect(WEBURL.'/employer/tutorials');
		 	}
		 } 
		$this->load->view('admin/testSummernote_view',$this->outputData);
	}
	
		
}
?>