<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Channels extends CI_Controller {
	public function index(){
		$data['title'] = SITE_NAME.': Channels';
		$data['msg'] = '';

		$obj_result = $this->db->query("SELECT * FROM tbl_channels")->result();
		$data['result'] = $obj_result;
		$this->load->view('admin/channels_view', $data);

		return;
	}
	
	public function get_channel_by_id($id=''){
		if($id!=''){
			$row = $this->db->query("SELECT * FROM tbl_channels WHERE ID='$id'")->result()['0'];
			$json_data = json_encode($row);
			echo $json_data;
			exit;
		}
		return;
	}
	public function add(){
		$data['title'] = SITE_NAME.': Add Channel';
		$data['msg'] = '';
		
		$data_array = array('channel' => $this->input->post('channel'));
		$this->db->insert("tbl_channels",$data_array);
        
        
		$this->session->set_flashdata('added_action', true);
		redirect(base_url('admin/channels'));
	}
    
	public function update(){
		
		$id = $this->input->post('key_id');
		if($id==''){
			redirect(base_url().'admin/channels','');
			exit;
		}
		
		$data['title'] = SITE_NAME.': Edit Channel';
		$data['msg'] = '';
		
		$data_array = array('channel' => $this->input->post('edit_channel'));
		$this->db->where("ID",$id);
		$this->db->update("tbl_channels",$data_array);
        
		$this->session->set_flashdata('update_action', true);
		redirect(base_url('admin/channels'));
		return;
	}
	
	public function delete($id=''){
		
		if($id==''){
			echo 'error';
			exit;
		}
		
		$this->db->query("DELETE FROM tbl_channels WHERE ID='$id'");
		echo 'done';
		exit;
	}
}