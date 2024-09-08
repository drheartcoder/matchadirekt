<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_analysis extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_job_analysis WHERE employer_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
		$data['results']=$results;
		$this->load->view('employer/job_analysis_view',$data);
	}
	private function array_to_object($array) 
	{
	    return (object) $array;
	}
	public function add()
	{
		$pageTitle=$this->input->post('pageTitle');
		$pageSlug=$this->input->post('pageSlug');
		$pageContent=$this->input->post('pageContent');
		if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
			redirect(base_url('employer/job_analysis'));
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("INSERT INTO tbl_job_analysis SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent',employer_id='".$this->session->userdata('user_id')."',created_at='$curr_date'");
		redirect(base_url('employer/job_analysis'));
	}
	public function update($id)
	{
		$pageTitle=$this->input->post('pageTitle');
		$pageSlug=$this->input->post('pageSlug');
		$pageContent=$this->input->post('pageContent');
		if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
			redirect(base_url('employer/job_analysis'));
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_job_analysis SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent',created_at='$curr_date' WHERE tbl_job_analysis.ID = '$id'AND employer_id='".$this->session->userdata('user_id')."'");
		redirect(base_url('employer/job_analysis'));
	}
	public function delete($id)
	{
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_job_analysis SET deleted='1',created_at='$curr_date' WHERE tbl_job_analysis.ID = '$id' AND employer_id='".$this->session->userdata('user_id')."'");
		redirect(base_url('employer/job_analysis'));
	}
}
