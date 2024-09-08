<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Certificate extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index(){
	
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['results']=$results;

		$this->load->view('newweb/employer/certificate_view',$this->outputData);
	}

	public function add_certificate(){

		if(isset($_POST['btnAddCert'])){
		$pageTitle=$this->input->post('pageTitle');
		$pageSlug=$this->input->post('pageSlug');
		$pageContent=$this->input->post('hiddeninput');
				$pageContent = str_replace("'", "", $pageContent);
				$pageContent = str_replace(";", "", $pageContent);

		if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
		redirect(WEBURL."/employer/certificate");
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("INSERT INTO tbl_employer_certificate SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent',employer_id='".$this->sessUserId."',created_at='$curr_date'");
		redirect(WEBURL."/employer/certificate");

		}
		$this->load->view('newweb/employer/certificate_add_view',$this->outputData);
	}

	public function edit_cetificate($id=0){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
			$results=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE tbl_employer_certificate.ID='".$id."' AND deleted='0'")->result();
		$this->outputData['results']=$results[0];

		//myPrint($results);die;

		if(isset($_POST['btnUpdateCer'])){
			//myPrint($_POST);die;
			$pageTitle=$this->input->post('pageTitle');
			$pageSlug=$this->input->post('pageSlug');
			$pageContent=$this->input->post('hiddeninput');
			$pageContent = str_replace("'", "", $pageContent);
			$pageContent = str_replace(";", "", $pageContent);
			if($pageContent=="" || $pageSlug=="" || $pageTitle=="")
				redirect(WEBURL."/employer/certificate");
			$curr_date=date("Y-m-d H:i:s");

			$this->db->query("UPDATE tbl_employer_certificate SET pageTitle='$pageTitle',pageSlug='$pageSlug',pageContent='$pageContent' WHERE tbl_employer_certificate.ID = '$id' AND employer_id='".$this->sessUserId."'");
			//exit;
			redirect(WEBURL."/employer/certificate");
		}
		$this->load->view('newweb/employer/certificate_edit_view',$this->outputData);
	}

	public function view_certificate($id=0){

		$results=$this->db->query("SELECT * FROM tbl_employer_certificate WHERE tbl_employer_certificate.ID='".$id."' AND deleted='0'")->result();
		$this->outputData['results']=$results[0];
		//myPrint($results);die;
		$this->load->view('newweb/employer/certificate_detail_view',$this->outputData);
	}

	public function delete($id=0)
	{
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_employer_certificate SET deleted='1',created_at='$curr_date' WHERE tbl_employer_certificate.ID = '$id' AND employer_id='".$this->sessUserId."'");
		redirect(WEBURL."/employer/certificate");
	}

}
