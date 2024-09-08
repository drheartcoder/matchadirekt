<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registration extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		//$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		/*	error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
		$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
        $this->outputData['channel_list']=$this->db->query("SELECT * FROM tbl_channels")->result();
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$tab= "seeker";
		$msg = "";
		$this->outputData['tab'] =$tab;
		$this->outputData['msg'] =$msg;
		if(isset($_POST['btnCompanySaveData'])){
			$tab= "company";
			$this->form_validation->set_rules('txtCompanyEmail', ('Email'), 'trim|required|valid_email|is_unique[tbl_employers.email]|strip_all_tags');	
			$this->form_validation->set_rules('txtCompPassword', ('Password'), 'trim|required|min_length[6]|strip_all_tags');
			$this->form_validation->set_rules('txtCompConfirmPassword', ('Confirm password'), 'trim|required|matches[txtCompPassword]|strip_all_tags');
			$this->form_validation->set_rules('txtCompFullName', ('Full Name'), 'trim|required');
			$this->form_validation->set_rules('txtCompCompanyName', ('Company Name'), 'trim|required');
			$this->form_validation->set_rules('selCompIndustry', ('Select Industry'), 'trim|required');
			$this->form_validation->set_rules('selCompOwnershipType', ('Org. Type'), 'trim|required');
			$this->form_validation->set_rules('txtCompAddress', ('Address'), 'trim|required');
			$this->form_validation->set_rules('selCompCountry', ('Country'), 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', '</div></div>');
			if ($this->form_validation->run() === FALSE) {
				$this->outputData['tab'] =$tab;
				$this->load->view('application/registration_view',$this->outputData);
				return;
			}

			$current_date_time = date("Y-m-d H:i:s");
			$company_slug = make_slug($this->input->post('txtCompCompanyName'));
			$is_slug = $this->companies_model->check_slug($company_slug);
			if($is_slug>0){
				$company_slug.='-'.time();
			}

			$employer_array = array(
									'first_name' => $this->input->post('txtCompFullName'),
									'email' => $this->input->post('txtCompanyEmail'),
									'pass_code' => $this->input->post('txtCompPassword'),
									'mobile_phone' => $this->input->post('txtCompCellPhone'),
									//'home_phone' => $this->input->post('home_phone'),
									'channel' => $this->input->post('selCompChannel'),
									'country' => $this->input->post('selCompCountry'),
									'city' => $this->input->post('txtCompCity'),
									'ip_address' => $this->input->ip_address(),
									'dated' => $current_date_time
			);
			
			$company_array = array(
									'company_name' => $this->input->post('txtCompCompanyName'),
									'industry_ID' => $this->input->post('selCompIndustry'),
									'company_phone' => $this->input->post('txtCompLandline'),
									'company_location' => $this->input->post('txtCompAddress'),
									'company_website' => $this->input->post('txtCompWebsite'),
									'no_of_employees' => $this->input->post('selNoOfEmployees'),
									'company_description' => $this->input->post('txtCompDescr'),
									'company_slug' => $company_slug,
									'ownership_type' => $this->input->post('selCompOwnershipType')
			);
			if (!empty($_FILES['companyLogo']['name'])){
				
				$company_name_for_file = strtolower($this->input->post('txtCompCompanyName'));
				$real_path = realpath(APPPATH . '../public/uploads/employer/');
				$config['upload_path'] = $real_path;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['overwrite'] = true;
				$config['max_size'] = 6000;
				$config['file_name'] = 'JOBPORTAL-'.time();
				$this->upload->initialize($config);
				if ($this->upload->do_upload('company_logo')){
					/*if($obj_row->companyLogo){
						@unlink($real_path.'/'.$obj_row->companyLogo);	
						@unlink($real_path.'/thumb/'.$obj_row->companyLogo);
					}*/
				}
				
				$image = array('upload_data' => $this->upload->data());	
				$image_name = $image['upload_data']['file_name'];
				$company_array['company_logo']=$image_name;
				$thumb_config['image_library'] = 'gd2';
				$thumb_config['source_image']	= $real_path.'/'.$image_name;
				$thumb_config['new_image']	= $real_path.'/thumb/'.$image_name;
				$thumb_config['maintain_ratio'] = TRUE;
				$thumb_config['height']	= 50;
				$thumb_config['width']	 = 70;
				
				$this->image_lib->initialize($thumb_config);
				$this->image_lib->resize();
			}
			$company_id = $this->companies_model->add_company($company_array);
			$employer_array['company_ID'] = $company_id;
			$employer_id = $this->employers_model->add_employer($employer_array);


			//Sending email to the user
			$row_email = $this->email_model->get_records_by_id(3);
			
			$config = $this->email_drafts_model->email_configuration();
			$this->email->initialize($config);
			$this->email->clear(TRUE);
			$this->email->from($row_email->from_email, $row_email->from_name);
			$this->email->to($this->input->post('txtCompanyEmail'));
			$mail_message = $this->email_drafts_model->employer_signup($row_email->content, $employer_array);
			$this->email->subject($row_email->subject);
			$this->email->message($mail_message);     
			$this->email->send();

			$msg =  '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Registration Successfull!!</strong> <a href="'.APPURL.'/login">Login Now </a></div>';
			//redirect(APPURL.'/login');
		}

		if(isset($_POST['btnSeekarSaveData'])){
			//myPrint($_POST);
			$tab= "seeker";
			$this->form_validation->set_rules('txtSeekerEmail', ('Email'), 'trim|required|valid_email|is_unique[tbl_job_seekers.email]|strip_all_tags');	
			$this->form_validation->set_rules('txtSeekerPassword', ('Password'), 'trim|required|min_length[6]|strip_all_tags');
			$this->form_validation->set_rules('txtSeekerConfirmPassword', ('Confirm password'), 'trim|required|matches[txtSeekerPassword]');
			$this->form_validation->set_rules('txtSeekerFullName', ('Full Name'), 'trim|required');
			$this->form_validation->set_rules('selSeekerGender', ('Gender'), 'trim|required');
			$this->form_validation->set_rules('selSeekerBirthDay', ('Day'), 'trim|required');
			$this->form_validation->set_rules('selSeekerBirthMonth', ('Month'), 'trim|required');
			$this->form_validation->set_rules('selSeekerBirthYear', ('Year'), 'trim|required');
			$this->form_validation->set_rules('txtSeekerMobile', ('Mobile'), 'trim|required');
			
			$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', '</div></div>');
			if ($this->form_validation->run() === FALSE) {
				$this->outputData['tab'] =$tab;
				$this->load->view('application/registration_view',$this->outputData);
				return;
			}else{

				$current_date = date("Y-m-d H:i:s");
				$job_seeker_array = array(
							'first_name' => $this->input->post('txtSeekerFullName'),
							'email' => $this->input->post('txtSeekerEmail'),
							'password' => $this->input->post('txtSeekerPassword'),
							'dob' => $this->input->post('selSeekerBirthYear').'-'.$this->input->post('selSeekerBirthMonth').'-'.$this->input->post('selSeekerBirthDay'),
							'mobile' => $this->input->post('txtSeekerMobile'),
							'home_phone' => $this->input->post('txtSeekerPhone'),
							'present_address' => $this->input->post('txtSeekerAddress'),
							'country' => $this->input->post('selSeekerCountry'),
							'city' => $this->input->post('txtSeekerCity'),
							'nationality' => $this->input->post('selSeekerNationality'),
							'channel' => $this->input->post('selSeekerChannel'),
							'gender' => $this->input->post('selSeekerGender'),
							'ip_address' => $this->input->ip_address(),
							'dated' => $current_date,
							'verification_code'=>md5($current_date)
				);
				
				$seeker_id = $this->job_seekers_model->add_job_seekers($job_seeker_array);
				
				if (!empty($_FILES['seekerResume']['name'])){
					$extention = get_file_extension($_FILES['seekerResume']['name']);
					$allowed_types = array('doc','docx','pdf','rtf','jpg','txt');
					
					if(!in_array($extention,$allowed_types)){
						$captcha_row = $this->cap_model->generate_captcha();
						$data['cpt_code'] = $captcha_row['image'];
						$data['msg'] = 'This file type is not allowed.';
						$this->load->view('application/registration_view',$data);
						return;	
					}
					
					$resume_array = array();
					$real_path = realpath(APPPATH . '../public/uploads/candidate/resumes/');
					$config['upload_path'] = $real_path;
					$config['allowed_types'] = '*';
					$config['overwrite'] = true;
					$max_size=6000;
					$max_size=$this->db->query("SELECT * FROM tbl_settings")->result()['0']->upload_limit;
					$config['max_size'] = $max_size;
					$config['file_name'] = replace_string(' ','-',strtolower($this->input->post('full_name'))).'-'.$seeker_id;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('seekerResume')){
						$this->job_seekers_model->delete_job_seeker($seeker_id);
						$captcha_row = $this->cap_model->generate_captcha();
						$data['cpt_code'] = $captcha_row['image'];
						$data['msg'] = $this->upload->display_errors();
						$this->load->view('application/registration_view',$data);
						return;
					}
					
					$resume = array('upload_data' => $this->upload->data());	
					$resume_file_name = $resume['upload_data']['file_name'];
					$resume_array = array(
											'seeker_ID' => $seeker_id,
											'file_name' => $resume_file_name,
											'dated' => $current_date,
											'is_uploaded_resume' => 'yes'
											
					);

					$this->resume_model->add($resume_array);		
				}	
				$this->jobseeker_additional_info_model->add(array('seeker_ID'=>$seeker_id));
				$row_email = $this->email_model->get_records_by_id(3);
				//Sending email to the user   
				$config = $this->email_drafts_model->email_configuration();
				$this->load->library('email');
				$this->email->initialize($config);
				$this->email->clear(TRUE);
				$this->email->from($row_email->from_email, $row_email->from_name);
				$this->email->to($this->input->post('txtSeekerEmail'));
				$mail_message = $this->email_drafts_model->jobseeker_signup($row_email->content, $job_seeker_array);
				$this->email->subject($row_email->subject);
				$this->email->message($mail_message);     
				$this->email->send();
				 // echo $this->email->print_debugger();
				//exit;
				$msg =  '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Registration Successfull!!</strong> <a href="'.APPURL.'/login">Login Now </a></div>';
				//redirect(APPURL.'/login');
			}
			}
		
		$this->outputData['tab'] =$tab;
		$this->outputData['msg'] =$msg;
		$this->load->view('application/registration_view',$this->outputData);
	}

	public function seeker(){
		if(isset($_POST['btnSeekarSaveData'])){
			myPrint($_POST);
			$insertData =array();
			//$insertData['']
		}
	}

	public function employer(){

	}

}