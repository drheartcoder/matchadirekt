<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quizzes extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index(){
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_quizzes WHERE employer_id='".$this->sessUserId."' AND deleted='0'")->result();
		$this->outputData['results']=$results;
		//myPrint($results);die;
		
		$this->load->view('application/employer/quizzes_view',$this->outputData);
	}


	public function add_quizzes(){

		if(isset($_POST['btnAddQuizz'])){
		//myPrint($_POST);die;
		$title=$this->input->post('title');
		$quizz=$this->input->post('quizz');
		$answer1=$this->input->post('answer1');
		$answer2=$this->input->post('answer2');
		$answer3=$this->input->post('answer3');
		if($title=="" || $quizz=="" || $answer1=="" || $answer2=="" || $answer3=="")
			redirect(APPURL.'/employer/quizzes');
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("INSERT INTO tbl_quizzes SET title='$title',quizz='$quizz',answer1='$answer1',answer2='$answer2',answer3='$answer3',employer_id='".$this->sessUserId."',created_at='$curr_date'");
		redirect(APPURL.'/employer/quizzes');

	}
		
		$this->load->view('application/employer/add_quizzes_view',$this->outputData);
	}


	public function edit_quizzes($id=0){

		$results=$this->db->query("SELECT * FROM tbl_quizzes WHERE ID='".$id."' AND deleted='0'")->result();
		$this->outputData['results']=$results[0];

		if(isset($_POST['btnUpdateQuizz'])){
		//myPrint($_POST);die;
		$title=$this->input->post('title');
		$quizz=$this->input->post('quizz');
		$answer1=$this->input->post('answer1');
		$answer2=$this->input->post('answer2');
		$answer3=$this->input->post('answer3');
		if($title=="" || $quizz=="" || $answer1=="" || $answer2=="" || $answer3=="")
		redirect(APPURL.'/employer/quizzes');
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_quizzes SET title='$title',quizz='$quizz',answer1='$answer1',answer2='$answer2',answer3='$answer3',created_at='$curr_date' WHERE tbl_quizzes.ID = '$id' AND employer_id='".$this->sessUserId."'");
		//echo $this->db->last_query();die;
		redirect(APPURL.'/employer/quizzes');
		}
		$this->load->view('application/employer/edit_quizzes_view',$this->outputData);
	}

	public function delete($id=0)
	{
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_quizzes SET deleted='1',created_at='$curr_date' WHERE tbl_quizzes.ID = '$id' AND employer_id='".$this->session->userdata('user_id')."'");
	redirect(APPURL.'/employer/quizzes');
	}

}
