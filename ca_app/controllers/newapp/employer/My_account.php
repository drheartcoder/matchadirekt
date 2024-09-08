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
		
		$data = $this->employers_model->get_employer_by_id($this->sessUserId);

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
			$this->outputData['full_name'] = (set_value('full_name'))?set_value('full_name'):$data->first_name;
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
				$this->load->view('application/employer/my_account_view',$this->outputData);
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
									'industry_ID' => $this->input->post('industry_id'),
									'company_phone' => $this->input->post('company_phone'),
									'company_location' => $this->input->post('company_location'),
									'company_website' => $this->input->post('company_website'),
									'no_of_employees' => $this->input->post('no_of_employees'),
									'company_description' => $this->input->post('company_description'),
									'company_slug' => $company_slug,
									'ownership_type' => $this->input->post('ownership_type')
			);
			
			$this->companies_model->update_company($data->company_ID, $company_array);
			$this->employers_model->update_employer($data->ID, $employer_array);

			redirect(APPURL."/employer/home");
			//$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>'. lang('Your company profile has been updated').'.</div>');
			//$this->session->set_userdata('slug',$company_slug);
		}

		//if(isset($_POST))
		$this->outputData['msg']='';
		$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$this->outputData['data'] = $data;
		$this->load->view('application/employer/my_account_view',$this->outputData);
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
		redirect(APPURL.'/login');	
	}
}
