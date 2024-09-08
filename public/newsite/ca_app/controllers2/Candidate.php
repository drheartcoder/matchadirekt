<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Candidate extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index($id='')
	{
		$data['ads_row'] = $this->ads;
		$data['chat_url'] = '';//base_url().'employer/chat/1'
		if($id==''){
			$this->load->view('404_view', $data);
			return;	
		}
				
		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg', 'Please login as a employer to view the candidate profile.');
			redirect(base_url('login'));
			return;	
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		
		if(!$row){
			$this->load->view('404_view', $data);
			return;		
		}
		
		//Latest Job
		$row_latest_exp = $this->jobseeker_experience_model->get_latest_job_by_seeker_id($decrypted_id);
		//Experience
		$result_experience = $this->job_seekers_model->get_experience_by_jobseeker_id($decrypted_id);
		
		//Qualification
		$result_qualification = $this->job_seekers_model->get_qualification_by_jobseeker_id($decrypted_id);
		
		//Resumes
		$result_resume = $this->resume_model->get_records_by_seeker_id($decrypted_id, 5, 0);
		
		//Additional Info
		$row_additional = $this->jobseeker_additional_info_model->get_record_by_userid($decrypted_id);
		
		$photo = ($row->photo)?$row->photo:'thumb/no_pic.jpg';
				if (!file_exists(realpath(APPPATH . '../public/uploads/candidate/'.$photo))){
					$photo='thumb/no_pic.jpg';
				}
		$employer_ = $this->employers_model->get_employer_by_id($this->session->userdata('user_id'));
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$employer_->ID' AND tbl_conversation.id_job_seeker='$row->ID'")->result();
		if(count($conv)>0)
			$data['chat_url'] = base_url().'employer/chat/'.$conv['0']->id_conversation;

		$data['IDCD'] 					= $id;
		$data['row'] 					= $row;
		$data['title'] 					= $row->first_name.' Profile';
		$data['result_experience'] 		= $result_experience;
		$data['result_qualification'] 	= $result_qualification;
		$data['result_degrees'] 		= $this->qualification_model->get_all_records();
		$data['result_resume'] 			= $result_resume;
		$data['row_additional'] 		= $row_additional;
		$data['latest_job_title']		= ($row_latest_exp)?$row_latest_exp->job_title:'';
		$data['latest_job_company_name']= ($row_latest_exp)?$row_latest_exp->company_name:'';
		$data['photo'] 					= $photo;
		$this->load->view('candidate_view',$data);
	}
	public function send_message($id)
	{
		if($id==''){
			$this->load->view('404_view', $data);
			return;	
		}
				
		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg', 'Please login as a employer to view the candidate profile.');
			redirect(base_url('login'));
			return;	
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		
		if(!$row){
			$this->load->view('404_view', $data);
			return;		
		}
		


		if(!$this->input->post("message"))
		{
			$this->load->view('404_view', $data);
			return;
		}
		$message=$this->input->post("message");
		$employer_ = $this->employers_model->get_employer_by_id($this->session->userdata('user_id'));
		stp:
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$employer_->ID' AND tbl_conversation.id_job_seeker='$row->ID'")->result();
		$curr_date=date("Y-m-d H:i:s");
		if(count($conv)<=0)
		{
			$this->db->query("INSERT INTO tbl_conversation SET id_employer='$employer_->ID',id_job_seeker='$row->ID',created_at='$curr_date'");
			goto stp;
		}
		$conv=$conv['0'];
		$this->db->query("INSERT INTO tbl_conv_message SET id_conversation='$conv->id_conversation',id_sender='$employer_->ID',message='$message',type_sender='employers',sent_at='$curr_date'");
		redirect(base_url().'employer/chat/'.$conv->id_conversation);
	}
}
