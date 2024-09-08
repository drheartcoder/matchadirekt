<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();
	
	public function index(){
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$finalResumeData = $this->get_data();
		$this->outputData['data'] = $finalResumeData;
		$companyData = $this->My_model->getSingleRowData("tbl_companies","tbl_companies.company_name,tbl_companies.industry_ID,tbl_companies.company_logo,(select industry_name from tbl_job_industries where tbl_job_industries.ID = tbl_companies.industry_ID) industry","tbl_companies.ID =".$this->sessCompanyId);
		$this->outputData['companyData'] = $companyData;
		//myPrint($companyData);die;
		
		$this->load->view('newweb/employer/job_tiles_seeker_view',$this->outputData);
	}

	public function get_data(){
		$resumeData = $this->My_model->exequery("SELECT js.ID, js.first_name, js.gender, js.dob, js.city, js.country, js.dob, js.expected_salary, js.photo FROM tbl_job_seekers AS js WHERE js.sts = 'active' ORDER BY js.ID DESC");

		$invitedCandidates = array();
		$wishlistedCandidates = array();
		$rejectedCandidates = array();

		$invitedCandidates = $this->My_model->selTableData("tbl_requests_info","jobseeker_id as seeker_ID ","employer_id = ".$this->sessUserId);
		$wishlistedCandidates = $this->My_model->selTableData("tbl_employer_wishlisted_candidate","seeker_ID","employer_ID = ".$this->sessUserId);
		$rejectedCandidates = $this->My_model->selTableData("tbl_employer_rejected_candidate","seeker_ID","employer_ID = ".$this->sessUserId);

		$idsToExclude = array();
		$finalExclude = array();
		$finalResumeData = array();
		/*myPrint($invitedCandidates);
		myPrint($wishlistedCandidates);
		myPrint($rejectedCandidates);*/
		if(isset($invitedCandidates) && $invitedCandidates != ""){
			$idsToExclude = array_merge($idsToExclude,$invitedCandidates);
		}
		if(isset($wishlistedCandidates) && $wishlistedCandidates != ""){
			$idsToExclude = array_merge($idsToExclude,$wishlistedCandidates);
		}
		if(isset($rejectedCandidates) && $rejectedCandidates != ""){
			$idsToExclude = array_merge($idsToExclude,$rejectedCandidates);
		}

		if(isset($idsToExclude) && $idsToExclude != ""){
			foreach($idsToExclude as $exclude){
				array_push($finalExclude, $exclude->seeker_ID );
			}
		}


		//myPrint($finalExclude);exit;
		if(isset($resumeData) && $resumeData != ""){
			foreach($resumeData as $resume ){
				$count = count($finalResumeData);
				if($count < 3){
					if(!in_array($resume->ID, $finalExclude)){
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
						} else{
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

						array_push($finalResumeData, $resume);	
					}
				} else {
					return $finalResumeData;
				} 
			}
		} else {
			return $finalResumeData;
		}
	}
}
