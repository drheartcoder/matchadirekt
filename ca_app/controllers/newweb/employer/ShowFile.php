<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Showfile extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		redirect(WEBURL."/employer/home");
	}
	

	public function download($file_name){
		if($file_name==''){
			redirect(WEBURL."/employer/home");
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

	//public/uploads/candidate/applied_job/
	public function show($file_name,$par){

		if($file_name=='' || $par==''){
			redirect(base_url('login'));
			exit;	
		}

		$pathToDownload="";
		switch ($par) {
			case 1:
				$pathToDownload="public/uploads/candidate/applied_job/";
				break;
			
			case 2:
				$pathToDownload="public/uploads/candidate/resumes/";
				break;
			
			case 3:
				$pathToDownload="public/uploads/chat/";
				break;

			case 4:
				$pathToDownload="public/uploads/employer/files/";
				break;
		}

 		$data['title']="BiXma Job System - File Preview";
		$data['redirect']='1';
		$data['echo']='';
 		$data['path']=base_url($pathToDownload.$file_name);

		$this->load->view('application/employer/showfile_view',$data);


	}
	public function showRang($app_id)
	{
		if($app_id==''){
			redirect(base_url('login'));
			exit;	
		}
		$pathToDownload="public/uploads/candidate/applied_job/";
		$whr="";
		$echo="";
		if($app_id>0)
			$whr="AND tbl_seeker_applied_for_job.ID='$app_id'";
		$files=$this->db->query("SELECT tbl_post_jobs.ID AS jobID,tbl_post_jobs.job_title,file_name 
								 FROM tbl_seeker_applied_for_job 
								 LEFT JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID 
								 WHERE tbl_seeker_applied_for_job.employer_ID='".$this->session->userdata('user_id')."'  
								 AND file_name<>'' AND file_name<>'$*_,_*$' 
								 $whr ")->result();
		foreach ($files as $file_row) 
		{
			$echo="";
			 $filenames=explode("$*_,_*$", $file_row->file_name);
	         for($i=0;$i<count($filenames);$i++)
	         {
				$echo="<hr/>".$file_row->job_title."<br/>";
	              if($i!=count($filenames)-1)
	                $echo.="<br/>";
				$data['path']=base_url($pathToDownload.$filenames[$i]);
				$data['redirect']='0';
				$data['echo']=$echo;
				$this->load->view('application/employer/showfile_view',$data);
	         }
		}
	}
}
