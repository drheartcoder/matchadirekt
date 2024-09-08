<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_account extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$data=array();
		$msg='';
		$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
        $this->outputData['channel_list']=$this->db->query("SELECT * FROM tbl_channels")->result();
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);
		$this->outputData['data'] = $data;
		if(isset($_POST['btnUpdate'])){
			//myPrint($_POST);exit;
			$dob = trim($_POST['selSeekerBirthYear']).'-'.trim($_POST['selSeekerBirthMonth']).'-'.trim($_POST['selSeekerBirthDay']);
			$cond =" ID = ".$this->sessUserId;
			$update = $this->db->query("UPDATE `tbl_job_seekers` SET `first_name`='".trim($_POST['txtFullName'])."',`email`='".trim($_POST['txtEmailId'])."',`gender`='". trim($_POST['selGender'])."',`present_address`='". trim($_POST['txtSeekerAddress'])."',`country`='".trim($_POST['selSeekerCountry'])."',`city`='".trim($_POST['txtSeekerCity'])."',`dob`='".$dob."', `mobile`='".trim($_POST['txtSeekerMobile'])."',`home_phone`='".trim($_POST['txtSeekerPhone'])."',`nationality`='".trim($_POST['selSeekerNationality'])."',`channel`='".trim($_POST['selSeekerChannel'])."'  WHERE ".$cond);

			if($update){
				$msg = '<div class="alert alert-success">  <strong>Data updated Successfully!</strong> </div>';
			} else {
				$msg = '<div class="alert alert-danger">  <strong>Something went wrong!</strong> </div>';
			}
		}
		$this->outputData['msg'] = $msg;
		$data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);
		$this->outputData['data'] = $data;
		$this->load->view('newweb/seeker/my_account_view',$this->outputData);
	}

	public function update_image(){
		$data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);
			//myPrint($data);die;
		if(isset($_POST['btnUpdate'])){
			myPrint($_POST);die;
			$real_path = realpath(APPPATH . '../public/uploads/candidate/');
			$config['upload_path'] = $real_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['overwrite'] = true;
			$config['max_size'] = 6000;
			$config['file_name'] = make_slug($data->first_name).'-BiXma-'.$data->ID;
			$this->upload->initialize($config);
			
			if($data->photo){
				@unlink($real_path.'/'.$data->photo);	
				@unlink($real_path.'/thumb/'.$data->photo);
			}
			if ($this->upload->do_upload('imageFile')){
				$image = array('upload_data' => $this->upload->data());	
				$image_name = $image['upload_data']['file_name'];
				$thumb_config['image_library'] = 'gd2';
				$thumb_config['source_image']	= $real_path.'/'.$image_name;
				$thumb_config['new_image']	= $real_path.'/thumb/'.$image_name;
				$thumb_config['maintain_ratio'] = TRUE;
				$thumb_config['height']	= 200;
				$thumb_config['width']	 = 200;
				$this->image_lib->initialize($thumb_config);
				$this->image_lib->resize();
				$photo_array = array('photo' => $image_name);
				//myPrint($photo_array );exit;
				$this->job_seekers_model->update($this->sessUserId, $photo_array);
				redirect(WEBURL.'/seeker/my-account');
			} else{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.('Error').'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(WEBURL.'/seeker/home');
				exit;
			}
		}
		$this->outputData['data'] = $data;
		$this->load->view('newweb/seeker/update_image_view',$this->outputData);
}

	public function delete_account(){
		$this->job_seekers_model->delete_job_seeker($this->sessUserId);
		$this->session->unset_userdata("sessUserId");
		$this->session->unset_userdata("sessUserRole");
		$this->session->unset_userdata("sessFirstName");
		$this->session->unset_userdata("sessSlug");
		$this->session->unset_userdata("sessIsLogin");
		$this->session->unset_userdata("sessIsJobSeeker");
		$this->session->unset_userdata("sessIsEmployer");
		$this->session->unset_userdata("sessRole");
		redirect(WEBURL.'/login');
	}	
}
