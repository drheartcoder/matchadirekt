<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_Applications extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$data['ads_row'] = $this->ads;
		$data['title'] = SITE_NAME.': '.lang('List of Received Job Applications');
		
		//Pagination starts
		$total_rows = $this->applied_jobs_model->count_applied_job_by_employer_id($this->session->userdata('user_id'));
		$config = pagination_configuration(base_url("app/employer/job_applications"), $total_rows, 50, 3, 5, true);
		
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(3) : 0;
		$page_num = $page-1;
		$page_num = ($page_num<0)?'0':$page_num;
		$page = $page_num*$config["per_page"];
		$data["links"] = $this->pagination->create_links();
		//Pagination ends
		
		//Applied Jobs by Employer ID
		// $result_applied_jobs = $this->applied_jobs_model->get_applied_job_by_employer_id($this->session->userdata('user_id'), $config["per_page"], $page);
		$cond="";
		if($this->input->get('name_ref'))
		{
			$vr="LIKE '%".$this->input->get('name_ref')."%'";
			$ijd=explode("JS", $this->input->get('name_ref'));
			if(count($ijd)>1)
				$ijd=$ijd['1'];
			else
				$ijd=0;
			$ijd=intval($ijd);
			$ijd>0?$ijd="OR tbl_job_seekers.ID ='".$ijd."'":$ijd='';
			$cond.=" AND ( first_name $vr OR job_title $vr OR last_name $vr $ijd )";
		}
		if($this->input->get('email'))
		{
			$vr="LIKE '%".$this->input->get('email')."%'";
			$cond.=" AND ( email $vr )";
		}
		if($this->input->get('gender'))
		{
			$vr="LIKE '%".$this->input->get('gender')."%'";
			$cond.=" AND ( gender $vr )";
		}
		if($this->input->get('city'))
		{
			$vr="LIKE '%".$this->input->get('city')."%'";
			$cond.=" AND ( tbl_job_seekers.city $vr )";
		}
		if($cond=="")
		{
			$result_applied_jobs = $this->applied_jobs_model->get_applied_job_by_employer_id($this->session->userdata('user_id'), $config["per_page"], $page);
		}
		else
		{

			$SQL="SELECT 
				tbl_post_jobs.job_title,
				tbl_seeker_applied_for_job.dated AS applied_date,
				tbl_job_seekers.ID AS job_seeker_ID, 
				tbl_job_seekers.*,tbl_seeker_applied_for_job.*,
				tbl_post_jobs.* 
			FROM 
				tbl_seeker_applied_for_job 
			INNER JOIN 
				tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID 
			INNER JOIN 
				tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID 
			WHERE 
				tbl_seeker_applied_for_job.deleted=0
			AND
				tbl_post_jobs.employer_ID='".$this->session->userdata('user_id')."' ".$cond."
		ORDER BY 
			tbl_seeker_applied_for_job.ID DESC";

			$result_applied_jobs=$this->db->query($SQL)->result();
		}
		$data['result_applied_jobs']= $result_applied_jobs;
		$data['id_employer_ID']= $this->session->userdata('user_id');
		$data['cities_res'] = $this->cities_model->get_all_active_cities();
        $data['title_app']='Job Applications Received';
		$this->load->view('application_views/employer/job_applications_view',$data);
	}


	public function delete($id){

		$this->applied_jobs_model->delete_applied_job($id);

		redirect(base_url('app/employer/job_applications'));

	}


	
	public function send_message_to_candidate(){
		if(!$this->session->userdata('user_id')){
			echo lang('All fields are mandatory.');
			exit;	
		}
		$this->form_validation->set_rules('message', lang('message'), 'trim|required|strip_all_tags');//|time_diff
		$this->form_validation->set_rules('jsid', lang('ID'), 'trim|required|strip_all_tags');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() === FALSE) {
			echo validation_errors();
			exit;
		}
		
		if($this->session->userdata('is_employer')!=TRUE){
			echo lang('You are not logged in with a employer account. Please login with a employer account to send message to the candidate.');
			exit;
		}
		
		$decrypted_id = $this->custom_encryption->decrypt_data($this->input->post('jsid'));
		
		$row_jobseeker 	= $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		$row_employer 	= $this->employers_model->get_employer_by_id($this->session->userdata('user_id'));
		if(!$row_jobseeker || !$row_employer){
			echo lang('Something went wrong.');
			exit;	
		}
		
		//Sending email to Jobseeker
		$config = array();
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config = $this->email_drafts_model->email_configuration();

		$row_email = $this->email_model->get_records_by_id(7);
		
		$this->email->initialize($config);
		// $this->email->clear(TRUE);
		$this->email->from($row_email->from_email, $row_email->from_name);
		$this->email->to($row_jobseeker->email);
		$mail_message = $this->email_drafts_model->send_message_to_candidate($row_email->content, $this->input->post('message'), $row_jobseeker, $row_employer);
		$this->email->subject($row_email->subject);
		$this->email->message($mail_message);     
		if(!$this->email->send())
			echo lang("Email cannot be send, unknown error");
		else
		{
			$this->session->set_userdata('timestm', date("H:i:s"));
			echo "done";
		}
		exit;
		
	}

	public function add_Event($job_seeker,$employer,$date,$notes)
	{
		if($job_seeker=="" || $employer=="" || $date=="" || $notes=="")
			return;
		$this->db->query(str_replace("%20"," ","INSERT INTO calendar ( `id_employer`, `id_job_seeker`, `notes`, `date`) VALUES ('$employer', '$job_seeker', '$notes', '$date')"));
		//redirect(base_url('employer/calendar'));
	}

	public function update_Event($id_calendar,$job_seeker,$employer,$date,$notes)
	{
		if($id_calendar=="" ||$job_seeker=="" || $employer=="" || $date=="" || $notes=="")
			return;
		$this->db->query(str_replace("%20"," ","UPDATE calendar SET id_employe='$employer',id_job_seeker='$job_seeker',notes='$notes',date='$date' WHERE id_calendar='$id_calendar'"));
		//redirect(base_url('employer/calendar'));
	}

	public function delete_Event($id_calendar)
	{
		if($id_calendar=="")
			return;
		$this->db->query("DELETE FROM calendar WHERE id_calendar='$id_calendar'");
		redirect(base_url('app/employer/job_applications'));
	}

	public function edit_status($job_id)
	{

		if($job_id=="" || !$this->input->post('status'))
			goto endd;
		if($this->db->query("UPDATE tbl_seeker_applied_for_job SET flag='".$this->input->post('status')."' WHERE ID='".$job_id."'"))
		{ 
			$row_email = $this->email_model->get_records_by_id(6);

			$row = $this->db->query("SELECT tbl_job_seekers.email AS jobseeker_email,tbl_post_jobs.job_title,tbl_companies.company_name,
            CONCAT(tbl_job_seekers.first_name,' ',tbl_job_seekers.last_name) AS jobseeker_name
            FROM tbl_seeker_applied_for_job INNER JOIN tbl_companies ON tbl_companies.id=tbl_seeker_applied_for_job.employer_ID INNER JOIN tbl_job_seekers ON tbl_job_seekers.id=tbl_seeker_applied_for_job.seeker_ID INNER JOIN tbl_post_jobs ON tbl_post_jobs.id=tbl_seeker_applied_for_job.job_ID WHERE tbl_seeker_applied_for_job.ID='".$job_id."'")->result();
		
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
		redirect(base_url('app/employer/job_applications'));
	}

	public function update_details($job_id)
	{
		if($job_id=="") goto endd;

		$data=[];
		if($this->input->post('comment')){
			$data['comment']=$this->input->post('comment');
		}

		if($this->input->post('rate')){
			$data['rate']=$this->input->post('rate');
		}


		if($this->input->post('Note')){
			$data['note']=$this->input->post('Note');
		}
		$this->applied_jobs_model->update_applied_job($job_id,$data); 

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>'. lang('Job application updated successfully').'.</div>');
		
		endd:
		
		redirect(base_url('app/employer/job_applications'));
	}

	public function send_link($job_id,$lnkname,$lnk)
	{
		if($job_id=="" || $lnkname=="" || $lnk=="")
			goto endd;

		$job=$this->db->query("SELECT * FROM tbl_seeker_applied_for_job WHERE ID='".$job_id."'")->result();
		if(count($job)<=0)
			goto endd;
		$job=$job['0'];
		$row_jobseeker 	= $this->job_seekers_model->get_job_seeker_by_id($job->seeker_ID);
		$row_employer 	= $this->employers_model->get_employer_by_id($this->session->userdata('user_id'));

		if(!$row_jobseeker || !$row_employer){
			echo lang('Something went wrong.');
			exit;	
		}
		$links['1']="https://openpsychometrics.org/tests/IPIP-BFFM/";
		$links['2']="https://openpsychometrics.org/tests/OEJTS/";
		$links['3']="https://openpsychometrics.org/tests/MGKT2/";
		$lnk=$links[$lnk];
		if(!$lnk){
			echo lang('Something went wrong.');
			exit;	
		}
		$lnkname=str_replace("%20"," ",$lnkname);
		$lnk=str_replace("%20"," ",$lnk);
		stp:
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$row_employer->ID' AND tbl_conversation.id_job_seeker='$row_jobseeker->ID'")->result();
		$curr_date=date("Y-m-d H:i:s");
		if(count($conv)<=0)
		{
			$this->db->query("INSERT INTO tbl_conversation SET id_employer='$row_employer->ID',id_job_seeker='$row_jobseeker->ID',created_at='$curr_date'");
			goto stp;
		}
		$conv=$conv['0'];

		$links=array();
		$sty="text-decoration: none;color: white;";
		$clk="showMe("."'".$lnkname."'".","."'".$lnk."'".")";
		$message="<i style='".$sty."' class='fa fa-link'>&nbsp;</i>
                  <a onclick=\"".$clk."\" style='".$sty."' href='#'>".lang('Personality test')."<br/><small>".$lnkname."</small></a>";
		$data_array = array(
		        'message' => $message,
		        'id_conversation' => $conv->id_conversation,
		        'id_sender' => $row_employer->ID,
		        'type_sender' => 'employers',
		        'sent_at' => $curr_date
		);
		// var_dump($data_array);
		// die();
		if($this->db->insert('tbl_conv_message', $data_array))
		{ 
			$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>'.lang('Success').'!</strong>'. lang('Message sent successfully').'.</div>');
		}
		endd:
		redirect(base_url('app/employer/job_applications'));
	}

	public function download($file_name){
		if($file_name==''){
			redirect(base_url('login'));
			exit;	
		}
		
					if (!file_exists(realpath(APPPATH . '../public/uploads/candidate/applied_job/'.$file_name))){
						echo 'Files does not exist on the server. <a href="javascript:;" onclick="window.history.back();">Back</a>';
						exit;
					}
					
		$data = file_get_contents(base_url("public/uploads/candidate/applied_job/".$file_name));
		force_download("Attached File_".$file_name, $data);
		exit;
	}


}
