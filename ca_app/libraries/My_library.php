<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_library {	
	
	public $outputdata 	= array();


	public function check_device(){
		$CI = & get_instance();	
		$CI->load->library('Mobile_Detect');
	    $detect = new Mobile_Detect();
	    if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
	       	header("Location: ".$CI->config->item('base_url')."/newapp"); exit;
	    }else{
	    	header("Location: ".$CI->config->item('base_url')."/newweb"); exit;
	    }
	}

	public function check_user_login(){
		$CI = & get_instance();	
		//echo $CI->session->userdata("sessUserId");exit;
		//echo $CI->session->userdata('sessUserId');exit;
		if($CI->session->userdata("sessUserId") > 0){
			$CI->sessUserId		=	$CI->session->userdata("sessUserId");
			$CI->sessUserEmail	 =	$CI->session->userdata("sessUserRole");
			$CI->sessFirstName	=	$CI->session->userdata("sessFirstName");
			$CI->sessSlug		=	$CI->session->userdata("sessSlug");
			$CI->sessIsLogin	=	$CI->session->userdata("sessIsLogin");
			$CI->sessIsJobSeeker=	$CI->session->userdata("sessIsJobSeeker");
			$CI->sessIsEmployer	=	$CI->session->userdata("sessIsEmployer");
			$CI->sessRole		=	$CI->session->userdata("sessRole");
			$CI->sessCompanyId		=	$CI->session->userdata("sessCompanyId");
			$CI->site_lang		=	"en";
			/*if($CI->sessIsJobSeeker == 1){
				redirect(APPURL."/seeker/home");
			}else if($CI->sessIsEmployer == 1){
				redirect(APPURL."/employer/home");
			}*/

		} else {
			redirect(WEBURL."/login");
		}
	}

	/*public function check_login(){
		$CI = &get_instance();	
		//	echo $CI->session->userdata(PREFIX."sessAuthId");exit;
		if($CI->session->userdata(PREFIX."sessAuthId") > 0){
			
			$CI->sessAuthId		=	$CI->session->userdata(PREFIX.'sessAuthId');
			$CI->sessName	 	=	$CI->session->userdata(PREFIX.'sessName');
			$CI->sessEmail		=	$CI->session->userdata(PREFIX."sessEmail");
			$CI->sessRole		=	$CI->session->userdata(PREFIX."sessRole");
		} else {
			redirect(BASEURL."/dashboard/login");
		}
	}*/

	public function _doUpload($uploadSettings) {
		$CI = &get_instance();	
		
		$CI->load->library('upload', $uploadSettings);
		$CI->upload->initialize($uploadSettings);
		if ( !$CI->upload->do_upload($uploadSettings['inputFieldName'])){
			$error = array('error' => $CI->upload->display_errors());
			return 0;	
		} else {
			$data = array('upload_data' => $CI->upload->data());
			return 1;
		}
	}

}