<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index($id='')
	{

		$data['ads_row'] = $this->ads;
		$data['title'] = SITE_NAME.': Calendar';
		$iduser=$this->session->userdata('user_id');
		$Calendar=$this->db->query("SELECT * FROM calendar INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=calendar.id_job_seeker WHERE id_employer='$iduser'")->result();
		$data['results']= $Calendar;
		$this->load->view('employer/calendar_view',$data);
	}
}
