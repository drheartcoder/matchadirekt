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
			redirect(base_url('app/employer/Job_applications'));
			return;	
		}
				
		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg', lang('Please login as a employer to view the candidate profile.'));
			redirect(base_url('app/user/login'));
			return;	
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		
		if(!$row){
			redirect(base_url('app/employer/Job_applications'));
			return;		
		}
		
		//Latest Job
		$row_latest_exp = $this->jobseeker_experience_model->get_latest_job_by_seeker_id($decrypted_id);
		//Experience
		$result_experience = $this->job_seekers_model->get_experience_by_jobseeker_id($decrypted_id);
		
		//Qualification
		$result_qualification = $this->job_seekers_model->get_qualification_by_jobseeker_id($decrypted_id);

		$result_reference = $this->db->query("SELECT * FROM tbl_seeker_reference WHERE seeker_ID='".$decrypted_id."' AND deleted='0'")->result();
		
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
		$data['result_reference'] 		= $result_reference;
		$data['result_degrees'] 		= $this->qualification_model->get_all_records();
		$data['result_resume'] 			= $result_resume;
		$data['row_additional'] 		= $row_additional;
		$data['latest_job_title']		= ($row_latest_exp)?$row_latest_exp->job_title:'';
		$data['latest_job_company_name']= ($row_latest_exp)?$row_latest_exp->company_name:'';
		$data['photo'] 					= $photo;
        $data['title_app'] 					= 'Candidate';
        
		$data['employer_jobs']=$this->db->query("SELECT * FROM tbl_post_jobs WHERE tbl_post_jobs.employer_ID='$employer_->ID' AND deleted='0'")->result();



		// Get company applications
		$data['applications']=[];
		if($this->session->userdata('is_employer')==TRUE){
			$user_id=$this->session->userdata('user_id');
			$rows = $this->applied_jobs_model->get_applied_job_by_seeker_and_employer_id($decrypted_id,$user_id);
			$data['applications']=$rows;
		}

		$this->load->view('application_views/candidate_view',$data);
	}






	public function send_message($id)
	{
		if($id==''){
			redirect(base_url('app/employer/Job_applications'));
			return;	
		}
				
		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg',lang('Please login as a employer to view the candidate profile.'));
			redirect(base_url('app/user/login'));
			return;	
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		
		if(!$row){
			redirect(base_url('app/employer/Job_applications'));
			return;		
		}
		


		if(!$this->input->post("message") && empty($_FILES['upload_file']['name']))
		{
			redirect(base_url('app/employer/Job_applications'));
			return;
		}
		$curr_date=date("Y-m-d H:i:s");
		$message=$this->input->post("message");
		$employer_ = $this->employers_model->get_employer_by_id($this->session->userdata('user_id'));
		stp:
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$employer_->ID' AND tbl_conversation.id_job_seeker='$row->ID'")->result();
		if(count($conv)<=0)
		{
			$this->db->query("INSERT INTO tbl_conversation SET id_employer='$employer_->ID',id_job_seeker='$row->ID',created_at='$curr_date'");
			goto stp;
		}
		$conv=$conv['0'];
		$message_to_send=lang("Hi").' '.$row->first_name.",<br/><br/>".lang("You have new message(s) from")." <a href='".base_url().'jobseeker/chat/'.$conv->id_conversation."'>".$employer_->first_name.' '.$employer_->last_name."</a> :<br/><br/>";
		if($this->input->post("message"))
		{
			$this->db->query("INSERT INTO tbl_conv_message SET id_conversation='$conv->id_conversation',id_sender='$employer_->ID',message='$message',type_sender='employers',sent_at='$curr_date'");
			$message_to_send.=$message."<br/>";
		}



		if (!empty($_FILES['upload_file']['name']))
		{
			$real_path = realpath(APPPATH . '../public/uploads/chat/');
			$config['upload_path'] = $real_path;
			$config['allowed_types'] = '*';
			$config['overwrite'] = true;
			$config['max_size'] = 60000;
			$config['file_name'] = 'Attached_file_BiXma-'.md5($curr_date);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('upload_file')){
				
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Error').'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(base_url('employer/chat').$conv->id_conversation);
				exit;
			}
			
			$resume = array('upload_data' => $this->upload->data());	
			$file_name = $resume['upload_data']['file_name'];
			$ull=base_url()."employer/chat/download/".$file_name;
			$sty="text-decoration: none;color: white;";
			$message="<i style='".$sty."' class='fa fa-file-o'>&nbsp;</i>
                  <a style='".$sty."' href='".$ull."'>Attached File<br></a>";
			$message_to_send.="<a href='".$ull."'>Attached File</a>";
			$data_array = array(
			        'message' => $message,
			        'id_conversation' => $conv->id_conversation,
			        'id_sender' => $employer_->ID,
			        'type_sender' => 'employers',
			        'sent_at' => $curr_date
			);
			// var_dump($data_array);
			// die();
			$this->db->insert('tbl_conv_message', $data_array);
		}
		$message_to_send.="<br/><br/>".lang('Regards').",";



		$config = $this->email_drafts_model->email_configuration();


		$this->email->initialize($config);
		
		// $this->email->clear(TRUE);
		$this->email->from("bixma@agoujil.com", "BiXma Job System");
		$this->email->to($row->email);
		$mail_message = $message_to_send;
		$this->email->subject($subject);
		$this->email->message($mail_message);     
		$this->email->send();

		redirect(base_url().'employer/chat/'.$conv->id_conversation);
	}
}
