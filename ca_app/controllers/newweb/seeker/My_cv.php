<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_cv extends CI_Controller {
	
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
		$experienceData = $this->My_model->selTableData('tbl_seeker_experience',"","seeker_ID = ".$this->sessUserId);
		$educationData = $this->My_model->selTableData('tbl_seeker_academic',"","seeker_ID = ".$this->sessUserId);
		$resumeData = $this->My_model->selTableData('tbl_seeker_resumes',"","seeker_ID = ".$this->sessUserId);
		$additionalData = $this->My_model->getSingleRowData('tbl_seeker_additional_info',"","seeker_ID = ".$this->sessUserId);
		//$jobApplicationData = $this->My_model->selTableData('tbl_seeker_applied_for_job',"","seeker_ID = ".$this->sessUserId);
		$fieldStr = "`tbl_seeker_applied_for_job`.ID,`tbl_seeker_applied_for_job`.seeker_ID,`tbl_seeker_applied_for_job`.dated,`tbl_seeker_applied_for_job`.job_ID,`tbl_seeker_applied_for_job`.cover_letter,`tbl_seeker_applied_for_job`.expected_salary,`tbl_seeker_applied_for_job`.skills_level,`tbl_post_jobs`.job_title,`tbl_post_jobs`.company_ID, `tbl_post_jobs`.pay, tbl_companies.company_name ";
		$jobApplicationData = $this->My_model->exequery('SELECT '.$fieldStr.' FROM `tbl_seeker_applied_for_job` LEFT JOIN tbl_post_jobs ON tbl_seeker_applied_for_job.job_ID = tbl_post_jobs.ID LEFT JOIN tbl_companies on tbl_companies.ID = tbl_post_jobs.company_ID where `tbl_seeker_applied_for_job`.seeker_ID = '.$this->sessUserId.'  ORDER BY tbl_seeker_applied_for_job.`ID`  DESC ');
		$skillData = $this->jobseeker_skills_model->get_records_by_seeker_id($this->sessUserId);
		$this->outputData['data'] = $data;
		$this->outputData['experienceData'] = $experienceData;
		$this->outputData['resumeData'] = $resumeData;
		$this->outputData['educationData'] = $educationData;
		$this->outputData['additionalData'] = $additionalData;
		$this->outputData['jobApplicationData'] = $jobApplicationData;
		$this->outputData['skillData'] = $skillData;
		$this->load->view('newweb/seeker/my_cv_view',$this->outputData);
	}


	public function edit_about(){
		$additionalData = $this->My_model->getSingleRowData('tbl_seeker_additional_info',"","seeker_ID = ".$this->sessUserId);
		if(isset($_POST['btnUpdate'])){
			//myPrint($_POST);die;
			$summary_array = array(
							'summary'		=> $this->input->post('txtSummary')
			);
			
			$row = $this->jobseeker_additional_info_model->get_record_by_userid($this->sessUserId);
			
			if($row){
				$this->jobseeker_additional_info_model->update($row->ID, $summary_array);
			}else{
				$this->jobseeker_additional_info_model->add($summary_array);
			}
			redirect(WEBURL.'/seeker/my-cv');
		}

		$this->outputData['additionalData'] = $additionalData;
		//myPrint($additionalData);die;

		$this->load->view('newweb/seeker/edit_about_view',$this->outputData);
	}

	public function add_experience(){
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		//myPrint($this->outputData['result_countries']);exit;
		if(isset($_POST['btnSubmit'])){
			$this->form_validation->set_rules('txtJobTitle', 'Job Title', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtCompanyName', 'Company Name', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('selCountry', 'Country', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtCity', 'City', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtStartDate', 'Start Date', 'trim|required|strip_all_tags');
			$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', '</div></div>');
			if ($this->form_validation->run() === FALSE) {
				//strip_tags(validation_errors());

				$this->load->view('newweb/seeker/add_experience_view',$this->outputData);
				return;
			}
			$start_date = date_formats($this->input->post('txtStartDate'),'Y-m-d');
			$end_date = ($this->input->post('txtStartDate')!='Present' && $this->input->post('txtStartDate')!='')?date_formats($this->input->post('txtStartDate'),'Y-m-d'):NULL;
			$exp_array = array(
								'seeker_ID'		=> $this->sessUserId,
								'job_title'		=> $this->input->post('txtJobTitle'),
								'company_name'	=> $this->input->post('txtCompanyName'),
								'country'		=> $this->input->post('selCountry'),
								'city' 			=> $this->input->post('txtCity'),
								'start_date' 	=> $start_date,
								'end_date' 		=> $end_date,
								'dated'			=> date("Y-m-d H:i:s")
			);
			$this->jobseeker_experience_model->add($exp_array);
			//$insert = $this->My_model->insert('tbl_seeker_experience',$insertData);
			redirect(WEBURL.'/seeker/my-cv');
		}

		//$this->outputData['result_countries'] = $result_countries;

		$this->load->view('newweb/seeker/add_experience_view',$this->outputData);
	}

	public function edit_experience($expId = 0){
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$expData = $this->My_model->getSingleRowData("tbl_seeker_experience","","ID = ".$expId);
		if(isset($_POST['btnSubmit'])){
			//echo $expId;exit;
			$this->form_validation->set_rules('txtJobTitle', 'Job Title', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtCompanyName', 'Company Name', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('selCountry', 'Country', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtCity', 'City', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtStartDate', 'Start Date', 'trim|required|strip_all_tags');
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('newweb/seeker/add_experience_view',$this->outputData);
				return;
			}
			$start_date = date_formats($this->input->post('txtStartDate'),'Y-m-d');
			$end_date = ($this->input->post('txtEndDate')!='Present' && $this->input->post('txtEndDate')!='')?date_formats($this->input->post('txtEndDate'),'Y-m-d'):NULL;
			$exp_array = array(
								'job_title'		=> $this->input->post('txtJobTitle'),
								'company_name'	=> $this->input->post('txtCompanyName'),
								'country'		=> $this->input->post('selCountry'),
								'city' 			=> $this->input->post('txtCity'),
								'start_date' 	=> $start_date,
								'end_date' 		=> $end_date
			);
			//myPrint($exp_array );exit;
			$this->jobseeker_experience_model->update($expId, $exp_array);
			redirect(WEBURL.'/seeker/my-cv');
		}
		$this->outputData['expData'] = $expData;
		$this->load->view('newweb/seeker/add_experience_view',$this->outputData);
	}

	public function delete_experience($id = 0){
		$this->jobseeker_experience_model->delete($id);
		redirect(WEBURL.'/seeker/my-cv');
	}

	public function delete_applied_job($id=0, $redirectTo = 0){

		$empData  = $this->My_model->getSingleRowData("tbl_seeker_applied_for_job","employer_ID","ID = ".$id);
		if(isset($empData) && $empData != ""){
				//echo $emp->email;
				$insertData =array();
				$insertData['seekerId'] =$this->sessUserId;
				$insertData['employerId'] = $empData->employer_ID;
				$insertData['notificationFor'] = "Withdraw From Job";
				$insertData['notificationText'] = "Seeker Withdraw From Job";

				$insertId  = $this->My_model->insert("tbl_employer_notification",$insertData);
		}
		$this->applied_jobs_model->delete_applied_job_by_id_seeker_id($id, $this->sessUserId);
		if( $redirectTo ==1){
			redirect(WEBURL.'/seeker/settings/show-applications');
		} else {
			redirect(WEBURL.'/seeker/my-cv');
		}
	}

	public function add_document(){
		if(isset($_POST['btnSubmit'])){
			if (!empty($_FILES['upload_resume']['name'])){
				$obj_row = $this->job_seekers_model->get_job_seeker_by_id($this->sessUserId);
				$real_path = realpath(APPPATH . '../public/uploads/candidate/resumes/');
				$config['upload_path'] = $real_path;
				$config['allowed_types'] = 'doc|docx|pdf|rtf|jpg|png|jpeg|mp4|txt|gif|xls|xlsx';
				$config['overwrite'] = true;
				$config['max_size'] = 6000;
				$config['file_name'] = make_slug($obj_row->first_name).'-BiXma-'.$obj_row->ID.time();
				$this->upload->initialize($config);
				$this->upload->do_upload('upload_resume');

				if (!$this->upload->do_upload('upload_resume')){
					$error = array('error' => $this->upload->display_errors());
					myPrint($error);
					//echo 4;exit;
					$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Error').'!</strong> '.strip_tags($error['error']).' </div>');
					redirect(WEBURL."/seeker/my-cv");
					exit;
				}
				/*if(is_file($config['upload_path']))
				{
				    chmod($config['upload_path'].$config['file_name'], 777); ## this should change the permissions
				}*/
				
				$resume = array('upload_data' => $this->upload->data());	
				//echo 1;exit;
				$resume_file_name = $resume['upload_data']['file_name'];
				$resume_array = array(
										'seeker_ID' => $obj_row->ID,
										'file_name' => $resume_file_name,
										'dated' => date("Y-m-d H:i:s"),
										'is_uploaded_resume' => 'yes'
										
				);
				$this->resume_model->add($resume_array);			
				//$this->session->set_flashdata('msg', '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Success').'!</strong>'. lang('CV uploaded successfully').'. </div>');
				redirect(WEBURL."/seeker/my-cv");
			}
		
		}
		$resumeData = $this->My_model->selTableData('tbl_seeker_resumes',"","seeker_ID = ".$this->sessUserId);
		$this->outputData['resumeData'] = $resumeData;
		//myPrint($resumeData);exit;
		$this->load->view('newweb/seeker/add_document_view',$this->outputData);
	}

	public function add_education(){
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		if(isset($_POST['btnSubmit'])){
			$this->form_validation->set_rules('selDegree', 'degree Title', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtMajorSub', 'major subject', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtInstitute', 'institute', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('selCountry', 'country', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtCity', 'edu city', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('selYear', 'completion year', 'trim|required|strip_all_tags');
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('newweb/seeker/add_education_view',$this->outputData);
				return;
			}
			$edu_array = array(
								'seeker_ID'			=> $this->sessUserId,
								'degree_title'		=> $this->input->post('selDegree'),
								'major'				=> $this->input->post('txtMajorSub'),
								'institude'			=> $this->input->post('txtInstitute'),
								'country' 			=> $this->input->post('selCountry'),
								'city' 				=> $this->input->post('txtCity'),
								'completion_year' 	=> $this->input->post('selYear'),
								'dated'				=> date("Y-m-d H:i:s")
			);
			$this->jobseeker_academic_model->add($edu_array);
			redirect(WEBURL.'/seeker/my-cv');
		}
		$this->load->view('newweb/seeker/add_education_view',$this->outputData);
	}

	public function edit_education($edId = 0){
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$eduData = $this->My_model->getSingleRowData("tbl_seeker_academic","","id = ".$edId);
		if(isset($_POST['btnSubmit'])){
			$this->form_validation->set_rules('selDegree', 'degree Title', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtMajorSub', 'major subject', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtInstitute', 'institute', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('selCountry', 'country', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('txtCity', 'edu city', 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('selYear', 'completion year', 'trim|required|strip_all_tags');
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('newweb/seeker/add_education_view',$this->outputData);
				return;
			}
			$edu_array = array(
							'degree_title'		=> $this->input->post('selDegree'),
							'major'				=> $this->input->post('txtMajorSub'),
							'institude'			=> $this->input->post('txtInstitute'),
							'country' 			=> $this->input->post('selCountry'),
							'city' 				=> $this->input->post('txtCity'),
							'completion_year' 	=> $this->input->post('selYear')
			);
			$this->jobseeker_academic_model->update($edId, $edu_array);\
			redirect(WEBURL.'/seeker/my-cv');
		}
		$this->outputData['eduData'] = $eduData;
		$this->load->view('newweb/seeker/add_education_view',$this->outputData);
	}

	public function delete_education($id = 0){
		$this->jobseeker_academic_model->delete($id);
		redirect(WEBURL.'/seeker/my-cv');
	}
	
	public function add_skills(){
		/*error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
		if(isset($_POST['btnSubmit'])){
			//myPrint($_POST);exit;
			if(isset($_POST['skill']) && $_POST['skill'] != ""){
				//delete skills 
				$this->My_model->del("tbl_seeker_skills","seeker_ID = ".$this->sessUserId);
				$skills = $_POST['skill'];
				$skils = $_POST['skill'];
				foreach($skills as $skill){
					if(trim($skill) != ""){
						$insertData =array();
						$insertData['seeker_ID'] = $this->sessUserId;
						$insertData['skill_name'] = $skill;
						$this->My_model->insert("tbl_seeker_skills",$insertData);
					}
				}
				redirect(WEBURL.'/seeker/my-cv');
			}
			/*
			$data_array = array('seeker_ID' => $this->sessUserId, 'skill_name' => $skill);
			$this->jobseeker_skills_model->add($data_array);*/
		}
		$skillData = $this->jobseeker_skills_model->get_records_by_seeker_id($this->sessUserId);
		$this->outputData['skillData'] = $skillData;
		$this->load->view('newweb/seeker/add_skills_view',$this->outputData);
	}

	public function delete_skill($skill = ""){
		$this->jobseeker_skills_model->delete($skill);
		redirect(WEBURL.'/seeker/my-cv');
	}

	public function expected_salary(){
		$data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);
		if(isset($_POST['btnSubmit'])){
			$cond =" ID = ".$this->sessUserId;
			$update = $this->db->query("UPDATE `tbl_job_seekers` SET  `expected_salary`='".trim($_POST['selExpectedSal'])."' WHERE ".$cond);
			redirect(WEBURL.'/seeker/my-cv');

		}
		$this->outputData['data']= $data;
		$this->load->view('newweb/seeker/expected_salary_view',$this->outputData);
	}

}
