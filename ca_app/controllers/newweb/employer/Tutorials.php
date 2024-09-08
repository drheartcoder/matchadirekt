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
		// //Pagination starts
		// $total_rows = $this->companies_model->record_count('tbl_companies');
		// $config = pagination_configuration(base_url("admin/companies"), $total_rows, 50, 3, 5, true);
		
		// $this->pagination->initialize($config);
  //       $page = ($this->uri->segment(2)) ? $this->uri->segment(3) : 0;
		// $page_num = $page-1;
		// $page_num = ($page_num<0)?'0':$page_num;
		// $page = $page_num*$config["per_page"];
		// $data["links"] = $this->pagination->create_links();
		// //Pagination ends
		
		// $obj_result = $this->companies_model->get_all_companies($config["per_page"], $page);
		// $data['result'] = $obj_result;
		$tutorialData = $this->My_model->exequery("SELECT tbl_tutorials.*,tbl_job_industries.industry_name  FROM `tbl_tutorials` left JOIN tbl_job_industries ON tbl_tutorials.industry_ID = tbl_job_industries.ID where `tbl_tutorials`.status=1 AND `tbl_tutorials`.employer_ID=".$this->sessUserId);
		$this->outputData['tutorialData'] = $tutorialData;	
		$this->load->view('newweb/employer/tutorials_view',$this->outputData);
	}

	public function add_tutorial($edId = 0){

		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();

		$current_date_time = date("Y-m-d H:i:s");
		if(isset($_POST['btnSubmitTut'])){
			$job_desc = $this->input->post('hiddeninput');
			$job_desc = str_replace("'", "", $job_desc);
			$job_desc = str_replace(";", "", $job_desc);
			$insertData=array();
			$insertData['industry_ID'] = trim($_POST['selCompIndustry']);
			$insertData['tutorial_name']=trim($_POST['txtTutorialName']);
			$insertData['tutorial_description']=$job_desc;
			$insertData['employer_ID']=$this->sessUserId;
			$insertData['dated']=$current_date_time;

			$insert = $this->My_model->insert("tbl_tutorials",$insertData);
			if($insert){
				redirect(WEBURL.'/employer/tutorials');
			}
		} 
		$this->load->view('newweb/employer/add_tutorial_view',$this->outputData);
	}

	public function edit_tutorial($id=0){

		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$tutorialData = $this->My_model->getSingleRowData('tbl_tutorials',"","ID = ".$id);
		if(isset($_POST['btnUpdateTut'])){
			$job_desc = $this->input->post('hiddeninput');
			$cond = "ID = ".$id;
			$update=array();
			$update['industry_ID'] = trim($_POST['selCompIndustry']);
			$update['tutorial_name']=trim($_POST['txtTutorialName']);
			$update['tutorial_description']=$job_desc;
			
			$updateTutorial= $this->My_model->update('tbl_tutorials',$update,$cond);
			redirect(WEBURL.'/employer/tutorials');
		}

		$this->outputData['tutorialData'] = $tutorialData;


		$this->load->view('newweb/employer/edit_tutorial_view',$this->outputData);
	}

	public function tutorial_details($id=0){

		$tutorialData = $this->My_model->exequery("SELECT * FROM `tbl_tutorials` left JOIN tbl_job_industries ON tbl_tutorials.industry_ID = tbl_job_industries.ID where `tbl_tutorials`.status=1 AND  `tbl_tutorials`.ID=".$id);
		$this->outputData['tutorialData'] = $tutorialData[0];	


		$this->load->view('newweb/employer/tutorial_detail_view',$this->outputData);
	}


	public function remove_tutorial($id=0){

		$employerId = $this->sessUserId;
		$tutorialData = $this->My_model->getSingleRowData('tbl_tutorials',"","ID = ".$id);
		$update=array();
		$update['status'] = 0;
		$cond = "tbl_tutorials.ID = ".$id;
		$updateTutorial= $this->My_model->update('tbl_tutorials',$update,$cond);
		if($updateTutorial){
			redirect(WEBURL."/employer/tutorials");
		}

	}


}
