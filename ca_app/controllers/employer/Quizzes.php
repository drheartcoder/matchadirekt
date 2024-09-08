<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quizzes extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_quizzes WHERE employer_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
		$data['results']=$results;
		$this->load->view('employer/quizzes_view',$data);
	}
	public function add()
	{
		$title=$this->input->post('title');
		$quizz=$this->input->post('quizz');
		$answer1=$this->input->post('answer1');
		$answer2=$this->input->post('answer2');
		$answer3=$this->input->post('answer3');
		if($title=="" || $quizz=="" || $answer1=="" || $answer2=="" || $answer3=="")
			redirect(base_url('employer/quizzes'));
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("INSERT INTO tbl_quizzes SET title='$title',quizz='$quizz',answer1='$answer1',answer2='$answer2',answer3='$answer3',employer_id='".$this->session->userdata('user_id')."',created_at='$curr_date'");
		redirect(base_url('employer/quizzes'));
	}
	public function update($id)
	{
		$title=$this->input->post('title');
		$quizz=$this->input->post('quizz');
		$answer1=$this->input->post('answer1');
		$answer2=$this->input->post('answer2');
		$answer3=$this->input->post('answer3');
		if($title=="" || $quizz=="" || $answer1=="" || $answer2=="" || $answer3=="")
			redirect(base_url('employer/quizzes'));
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_quizzes SET title='$title',quizz='$quizz',answer1='$answer1',answer2='$answer2',answer3='$answer3',created_at='$curr_date' WHERE tbl_quizzes.ID = '$id'AND employer_id='".$this->session->userdata('user_id')."'");
		redirect(base_url('employer/quizzes'));
	}
	public function delete($id)
	{
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_quizzes SET deleted='1',created_at='$curr_date' WHERE tbl_quizzes.ID = '$id' AND employer_id='".$this->session->userdata('user_id')."'");
		redirect(base_url('employer/quizzes'));
	}
}
