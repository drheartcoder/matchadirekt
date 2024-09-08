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

		$tutorialData = $this->My_model->exequery("SELECT tbl_tutorials.*,tbl_job_industries.industry_name  FROM `tbl_tutorials` left JOIN tbl_job_industries ON tbl_tutorials.industry_ID = tbl_job_industries.ID where `tbl_tutorials`.status=1 AND `tbl_tutorials`.employer_ID=".$this->sessUserId);
	//myPrint($this->sessUserId);die;

		$this->outputData['tutorialData'] = $tutorialData;	
		$this->load->view('application/employer/tutorials_view',$this->outputData);
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
			//$insertData['tutorial_description']=trim($_POST['hiddeninput']);
			$insertData['employer_ID']=$this->sessUserId;
			$insertData['dated']=$current_date_time;


			//print_r($insertData);die;
			// if (!empty($_FILES['seekerResume']['name'])){
			// 		$extention = get_file_extension($_FILES['seekerResume']['name']);
			// 		$allowed_types = array('doc','docx','pdf','rtf','jpg','txt');
					
			// 		if(!in_array($extention,$allowed_types)){
			// 			$captcha_row = $this->cap_model->generate_captcha();
			// 			$data['cpt_code'] = $captcha_row['image'];
			// 			$data['msg'] = 'This file type is not allowed.';
			// 			$this->load->view('jobseeker_signup_view',$data);
			// 			return;	
			// 		}
					
			// 		$resume_array = array();
			// 		$real_path = realpath(APPPATH . '../public/uploads/candidate/resumes/');
			// 		$config['upload_path'] = $real_path;
			// 		$config['allowed_types'] = '*';
			// 		$config['overwrite'] = true;
			// 		$max_size=6000;
			// 		$max_size=$this->db->query("SELECT * FROM tbl_settings")->result()['0']->upload_limit;
			// 		$config['max_size'] = $max_size;
			// 		$config['file_name'] = replace_string(' ','-',strtolower($this->input->post('full_name'))).'-'.$seeker_id;
			// 		$this->upload->initialize($config);
			// 		if (!$this->upload->do_upload('seekerResume')){
			// 			$this->job_seekers_model->delete_job_seeker($seeker_id);
			// 			$captcha_row = $this->cap_model->generate_captcha();
			// 			$data['cpt_code'] = $captcha_row['image'];
			// 			$data['msg'] = $this->upload->display_errors();
			// 			$this->load->view('jobseeker_signup_view',$data);
			// 			return;
			// 		}
					
			// 		$resume = array('upload_data' => $this->upload->data());	
			// 		$resume_file_name = $resume['upload_data']['file_name'];
			// 		$resume_array = array(
			// 								'seeker_ID' => $seeker_id,
			// 								'file_name' => $resume_file_name,
			// 								'dated' => $current_date,
			// 								'is_uploaded_resume' => 'yes'
											
			// 		);

			// 		$insert = $this->My_model->insert("tbl_tutorials",$insertData);		
			// 	}

			$insert = $this->My_model->insert("tbl_tutorials",$insertData);
			//echo $insert;exit;
				if($insert){
						redirect(APPURL.'/employer/tutorials');
				}
			} 
		$this->load->view('application/employer/add_tutorial_view',$this->outputData);
	}

	public function edit_tutorial($id=0){

		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$tutorialData = $this->My_model->getSingleRowData('tbl_tutorials',"","ID = ".$id);
	//	print_r($tutorialData);die;
		if(isset($_POST['btnUpdateTut'])){
			$job_desc = $this->input->post('hiddeninput');
			$cond = "ID = ".$id;
			$update=array();
			$update['industry_ID'] = trim($_POST['selCompIndustry']);
			$update['tutorial_name']=trim($_POST['txtTutorialName']);
			$update['tutorial_description']=$job_desc;
			
			$updateTutorial= $this->My_model->update('tbl_tutorials',$update,$cond);
			//echo $this->db->last_query();die;
			redirect(APPURL.'/employer/tutorials');
		}

		$this->outputData['tutorialData'] = $tutorialData;


		$this->load->view('application/employer/edit_tutorial_view',$this->outputData);
	}

	public function tutorial_details($id=0){

		$tutorialData = $this->My_model->exequery("SELECT * FROM `tbl_tutorials` left JOIN tbl_job_industries ON tbl_tutorials.industry_ID = tbl_job_industries.ID where `tbl_tutorials`.status=1 AND  `tbl_tutorials`.ID=".$id);
	//myPrint($tutorialData);die;
		$this->outputData['tutorialData'] = $tutorialData[0];	


		$this->load->view('application/employer/tutorial_detail_view',$this->outputData);

	}


	public function remove_tutorial($id=0){

		$employerId = $this->sessUserId;
		$tutorialData = $this->My_model->getSingleRowData('tbl_tutorials',"","ID = ".$id);
		$update=array();
		$update['status'] = 0;
		$cond = "tbl_tutorials.ID = ".$id;
		$updateTutorial= $this->My_model->update('tbl_tutorials',$update,$cond);
		if($updateTutorial){
			redirect(APPURL."/employer/tutorials");
		}

	}


}
