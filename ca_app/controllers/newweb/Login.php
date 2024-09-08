<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("class.smtp.php");
include("class.phpmailer.php");
class Login extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		
		
		
		$this->load->library('Mobile_Detect');
	    $detect = new Mobile_Detect();
	    /*if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
	       	//header("Location: ".$this->config->item('base_url')."/newapp"); exit;
	       	echo '<script type="text/javascript">window.location="'.$this->config->item('base_url').'/newapp";</script>';

		}else{
	    	//header("Location: ".$this->config->item('base_url')."/newweb"); exit;
	    	echo '<script type="text/javascript">window.location="'.$this->config->item('base_url').'/newweb";</script>';

	    }*/
	}
	public function index1() {
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
	    $this->load->library('Mobile_Detect');
	    $detect = new Mobile_Detect();
	    if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
	        header("Location: ".$this->config->item('base_url')."/mobile"); exit;
	    }else{
	    	header("Location: ".$this->config->item('base_url')."/web"); exit;
	    }
	}
	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$msg="";
		if($this->session->userdata('sessUserId') > 0){
			if($this->session->userdata('sessIsJobSeeker') == 1){
				redirect(WEBURL."/seeker/home");
			}else if($this->session->userdata('sessIsEmployer') == 1){
				redirect(WEBURL."/employer/home");
			}
		}

		if(isset($_POST['btnLogin'])) {
				$user_data  =array();
				$this->form_validation->set_rules('email', lang('Email address'), 'trim|required');
				$this->form_validation->set_rules('pass', lang('Password'), 'trim|required');
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
				if ($this->form_validation->run() === FALSE) {
					$data['msg'] = $this->session->flashdata('msg');
					$this->load->view('newweb/login_view', $data);
					return;
				}
				

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
							$this->load->view('newweb/login_view', $data);
							return;
						 }	
					}
				}//exit;
				if(isset($userData) && $userData != ""){
					if($userData[0]->sts=='pending'){
						$data['msg'] = lang('You have not yet verified your email address.');
						$this->load->view('newweb/login_view', $data);
						return;
					} else if($userData[0]->sts=='blocked'){
						$data['msg'] = lang('Your account was suspended. Please contact site admin for further information.');
						$this->load->view('newweb/login_view', $data);
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
			//myPrint($userData);die;
			$this_model_name = ($isEmployer==TRUE)?'employers_model':'job_seekers_model';
			if($userData[0]->first_login_date==''){
			$updateDate=$this->$this_model_name->update($userData[0]->ID, array('first_login_date' => date("Y-m-d H:i:s"), 'last_login_date' => date("Y-m-d H:i:s"), 'sts' => 'active'));	
		} else {
			$updateDate=$this->$this_model_name->update($userData[0]->ID, array('last_login_date' => date("Y-m-d H:i:s")));
		}
		//echo $this->db->last_query();exit;
		//if($updateDate){echo "date updated";exit;}
		//myPrint($userData);die;
						//exit;
						if($this->session->userdata('sessUserId') > 0){
							if($this->session->userdata('sessIsJobSeeker') == 1){
								redirect(WEBURL."/seeker/home");
							}else if($this->session->userdata('sessIsEmployer') == 1){
								redirect(WEBURL."/employer/home");
							}
						}
					}
				} else {
					$data['msg'] = lang('Something went wrong.');
					$this->load->view('newweb/login_view', $data);
					return;
				}
		}
		$data['msg']=$msg;
		$this->load->view('newweb/login_view',$data);
	}


	public function logout() {
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
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
			redirect(WEBURL.'/login');
		} else {
		 	redirect(WEBURL.'/login');
		}
	}

	public function forgot(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$msg='';
		//$_SESSION['site_lang']='en';
		$data['ads_row'] = $this->ads;
		$data['title'] = lang('Recover Your Password');
		$data['msg'] = '';
		if(isset($_POST['btnForgotPass'])){
			$row = $this->job_seekers_model->authenticate_job_seeker_email_address($this->input->post('email'));

			$email = @$row->email;
			$password = @$row->password;
			if(!$row){
				$row = $this->employers_model->authenticate_employer_by_email($this->input->post('email'));	
				//myPrint($row);
			// 	if(!isset($row) && $row== NULL){


			// $msg= '<div class="alert alert-danger">'.lang('Provided email address does not exist').'.</div>';

			// 		// $this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang('Provided email address does not exist').'.</div>');
			// 		//redirect(WEBURL.'/login/forgot');
			// 		//exit;
			// 	}
				$email = $row->email;
				//myPrint($email);die;
				$password = $row->pass_code;
			}
			if(isset($row) && $row!=''){


			
			//$row_email = $this->email_model->get_records_by_id(1);
			//myPrint($row_email);die;
			//myPrint($row_email);die;
			/*
			$config = $this->email_drafts_model->email_configuration();
			$this->email->initialize($config);
			$this->email->clear(TRUE);
			$this->email->from($row_email->from_email, $row_email->from_name);
			$this->email->to($email);
			
			$this->email->subject(SITE_NAME.' | Password Recovery');
			$this->email->message($mail_message); 
			$this->email->send();

			$config = $this->email_drafts_model->email_configuration();
			$this->email->initialize($config);*/
			$row_email = $this->email_model->get_records_by_id(1);
			$mail_message = $this->email_drafts_model->get_forgot_password_draft($email, $password, $row_email->content);
			

			//Create a new PHPMailer instance
$row_email = $this->email_model->get_records_by_id(1);
$mail_message = $this->email_drafts_model->get_forgot_password_draft($email, $password, $row_email->content);
			$mail = new PHPMailer();
			$mail->IsSMTP();
			//$mail->SMTPDebug = 1; 
			$mail->SMTPAuth = true;
			//$mail->SMTPSecure = 'ssl';
			$mail->Host = MAILERHOST;
			$mail->Username = MAILERUSER;
			$mail->Password = MAILERPASS; 
			$mail->From = $row_email->from_email;
			$mail->FromName = $row_email->from_name;
			$mail->AddAddress($email,$row->first_name);
			//myPrint($email);exit;
			$mail->Subject =$row_email->subject;
			$mail->Body = $mail_message;
			$mail->WordWrap = 50;
			$mail->IsHTML(true);
			//$mail->SMTPDebug = 2; 
			// $mail->SMTPOptions = array(
			// 'ssl' => array(
			// 'verify_peer' => false,
			// 'verify_peer_name' => false,
			// 'allow_self_signed' => true
			// )
			// );
			// $mail->SMTPSecure = false;
			// $mail->SMTPAutoTLS = false;
			// $mail->SMTPSecure = 'TLS';
			// $mail->Port = 587;
			$mail->Port = 25;
			//$mail->Port = 25;
			
			$mail->Send();
// 			if (!$mail->send()) {
// $error = "Mailer Error: " . $mail->ErrorInfo;
// echo '<p id="para">'.$error.'</p>';
// }
// else {
// echo '<p id="para">Message sent!</p>';
// }

			$msg= '<div class="alert alert-success">'.lang('Your account information has been sent to your email address').'.</div>';

			//redirect(WEBURL.'/login');	
		}
		else{

			$msg= '<div class="alert alert-danger">'.lang('Provided email address does not exist').'.</div>';
		}
		}	
		$data['msg']=$msg;
		$this->load->view('newweb/forgot_view',$data);
	}

	
}