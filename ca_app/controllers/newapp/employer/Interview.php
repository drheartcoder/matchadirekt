<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Interview extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index(){

		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_interview WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['results']=$results;
		$this->load->view('application/employer/interview_view',$this->outputData);
	}

	public function add_new_interview(){

		if(isset($_POST['txtBtnAdd'])){

		$pageTitle=$this->input->post('pageTitle');
		$pageSlug=$this->input->post('pageSlug');
		$pageContent=$this->input->post('hiddeninput');
		$pageContent = str_replace("'", "", $pageContent);
		$pageContent = str_replace(";", "", $pageContent);

		if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
		redirect(APPURL.'/employer/interview');
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("INSERT INTO tbl_interview SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent',employer_id='".$this->sessUserId."',created_at='$curr_date'");
		redirect(APPURL.'/employer/interview');
		}
		$this->load->view('application/employer/add_new_interview');
		
	}


	public function edit_interview($id){
		$results=$this->db->query("SELECT * FROM tbl_interview WHERE ID='".$id."' AND deleted='0'")->result();
		$this->outputData['results']=$results[0];
		if(isset($_POST['txtBtnUpdate'])){
		
			$pageTitle=$this->input->post('pageTitle');
			$pageSlug=$this->input->post('pageSlug');
			$pageContent=$this->input->post('hiddeninput');
			if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
			redirect(APPURL.'/employer/interview');
			
			$this->db->query("UPDATE tbl_interview SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent' WHERE tbl_interview.ID = '$id'AND employer_id='".$this->sessUserId."'");
			
			redirect(APPURL.'/employer/interview');
		
	}

	$this->load->view('application/employer/edit_interview_view',$this->outputData);
	}


	public function view_interview($id){

		$results=$this->db->query("SELECT * FROM tbl_interview WHERE ID='".$id."' AND deleted='0'")->result();
		$this->outputData['results']=$results[0];
		// /myPrint($results);die;
		$this->load->view('application/employer/interview_detail_view',$this->outputData);
		
	}

	public function delete($id)
	{
		$this->db->query("UPDATE tbl_interview SET deleted='1' WHERE tbl_interview.ID = '$id' AND employer_id='".$this->sessUserId."'");
		redirect(APPURL.'/employer/interview');
	}


}
