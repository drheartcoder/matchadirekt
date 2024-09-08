<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index(){
		$jobList = $this->My_model->exequery("SELECT pj.ID, pj.job_title, pj.job_slug, pj.job_description, pj.employer_ID, pj.last_date, pj.dated, pj.city, pj.is_featured, pj.sts, pc.company_name, pc.company_logo
			FROM `tbl_post_jobs` AS pj
			INNER JOIN tbl_companies AS pc ON pj.company_ID=pc.ID
			WHERE pj.company_ID=".$this->sessCompanyId." AND pj.sts IN ('active', 'inactive', 'pending') AND pc.sts = 'active' AND pc.sts <> 'archive'
		    and pj.deleted=0 
			ORDER BY ID DESC");
		$this->outputData['jobList'] = $jobList;
		//myPrint($jobList);die;
		$this->load->view('newweb/employer/emp_my_jobs_view',$this->outputData);
	}

	public function add_new_job(){
		/*error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
		$available_skills = '';
		foreach($this->skill_model->get_all_skills() as $skill_row){
			$available_skills.='"'.$skill_row->skill_name.'", ';
		}	
		$row = $this->employers_model->get_employer_by_id($this->sessUserId);
		if(isset($_POST['btnSubmit']) || isset($_POST['btnDraft']) ){
			//myPrint($_POST);exit;
				$row_settings = $this->settings_model->get_record_by_id(1);
				if(isset($row_settings))
					$response = $this->check_employer_job_status($row,$row_settings);
				//myPrint($response );exit;
				
				if($response=='no'){
					//redirect(base_url('employer/choose_package'),'');	
					exit;
				}				
				$available_skills = '['.rtrim($available_skills,', ').']';
				$this->outputData['available_skills'] = $available_skills;
				$this->outputData['row'] = $row;
			
				$this->form_validation->set_rules('industry_ID', ('Job category'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('job_title', ('Job Title'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('vacancies', ('Vacancies'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('job_mode', ('Job Mode'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('pay', ('Pay'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('last_date', ('Apply date'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('country', ('Country'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('city', ('City'), 'trim|required|strip_all_tags');
				$this->form_validation->set_rules('qualification', ('Qualification'), 'trim|required');
				//$this->form_validation->set_rules('industry_ID', ('Category'), 'trim|required');
				$this->form_validation->set_rules('hiddeninput', ('Job description'), 'trim|required');
				$this->form_validation->set_rules('experience', ('Experience'), 'trim|required|strip_all_tags');
				//$this->form_validation->set_rules('s_val', ('Skill'), 'trim|required|strip_all_tags');
				$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">',  '</div></div>');
				if ($this->form_validation->run() === FALSE) {
					//$data['cpt_code'] = create_ml_captcha();
					$this->outputData['msg']='';	
					$this->outputData['job_analysis']=$this->db->query("SELECT * FROM tbl_job_analysis WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
					$this->outputData['employer_certificates']=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
					$this->outputData['interviews']=$this->db->query("SELECT * FROM tbl_interview WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
					$this->outputData['quizzes']=$this->db->query("SELECT * FROM tbl_quizzes WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
					$this->outputData['last_date_dummy'] = date('m/d/Y', strtotime("+4 months", strtotime(date("Y-m-d"))));
					$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
					$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
					$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
					$this->outputData['result_salaries'] = $this->salaries_model->get_all_records();
					$this->outputData['result_qualification'] = $this->qualification_model->get_all_records();

					$this->load->view('newweb/employer/emp_add_new_job_view',$this->outputData);
					return;
					
				}
				$quizz_text="";
				foreach ($this->input->post('quizzes') as $quizz_id)
				{
					if($quizz_text!="")
				    	$quizz_text.=",";
				    $quizz_text=$quizz_id;
				}
				$sts='active';
				if($this->input->post('btnDraft'))
					$sts='inactive';
				$current_date_time = date("Y-m-d H:i:s");
				$age_required="";
				if($this->input->post('dated'))
				{
					$current_date_time=$this->input->post('dated');
					$age_required="1";
				}
				if($this->input->post('job_type')=="Internal")
					$sts='inactive';
				$required_skills = "";
				if(($this->input->post("skill"))){
					$required_skills = implode(",",$this->input->post("skill") );
				}
				$job_desc = str_replace("&#8217;", "'", $this->input->post('hiddeninput'));
				$last_date = date_formats($this->input->post('last_date'),'Y-m-d');
				$job_array = array(
										'industry_ID' => $this->input->post('industry_ID'),
										'diarie' => $this->input->post('diarie'),
										'job_title' => humanize($this->input->post('job_title')),
										'vacancies' => $this->input->post('vacancies'),
										'job_mode' => $this->input->post('job_mode'),
										'pay' => $this->input->post('pay'),
										'experience' => $this->input->post('experience'),
										'last_date' => $last_date,
										'country' => $this->input->post('country'),
										'city' => $this->input->post('city'),
										'qualification' => $this->input->post('qualification'),
										'quizz_text' => $quizz_text,
										// 'quizz_text' => $this->input->post('quizz_text'),
										// 'answer_1' => $this->input->post('answer_1'),
										// 'answer_2' => $this->input->post('answer_2'),
										// 'answer_3' => $this->input->post('answer_3'),
										'job_description' => $job_desc,
										'company_ID' => $row->company_ID,
										'employer_ID' => $row->ID,
										'required_skills' => $required_skills,
										'ip_address' => $this->input->ip_address(),
										'job_analysis_id' => $this->input->post('job_analysis'),
										'job_type' => $this->input->post('job_type'),
										'local_mdp' => $this->input->post('local_mdp'),
										'employer_certificate_id' => $this->input->post('employer_certificate'),
										'interview_id' => $this->input->post('interview'),
										'sts' => $sts,
										'dated' => $current_date_time,
										'note'=>$this->input->post('Note'),
										'age_required'=>$age_required
				);
				//myPrint($job_array);exit;
				$job_id = $this->posted_jobs_model->add_posted_job($job_array);
				$job_slug = $this->make_job_slug($row->company_slug, $this->input->post('job_title'), $this->input->post('city'), $job_id);
				$this->posted_jobs_model->update_posted_job($job_id, array('job_slug' => $job_slug));
					
				//insert to notification

				if($sts == "active"){
					$postedSkills = $this->input->post("skill");
					$seekerIdArray = array();
					foreach($postedSkills as $skillName){
						echo  $skillName;
						$getSeekerIds = $this->My_model->selTableData("tbl_seeker_skills","seeker_ID","skill_name like '%".$skillName."%'");
						if(isset($getSeekerIds) && $getSeekerIds != ""){
							foreach($getSeekerIds as $seeker){
								array_push($seekerIdArray,$seeker);
							}
							//array_merge($seekerIdArray,$getSeekerIds);
						}
						array_unique($seekerIdArray);
					}
					if(isset($seekerIdArray) && $seekerIdArray != ""){
						foreach($seekerIdArray as $seeker){
							$insertData =array();
							$insertData['seekerId'] =$seeker->seeker_ID;
							$insertData['employerId'] = $this->sessUserId;
							$insertData['notificationFor'] = "New Job";
							$insertData['notificationText'] = "New Job Added";
							$insertData['jobId'] = $job_id;
							$insertId  = $this->My_model->insert("tbl_seeker_notification",$insertData);
						}
					}
				}
			

				//Reducing 1 if payment plan is active
				if(isset($row_settings) && isset($row_settings->payment_plan) && $row_settings->payment_plan != ""){
					if($row_settings->payment_plan=='1'){
						$allowed_job_qty = $row->allowed_job_qty-1;
						$allowed_job_qty = ($allowed_job_qty<0)?0:$allowed_job_qty;
						$this->employers_model->update($this->sessUserId, array('allowed_job_qty'=>$allowed_job_qty));	
					}
				}
				redirect(WEBURL."/employer/job");
				/*if($this->input->post('preview'))
					redirect(base_url("jobs/".$job_slug),'');*/
			}
		$this->outputData['available_skills'] = $available_skills;
		$this->outputData['row'] = $row;
		$this->outputData['msg']='';	
		$this->outputData['job_analysis']=$this->db->query("SELECT * FROM tbl_job_analysis WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['employer_certificates']=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['interviews']=$this->db->query("SELECT * FROM tbl_interview WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['quizzes']=$this->db->query("SELECT * FROM tbl_quizzes WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['last_date_dummy'] = date('m/d/Y', strtotime("+4 months", strtotime(date("Y-m-d"))));
		$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$this->outputData['result_salaries'] = $this->salaries_model->get_all_records();
		$this->outputData['result_qualification'] = $this->qualification_model->get_all_records();
		$this->load->view('newweb/employer/emp_add_new_job_view',$this->outputData);
		
	}

	public function edit($jobId =0,$redirectTo = 0){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$row = $this->employers_model->get_employer_by_id($this->sessUserId);
		$jobData = $this->My_model->getSingleRowData("tbl_post_jobs","","ID = ".$jobId); 
		//$this->posted_jobs_model->getJob($jobId);
		$available_skills='';
		foreach($this->skill_model->get_all_skills() as $skill_row){
			$available_skills.='"'.$skill_row->skill_name.'", ';
		}
		$available_skills = '['.rtrim($available_skills,', ').']';
		$this->outputData['available_skills'] = $available_skills;
		$this->outputData['row'] = $row;
		$this->outputData['msg']='';	
		$this->outputData['job_analysis']=$this->db->query("SELECT * FROM tbl_job_analysis WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['employer_certificates']=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['interviews']=$this->db->query("SELECT * FROM tbl_interview WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['quizzes']=$this->db->query("SELECT * FROM tbl_quizzes WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['last_date_dummy'] = date('m/d/Y', strtotime("+4 months", strtotime(date("Y-m-d"))));
		$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$this->outputData['result_salaries'] = $this->salaries_model->get_all_records();
		$this->outputData['result_qualification'] = $this->qualification_model->get_all_records();
		$this->outputData['jobData'] = $jobData;

		if(isset($_POST['btnSubmit'])){
			$this->form_validation->set_rules('industry_ID', ('Job category'), 'trim|required');
			$this->form_validation->set_rules('job_title', ('Job Title'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('vacancies', ('Vacancies'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('job_mode', ('Job Mode'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('pay', ('Pay'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('last_date', ('Apply date'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('country', ('Country'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('city', ('City'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('qualification', ('Qualification'), 'trim|required');
			//$this->form_validation->set_rules('industry_id', ('Category'), 'trim|required');
			$this->form_validation->set_rules('hiddeninput', ('Job Description'), 'trim|required');
			/*$this->form_validation->set_rules('contact_person', ('Contact Person'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('contact_email', ('Contact email'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('contact_phone', ('Contact phone'), 'trim|required|strip_all_tags');*/
			$this->form_validation->set_rules('experience', ('Experience'), 'trim|required|strip_all_tags');
			$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">','</div></div>');
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('newweb/employer/edit_job_view',$this->outputData);
				return;
			}
			$quizz_text="";
			foreach ($this->input->post('quizzes') as $quizz_id)
			{
				if($quizz_text!="")
			    	$quizz_text.=",";
			    $quizz_text.=$quizz_id;
			}
			$sts=$row->sts;
			if($this->input->post('job_type')=="Internal")
				$sts='inactive';

			$required_skills = ltrim($this->input->post('s_val'),', ');
			$job_desc = str_replace("&#8217;", "'", $this->input->post('hiddeninput')); //str_replace('"', "'", ($this->input->post('hiddeninput')));
			$last_date = date_formats($this->input->post('last_date'),'Y-m-d');
			$job_slug = $this->make_job_slug($row->company_slug, $this->input->post('job_title'), $this->input->post('city'), $jobId);
			$job_array = array(
								'industry_ID' => $this->input->post('industry_ID'),
								'diarie' => $this->input->post('diarie'),
								'job_title' => $this->input->post('job_title'),
								'vacancies' => $this->input->post('vacancies'),
								'job_mode' => $this->input->post('job_mode'),
								'pay' => $this->input->post('pay'),
								'experience' => $this->input->post('experience'),
								'last_date' => $last_date,
								'country' => $this->input->post('country'),
								'city' => $this->input->post('city'),
								'qualification' => $this->input->post('qualification'),
								'quizz_text' => $quizz_text,
								'job_description' => $job_desc,
								'job_type' => $this->input->post('job_type'),
								'local_mdp' => $this->input->post('local_mdp'),
								'contact_person' => $this->input->post('contact_person'),
								'contact_email' => $this->input->post('contact_email'),
								'contact_phone' => $this->input->post('contact_phone'),
								'job_analysis_id' => $this->input->post('job_analysis'),
								'employer_certificate_id' => $this->input->post('employer_certificate'),
								'interview_id' => $this->input->post('interview'),
								'required_skills' => $required_skills,
								'job_slug' => $job_slug,
								'sts' => $sts,
								'note'=>$this->input->post('Note'),
							);
			$this->posted_jobs_model->update_posted_job($jobId, $job_array);
			$this->add_skill($required_skills);
			if($redirectTo == 1)
				redirect(WEBURL."/employer/company");
			else
				redirect(WEBURL."/employer/job");
		}
		//myPrint($job_array);exit;
		$this->load->view('newweb/employer/edit_job_view',$this->outputData);
	}


	public function archive_job($jobId = 0,$type= '', $redirectTo = 0){
		$statut="archive";
		$this->db->query("UPDATE `tbl_post_jobs` SET `sts` = '".$statut."' WHERE `tbl_post_jobs`.`ID` = ".$jobId." and employer_ID= ".$this->sessUserId);
		if($redirectTo == 0){
			redirect(WEBURL."/employer/job");
		}
	}

	public function change_status($jobId=0){
		$obj_row = $this->posted_jobs_model->get_posted_job_by_id_employer_id($jobId, $this->sessUserId);
		
		if($obj_row){
			$current_status = $obj_row->sts;
			/*if($obj_row->job_type=="Internal")
			{	
				echo lang('draft');
				exit;
			}*/
			if($current_status=='active')
				$new_status= 'inactive';
			else
				$new_status= 'active';
			
			$data = array ('sts' => $new_status);
			
			$this->posted_jobs_model->update_posted_job($jobId, $data);
			//echo $new_status=='inactive'?lang('draft'):lang($new_status);
			redirect(WEBURL."/employer/job");
		} 
	}

	public function view_job($jobId=0,$redirectTo = 0,$archiveId = 0, $candidateId = 0){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$row = $this->employers_model->get_employer_by_id($this->sessUserId);

		$jobData = $this->db->query("SELECT * FROM `tbl_post_jobs` WHERE `ID` =".$jobId)->result(); 
		//	myPrint($jobData);die;
		$this->outputData['jobData']=$jobData[0];
		$this->outputData['redirectTo']=$redirectTo;
		$this->outputData['archiveId']=$archiveId;
		$this->outputData['candidateId']=$candidateId;
		$this->outputData['jobId']=$jobId;
		$this->load->view('newweb/employer/emp_view_job',$this->outputData);
		
	}

	public function delete_job($jobId = 0,$redirectTo = 0){
		//delete_posted_job_by_id_emp_id
		$employerId = $this->sessUserId;
		$this->posted_jobs_model->delete_posted_job_by_id_emp_id($jobId, $employerId);
		$this->applied_jobs_model->delete_applied_job_by_posted_job_id($jobId);

		if($redirectTo == 1)
			redirect(WEBURL."/employer/company");
		else
			redirect(WEBURL."/employer/job");
	}


	public function add_skill($skills)
	{
		if(!$this->sessUserId){
			echo lang('Your session has been expired, please re-login first.');
			exit;	
		}
		$skills_array = explode(', ',$skills);
		
		foreach($skills_array as $skill){
			if(!$this->skill_model->get_skills_by_skill_name($skill)){
				$this->skill_model->add(array('skill_name'=>$skill));
			}
		}
	}

	public function make_job_slug($company_slug, $job_title, $city, $id){
		
		$job_url_prefix = $company_slug.'-jobs-in-';
		$final_job_url ='';
		$job_title = trim($job_title);
		$string1 = preg_replace('/[^a-zA-Z0-9 ]/s', '', $job_title);
		$job_title_slug = strtolower(preg_replace('/\s+/', '-', $string1));
		$job_url_postfix = strtolower($city).'-'.$job_title_slug.'-'.$id;
		$final_job_url = $job_url_prefix.$job_url_postfix;
		return $final_job_url;
		
	}

	private function check_employer_job_status($row,$row_settings){
		$return = 'yes';
		if(isset($row_settings) && isset($row_settings->payment_plan) && $row_settings->payment_plan != ""){
			if($row_settings->payment_plan == '1'){
				if($row->allowed_job_qty<1){
					$return = 'no';	
				}
			}
		}
		return $return;
	}

}
