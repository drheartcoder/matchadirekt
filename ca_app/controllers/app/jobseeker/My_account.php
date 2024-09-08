<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_Account extends CI_Controller {
	
	public function __construct(){
        parent::__construct();

        $this->load->helper('email');
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		if(!$this->session->userdata('user_id')){
            redirect(base_url()."app/User/login"); 
			exit;	
		}
		
		//Additional Info
		$row_additional = $this->jobseeker_additional_info_model->get_record_by_userid($this->session->userdata('user_id'));
		
		//Skills
//		$keywords = $this->jobseeker_skills_model->count_jobseeker_skills_by_seeker_id($this->session->userdata('user_id'));
//		$is_keywords_provided = $keywords;
//		
//		if($is_keywords_provided<3){
//			  redirect(base_url('jobseeker/add_skills'));
//			  exit;
//		}
		
		$data['ads_row'] = $this->ads;
		$user_id=$this->session->userdata('user_id');
		$row = $this->job_seekers_model->get_job_seeker_by_id($user_id);
		$data['title'] = SITE_NAME.': Manage Account';
		$data['title_app'] = 'Manage Account';

		$data['row'] = $row;
		$data['result_cities'] 			= $this->cities_model->get_all_cities();
		$data['result_countries'] 		= $this->countries_model->get_all_countries();
		$strv="tbl_job_seekers.email.".$user_id."'";
		$this->form_validation->set_rules('email',lang('Email'), "valid_email|required|trim|xss_clean|edit_unique[$strv]");
		$this->form_validation->set_rules('full_name', lang('Full Name'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('mobile', lang('Mobile'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('dob_day', 'DOB', 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('dob_month', 'DOB', 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('dob_year', 'DOB', 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('gender', lang('Gender'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('present_address', lang('Present address'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('country', lang('Country'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('city', lang('City'), 'trim|required|strip_all_tags');
		$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', '</div></div>');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('application_views/jobseeker/my_profile',$data);
			return;
		}
		$profile_array = array(
							'email'		=> $this->input->post('email'),
							'first_name'		=> $this->input->post('full_name'),
							'last_name'			=> '',
							'mobile'			=> $this->input->post('mobile'),
							'dob'				=> $this->input->post('dob_year').'-'.$this->input->post('dob_month').'-'.$this->input->post('dob_day'),
							'present_address' 	=> $this->input->post('present_address'),
							'country' 			=> $this->input->post('country'),
							'city' 				=> $this->input->post('city'),
							'gender' 			=> $this->input->post('gender'),
		);
		$this->job_seekers_model->update($this->session->userdata('user_id'), $profile_array);
		$this->session->set_userdata('first_name',$this->input->post('full_name'));
		$this->session->set_flashdata('msg', '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Success').'!</strong> '.lang('Profile has been updated successfully').'. </div>');
		redirect(base_url('app/jobseeker/my_account'));
	}
    
    
  	public function upload_photo(){
		if(!$this->session->userdata('user_id')){
            redirect(base_url()."app/User/login"); 
			exit;	
		}
		if (!empty($_FILES['upload_pic']['name'])){
			$obj_row = $this->job_seekers_model->get_job_seeker_by_id($this->session->userdata('user_id'));
			$company_name_for_file = strtolower($this->input->post('company_name'));
			$real_path = realpath(APPPATH . '../public/uploads/candidate/');
			$config['upload_path'] = $real_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['overwrite'] = true;
			$config['file_name'] = make_slug($obj_row->first_name).'-BiXma-'.$obj_row->ID;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('upload_pic')){
//				if(!$obj_row->photo){
//					@unlink($real_path.'/'.$obj_row->photo);	
//					@unlink($real_path.'/thumb/'.$obj_row->photo);
//				}
//			} else{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Error').'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(base_url('app/jobseeker/my_account'));
				exit;
			}
			$image = array('upload_data' => $this->upload->data());	
			$image_name = $image['upload_data']['file_name'];
			$thumb_config['image_library'] = 'gd2';
			$thumb_config['source_image']	= $real_path.'/'.$image_name;
			$thumb_config['new_image']	= $real_path.'/thumb/'.$image_name;
			$thumb_config['maintain_ratio'] = TRUE;
			$thumb_config['height']	= 200;
			$thumb_config['width']	 = 200;
			
			$this->image_lib->initialize($thumb_config);
			$this->image_lib->resize();
			
			$photo_array = array('photo' => $image_name);
			$this->job_seekers_model->update($this->session->userdata('user_id'), $photo_array);
			$this->session->set_flashdata('msg', '<div style="margin-top:15px;" class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Success').'!</strong>'. lang('Photo uploaded successfully').'. </div>');
		}
		redirect(base_url('app/jobseeker/my_account'));
	}

}
