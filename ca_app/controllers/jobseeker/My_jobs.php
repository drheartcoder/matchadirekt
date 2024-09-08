<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_Jobs extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$data['ads_row'] = $this->ads;
		$data['title'] = SITE_NAME.': My Jobs';
		
		//Additional Info
		$row_additional = $this->jobseeker_additional_info_model->get_record_by_userid($this->session->userdata('user_id'));
		
		//Skills
		$keywords = $this->jobseeker_skills_model->count_jobseeker_skills_by_seeker_id($this->session->userdata('user_id'));
		$is_keywords_provided = $keywords;
		
		if($is_keywords_provided<3){
			  redirect(base_url('jobseeker/add_skills'));
			  exit;
		}
		
		//Pagination starts
		$total_rows = $this->applied_jobs_model->count_applied_job_jobseeker_id($this->session->userdata('user_id'));
		$config = pagination_configuration(base_url("jobseeker/my_jobs"), $total_rows, 50, 3, 5, true);
		
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
		$this->load->view('jobseeker/my_jobs_view',$data);
	}
	

	public function download($file_name){
		if($file_name==''){
			redirect(base_url('login'));
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
			redirect(base_url('login'));
			exit;	
		}
		$this->db->query("UPDATE tbl_seeker_applied_for_job SET withdraw='1' WHERE ID=$applied_job_id");
		redirect(base_url('jobseeker/my_jobs'));
	}
	public function delete_file($file_name,$applied_job_id){
		if($applied_job_id==''){
			redirect(base_url('login'));
			exit;	
		}
		$this->db->query("UPDATE tbl_seeker_applied_for_job SET file_name=REPLACE(file_name, '$file_name', '') WHERE ID=$applied_job_id");
		$this->db->query("UPDATE tbl_seeker_applied_for_job SET file_name=REPLACE(file_name, '$*_,_*$$*_,_*$', '$*_,_*$') WHERE ID=$applied_job_id");
	    redirect(base_url('jobseeker/my_jobs'));
	}
	public function add_file($applied_job_id){
		if($applied_job_id==''){
			redirect(base_url('login'));
			exit;	
		}


		$allowed_types = array('doc','docx','pdf','rtf','jpg','png','jpeg','txt','mp4','flv','avi','wmv','gif','3gp');
		
		$real_path = realpath(APPPATH . '../public/uploads/candidate/applied_job/');

		$attached_file="";
		$filesCount = 0;
		if(!empty($_FILES['attached_file']['name']))
			$filesCount = count($_FILES['attached_file']['name']);

        for($i = 0; $i < $filesCount; $i++)
        {
        	$_FILES['userFile']['name'] = $_FILES['attached_file']['name'][$i];
            $_FILES['userFile']['type'] = $_FILES['attached_file']['type'][$i];
            $_FILES['userFile']['tmp_name'] = $_FILES['attached_file']['tmp_name'][$i];
            $_FILES['userFile']['error'] = $_FILES['attached_file']['error'][$i];
            $_FILES['userFile']['size'] = $_FILES['attached_file']['size'][$i];
            $extention = get_file_extension($_FILES['userFile']['name']);
            if(in_array($extention,$allowed_types))
			{
				$config['upload_path'] = $real_path;
				$config['allowed_types'] = '*';
				$config['overwrite'] = true;
				$max_size=6000;
				$max_size=$this->db->query("SELECT * FROM tbl_settings")->result()['0']->upload_limit;
				$config['max_size'] = $max_size;
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('userFile'))
				{
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
					if($i!=0)
						$attached_file.="$*_,_*$";
					$attached_file.= $file_name;
				}
			}
        }
		$result_row=$this->db->query("SELECT file_name FROM tbl_seeker_applied_for_job WHERE ID=$applied_job_id")->result()['0'];
		if($result_row->file_name<>"")
			$file_name=$result_row->file_name."$*_,_*$".$file_name;

		$this->db->query("UPDATE tbl_seeker_applied_for_job SET file_name='$file_name' WHERE ID=$applied_job_id");
	    redirect(base_url('jobseeker/my_jobs'));
	}
}
