<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Candidate extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){
		$resumeData = $this->My_model->exequery("SELECT js.ID, js.first_name, js.gender, js.dob, js.city, js.country, js.dob, js.expected_salary, js.photo FROM tbl_job_seekers AS js WHERE js.sts = 'active' ORDER BY js.ID DESC  LIMIT 0,3 ");
		if(isset($resumeData) && $resumeData != ""){
			foreach($resumeData as $resume ){
				$final_exp = "No Experience";
				$skillData= $this->My_model->selTableData("tbl_seeker_skills","","seeker_ID = ".$resume->ID);
				$aboutData= $this->My_model->getSingleRowData("tbl_seeker_additional_info","summary","seeker_ID = ".$resume->ID);
				//myPrint($aboutData->summary);
				$sData =array();
				$sData =array();
				if(isset($skillData) && $skillData != ""){
					foreach($skillData as $skill){
						array_push($sData, $skill->skill_name);
					}
				}
				$resume->about = "";
				if($aboutData != "" && isset($aboutData)){
					$resume->about = $aboutData->summary; 
				}


				$total_experience = $this->jobseeker_experience_model->get_total_experience_by_seeker_id($resume->ID);
				$total_experience = number_format($total_experience,'1','.','');
				$total_experience = ($total_experience>0)?$total_experience.' years':'';
				$final_exp ='';
				$total_experience_array = explode('.',$total_experience);
				
				if(count($total_experience_array)>1){
					
					$year = ($total_experience_array[0]>0)?$total_experience_array[0]:'';
					$year = $year.' '.get_singular_plural($year, 'Year', 'Years');
					
					$monthval = substr($total_experience_array[1],0,1);
					$month = ($monthval>0)?$monthval:'';
					$month = $month.' '.get_singular_plural($month, 'Month', 'Months');
					
					$final_exp = (trim($year)!='' && trim($month)!='')?$year.' and '.$month:$year.' '.$month;
					$final_exp = trim($final_exp);
				}
				else{
					$final_exp =lang('No Experience');	
				}

				$row_latest_exp = $this->jobseeker_experience_model->get_latest_job_by_seeker_id($resume->ID);
				
				$lastest_job_title = ($row_latest_exp)?word_limiter(strip_tags(ucwords($row_latest_exp->job_title)),15):'';
				$edu_row = $this->jobseeker_academic_model->get_record_by_seeker_id($resume->ID);
				
				$latest_education = ($edu_row)?$edu_row->degree_title:"";
				$latest_institute = ($edu_row)?$edu_row->institude:"";
				$latest_institute_city = ($edu_row)?$edu_row->city:"";
				$age = date_difference_in_years($resume->dob, date("Y-m-d"));
				$resume->latest_education = $latest_education; 
				$resume->latest_institute = $latest_institute; 
				$resume->latest_institute_city = $latest_institute_city; 
				$resume->skills = $sData; 
				
				$resume->experience =$final_exp ;
				$resume->age =$age ;
				$resume->lastest_job_title =$lastest_job_title ;
			}
		}
		$this->outputData['data'] = $resumeData;
		$this->load->view('application/employer/job_tiles_seeker_view',$this->outputData);
	}

	public function invite(){

		$seekerID = $_POST['seeker_ID'];
		$insertData =array();
		$insertData['employer_id'] = $this->sessUserId;
		$insertData['jobseeker_id'] = $seekerID ;
		$insertData['sts'] = "pending" ;
		$insert = $this->My_model->insert("tbl_requests_info",$insertData);



		if($insert){
			echo 1;
		} else { 
			echo 0;
		}
		// $this->db->query("INSERT INTO tbl_requests_info SET sts='pending',employer_id='".$this->session->userdata('user_id')."',jobseeker_id='".$row->ID."' ");
	}

	public function reject(){
		$seekerID = $_POST['seeker_ID'];
		$current_date_time = date("Y-m-d H:i:s");
		$insertData = array();
		$insertData['employer_ID'] = $this->sessUserId;
		$insertData['seeker_ID'] = $seekerID ;
		$insertData['company_ID'] = $this->sessCompanyId;
		$insertData['dated'] = $current_date_time ;
		$insert = $this->My_model->insert("tbl_employer_rejected_candidate",$insertData);
		if($insert){
			echo 1;
		} else { 
			echo 0;
		}
	}

	public function wishlist(){
		$seekerID = $_POST['seeker_ID'];
		$current_date_time = date("Y-m-d H:i:s");
		$insertData = array();
		$insertData['employer_ID'] = $this->sessUserId;
		$insertData['seeker_ID'] =  $seekerID;
		$insertData['company_ID'] = $this->sessCompanyId;
		$insertData['dated'] = $current_date_time ;
		$insert = $this->My_model->insert("tbl_employer_wishlisted_candidate",$insertData);
		if($insert){
			echo 1;
		} else { 
			echo 0;
		}
	}

	public function candidate_full_post($id=0, $redirectTo = 0,$jobId = 0,$employer_id = 0, $jobseeker_id = 0){
		$data['ads_row'] = $this->ads;
		$data['chat_url'] = '';
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		//Latest Job
		$row_latest_exp = $this->jobseeker_experience_model->get_latest_job_by_seeker_id($decrypted_id);
		//Experience
		$result_experience = $this->job_seekers_model->get_experience_by_jobseeker_id($decrypted_id);
		//Qualification
		$result_qualification = $this->job_seekers_model->get_qualification_by_jobseeker_id($decrypted_id);
		//Resumes
		$result_resume = $this->resume_model->get_records_by_seeker_id($decrypted_id, 5, 0);
		//Additional Info
		$row_additional = $this->jobseeker_additional_info_model->get_record_by_userid($decrypted_id);
		$employer = $this->employers_model->get_employer_by_id($this->sessUserId);
		$data['IDCD'] 					= $id;
		$data['row'] 					= $row;
		$data['title'] 					= $row->first_name.' Profile';
		$data['result_experience'] 		= $result_experience;
		$data['result_qualification'] 	= $result_qualification;
		$data['result_reference'] 		= $result_reference;
		$data['result_degrees'] 		= $this->qualification_model->get_all_records();
		$data['result_resume'] 			= $result_resume;
		$data['row_additional'] 		= $row_additional;
		$data['latest_job_title']		= ($row_latest_exp)?$row_latest_exp->job_title:'';
		$data['latest_job_company_name']= ($row_latest_exp)?$row_latest_exp->company_name:'';
		//$data['photo'] 					= $photo;
		$data['employer_jobs']=$this->db->query("SELECT * FROM tbl_post_jobs WHERE tbl_post_jobs.employer_ID='$employer_->ID' AND deleted='0'")->result();
		$data['applications']=[];
		if($this->sessIsEmployer==TRUE){
			$user_id=$this->sess;
			$rows = $this->applied_jobs_model->get_applied_job_by_seeker_and_employer_id($decrypted_id,$user_id);
			$data['applications']=$rows;
		}
		$this->outputData['candidateDetails'] = $data['row'];
		$this->outputData['documents'] = $data['result_resume'];
		$this->outputData['additionalInfo'] = $data['row_additional'];
		$this->outputData['experience'] = $data['result_experience'];
		$this->outputData['qualification'] = $data['result_qualification'];
		$this->outputData['applications'] = $data['applications'];
		$this->outputData['redirectTo'] = $redirectTo;
		$this->outputData['employer_id'] = $employer_id;
		$this->outputData['jobseeker_id'] = $jobseeker_id;
		$this->outputData['jobId'] = $jobId;
		$this->load->view('application/employer/candidate_full_post_view',$this->outputData);
	}

	public function wishlisted_candidates(){
	 	$seekerID = $_POST['seeker_ID'];
		$current_date_time = date("Y-m-d H:i:s");

		 $wishlistedCand= $this->My_model->exequery("SELECT `tbl_employer_wishlisted_candidate`.*, tbl_job_seekers.first_name, tbl_job_seekers.email FROM `tbl_employer_wishlisted_candidate` LEFT JOIN tbl_job_seekers ON tbl_employer_wishlisted_candidate.seeker_ID = tbl_job_seekers.ID where tbl_employer_wishlisted_candidate.employer_ID =" .$this->sessUserId);

		// $empId =$this->sessIsEmployer;
		//myPrint($wishlistedCand);die;
		$this->outputData['wishlistedCand'] = $wishlistedCand;

		$this->load->view('application/employer/saved_candidate_view',$this->outputData);
	}

	public function delete_wishlisted_job($id=0, $redirectTo = 0){

	 	$delete = $this->My_model->del("tbl_employer_wishlisted_candidate","ID = ".$id);
		if($delete){
			redirect(APPURL.'/employer/candidate/wishlisted-candidates');
		}
	}

	public function view_candidate_details($id=0 ,$jobId = 0, $returnTo = 0,$applicationId = 0){
		$data['ads_row'] = $this->ads;
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		// $decrypted_id = $this->custom_encryption->decrypt_data($id);
		$candidateDetails = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$id);
		$jobData = $this->My_model->getSingleRowData('tbl_post_jobs',"","ID = ".$jobId);
		$latest_job_title = $this->My_model->getSingleRowData('tbl_seeker_experience',"","seeker_ID = ".$id);	
		$applied_job_title = $this->My_model->getSingleRowData('tbl_seeker_applied_for_job',"","seeker_ID = ".$id);	
		/*myPrint($jobData);
	    myPrint($candidateDetails);
	    myPrint($latest_job_title);
	    myPrint($applied_job_title);
	    exit;*/
		$this->outputData['jobData'] = $jobData;
		$this->outputData['candidateDetails'] = $candidateDetails;
		$this->outputData['latest_job_title'] = $latest_job_title;
		$this->outputData['applied_job_title'] = $applied_job_title;
		$this->outputData['returnTo'] = $returnTo;
		$this->outputData['applicationId'] = $applicationId;
		$this->outputData['jobId'] = $jobId;
		$this->outputData['seeker_id'] = $id;
		$this->load->view('application/employer/manage_candidate_interview_process_view',$this->outputData);
	}

	public function add_event($seekerId=0,$jobId=0,$applicationId = 0){
		/**/
		$date = trim($_POST['txtDate'])." ".trim($_POST['txtTime']);
		$notes = trim($_POST['txtNote']);
		$employer = $this->sessUserId;
		if($seekerId=="" || $employer=="" || $date=="" || $notes=="")
			return;
		$this->db->query("INSERT INTO calendar ( `id_employer`, `id_job_seeker`,`applicationId`, `notes`, `date`) VALUES ('$employer', '$seekerId','$applicationId', '$notes', '$date')");
		//redirect(APPURL."/employer/candidate/view-candidate-details/".$seekerId."/".$jobId);
		redirect(APPURL."/employer/calender");
	}

	public function update_event($seekerId=0,$jobId=0){
		$date = trim($_POST['txtDate'])." ".trim($_POST['txtTime']);
		$notes = trim($_POST['txtNote']);
		$id_calendar = trim($_POST['calId']);
		$this->db->query("UPDATE calendar SET notes='$notes',date='$date' WHERE id_calendar='$id_calendar'");
		redirect(APPURL."/employer/candidate/view-candidate-details/".$seekerId."/".$jobId);
	}

	public function change_status($seeker_ID = 0,$job_id = 0 ){
		
		if($job_id=="" || !$this->input->post('status'))
				goto endd;
		if($this->db->query("UPDATE tbl_seeker_applied_for_job SET flag='".$this->input->post('status')."' WHERE job_ID='".$job_id."' AND tbl_seeker_applied_for_job.seeker_ID = ".$seeker_ID))
			{ 
				$row_email = $this->email_model->get_records_by_id(6);

				$row = $this->db->query("SELECT tbl_job_seekers.email AS jobseeker_email,tbl_post_jobs.job_title,tbl_companies.company_name,
				CONCAT(tbl_job_seekers.first_name,' ',tbl_job_seekers.last_name) AS jobseeker_name
				FROM tbl_seeker_applied_for_job INNER JOIN tbl_companies ON tbl_companies.id=tbl_seeker_applied_for_job.employer_ID INNER JOIN tbl_job_seekers ON tbl_job_seekers.id=tbl_seeker_applied_for_job.seeker_ID INNER JOIN tbl_post_jobs ON tbl_post_jobs.id=tbl_seeker_applied_for_job.job_ID WHERE tbl_seeker_applied_for_job.job_ID='".$job_id."'  AND tbl_seeker_applied_for_job.seeker_ID = ".$seeker_ID)->result();
				//myPrint($row);exit;
				if(!$row && count($row)<=0){
					echo "Unknown Error";
					exit;	
				}
				$data_array=$row['0'];
				$config = array();
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$config = $this->email_drafts_model->email_configuration();

				$this->email->initialize($config);
				// $this->email->clear(TRUE);
				$this->email->from("bixma@agoujil.com", "BiXma Job System");
				$this->email->to($data_array->jobseeker_email);
				$this->email->subject(lang("About")." ".$data_array->job_title);
				$mail_message=$data_array->jobseeker_name."<br/><br/>"."The employer of this job has been change status of your application on '".$data_array->company_name."' to ".$this->input->post('status').".<br/><br/>Regards,";
				;
				$this->email->message($mail_message);     
				$this->email->send();
				$this->session->set_userdata('message','success');
				$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>'. lang('Job application updated successfully').'.</div>');
			}
			endd:
	}


	public function send_message($id)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		if($id==''){
			$this->load->view('404_view', $data);
			return;	
		}
				
		if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg','Please login as a employer to view the candidate profile.');
			redirect(APPURL.'/login');
			return;	
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		
		if(!$row){
			$this->load->view('404_view', $data);
			return;		
		}
		


		if(!$this->input->post("message") && empty($_FILES['upload_file']['name']))
		{
			$this->load->view('404_view', $data);
			return;
		}
		$curr_date=date("Y-m-d H:i:s");
		$message=$this->input->post("message");
		$employer_ = $this->employers_model->get_employer_by_id($this->sessUserId);
		stp:
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$employer_->ID' AND tbl_conversation.id_job_seeker='$row->ID'")->result();
		if(count($conv)<=0)
		{
			$this->db->query("INSERT INTO tbl_conversation SET id_employer='$employer_->ID',id_job_seeker='$row->ID',created_at='$curr_date'");
			goto stp;
		}
		$conv=$conv['0'];
		$message_to_send="Hi".' '.$row->first_name.",<br/><br/>"."You have new message(s) from"." <a href='".APPURL.'/seeker/chat/'.$conv->id_conversation."'>".$employer_->first_name."</a> :<br/><br/>";
		if($this->input->post("message"))
		{
			//echo $this->input->post("message");die;
			$this->db->query("INSERT INTO tbl_conv_message SET id_conversation='$conv->id_conversation',id_sender='$employer_->ID',message='$message',type_sender='employers',sent_at='$curr_date'");
			$message_to_send.=$message."<br/>";
		}



		if (!empty($_FILES['upload_file']['name']))
		{
			$real_path = realpath(APPPATH . '../public/uploads/chat/');
			echo $real_path;die;
			$config['upload_path'] = $real_path;
			$config['allowed_types'] = '*';
			$config['overwrite'] = true;
			$max_size=6000;
			$max_size=$this->db->query("SELECT * FROM tbl_settings")->result()['0']->upload_limit;
			$config['max_size'] = $max_size;
			$config['file_name'] = 'Attached_file_BiXma-'.md5($curr_date);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('upload_file')){
				
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.'Error'.'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(APPURL('employer/messenger/chat/').$conv->id_conversation);
				exit;
			}
			
			$resume = array('upload_data' => $this->upload->data());	
			$file_name = $resume['upload_data']['file_name'];
			$ull=APPURL."/employer/messenger/download/".$file_name;
			$sty="text-decoration: none;color: white;";
			$message="<i style='".$sty."' class='fa fa-file-o'>&nbsp;</i>
                  <a style='".$sty."' href='".$ull."'>Attached File<br></a>";
			$message_to_send.="<a href='".$ull."'>Attached File</a>";
			$data_array = array(
			        'message' => $message,
			        'id_conversation' => $conv->id_conversation,
			        'id_sender' => $employer_->ID,
			        'type_sender' => 'employers',
			        'sent_at' => $curr_date
			);
			// var_dump($data_array);
			// die();
			$this->db->insert('tbl_conv_message', $data_array);
		}
		$message_to_send.="<br/><br/>".'Regards'.",";



		$config = $this->email_drafts_model->email_configuration();


		$this->email->initialize($config);
		
		// $this->email->clear(TRUE);
		$this->email->from("bixma@agoujil.com", "BiXma Job System");
		$this->email->to($row->email);
		$mail_message = $message_to_send;
		$this->email->subject($subject);
		$this->email->message($mail_message);     
		$this->email->send();

		redirect(APPURL.'/employer/messenger/chat/'.$conv->id_conversation);
	}

	/*public function invitation(){

		$data['ads_row'] = $this->ads;
		$data['chat_url'] = '';
		
		$invitedCandidates= $this->My_model->exequery("SELECT `tbl_requests_info`.*, tbl_job_seekers.first_name, tbl_job_seekers.email FROM `tbl_requests_info` LEFT JOIN tbl_job_seekers ON tbl_requests_info.jobseeker_id = tbl_job_seekers.ID where tbl_requests_info.employer_id =" .$this->sessUserId);
		//echo $this->db->last_query();exit;
		$this->outputData['invitedCandidates'] = $invitedCandidates;
		$this->load->view('application/employer/invitation_view',$this->outputData);
	}
*/
}
