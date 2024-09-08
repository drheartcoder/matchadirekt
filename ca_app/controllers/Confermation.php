<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Confermation extends CI_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->database();
		$this->load->helper('url');

    }

	public function seeker($token){
 
		$this->db->query("UPDATE tbl_job_seekers set verification_code='' WHERE verification_code='".$token."'");

		redirect(base_url('login'));


	}


}