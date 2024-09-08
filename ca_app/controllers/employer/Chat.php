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
		$data['title']=lang('Chat').' | '.SITE_NAME;
		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg', lang('Please login as a employer to view the candidate profile.'));
			redirect(base_url('login'));
			return;	
		}

		$employer_ = $this->employers_model->get_employer_by_id($this->session->userdata('user_id'));
		$convs=$this->db->query("SELECT * FROM tbl_conversation INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_conversation.id_job_seeker WHERE id_employer='$employer_->ID'")->result();
		//myPrint($convs);die;
		if($id=="" && count($convs)>0)
		{
			redirect(base_url().'employer/chat/'.$convs['0']->id_conversation);
		}
		$conv=$this->db->query("SELECT * FROM tbl_conversation WHERE id_conversation='$id' AND id_employer='$employer_->ID'")->result();
		if(count($conv)<=0){
			$data['nothing']=1;
			$this->load->view('employer/chat', $data);
			return;	
		}
		$conv=$conv['0'];
		$data['convs']=$convs;
		$messages=$this->db->query("SELECT * FROM tbl_conv_message WHERE id_conversation='$conv->id_conversation'")->result();
		$job_seeker=$this->job_seekers_model->get_job_seeker_by_id($conv->id_job_seeker);
		$data['messages']=$messages;
		$data['employer']=$employer_;
		$data['job_seeker']=$job_seeker;
		$this->load->view('employer/chat',$data);
	}
	public function download($file_name){
		if($file_name==''){
			redirect(base_url('login'));
			exit;	
		}
		
					if (!file_exists(realpath(APPPATH . '../public/uploads/chat/'.$file_name))){
						echo 'Files does not exist on the server. <a href="javascript:;" onclick="window.history.back();">Back</a>';
						exit;
					}
					
		$data = file_get_contents(base_url("public/uploads/chat/".$file_name));
		force_download("Attached File_".$file_name, $data);
		exit;
	}
}
