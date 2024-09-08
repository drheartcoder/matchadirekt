<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Edit_Posted_Job extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index($id='')
	{
		
		if($id==''){
			redirect(base_url().'app/employer/my_posted_jobs','');
			exit;
		}
		
		$data['ads_row'] = $this->ads;
		$data['id'] = $id;
		$data['title'] = SITE_NAME.' : Edit Posted Job';
		$data['msg']='';
		$data['result_cities'] = $this->cities_model->get_all_cities();
		$data['result_countries'] = $this->countries_model->get_all_countries();
		$data['result_industries'] = $this->industries_model->get_all_industries();
		$data['result_salaries'] = $this->salaries_model->get_all_records();
		$data['result_qualification'] = $this->qualification_model->get_all_records();
		$data['job_analysis']=$this->db->query("SELECT * FROM tbl_job_analysis WHERE employer_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
		$data['result_files']=$this->db->query("SELECT * FROM tbl_employer_files WHERE employer_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
		$data['employer_certificates']=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE employer_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
		$data['interviews']=$this->db->query("SELECT * FROM tbl_interview WHERE employer_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
		$data['quizzes']=$this->db->query("SELECT * FROM tbl_quizzes WHERE employer_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
        $data['title_app']='Edit Posted Job';
		$available_skills='';
		foreach($this->skill_model->get_all_skills() as $skill_row){
			$available_skills.='"'.$skill_row->skill_name.'", ';
		}
		$available_skills = '['.rtrim($available_skills,', ').']';
		$data['available_skills'] = $available_skills;
		$row = $this->posted_jobs_model->get_posted_job_by_id_employer_id($id, $this->session->userdata('user_id'));
		if(!$row){
			redirect(base_url().'app/employer/my_posted_jobs','');
			exit;	
		}
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
		$this->form_validation->set_rules('editor1', lang('Job Description'), 'trim|required');
		$this->form_validation->set_rules('contact_person', lang('Contact Person'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('contact_email', lang('Contact email'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('contact_phone', lang('Contact phone'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('experience', lang('Experience'), 'trim|required|strip_all_tags');
	
		$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', '</div></div>');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('application_views/employer/edit_posted_job_view',$data);
			return;
		}
		$quizz_text="";
		foreach ($this->input->post('quizzes') as $quizz_id)
		{
			if($quizz_text!="")
		    	$quizz_text.=",";
		    $quizz_text.=$quizz_id;
		}
		
		$required_skills = ltrim($this->input->post('s_val'),', ');
		$job_desc = $this->input->post('editor1');
		$last_date = date_formats($this->input->post('last_date'),'Y-m-d');
		$job_slug = $this->make_job_slug($row->company_slug, $this->input->post('job_title'), $this->input->post('city'), $id);
		$job_array = array(
								'industry_id' => $this->input->post('industry_id'),
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
								// 'quizz_text' => $this->input->post('quizz_text'),
								// 'answer_1' => $this->input->post('answer_1'),
								// 'answer_2' => $this->input->post('answer_2'),
								// 'answer_3' => $this->input->post('answer_3'),
								'job_description' => $job_desc,
								'contact_person' => $this->input->post('contact_person'),
								'contact_email' => $this->input->post('contact_email'),
								'contact_phone' => $this->input->post('contact_phone'),
								'job_analysis_id' => $this->input->post('job_analysis'),
								'employer_certificate_id' => $this->input->post('employer_certificate'),
								'interview_id' => $this->input->post('interview'),
								'required_skills' => $required_skills,
								'job_slug' => $job_slug,
								'note'=>$this->input->post('Note'),
		);
		$this->posted_jobs_model->update_posted_job($id, $job_array);
		$this->add_skill($required_skills);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>' .lang('Job has been updated successfully').'.</div>');
		redirect(base_url('app/employer/edit_posted_job/index/'.$id),'');		
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
	
	public function delete_posted_job($id=''){
		
		if(!$this->session->userdata('user_id')){
			echo lang('Your session has been expired, please re-login first.');
			exit;	
		}
		
		if($this->session->userdata('is_employer')!=TRUE){
			echo lang('Illegal Request. Details are sent to administrator.');
			exit;	
		}
		
		if($id==''){
			echo lang('Valid ID is missing.');
			exit;	
		}
		
		$this->posted_jobs_model->delete_posted_job_by_id_emp_id($id, $this->session->userdata('user_id'));
		$this->applied_jobs_model->delete_applied_job_by_posted_job_id($id);
		echo "done";
		
	}
	
	public function status($id=''){
		
		if($id==''){
			echo 'error';
			exit;
		}
		if(!$this->session->userdata('user_id')){
			echo lang('Your session has been expired, please re-login first.');
			exit;	
		}
		
		if($this->session->userdata('is_employer')!=TRUE){
			echo lang('Illegal Request. Details are sent to administrator.');
			exit;	
		}
		
		$obj_row = $this->posted_jobs_model->get_posted_job_by_id_employer_id($id, $this->session->userdata('user_id'));
		
		if($obj_row){
			$current_status = $obj_row->sts;
			if($current_status=='active')
				$new_status= 'inactive';
			else
				$new_status= 'active';
			
			$data = array ('sts' => $new_status);
			
			$this->posted_jobs_model->update_posted_job($id, $data);
			echo $new_status=='inactive'?lang('draft'):lang($new_status);
		}else{
			echo lang('It seems an illegal Request. Details are sent to administrator.');
		}
		exit;
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
	public function edit_advertise($id='')
	{
		// echo $this->input->post('html_code');
		if($id==''){
			redirect(base_url().'app/employer/my_posted_jobs','');
			exit;
		}

		$row = $this->posted_jobs_model->get_posted_job_by_id_employer_id($id, $this->session->userdata('user_id'));
		if(!$row){
			redirect(base_url().'app/employer/my_posted_jobs','');
			exit;	
		}


		$this->db->set('advertise', $this->input->post('html_code'));
		$this->db->where('ID', $id);
		$this->db->update('tbl_post_jobs');
		
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>'. lang('Job Advertise has been updated successfully').'.</div>');
		$job_advertise_name="BIXMA_JOB_".$id;
		$jburl=base_url().'aqcsh/'.$id;
		$output = exec("xvfb-run wkhtmltoimage --width 700 ".$jburl." /home/ubuntu/code/job-portal/public/uploads/employer/companies/".$job_advertise_name.".png");
		redirect(base_url('app/employer/edit_posted_job/index/'.$id),'');		
	}

	public function download($id,$name){
		if($id==''){
			redirect(base_url('login'));
			exit;	
		}
		$file_name="BIXMA_JOB_".$id.".png";
		if($name=="")
			$name=$file_name;
		
					if (!file_exists(realpath(APPPATH . '../public/uploads/employer/companies/'.$file_name))){
						echo 'Files does not exist on the server. <a href="javascript:;" onclick="window.history.back();">Back</a>';
						exit;
					}
					
		$data = file_get_contents(base_url("public/uploads/employer/companies/".$file_name));
		force_download($name, $data);
		exit;
	}


	public function upload_file($id){
		if(!$this->session->userdata('user_id')){
			echo lang('Your session has been expired, please re-login first.');
			exit;	
		}
		if (!empty($_FILES['upload_file']['name'])){
			$real_path = realpath(APPPATH . '../public/uploads/employer/files/');
			$config['upload_path'] = $real_path;
			$config['allowed_types'] = 'doc|docx|pdf|rtf|jpg|png|jpeg|mp4|txt|gif|xls|xlsx';
			$config['overwrite'] = true;
			$config['max_size'] = 6000;
			$config['file_name'] = 'BiXma-Job-File-'.$id.time();
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('upload_file')){
				
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Error').'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(base_url('app/employer/edit_posted_job/index/'.$id));
				exit;
			}
			
			$file = array('upload_data' => $this->upload->data());	
			$file_file_name = $file['upload_data']['file_name'];
			$file_array = array(
									'employer_ID' => $this->session->userdata('user_id'),
									'job_ID' => $id,
									'file_name' => $file_file_name,
									'created_at' => date("Y-m-d H:i:s")
									
			);
			$this->db->insert("tbl_employer_files",$file_array);			
			$this->session->set_flashdata('msg', '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Success').'!</strong>'. lang('File uploaded successfully').'. </div>');
		}
		redirect(base_url('app/employer/edit_posted_job/index/'.$id));
	}
	public function edit_file($param,$id,$id2)
	{
		$yn="no";
		if($param=="0")
			$yn="yes";
		$this->db->query("UPDATE tbl_employer_files SET private='$yn' WHERE ID='$id' AND job_id='$id2' AND employer_id='".$this->session->userdata('user_id')."'");
		redirect(base_url('app/employer/edit_posted_job/index/'.$id2));	
	}
	public function delete_file($id,$id2)
	{		
		if($obj_row=$this->db->query("SELECT * FROM tbl_employer_files WHERE deleted='0' AND ID='$id' AND job_id='$id2' AND employer_id='".$this->session->userdata('user_id')."'")->result())
		{
			$this->db->query("UPDATE tbl_employer_files SET deleted='1' WHERE ID='$id' AND job_id='$id2' AND employer_id='".$this->session->userdata('user_id')."'");
			$obj_row=$obj_row['0'];
			$real_path = realpath(APPPATH . '../public/uploads/employer/files/');
			@unlink($real_path.'/'.$obj_row->file_name);	
		} 

		redirect(base_url('app/employer/edit_posted_job/index/'.$id2));	
	}


    public function Clone_1($id_toClone)
    {
        $row = $this->posted_jobs_model->getJob($id_toClone);
		$row->ID=null;
		$id=$this->posted_jobs_model->add_posted_job($row);

		redirect(base_url('app/employer/edit_posted_job/index/'.$id),'');
    }


}
