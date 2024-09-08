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
			$this->session->set_flashdata('msg', lang('Please login as a employer to view the candidate profile.'));
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
		$data['employer_jobs']=$this->db->query("SELECT * FROM tbl_post_jobs WHERE tbl_post_jobs.employer_ID='$employer_->ID' AND deleted='0'")->result();



		// Get company applications
		$data['applications']=[];
		if($this->session->userdata('is_employer')==TRUE){
			$user_id=$this->session->userdata('user_id');
			$rows = $this->applied_jobs_model->get_applied_job_by_seeker_and_employer_id($decrypted_id,$user_id);
			$data['applications']=$rows;
		}
//myPrint($data);die;

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
			$this->session->set_flashdata('msg',lang('Please login as a employer to view the candidate profile.'));
			redirect(base_url('login'));
			return;	
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		
		if(!$row){
			$this->load->view('404_view', $data);
			return;		
		}
		


		if(!$this->input->post("message") && empty($_FILES['upload_file']['name']))
		{
			$this->load->view('404_view', $data);
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
			$max_size=6000;
			$max_size=$this->db->query("SELECT * FROM tbl_settings")->result()['0']->upload_limit;
			$config['max_size'] = $max_size;
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


	public function add($candidateID){


		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg', lang('Please login as a employer to view the candidate profile.'));
			redirect(base_url('login'));
			return;	
		}

		$employer_id=$this->session->userdata('user_id');
		
		$is_already_applied = $this->applied_jobs_model->get_applied_count_job_by_seeker_and_employer_id($candidateID, $employer_id);
		
		if($is_already_applied>0){
			redirect($this->agent->referrer());

	
		}

		


		$current_date_time = date("Y-m-d H:i:s");

		$job_array = array(
							'seeker_ID' 		=> $candidateID,
							'job_ID' 			=> 0,
							'employer_ID' 		=> $employer_id,
							'dated' 			=> $current_date_time
		);
		$this->applied_jobs_model->add_applied_job($job_array);

		redirect($this->agent->referrer());



	}

	public function add_to_job($candidateID){


		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg', lang('Please login as a employer to view the candidate profile.'));
			redirect(base_url('login'));
			return;	
		}

		$employer_id=$this->session->userdata('user_id');
		$job_id=$this->input->post('job_id');
		
		$is_already_applied = $this->applied_jobs_model->get_applied_count_job_by_seeker_and_employer_id_and_job_id($candidateID, $employer_id, $job_id);
		
		if($is_already_applied>0){
			redirect($this->agent->referrer());

	
		}

		$allowed_types = array('doc','docx','pdf','rtf','jpg','png','jpeg','txt','mp4','flv','avi','wmv','gif','3gp');
		
		$real_path = realpath(APPPATH . '../public/uploads/candidate/applied_job/');

		$attached_file="";
		$filesCount = 0;
		if(!empty($_FILES['attached_file']['name']))
			$filesCount = count($_FILES['attached_file']['name']);

        for($i = 0; $i < $filesCount; $i++)
        {
        	$_FILES['userFile']['name'] = $_FILES['attached_file']['name'][$i];
            $_FILES['userFile']['type'] = $_FILES['attached_file']['type'][$i];
            $_FILES['userFile']['tmp_name'] = $_FILES['attached_file']['tmp_name'][$i];
            $_FILES['userFile']['error'] = $_FILES['attached_file']['error'][$i];
            $_FILES['userFile']['size'] = $_FILES['attached_file']['size'][$i];
            $extention = get_file_extension($_FILES['userFile']['name']);
            if(in_array($extention,$allowed_types))
			{
				$config['upload_path'] = $real_path;
				$config['allowed_types'] = '*';
				$config['overwrite'] = true;
				$max_size=6000;
				$max_size=$this->db->query("SELECT * FROM tbl_settings")->result()['0']->upload_limit;
				$config['max_size'] = $max_size;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('userFile'))
				{
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
					if($i!=0)
						$attached_file.="$*_,_*$";
					$attached_file.= $file_name;
				}
			}
        }


		$current_date_time = date("Y-m-d H:i:s");

		$job_array = array(
							'seeker_ID' 		=> $candidateID,
							'job_ID' 			=> $job_id,
							'employer_ID' 		=> $employer_id,
							'file_name' 		=> $attached_file,
							'dated' 			=> $current_date_time
		);
		$this->applied_jobs_model->add_applied_job($job_array);

		redirect($this->agent->referrer());



	}

}
