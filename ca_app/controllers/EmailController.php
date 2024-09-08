<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EmailController extends CI_Controller {
	
    public function index()
    {
		$this->load->library('email');

		$config['protocol']    = 'smtp';

		$config['smtp_host']    = 'ssl://smtp.mailgun.org';

		$config['smtp_port']    = '465';

		$config['smtp_timeout'] = '7';

		$config['smtp_user']    = 'job@agoujil.com';

		$config['smtp_pass']    = '123456789';

		$config['charset']    = 'utf-8';

		$config['newline']    = "\r\n";

		$config['mailtype'] = 'html'; // or html

		$config['validation'] = TRUE; // bool whether to validate email or not      

		$this->email->initialize($config);


		$this->email->from('job@agoujil.com', 'Ayoub');
		$this->email->to('a37killer@gmail.com'); 


		$this->email->subject('Email Test');

		$this->email->message('Testing the email class.');  

		$this->email->send();
    }
}
	