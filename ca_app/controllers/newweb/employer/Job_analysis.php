<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_analysis extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index(){
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_job_analysis WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['results']=$results;
		//myPrint($results);die;
		$this->load->view('newweb/employer/job_analysis_view',$this->outputData);
	}

	public function add_job_analysis(){

			if(isset($_POST['btnJobAnalysis'])){
			//myPrint($_POST);die;
			$pageTitle=$this->input->post('pageTitle');
			$pageSlug=$this->input->post('pageSlug');
			$pageContent=$this->input->post('hiddeninput');
				$pageContent = str_replace("'", "", $pageContent);
				$pageContent = str_replace(";", "", $pageContent);

			if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
				redirect(WEBURL.'/employer/job_analysis');
			$curr_date=date("Y-m-d H:i:s");
			$this->db->query("INSERT INTO tbl_job_analysis SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent',employer_id='".$this->sessUserId."',created_at='$curr_date'");
				redirect(WEBURL.'/employer/job_analysis');

			}
		$this->load->view('newweb/employer/add_job_analysis_view',$this->outputData);
		
	}

	public function edit_job_analysis($id='0'){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		$results=$this->db->query("SELECT * FROM tbl_job_analysis WHERE ID='".$id."' AND deleted='0'")->result();
		$this->outputData['results']=$results[0];


		if(isset($_POST['btnJobAnalysis'])){

			// /myPrint($_POST);die;

			$pageTitle=$this->input->post('pageTitle');
			$pageSlug=$this->input->post('pageSlug');
			$pageContent=$this->input->post('hiddeninput');
				$pageContent = str_replace("'", "", $pageContent);
				$pageContent = str_replace(";", "", $pageContent);
			//echo $pageContent;die;	
			if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
				redirect(WEBURL.'/employer/job_analysis');
				$curr_date=date("Y-m-d H:i:s");
			$this->db->query("UPDATE tbl_job_analysis SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent',created_at='$curr_date' WHERE tbl_job_analysis.ID = '$id'AND employer_id='".$this->sessUserId."'");
			//echo $this->db->last_query();die;
			redirect(WEBURL.'/employer/job_analysis');
		}


		$this->load->view('newweb/employer/edit_job_analysis_view',$this->outputData);
	}
	public function detail_job_analysis($id='0'){

		$results=$this->db->query("SELECT * FROM tbl_job_analysis WHERE ID='".$id."' AND deleted='0'")->result();
		$this->outputData['results']=$results[0];

		//myPrint($results);die;
		$this->load->view('newweb/employer/job_analysis_detail_view',$this->outputData);
	}

	public function delete($id)
	{
		$this->db->query("UPDATE tbl_job_analysis SET deleted='1' WHERE tbl_job_analysis.ID = '$id' AND employer_id='".$this->sessUserId."'");
				redirect(WEBURL.'/employer/job_analysis');
	}


}
