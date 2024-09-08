<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class job_details extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index($url="")
	{
		$data['title_app'] = "Job Details";
		$data['ads_row'] = $this->ads;		
		$job_url = $url;
		$is_apply = $this->input->get('apply');
		$is_scam = $this->input->get('sc');
		$is_already_applied = '';
		if($job_url==''){
			redirect(base_url('app/Jobs'),'');
            
                exit;
		}
		
		if($is_apply=='yes' && $this->session->userdata('is_job_seeker')!=TRUE && $this->session->userdata('is_employer')!=TRUE){
			$this->session->set_userdata('back_from_user_login', $this->uri->uri_string);
			redirect(base_url('app/User'),'');
           
			exit;	
		}
		
		
		if($is_scam=='yes' && $this->session->userdata('is_job_seeker')!=TRUE && $this->session->userdata('is_employer')!=TRUE){
			$this->session->set_userdata('back_from_user_login', $this->uri->uri_string.'?sc=yes');
						redirect(base_url('app/User'),'');
            
			exit;	
		}
		
		$job_url_array = explode('-',$job_url);
		$job_url_array_reverse = array_reverse($job_url_array);
		$job_id = trim($job_url_array_reverse[0]);
		if(!is_numeric($job_id)){
			redirect(base_url('app/Jobs'),'');
			exit;	
		}
		$row_posted_job = $this->posted_jobs_model->get_active_posted_job_by_id($job_id);
		if(!$row_posted_job){
			redirect(base_url('app/Jobs'),'');
            
			return;
		}
		$currently_opened_jobs = $this->posted_jobs_model->count_active_opened_jobs_by_company_id($row_posted_job->CID);
	
		
		$company_logo = ($row_posted_job->company_logo)?$row_posted_job->company_logo:'thumb/no_pic.jpg';
				if (!file_exists(realpath(APPPATH . '../public/uploads/employer/'.$company_logo))){
					$company_logo='thumb/no_pic.jpg';
				}


		
		if(!$row_posted_job){
			redirect(base_url('app/Jobs'),'');
			exit;
		}
		
		$can_apply = ($row_posted_job->last_date > date("Y-m-d")?'yes':'no');
		
		if($this->session->userdata('is_user_login')==TRUE){
			$is_already_applied = $this->applied_jobs_model->get_applied_job_by_seeker_and_job_id($this->session->userdata('user_id'), $job_id);
			$is_already_applied = ($is_already_applied>0)?'yes':'no';
			$data['result_salaries'] = $this->salaries_model->get_all_records();
			$data['result_resume'] = $this->resume_model->get_records_by_seeker_id($this->session->userdata('user_id'));
		}
		$tt = explode(', ',$row_posted_job->required_skills);
		$data['required_skills'] = explode(', ',$row_posted_job->required_skills);
		$data['row_posted_job'] = $row_posted_job;
		$data['company_logo'] = $company_logo;
		$data['is_apply'] = $is_apply;
		$data['can_apply'] = $can_apply;
		$data['is_already_applied'] = $is_already_applied;
		$data['currently_opened_jobs'] = $currently_opened_jobs;
		$data['title'] = $row_posted_job->job_title.' Job in '.$row_posted_job->company_name.' - '.$row_posted_job->city;
		$data['cpt_code'] = create_ml_captcha();

		$data['result_files']=$this->db->query("SELECT * FROM tbl_employer_files WHERE private='no' AND job_ID='".$row_posted_job->ID."' AND deleted='0'")->result();


		$applications=[];
		if($this->session->userdata('user_id')==$row_posted_job->CID && $this->session->userdata('is_employer')==TRUE){
			
			$rows = $this->applied_jobs_model->get_applied_job_by_job_id($job_id);
			
			$data['applications']=$rows;
        
 
		}



		$this->load->view('application_views/job_details_view',$data);
        
	}
	
}
