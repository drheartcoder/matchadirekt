<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Controller {
	
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
		$param='';		
		$param = strip_tags($param);
		$obj_result = $this->resume_model->get_searched_resume($param, 20, 0);
		//Seeker search Group By City
		$seekerCountry = $this->My_model->exequery('SELECT count(ID) score, `country` from tbl_job_seekers WHERE `country`=tbl_job_seekers.`country` GROUP BY `country`');
		$seekerCity = $this->My_model->exequery('SELECT count(ID) score, `city` from tbl_job_seekers WHERE `city`=tbl_job_seekers.`city` GROUP BY `city`');

		//Seeker search by Designation
		$seekerByDesig = $this->My_model->exequery("SELECT count(ID) score, job_title from tbl_seeker_experience WHERE job_title=tbl_seeker_experience.job_title GROUP BY job_title");	

		//Seeker search by Salary Expectation

		$seekerByExpect = $this->My_model->exequery("SELECT count(ID) score, `expected_salary` FROM `tbl_job_seekers` WHERE `expected_salary`=tbl_job_seekers.`expected_salary` GROUP BY `expected_salary`");

		//myPrint($seekerByExpect);die;

		$this->outputData['seekerCountry']=$seekerCountry;
		$this->outputData['seekerCity']=$seekerCity;
		$this->outputData['seekerByDesig']=$seekerByDesig;
		$this->outputData['seekerByExpect']=$seekerByExpect;
		$this->outputData['obj_result']=$obj_result;
		$this->outputData['param'] = $param;
		//myPrint($obj_result);die;

		$this->load->view('newweb/employer/search_candidate_view',$this->outputData);
	}

	public function getSeekerData(){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);


		$searchName= $_POST['searchName'];
		$selSeekerCity= $_POST['selSeekerCity'];
		$selSeekerDesig= $_POST['selSeekerDesig'];
		$selSeekerSalExp= $_POST['selSeekerSalExp'];
		$selSeekerCountry= $_POST['selSeekerCountry'];

		$seekerCond='1';
		$cityCond='1';
		$desigCond='1';
		$salCond='1';
		$returnString="";

		if($searchName  != ""){
			$seekerCond = " tbl_job_seekers.first_name LIKE '".$searchName."%'";			
		}
		if($selSeekerCity  != ""){
			$cityCond = " tbl_job_seekers.city = '".$selSeekerCity."'"; 
		}
		if($selSeekerCountry  != ""){
			$countryCond = " tbl_job_seekers.country = '".$selSeekerCountry."'"; 
		}

		if($selSeekerSalExp  != ""){
			$salCond = " tbl_job_seekers.expected_salary = '".$selSeekerSalExp."'"; 
		}
		if($selSeekerDesig  != ""){

			$desigCond = " tbl_seeker_experience.job_title = '".$selSeekerDesig."'"; 
		}



		$seekerData=$this->db->query("SELECT tbl_job_seekers.`ID`, tbl_job_seekers.`first_name`,tbl_job_seekers.`city`,tbl_job_seekers.`expected_salary`,tbl_job_seekers.`dated`, tbl_seeker_experience.job_title FROM `tbl_job_seekers` left join tbl_seeker_experience ON tbl_seeker_experience.`seeker_ID` = tbl_job_seekers.`ID` where tbl_job_seekers.`sts` = 'active' AND ".$seekerCond." AND ".$cityCond." AND ".$salCond." AND ".$desigCond)->result();
		//myPrint($seekerData);exit;
		if(isset($seekerData) && $seekerData != ""){
			foreach($seekerData as $seeker){
				$date =  date_formats($seeker->dated, 'd M , Y');
                $returnString .='<li class="job-main p-3 mb-3">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-9 col-sm-7 col-lg-7 text-left">
                                          <a href="'.WEBURL.'/employer/candidate/candidate-full-post/'.$this->custom_encryption->encrypt_data($seeker->ID ).'/7" class="d-block">
                                        <h3 class="mb-2 j-title card-title">'. $seeker->first_name.'</h3>
                                        <h4 class="mb-1 comp-name text-blue card-subtitle">'. $seeker->city.'</h4>
                                        <p class="mb-1 j-date">'.$date.'</p>
                                        <p class="mb-1 j-desc">'. $seeker->expected_salary.'</p>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </li>';
			}
		} else {
			  $returnString .='<li class="job-main p-3 mb-3">
	                            <div class="col-12">
	                                <div class="row">
	                                    <div class="col-9 col-sm-7 col-lg-7 text-left">
	                                        <a href="#" class="d-block">
	                                       		<h3 class="mb-2 j-title card-title">No Jobs found</h3>
	                                   		</a>
	                                    </div>
	                                </div>
	                            </div>
                        	</li>';	
		}
		echo json_encode($returnString);

	}

}
