<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apply_Job extends CI_Controller {
	
	public function index()
	{
		$data['title'] = SITE_NAME.' : '.lang('Apply for the Job');
		$data['msg']='';
		
		if(!$this->session->userdata('user_id')){
			echo lang('All fields are mandatory.');
			exit;	
		}
		
		/*$this->form_validation->set_rules('cv', 'CV', 'trim|required|strip_all_tags');*/
		$this->form_validation->set_rules('expected_salary', lang('Expected Salary'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('cover_letter', lang('Cover letter'), 'trim|required|strip_all_tags');
		$this->form_validation->set_rules('jid', lang('ID'), 'trim|required|strip_all_tags');
		if ($this->form_validation->run() === FALSE) {
			echo validation_errors();
			exit;
			
		}
		$row = $this->posted_jobs_model->get_active_posted_job_by_id($this->input->post('jid'));
		
		if(!$row){
			echo lang('Something went wrong.');
			exit;	
		}
		
		if($this->session->userdata('is_job_seeker')!=TRUE){
			echo lang('You are not logged in with a jobseeker account. Please re-login with a jobseeker account to apply for this job.');
			exit;
		}
		$is_already_applied = $this->applied_jobs_model->get_applied_job_by_seeker_and_job_id($this->session->userdata('user_id'), $this->input->post('jid'));
		
		if($is_already_applied>0){
			echo lang('You have already applied for this job job has been closed.');
			exit;	
		}
		
		/*$can_apply = ($row->last_date > date("Y-m-d")?'yes':'no');
		
		if($can_apply=='no'){
			echo 'This job has been closed.';
			exit;	
		}*/
		
		$current_date_time = date("Y-m-d H:i:s");
		
		

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
				$config['max_size'] = 100000;
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


		
		$job_array = array(
							'seeker_ID' 		=> $this->session->userdata('user_id'),
							'job_ID' 			=> $this->input->post('jid'),
							'employer_ID' 		=> $row->employer_ID,
							'cover_letter' 		=> $this->input->post('cover_letter'),
							'expected_salary' 	=> $this->input->post('expected_salary'),
							'answer' 			=> $this->input->post('answer'),
							'skills_level' 		=> $this->input->post('skills_level'),
							'file_name' 		=> $attached_file,
							'dated' 			=> $current_date_time
		);
		$this->applied_jobs_model->add_applied_job($job_array);
		
		//Sending email
		$row_email = $this->email_model->get_records_by_id(5);
		$config = array();
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
		$data_array = $this->posted_jobs_model->get_active_posted_job_by_id($this->input->post('jid'));
		$seeker_id = $this->custom_encryption->encrypt_data($this->session->userdata('user_id'));
		
		$subject = str_replace('{JOB_TITLE}', $data_array->job_title, $row_email->subject);
		
		
		$config = $this->email_drafts_model->email_configuration();


		$this->email->initialize($config);


		$this->email->initialize($config);
		// $this->email->clear(TRUE);
		$this->email->from("bixma@agoujil.com", "BiXma Job System");
		$this->email->to($data_array->employer_email);
		$mail_message = $this->email_drafts_model->apply_job($seeker_id, $row_email->content, $data_array);
		$this->email->subject($subject);
		$this->email->message($mail_message);     
		$this->email->send();
		if($this->input->get('yep',TRUE))
		{
			$this->session->set_userdata('message_applied_job','1');
			redirect(base_url().'app/job_details/index/job_details'.$row->job_slug);
		}
		echo 'done';
	}
}
