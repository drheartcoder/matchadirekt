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
		// error_reporting(E_ALL);
		// ini_set('display_errors', TRUE);
		// ini_set('display_startup_errors', TRUE);
		
		$data = $this->employers_model->get_employer_by_id($this->sessUserId);
		//myPrint($data);exit;
		if(isset($_POST['btnUpdate'])){
			$this->form_validation->set_rules('full_name', ('Your Name'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('country', ('Country'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('city', ('City'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('mobile_phone', ('Mobile'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('company_name', ('Company Name'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('industry_ID', ('Industry'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('company_location', ('Company Address'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('company_description', ('Company Description'), 'trim|required|strip_all_tags|secure');
			$this->form_validation->set_rules('company_phone', ('Company Phone'), 'trim|required|strip_all_tags');
			$this->form_validation->set_rules('no_of_employees', ('No of Employees'), 'trim|required|strip_all_tags');
			//$this->form_validation->set_rules('company_website', ('Company Website'), 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', '</div></div>');
			$this->outputData['full_name'] = (set_value('full_name'))?set_value('full_name'):$data->company_name;
			$this->outputData['industry_ID'] = (set_value('industry_ID'))?set_value('industry_ID'):$data->industry_ID;
			$this->outputData['ownership_type'] = (set_value('ownership_type'))?set_value('ownership_type'):$data->ownership_type;
			$this->outputData['company_name'] = (set_value('company_name'))?set_value('company_name'):$data->company_name;
			$this->outputData['company_location'] = (set_value('company_location'))?set_value('company_location'):$data->company_location;
			$this->outputData['country'] = (set_value('country'))?set_value('country'):$data->country;
			$this->outputData['city'] = (set_value('city'))?set_value('city'):$data->city;
			$this->outputData['company_phone'] = (set_value('company_phone'))?set_value('company_phone'):$data->company_phone;
			
			$this->outputData['mobile_phone'] = (set_value('mobile_phone'))?set_value('mobile_phone'):$data->mobile_phone;
			$this->outputData['company_website'] = (set_value('company_website'))?set_value('company_website'):$data->company_website;
			$this->outputData['no_of_employees'] = (set_value('no_of_employees'))?set_value('no_of_employees'):$data->no_of_employees;
			$this->outputData['company_description'] = (set_value('company_description'))?set_value('company_description'):$data->company_description;
			
			$ip_address = ($data->ip_address=='')?$this->input->ip_address():$data->ip_address;
			if ($this->form_validation->run() === FALSE) {
				$this->outputData['msg']='';
				$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
				$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
				$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
				$this->outputData['data'] = $data;
				$this->load->view('newweb/employer/my_account_view',$this->outputData);
				return;
			}
			$company_slug = make_slug($this->input->post('company_name'));
			$is_slug = $this->companies_model->check_slug_edit($data->company_ID, $company_slug);
			if($is_slug>0){
				$company_slug.='-'.time();
			}
			
			$employer_array = array(
									'first_name' => $this->input->post('full_name'),
									'mobile_phone' => $this->input->post('mobile_phone'),
									'country' => $this->input->post('country'),
									'city' => $this->input->post('city'),
									'ip_address' => $ip_address,
									'dated' => $current_date_time
			);
			
			$company_array = array(
									'company_name' => $this->input->post('company_name'),
									'industry_ID' => $this->input->post('industry_ID'),
									'company_phone' => $this->input->post('company_phone'),
									'company_location' => $this->input->post('company_location'),
									'company_website' => $this->input->post('company_website'),
									'no_of_employees' => $this->input->post('no_of_employees'),
									'company_description' => $this->input->post('company_description'),
									'company_slug' => $company_slug,
									'ownership_type' => $this->input->post('ownership_type'),
									'latitude' => $this->input->post('latitude'),
									'longitude' => $this->input->post('longitude')
			);
			
			$this->companies_model->update_company($data->company_ID, $company_array);
			$this->employers_model->update_employer($data->ID, $employer_array);

			redirect(WEBURL."/employer/home");
			//$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>'. lang('Your company profile has been updated').'.</div>');
			//$this->session->set_userdata('slug',$company_slug);
		}

		//if(isset($_POST))
		$this->outputData['msg']='';
		$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$this->outputData['data'] = $data;
		$this->load->view('newweb/employer/my_account_view',$this->outputData);
	}

	public function delete_account(){
		$this->employers_model->delete_employer($this->sessUserId);
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

		public function update_image(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
 		//$data = $this->employers_model->get_employer_by_id($this->sessUserId);
 		 $data = $this->My_model->getSingleRowData("tbl_companies","", "tbl_companies.ID =".$this->sessCompanyId);
 		//$cond=$this->sessCompanyId;
 		//$data = $this->My_model->selTableData("tbl_companies","",$cond);
 		//myPrint($data);die;
		//$empdata = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);
		//myPrint($data);die;
 		
 		//myPrint($cond);die;
		if(isset($_POST['btnUpdate'])){
			//myPrint($_POST);die;
			$real_path = realpath(APPPATH . '../public/uploads/employer/');
			$config['upload_path'] = $real_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['overwrite'] = true;
			$config['max_size'] = 6000;
			$config['file_name'] = make_slug($data->company_name).'-BiXma-'.$data->ID;
			$this->upload->initialize($config);
			
			if($data->company_logo){
				@unlink($real_path.'/'.$data->company_logo);	
				@unlink($real_path.'/thumb/'.$data->company_logo);
				//myPrint($real_path);die;
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
				$photo_array = array('company_logo' => $image_name);
				//myPrint($photo_array );exit;
				//$this->My_model->exequery("UPDATE `tbl_companies` SET `company_logo` =".$image_name. "WHERE `ID`=".$this->sessCompanyId);
				$this->companies_model->update_company($this->sessCompanyId, $photo_array);
			//echo $this->db->last_query(); exit;
				//$this->My_model->update("tbl_companies", $photo_array, $cond);
				//$this->employers_model->update($this->sessUserId, $photo_array);
				redirect(WEBURL.'/employer/my-account');
			} else{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.('Error').'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(WEBURL.'/employer/home');
				exit;
			}
		}
		$this->outputData['data'] = $data;
		$this->load->view('newweb/employer/update_image_view',$this->outputData);
}
}
