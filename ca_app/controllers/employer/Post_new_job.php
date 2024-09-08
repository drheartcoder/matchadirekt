<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_New_Job extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$row = $this->employers_model->get_employer_by_id($this->session->userdata('user_id'));
		$row_settings = $this->settings_model->get_record_by_id(1);
		if(count($row_settings)>0)
			$response = $this->check_employer_job_status($row,$row_settings);
		
		if($response=='no'){
			redirect(base_url('employer/choose_package'),'');	
			exit;
		}
		
		$available_skills = '';
		$data['ads_row'] = $this->ads;
		$data['title'] = SITE_NAME.' : Post New Job';
		$data['msg']='';
		$data['last_date_dummy'] = date('m/d/Y', strtotime("+4 months", strtotime(date("Y-m-d"))));
		$data['result_cities'] = $this->cities_model->get_all_cities();
		$data['result_countries'] = $this->countries_model->get_all_countries();
		$data['result_industries'] = $this->industries_model->get_all_industries();
		$data['result_salaries'] = $this->salaries_model->get_all_records();
		$data['result_qualification'] = $this->qualification_model->get_all_records();
		$data['job_analysis']=$this->db->query("SELECT * FROM tbl_job_analysis WHERE employer_id='".$row->ID."' AND deleted='0'")->result();
		$data['employer_certificates']=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE employer_id='".$row->ID."' AND deleted='0'")->result();
		$data['interviews']=$this->db->query("SELECT * FROM tbl_interview WHERE employer_id='".$row->ID."' AND deleted='0'")->result();
		$data['quizzes']=$this->db->query("SELECT * FROM tbl_quizzes WHERE employer_id='".$row->ID."' AND deleted='0'")->result();
		foreach($this->skill_model->get_all_skills() as $skill_row){
			$available_skills.='"'.$skill_row->skill_name.'", ';
		}
		$available_skills = '['.rtrim($available_skills,', ').']';
		$data['available_skills'] = $available_skills;
		$data['row'] = $row;
	
		$this->form_validation->set_rules('industry_id', lang('Job category'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('job_title', lang('Job Title'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('vacancies', lang('Vacancies'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('job_mode', lang('Job Mode'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('pay', lang('Pay'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('last_date', lang('Apply date'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('country', lang('Country'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('city', lang('City'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('qualification', lang('Qualification'), 'trim|required');
		$this->form_validation->set_rules('industry_id', lang('Category'), 'trim|required');
		$this->form_validation->set_rules('editor1', lang('Job description'), 'trim|required|secure');
		$this->form_validation->set_rules('experience', lang('Experience'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('s_val', lang('Skill'), 'trim|required|strip_all_tags');
		$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', 

'</div></div>');
		if ($this->form_validation->run() === FALSE) {
			$data['cpt_code'] = create_ml_captcha();
			$this->load->view('employer/post_new_job_view',$data);
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
		if($this->input->post('draft'))
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
		$required_skills = ltrim($this->input->post('s_val'),', ');
		$job_desc = $this->input->post('editor1');
		$last_date = date_formats($this->input->post('last_date'),'Y-m-d');
		$job_array = array(
								'industry_ID' => $this->input->post('industry_id'),
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
								'age_required'=>$age_required,
		);
		$job_id = $this->posted_jobs_model->add_posted_job($job_array);
		$job_slug = $this->make_job_slug($row->company_slug, $this->input->post('job_title'), $this->input->post

('city'), $job_id);
		$this->posted_jobs_model->update_posted_job($job_id, array('job_slug' => $job_slug));
		
		//Reducing 1 if payment plan is active
		if($row_settings->payment_plan=='1'){
			$allowed_job_qty = $row->allowed_job_qty-1;
			$allowed_job_qty = ($allowed_job_qty<0)?0:$allowed_job_qty;
			$this->employers_model->update($this->session->userdata('user_id'), array('allowed_job_qty'=>

$allowed_job_qty));	
		}

		if($this->input->post('preview'))
			redirect(base_url("jobs/".$job_slug),'');

		//$this->add_skill($required_skills);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-

dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>'. lang('New job has been posted successfully').'.</div>');
		
		redirect(base_url('employer/my_posted_jobs'),'');
		
	}
	public function add_skill($skills)
	{
		if(!$this->session->userdata('user_id')){
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
		if($row_settings->payment_plan=='1'){
			if($row->allowed_job_qty<1){
				$return = 'no';	
			}
		}
		return $return;
	}
}
