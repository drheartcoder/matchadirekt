<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_requests extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$data['ads_row'] = $this->ads;
		$data['title'] = SITE_NAME.': My Requests';
		$result_requests = $this->db->query("SELECT tbl_requests_info.*,tbl_employers.first_name as employer_name FROM tbl_requests_info LEFT JOIN tbl_employers ON tbl_employers.ID=tbl_requests_info.employer_id WHERE jobseeker_id='".$this->session->userdata('user_id')."'")->result();
		$data['result_requests']= $result_requests;
		$this->load->view('jobseeker/my_requests_view',$data);
	}
}
