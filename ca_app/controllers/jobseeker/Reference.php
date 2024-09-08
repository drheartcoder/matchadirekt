<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reference extends CI_Controller {
	
	public function index(){
		echo "you are not allow to access this page directly";
		exit;
	}
	
	public function add()
	{
		if(!$this->session->userdata('user_id')){
			echo lang('Your session has been expired, please re-login first.');
			exit;	
		}
		$data = array(
			'seeker_ID'		=> $this->session->userdata('user_id'),
			'name'		=> $this->input->post('name'),
			'title'	=> $this->input->post('title'),
			'phone'		=> $this->input->post('phone'),
			'email' 			=> $this->input->post('email'),
			'created_at'			=> date("Y-m-d H:i:s")
		);
		$this->db->insert('tbl_seeker_reference',$data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Success').'!</strong>'.lang('Your reference has been added successfully').'. </div>');
		echo "done";
	}
	
	public function edit()
	{
		if(!$this->session->userdata('user_id')){
			echo lang('Your session has been expired, please re-login first.');
			exit;	
		}
		$data = array(
			'name'		=> $this->input->post('name'),
			'title'	=> $this->input->post('title'),
			'phone'		=> $this->input->post('phone'),
			'email' 			=> $this->input->post('email'),
			'created_at'			=> date("Y-m-d H:i:s")
		);
		$this->db->where('ID', $this->input->post('id'));
		$this->db->update('tbl_seeker_reference', $data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Success').'!</strong> '.lang('Your reference has been updated successfully').'. </div>');
		echo "done";
	}
	
	public function delete()
	{
		if(!$this->session->userdata('user_id')){
			echo lang('Your session has been expired, please re-login first.');
			exit;	
		}
		$data = array(
			'deleted'		=> '1',
			'created_at'	=> date("Y-m-d H:i:s")
		);		
		$this->db->where('ID', $this->input->post('id'));
		$this->db->update('tbl_seeker_reference', $data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Success').'!</strong> '.lang('Your reference has been deleted successfully').'. </div>');
		echo "done";
	}
	
	public function reference_by_id()
	{
		if(!$this->session->userdata('user_id')){
			echo login('Your session has been expired, please re-login first.');
			exit;	
		}
		$row = $this->db->query("SELECT * FROM tbl_seeker_reference WHERE ID='".$this->input->post('id')."'")->result()['0'];
		echo json_encode($row);
	}
}
