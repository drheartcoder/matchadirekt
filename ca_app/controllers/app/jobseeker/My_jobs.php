<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_Jobs extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$data['title_app'] = "My Jobs";
		$data['ads_row'] = $this->ads;
		$data['title'] = SITE_NAME.': My Jobs';
		
		//Additional Info
		$row_additional = $this->jobseeker_additional_info_model->get_record_by_userid($this->session->userdata('user_id'));
		
		//Skills
		$keywords = $this->jobseeker_skills_model->count_jobseeker_skills_by_seeker_id($this->session->userdata('user_id'));
		$is_keywords_provided = $keywords;
		
		if($is_keywords_provided<3){
			  redirect(base_url('app/jobseeker/Add_skills'));
			  exit;
		}
		
		//Pagination starts
		$total_rows = $this->applied_jobs_model->count_applied_job_jobseeker_id($this->session->userdata('user_id'));
		$config = pagination_configuration(base_url("app/jobseeker/my_jobs"), $total_rows, 50, 3, 5, true);
		
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(3) : 0;
		$page_num = $page-1;
		$page_num = ($page_num<0)?'0':$page_num;
		$page = $page_num*$config["per_page"];
		$data["links"] = $this->pagination->create_links();
		//Pagination ends
		
		//Applied Jobs by Employer ID
		$result_applied_jobs = $this->applied_jobs_model->get_applied_jobs_by_jobseeker_id($this->session->userdata('user_id'), $config["per_page"], $page);
		$data['result_applied_jobs']= $result_applied_jobs;
		$this->load->view('application_views/jobseeker/my_jobs_view',$data);
	}
	

	public function download($file_name){
		if($file_name==''){
            redirect(base_url()."app/User/login"); 
			exit;	
		}
		 $path=realpath(APPPATH . '../public/uploads/candidate/applied_job/'.$file_name);
		if (!file_exists($path)){
			echo 'Files does not exist on the server. <a href="javascript:;" onclick="window.history.back();">Back</a>';
			exit;
		}
					
		$data = file_get_contents($path);
		
		force_download($file_name, $data);
		//die('ffff');
		
		exit;
	}


	public function withdraw($applied_job_id){
		if($applied_job_id==''){
            redirect(base_url()."app/User/login"); 
			exit;	
		}
		$this->db->query("UPDATE tbl_seeker_applied_for_job SET withdraw='1' WHERE ID=$applied_job_id");
		redirect(base_url('app/jobseeker/My_jobs'));
	}
}
