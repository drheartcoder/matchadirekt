<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("class.smtp.php");
include("class.phpmailer.php");
class Setpassword extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){


	}

	
	public function change_password(){

		$msg = "";
		$this->outputData['msg'] =$msg;
		if(isset($_POST['btnChangePass']))
		{

			$pass=$this->My_model->selTableData("tbl_employers","pass_code,email","ID = ".$this->sessUserId);
				//myPrint($pass);die;
			$old_pass=$this->input->post('old_pass');
			$new_pass=$this->input->post('new_pass');
			$confirm_pass=$this->input->post('confirm_pass');
			$session_id=$this->sessUserId;
			$que=$this->db->query("select * from tbl_employers where ID='$session_id'");
			$row=$que->row();
			if((!strcmp($old_pass, $pass[0]->pass_code))&& (!strcmp($new_pass, $confirm_pass))){

				$updateData=array();
				$updateData['pass_code']=$_POST['confirm_pass'];
				$cond='tbl_employers.ID='.$session_id;

				//$update=$this->My_model->update('tbl_employers',$updatedata,$cond)
				$update_pass=$this->db->query("UPDATE tbl_employers set pass_code='$new_pass'  where ID='$session_id'");

				$msg =  '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Password changed successfully</strong></div>';
				}
			    else{
					$msg= '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>INVALID</strong></div>';
				}
		}
		$this->outputData['msg'] =$msg;
		$this->load->view('newweb/employer/change_pass_view',$this->outputData);
		
	
	}

		
	// 	public function forgot(){
		
	// 	$data['ads_row'] = $this->ads;
	// 	$data['title'] = lang('Recover Your Password');
	// 	$data['msg'] = '';
	// 	//$signup_link = base_url('jobseeker-signup');
		
	// 	$this->form_validation->set_rules('email', lang('email address'), 'trim|required|valid_email');
	// 	$this->form_validation->set_rules('captcha', lang('Verification code'), 'trim|required|callback_check_captcha');
		
	// 	$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
	// 	if ($this->form_validation->run() === FALSE) {
	// 		$captcha_row = $this->cap_model->generate_captcha();
	// 		$data['cpt_code'] = $captcha_row['image'];
	// 		$this->load->view('newweb/employer/forgot_view', $data);
	// 		return;
	// 	}
		
	// 	// if(stristr($this->session->userdata('back_from_user_login'), 'employer/')){
	// 	// 	$signup_link = base_url('employer-signup');
	// 	// }
	// 	// else
	// 	// {
	// 	// 	$signup_link = base_url('jobseeker-signup');
	// 	// }
		
	// 	// $data['signup_link'] = $signup_link;
		
		
	// 	$row = $this->job_seekers_model->authenticate_job_seeker_email_address($this->input->post('email'));
	// 	$email = @$row->email;
	// 	$password = @$row->password;
	// 	if(!$row){
	// 		$row = $this->employers_model->authenticate_employer_by_email($this->input->post('email'));	
	// 		if(!$row){
	// 			$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang('Provided email address does not exist').'.</div>');
	// 			redirect(WEBURL."/employer/setpassword/forgot/");

	// 			exit;
	// 		}
	// 		$email = $row->email;
	// 		$password = $row->pass_code;
	// 	}
		
	// 	$row_email = $this->email_model->get_records_by_id(1);
	
		
	// 	$config = $this->email_drafts_model->email_configuration();
	// 	$this->email->initialize($config);
	// 	$this->email->clear(TRUE);
	// 	$this->email->from($row_email->from_email, $row_email->from_name);
	// 	$this->email->to($email);
	// 	$mail_message = $this->email_drafts_model->get_forgot_password_draft($email, $password, $row_email->content);
	// 	$this->email->subject(SITE_NAME.' | Password Recovery');
	// 	$this->email->message($mail_message);     
	// 	$this->email->send();
		
		
		
			
	// 	$this->session->set_flashdata('success_msg', '<div class="alert alert-success">'.lang('Your account information has been sent to your email address').'.</div>');
	// 		redirect(WEBURL."/login/);		
	// }
	

}
