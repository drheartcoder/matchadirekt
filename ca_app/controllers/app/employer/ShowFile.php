<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ShowFile extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		redirect(base_url('app/user/login'));
	}
	

	public function download($file_name){
		if($file_name==''){
			redirect(base_url('application_views/login_app'));
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
	public function show($file_name,$par='1'){

		if($file_name=='' || $par==''){
			redirect(base_url('app/login_app'));
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
 		$data['path']=base_url($pathToDownload.$file_name);

		$this->load->view('application_views/showFile_view',$data);

	}
}
