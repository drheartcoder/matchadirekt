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
		$Calendar=$this->db->query("SELECT * FROM calendar INNER JOIN tbl_employers ON tbl_employers.ID=calendar.id_employer WHERE id_job_seeker='$iduser'")->result();
		$data['results']= $Calendar;
		$this->load->view('jobseeker/calendar_view',$data);
	}
}
