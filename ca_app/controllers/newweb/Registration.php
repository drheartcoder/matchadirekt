<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("class.smtp.php");
include("class.phpmailer.php");
class Registration extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		//$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$this->outputData['result_cities'] = $this->cities_model->get_all_cities();
        $this->outputData['channel_list']=$this->db->query("SELECT * FROM tbl_channels")->result();
		$this->outputData['result_countries'] = $this->countries_model->get_all_countries();
		$this->outputData['result_industries'] = $this->industries_model->get_all_industries();
		$tab= "seeker";
		$msg = "";
		$errArray=array();
		$this->outputData['tab'] =$tab;
		$this->outputData['msg'] =$msg;
		 //echo WEBURL.'/login'; die;
		if(isset($_POST['btnCompanySaveData'])){
			//myPrint($_POST);
			 $tab= "company";

			$employerData = $this->My_model->getSingleRowData("tbl_employers","","email= '".$this->input->post('txtCompanyEmail')."'");
				if(isset($employerData) && $employerData != ""){
					$msg =  '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Email Id already exist</div>';
				} else {
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
					//myPrint($company_array);
					$employer_array['company_ID'] = $company_id;
					$employer_id = $this->employers_model->add_employer($employer_array);
				   //	myPrint($employer_id);die;

					//Sending email to the user
					$row_email = $this->email_model->get_records_by_id(3);
					
					$config = $this->email_drafts_model->email_configuration();
					/*$this->email->initialize($config);
					$this->email->clear(TRUE);
					$this->email->from($row_email->from_email, $row_email->from_name);
					$this->email->to($this->input->post('txtCompanyEmail'));
					$mail_message = $this->email_drafts_model->employer_signup($row_email->content, $employer_array);
					$this->email->subject($row_email->subject);
					$this->email->message($mail_message);     
					$this->email->send();*/
					$mail_message = $this->email_drafts_model->employer_signup($row_email->content, $employer_array);
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->Host = MAILERHOST;
					$mail->Username = MAILERUSER;
					$mail->Password = MAILERPASS; 
					$mail->From = $row_email->from_email;
					$mail->FromName = $row_email->from_name;
					$mail->AddAddress($this->input->post('txtCompanyEmail'),$this->input->post('txtCompFullName'));
					$mail->Subject =$row_email->subject;
					$mail->Body = $mail_message;
					$mail->WordWrap = 50;
					$mail->IsHTML(true);
					/*$mail->SMTPSecure = 'tls';
					$mail->Port = 587;*/
					$mail->Port = 25;
						
					$mail->Send();


					/*echo $this->email->print_debugger();
						exit;*/
					$msg =  '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Registration Successfull!!</strong> <a href="'.WEBURL.'/login">Login Now </a></div>';
					//redirect(WEBURL.'/login');
			}
		}

		if(isset($_POST['btnSeekarSaveData'])){
			//myPrint($_POST);exit;
			$tab= "seeker";
			// $this->form_validation->set_rules('txtSeekerEmail', ('Email'), 'trim|required|valid_email|is_unique[tbl_job_seekers.email]|strip_all_tags');	
			// $this->form_validation->set_rules('txtSeekerPassword', ('Password'), 'trim|required|min_length[6]|strip_all_tags');
			// $this->form_validation->set_rules('txtSeekerConfirmPassword', ('Confirm password'), 'trim|required|matches[txtSeekerPassword]');
			// $this->form_validation->set_rules('txtSeekerFullName', ('Full Name'), 'trim|required');
			// $this->form_validation->set_rules('selSeekerGender', ('Gender'), 'trim|required');
			// $this->form_validation->set_rules('selSeekerBirthDay', ('Day'), 'trim|required');
			// $this->form_validation->set_rules('selSeekerBirthMonth', ('Month'), 'trim|required');
			// $this->form_validation->set_rules('selSeekerBirthYear', ('Year'), 'trim|required');
			// $this->form_validation->set_rules('txtSeekerMobile', ('Mobile'), 'trim|required');
			// $this->form_validation->set_rules('selSeekerIndustry', ('Mobile'), 'trim|required');
			
			//$this->form_validation->set_error_delimiters('<div class="errowbox"><div class="erormsg">', '</div></div>');
			// if ($this->form_validation->run() === FALSE) {
			// 	$this->outputData['tab'] =$tab;
			// 	$this->load->view('newweb/registration_view',$this->outputData);
			// 	return;
			// }else{
				
				$seekerData = $this->My_model->getSingleRowData("tbl_job_seekers","","email= '".$this->input->post('txtSeekerEmail')."'");
				if(isset($seekerData) && $seekerData != ""){
					$msg =  '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Email Id already exist</div>';
				} else {
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
								'industry_ID' => $this->input->post('selSeekerIndustry'),
								'ip_address' => $this->input->ip_address(),
								'dated' => $current_date,
								'verification_code'=>md5($current_date)
					);
					
					$seeker_id = $this->job_seekers_model->add_job_seekers($job_seeker_array);
					
					if (!empty($_FILES['seekerResume']['name'])){
						$extention = get_file_extension($_FILES['seekerResume']['name']);
						$allowed_types = array('doc','docx','pdf','rtf','jpg','txt');
						
						if(!in_array($extention,$allowed_types)){
							//$captcha_row = $this->cap_model->generate_captcha();
							//$data['cpt_code'] = $captcha_row['image'];
							$data['msg'] = 'This file type is not allowed.';
							$this->load->view('newweb/registration_view',$data);
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
							$this->load->view('newweb/registration_view',$data);
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

					if(isset($_POST['skill']) && $_POST['skill'] != ""){
						//delete skills 
						//$this->My_model->del("tbl_seeker_skills","seeker_ID = ".$seeker_id);
						$skills = $_POST['skill'];
						foreach($skills as $skill){
							if(trim($skill) != ""){
								$insertData =array();
								$insertData['seeker_ID'] = $seeker_id;
								$insertData['skill_name'] = $skill;
								$this->My_model->insert("tbl_seeker_skills",$insertData);
							}
						}
						
					}
					$this->jobseeker_additional_info_model->add(array('seeker_ID'=>$seeker_id));
					$row_email = $this->email_model->get_records_by_id(2);
					//Sending email to the user   
					/*$config = $this->email_drafts_model->email_configuration();
					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->clear(TRUE);
					$this->email->from($row_email->from_email, $row_email->from_name);
					$this->email->to($this->input->post('txtSeekerEmail'));
					$mail_message = $this->email_drafts_model->jobseeker_signup($row_email->content, $job_seeker_array);
					$this->email->subject($row_email->subject);
					$this->email->message($mail_message);     
					echo $this->email->send();
					echo $this->email->print_debugger();
					exit;*/
					$mail_message = $this->email_drafts_model->jobseeker_signup($row_email->content, $job_seeker_array);
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->Host = MAILERHOST;
					$mail->Username = MAILERUSER;
					$mail->Password = MAILERPASS; 
					$mail->From = $row_email->from_email;
					$mail->FromName = $row_email->from_name;
					$mail->AddAddress($this->input->post('txtSeekerEmail'),$this->input->post('txtSeekerFullName'));
					$mail->Subject =$row_email->subject;
					$mail->Body = $mail_message;
					$mail->WordWrap = 50;
					$mail->IsHTML(true);
					/*$mail->SMTPSecure = 'tls';
					$mail->Port = 587;*/
					$mail->Port = 25;
						
					$mail->Send();
					//insert to notification
					$empData  = $this->My_model->exequery("select tbl_employers.email, tbl_employers.first_name, tbl_employers.ID from tbl_employers left join tbl_companies on tbl_employers.company_ID = tbl_companies.ID where tbl_companies.industry_ID = ".$this->input->post('selSeekerIndustry'));
					if(isset($empData) && $empData != ""){
						foreach($empData as $emp){
							//echo $emp->email;
							$insertData =array();
							$insertData['seekerId'] =$seeker_id;
							$insertData['employerId'] = $emp->ID;
							$insertData['notificationFor'] = "New Seeker";
							$insertData['notificationText'] = "New Seeker Registered";

							$insertId  = $this->My_model->insert("tbl_employer_notification",$insertData);
						}
					}
					//exit;
					
					$msg =  '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Registration Successfull!!</strong> <a href="'.WEBURL.'/login">Login Now </a></div>';	
				}

				//redirect(WEBURL.'/login');

			//}
			}
		
		$this->outputData['tab'] =$tab;
		$this->outputData['msg'] =$msg;
		//myPrint($tab);die;
		$this->load->view('newweb/registration_view',$this->outputData);
	}


	public function social_reg(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		//$employer_array='';
		//$company_array='';
		if(isset($_POST['radioVal']) && $_POST['radioVal'] > 0){
			//echo $_POST['radioVal'];exit;
			$name = trim($_POST['name']);
			$email = trim($_POST['email']);
			$loginfrom = trim($_POST['loginfrom']);
			$facebook = trim($_POST['facebook']);
			$google = trim($_POST['google']);
			$current_date_time = date("Y-m-d H:i:s");
			if($_POST['radioVal'] == 1){
				$tblName = "tbl_job_seekers";
				$seekerData = $this->My_model->getSingleRowData("tbl_job_seekers",""," email = '".$email."'");
				if(isset($seekerData) && $seekerData != ""){
					$seeker_id  =$seekerData->ID;
				} else{
					$current_date = date("Y-m-d H:i:s");
					$job_seeker_array = array(
								'first_name' => $name ,
								'email' => $email,
								'password' => "",
								'dob' => "",
								'mobile' => "",
								'home_phone' => "",
								'present_address' => "",
								'country' => "",
								'city' => "",
								'nationality' => "",
								'channel' => "",
								'gender' => "",
								'ip_address' => "",
								'dated' => $current_date,
								'verification_code'=>md5($current_date)
					);
					
					$seeker_id = $this->job_seekers_model->add_job_seekers($job_seeker_array);
					
					$this->jobseeker_additional_info_model->add(array('seeker_ID'=>$seeker_id));
				}
				$isJobSeeker =1;
				$isEmployer	= 0;
				$role	= 'seeker';
				if($seeker_id){
					$user_data = array(
									'sessUserId' => $seeker_id,
									 'sessUserRole' => $email,
									 'sessFirstName' => $name,
									 'sessSlug' => "",
									 'sessIsLogin' => TRUE,
									 'sessIsJobSeeker' => $isJobSeeker,
									 'sessIsEmployer' => $isEmployer,
									 'sessRole' => $role,
									 'sessCompanyId' =>0
									 );
				}
			} else if($_POST['radioVal'] == 2){
				$tblName = "tbl_employers";
				$empData = $this->My_model->getSingleRowData("tbl_employers",""," email = '".$email."'");
				if(isset($empData) && $empData != ""){
					$company_id  =$empData->company_ID;
					$employer_id =$empData->ID;
				} else {
					$employer_array = array(
											'first_name' =>$name ,
											'email' =>$email,
											'pass_code' =>"",
											'mobile_phone' => "",
											//'home_phone' => "",
											'channel' => "",
											'country' => "",
											'city' => "",
											'ip_address' =>"",
											'dated' => $current_date_time,
											'loginFrom' => $loginfrom,
											'facebookId' =>$facebook,
											'googleId' =>$google
					);
					//myPrint($employer_array);exit;
					
					$company_array = array(
											'company_name' => "",
											'industry_ID' => "",
											'company_phone' => "",
											'company_location' => "",
											'company_website' =>"",
											'no_of_employees' => "",
											'company_description' => "",
											'company_slug' => "",
											'ownership_type' => ""
					);
					$company_id = $this->companies_model->add_company($company_array);
					$employer_array['company_ID'] = $company_id;
					$employer_id = $this->employers_model->add_employer($employer_array);
				}

				$isJobSeeker = 0;
				$isEmployer	= 1;
				$role	= 'employer';
				if($employer_id){
					$user_data = array(
									'sessUserId' => $employer_id,
									 'sessUserRole' => $email,
									 'sessFirstName' => $name,
									 'sessSlug' => "",
									 'sessIsLogin' => TRUE,
									 'sessIsJobSeeker' => $isJobSeeker,
									 'sessIsEmployer' => $isEmployer,
									 'sessRole' => $role,
									 'sessCompanyId' => $company_id
									 );
				}
			}
			if($user_data){	
				$this->session->set_userdata($user_data);
				//exit;
				if($this->session->userdata('sessUserId') > 0){
					if($this->session->userdata('sessIsJobSeeker') == 1){
						echo (WEBURL."/seeker/my-account");
					}else if($this->session->userdata('sessIsEmployer') == 1){
						echo (WEBURL."/employer/my-account");
					}
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}
	}


	public function getCities(){

		$countryID = $this->My_model->getSingleRowData("tbl_countries","ID","country_name = '".$_POST['country']."'");
		/*echo 'ID:';
		myPrint($countryID);exit;		*/
		$options = "";
		if(isset($countryID) && $countryID != ""){
			$cities = $this->My_model->selTableData("tbl_cities","","country_ID = ".$countryID->ID);
			if(isset($cities) && $cities != ""){
				$options .= '<option selected="" disabled="" value="">'.lang('City').'</option>';
				foreach($cities as $city){
					$options .= '<option value="'.$city->city_name.'" >'.$city->city_name.'</option>';
				}
			} else {
				$options .= '<option value="" >'.lang("No city Found").'</option>';
			}
		} else {
			$options .= '<option value="" >'.lang("No city Found").'</option>';
		}

		echo $options;

	}

}