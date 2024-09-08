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
		


		if(!$this->input->post("message"))
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
		$this->db->query("INSERT INTO tbl_conv_message SET id_conversation='$conv->id_conversation',id_sender='$employer_->ID',message='$message',type_sender='job_seekers',sent_at='$curr_date'");
		redirect(base_url().'jobseeker/chat/'.$conv->id_conversation);
	}
}
