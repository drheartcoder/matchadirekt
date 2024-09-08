<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tutorials extends CI_Controller {
	// public function __construct(){
 //        parent::__construct();
	// 	$this->ads = '';
	// 	$this->ads = $this->ads_model->get_ads();
	// 	$this->my_library->check_user_login();
 //    }
    public $outputData = array();
	public function index(){

		$data['title'] = SITE_NAME.': Manage Tutorials';
		$data['msg'] = '';
		$tutorialData = $this->My_model->exequery("SELECT * FROM `tbl_tutorial_admin` WHERE `status`=1");
		
		//myPrint($tutorialData);die;
		$this->outputData['tutorialData'] = $tutorialData;
		$this->load->view('admin/tutorials_view', $this->outputData);
		return;
	}

		public function add_tutorial($edId = 0){

		//$this->outputData['result_industries'] = $this->industries_model->get_all_industries();

			 $current_date_time = date("Y-m-d H:i:s");
			if(isset($_POST['btnSubmitTut'])){
				//myPrint($_POST);die;
		 	$job_desc = $this->input->post('hiddeninput');
		 	$job_desc = str_replace("'", "", $job_desc);
		 	$job_desc = str_replace(";", "", $job_desc);
		 	$insertData=array();
		// 	$insertData['industry_ID'] = trim($_POST['selCompIndustry']);
		 	$insertData['tutName']=trim($_POST['txtTutorialName']);
		 	$insertData['tutDescrip']=$job_desc;
		 	$insertData['status']= 1;
		 	$insertData['createdOn']=$current_date_time;

		 	$insert = $this->My_model->insert("tbl_tutorial_admin",$insertData);
		 	if($insert){
		 		redirect(base_url('admin/tutorials'));
		 		// /redirect(WEBURL.'/employer/tutorials');
		 	}
		 } 
		$this->load->view('admin/add_tutorials_view',$this->outputData);
	}

	public function edit_tutorial($id=0){

		//$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$tutorialData = $this->My_model->getSingleRowData('tbl_tutorial_admin',"","tutId = ".$id);

		if(isset($_POST['btnUpdateTut'])){

			$job_desc = $this->input->post('hiddeninput');
			$cond = "tutId = ".$id;
			$update=array();
			//$update['industry_ID'] = trim($_POST['selCompIndustry']);
			$update['tutName']=trim($_POST['txtTutorialName']);
			$update['tutDescrip']=$job_desc;
			
			$updateTutorial= $this->My_model->update('tbl_tutorial_admin',$update,$cond);
			redirect(base_url('admin/tutorials'));
		}

		$this->outputData['tutorialData'] = $tutorialData;


		$this->load->view('admin/update_tutorials_view',$this->outputData);
	}

	public function tutorial_details($id=0){

		$tutorialData = $this->My_model->exequery("SELECT * FROM `tbl_tutorial_admin` WHERE tutId =".$id);
		//myPrint($tutorialData);die;
		$this->outputData['tutorialData'] = $tutorialData[0];	




		$this->load->view('admin/tutorial_detail_view',$this->outputData);
	}


	public function remove_tutorial($id=0){

		//$employerId = $this->sessUserId;
		$tutorialData = $this->My_model->getSingleRowData('tbl_tutorial_admin',"","tutId = ".$id);
		$update=array();
		$update['status'] = 0;
		$cond = "tbl_tutorial_admin.tutId = ".$id;
		$updateTutorial= $this->My_model->update('tbl_tutorial_admin',$update,$cond);
		if($updateTutorial){
				redirect(base_url('admin/tutorials'));
		}

	}
		
}
?>