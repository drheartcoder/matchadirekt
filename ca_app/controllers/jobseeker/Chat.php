<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index($id='')
	{
		$data['convs']='';
		$data['messages']='';
		$data['nothing']=0;
		$data['title']="Chat | ".SITE_NAME;
		if($this->session->userdata('is_job_seeker')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			redirect(base_url('login'));
			return;	
		}

		$job_seeker_ = $this->job_seekers_model->get_job_seeker_by_id($this->session->userdata('user_id'));
		$convs=$this->db->query("SELECT * FROM tbl_conversation INNER JOIN tbl_employers ON tbl_employers.ID=tbl_conversation.id_employer INNER JOIN tbl_companies ON tbl_companies.ID=tbl_employers.company_id WHERE id_job_seeker='$job_seeker_->ID'")->result();
		if($id=="" && count($convs)>0)
		{
			redirect(base_url().'jobseeker/chat/'.$convs['0']->id_conversation);
		}
		$conv=$this->db->query("SELECT * FROM tbl_conversation WHERE id_conversation='$id' AND id_job_seeker='$job_seeker_->ID'")->result();
		if(count($conv)<=0){
			$data['nothing']=1;
			$this->load->view('jobseeker/chat', $data);
			return;	
		}
		$conv=$conv['0'];
		$data['convs']=$convs;
		$messages=$this->db->query("SELECT * FROM tbl_conv_message WHERE id_conversation='$conv->id_conversation'")->result();
		$employer=$this->employers_model->get_employer_by_id($conv->id_employer);
		$data['messages']=$messages;
		$data['jobseeker']=$job_seeker_;
		$data['employer']=$employer;
		$this->load->view('jobseeker/chat',$data);
	}
	public function send_message($id)
	{
		if($id==''){
			$this->load->view('404_view', $data);
			return;	
		}
				
		if($this->session->userdata('is_job_seeker')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			redirect(base_url('login'));
			return;	
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$employer_ = $this->employers_model->get_employer_by_id($decrypted_id);
		
		if(!$employer_){
			$this->load->view('404_view', $data);
			return;		
		}
		


		if(!$this->input->post("message") && empty($_FILES['upload_file']['name']))
		{
			$this->load->view('404_view', $data);
			return;
		}
		$message=$this->input->post("message");
		$row = $this->job_seekers_model->get_job_seeker_by_id($this->session->userdata('user_id'));
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$employer_->ID' AND tbl_conversation.id_job_seeker='$row->ID'")->result();
		$curr_date=date("Y-m-d H:i:s");
		if(count($conv)<=0)
		{
			$this->load->view('404_view', $data);
			return;
		}
		$conv=$conv['0'];
		$message_to_send=lang("Hi").' '.$employer_->first_name.",<br/><br/>".lang("You have new message(s) from")." <a href='".base_url().'employer/chat/'.$conv->id_conversation."'>".$row->first_name.' '.$row->last_name."</a> :<br/><br/>";
		if($this->input->post("message"))
		{
			$this->db->query("INSERT INTO tbl_conv_message SET id_conversation='$conv->id_conversation',id_sender='$employer_->ID',message='$message',type_sender='job_seekers',sent_at='$curr_date'");
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
				redirect(base_url('jobseeker/chat').$conv->id_conversation);
				exit;
			}
			
			$resume = array('upload_data' => $this->upload->data());	
			$file_name = $resume['upload_data']['file_name'];
			$ull=base_url()."chat/download/".$file_name;
			$sty="text-decoration: none;color: white;";
			$message="<i style='".$sty."' class='fa fa-download'>&nbsp;</i>
                  <a style='".$sty."' href='".$ull."'>Attached File<br></a>";
			$message_to_send.="<a href='".$ull."'>Attached File</a>";
			$data_array = array(
			        'message' => $message,
			        'id_conversation' => $conv->id_conversation,
			        'id_sender' => $employer_->ID,
			        'type_sender' => 'job_seekers',
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
		$this->email->to($employer_->email);
		$mail_message = $message_to_send;
		$this->email->subject($subject);
		$this->email->message($mail_message);     
		$this->email->send();




		redirect(base_url().'jobseeker/chat/'.$conv->id_conversation);
	}
}
