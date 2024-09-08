<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("class.smtp.php");
include("class.phpmailer.php");
class Test extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		//$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$row_email = $this->email_model->get_records_by_id(3);
			$current_date = date("Y-m-d H:i:s");
		$job_seeker_array = array(
				'first_name' => 'txtSeekerFullName',
				'email' => 'vanashri.jadhav6@gmail.com',
				'password' => 'txtSeekerPassword',
				'dob' => 'selSeekerBirthYear'.'-'.'selSeekerBirthMonth'.'-'.'selSeekerBirthDay',
				'mobile' => '8805699530',
				'home_phone' => 'txtSeekerPhone',
				'present_address' => 'txtSeekerAddress',
				'country' => 'selSeekerCountry',
				'city' => 'txtSeekerCity',
				'nationality' => 'selSeekerNationality',
				'channel' => 'selSeekerChannel',
				'gender' => 'selSeekerGender',
				'dated' => $current_date,
				'verification_code'=>md5($current_date)
		);
		$mail_message = $this->email_drafts_model->jobseeker_signup($row_email->content, $job_seeker_array);

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = MAILERHOST;
		$mail->Username = MAILERUSER;
		$mail->Password = MAILERPASS; 
		$mail->From = $row_email->from_email;
		$mail->FromName = $row_email->from_name;
		$mail->AddAddress('vanashri.jadhav6@gmail.com','test');
		$mail->Subject =$row_email->subject."TESTING";
		$mail->Body = $mail_message;
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		/*$mail->SMTPSecure = 'tls';
		$mail->Port = 587;*/
		$mail->Port = 25;
			
		$mail->Send();
	}


}