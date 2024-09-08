<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		//$this->my_library->check_user_login();
    }
	
	public function index(){
		if(isset($_POST['btnLogin'])) {
				$user_data  =array();
				$this->form_validation->set_rules('email', lang('Email address'), 'trim|required');
				$this->form_validation->set_rules('pass', lang('Password'), 'trim|required');
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
				if ($this->form_validation->run() === FALSE) {
					$data['msg'] = $this->session->flashdata('msg');
					$this->load->view('application/login_view', $data);
					return;
				}
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);

				$userName = $this->input->post('email');
				$password = $this->input->post('pass');
				$seekerCond = "email = '".$userName."' AND password = '".$password."'";
				$userData = $this->My_model->selTableData("tbl_job_seekers","",$seekerCond);
				if(isset($userData) && $userData != ""){
					$userId = $userData[0]->ID;
					$userEmail = $userData[0]->email;
					$firstName = $userData[0]->first_name;
					$slug = "";
					$isJobSeeker = 1;
					$isEmployer	= 0;
					$role	= 'seeker';
					$companyId 	= 0;
				} else {
					$compCond = "email = '".$userName."' AND pass_code = '".$password."'";
					$userData = $this->My_model->exequery("select tbl_employers.*,tbl_companies.company_slug from tbl_employers inner join tbl_companies on tbl_employers.company_ID = tbl_companies.ID where ".$compCond);
					//myPrint($userData);
					if(isset($userData) && $userData != ""){
						$userId = $userData[0]->ID;
						$userEmail = $userData[0]->email;
						$firstName = $userData[0]->first_name;
						$slug = $userData[0]->company_slug;
						$companyId 	=  $userData[0]->company_ID;
						$isJobSeeker = 0;
						$isEmployer	= 1;
						$role	= 'employer';
					} else {
						if(!$userData){
							$data['msg'] = ('Wrong email or password provided');
							$this->load->view('application/login_view', $data);
							return;
						 }	
					}
				}//exit;
				if(isset($userData) && $userData != ""){
					if($userData[0]->sts=='pending'){
						$data['msg'] = lang('You have not yet verified your email address.');
						$this->load->view('application/login_view', $data);
						return;
					} else if($userData[0]->sts=='blocked'){
						$data['msg'] = lang('Your account was suspended. Please contact site admin for further information.');
						$this->load->view('application/login_view', $data);
						return;
					} else if($userId  > 0){
						$user_data = array(
								'sessUserId' => $userId,
								 'sessUserRole' => $userEmail,
								 'sessFirstName' => $firstName,
								 'sessSlug' => $slug,
								 'sessIsLogin' => TRUE,
								 'sessIsJobSeeker' => $isJobSeeker,
								 'sessIsEmployer' => $isEmployer,
								 'sessRole' => $role,
								 'sessCompanyId' => $companyId
								 );
						$this->session->set_userdata($user_data);
						//exit;
						if($this->session->userdata('sessUserId') > 0){
							if($this->session->userdata('sessIsJobSeeker') == 1){
								redirect(APPURL."/seeker/home");
							}else if($this->session->userdata('sessIsEmployer') == 1){
								redirect(APPURL."/employer/home");
							}
						}
					}
				} else {
					$data['msg'] = lang('Something went wrong.');
					$this->load->view('application/login_view', $data);
					return;
				}
		}
		$this->load->view('application/login_view');
	}


	public function logout() {
		if($this->session->userdata('sessUserId') > 0){
			$this->session->unset_userdata("sessUserId");
			$this->session->unset_userdata("sessUserRole");
			$this->session->unset_userdata("sessFirstName");
			$this->session->unset_userdata("sessSlug");
			$this->session->unset_userdata("sessIsLogin");
			$this->session->unset_userdata("sessIsJobSeeker");
			$this->session->unset_userdata("sessIsEmployer");
			$this->session->unset_userdata("sessRole");
			$this->session->unset_userdata("sessCompanyId");
			redirect(APPURL.'/login');
		} else {
		 	redirect(APPURL.'/login');
		}
	}
	/*public function login_with_email(){

		if(isset($_POST['btnContinue'])){
			redirect(APPURL."/login/check-email");
		}

		$this->load->view('application/login_with_email_view');
	}
	
	public function check_email(){
		$this->load->view('application/login_check_email_view');
	}
	
	public function login_with_mobile(){
		$this->load->view('application/login_with_mobile_view');
	}

	public function mobile_otp(){
		$this->load->view('application/login_with_mobile_view');
	}*/


	/*
	public function forgot(){
		
		$data['ads_row'] = $this->ads;
		$data['title'] = lang('Recover Your Password');
		$data['msg'] = '';
		$signup_link = base_url('jobseeker-signup');
		
		$this->form_validation->set_rules('email', lang('email address'), 'trim|required|valid_email');
		$this->form_validation->set_rules('captcha', lang('Verification code'), 'trim|required|callback_check_captcha');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
		if ($this->form_validation->run() === FALSE) {
			$captcha_row = $this->cap_model->generate_captcha();
			$data['cpt_code'] = $captcha_row['image'];
			$this->load->view('forgot_view', $data);
			return;
		}
		
		if(stristr($this->session->userdata('back_from_user_login'), 'employer/')){
			$signup_link = base_url('employer-signup');
		}
		else
		{
			$signup_link = base_url('jobseeker-signup');
		}
		
		$data['signup_link'] = $signup_link;
		
		
		$row = $this->job_seekers_model->authenticate_job_seeker_email_address($this->input->post('email'));
		$email = @$row->email;
		$password = @$row->password;
		if(!$row){
			$row = $this->employers_model->authenticate_employer_by_email($this->input->post('email'));	
			if(!$row){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang('Provided email address does not exist').'.</div>');
				redirect(base_url('forgot'));
				exit;
			}
			$email = $row->email;
			$password = $row->pass_code;
		}
		
		$row_email = $this->email_model->get_records_by_id(1);
	
		
		$config = $this->email_drafts_model->email_configuration();
		$this->email->initialize($config);
		$this->email->clear(TRUE);
		$this->email->from($row_email->from_email, $row_email->from_name);
		$this->email->to($email);
		$mail_message = $this->email_drafts_model->get_forgot_password_draft($email, $password, $row_email->content);
		$this->email->subject(SITE_NAME.' | Password Recovery');
		$this->email->message($mail_message);     
		$this->email->send();
		
		
		
			
		$this->session->set_flashdata('success_msg', '<div class="alert alert-success">'.lang('Your account information has been sent to your email address').'.</div>');
		redirect(base_url('login'));		
	}
	
	public function logout() {
		  
		  $user_data = array(
				'user_id' => '',
				 'useremail' => '',
				 'is_user_login' => FALSE,
				 'slug' => '',
				 'is_job_seeker' => FALSE,
				 'is_employer' => FALSE
				 );
		$this->session->set_userdata($user_data);
		$this->session->unset_userdata($user_data);
		redirect(base_url(), 'refresh'); 
	}
	
	public function check_captcha($str)
	{
	  $word = $this->session->userdata('capWord');
	  if(strcmp(strtoupper($str),strtoupper($word)) == 0){
		return true;
	  }
	  else{
		$this->form_validation->set_message('check_captcha', lang('Please enter correct characters.'));
		return false;
	  }
    }

    //is_employer
    //is_job_seeker
    public function deleteAccount(){

    	$isMobile=$this->input->get('mobile');

    	$userID=$this->session->userdata('user_id');

    	if(!$userID) die();

    	if($this->session->userdata('is_employer')){
    		$this->deleteEmployer($userID);
    	}

    	if($this->session->userdata('is_job_seeker')){
    		$this->deleteSeeker($userID);
    	}

    	if($isMobile){
    		redirect(base_url().'app/User/logout');
    	}else{
    		redirect(base_url().'user/logout');
    	}

    }


    private function deleteEmployer($id){
    	$this->employers_model->delete_employer($id);    	
    	///
    }


    private function deleteSeeker($id){
    	$this->job_seekers_model->delete_job_seeker($id);
    	///
    }*/



}
