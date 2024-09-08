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
		$param = "";//str_replace('-',' ', $this->uri->segment(2));

		//Group By Title
	//	$title_group = $this->posted_jobs_model->get_searched_group_by_title($param);

		$title_group = $this->My_model->exequery("SELECT count(ID) score, job_title from tbl_post_jobs WHERE job_title=tbl_post_jobs.job_title AND `deleted`=0 GROUP BY job_title");	

		//myPrint($job_title_group);die;
		
		//Group By City
		$city_group = $this->My_model->exequery("SELECT count(ID) score, city from tbl_post_jobs WHERE city=tbl_post_jobs.city AND `deleted`=0 GROUP BY city");	

		//$city_group = $this->posted_jobs_model->get_searched_group_by_city($param);
		//$city_group = $this->My_model->exequery('SELECT count(ID) score, `city` from tbl_post_jobs WHERE `city`=tbl_post_jobs.`city` GROUP BY `city`');
		
		//Group By Companies
		$company_group = $this->posted_jobs_model->get_searched_group_by_company($param);
		//myPrint($company_group);die;
		// SELECT COUNT(ID) score,company_slug ,company_name
		// FROM tbl_companies
		// GROUP BY company_name;
		// $company_group = $this->My_model->exequery('SELECT count(ID) score, `company_name` from tbl_companies WHERE `company_name`=tbl_companies.`company_name` AND tbl_companies.`sts`='active' GROUP BY `company_name`');

		//Group By Salary Range
		$salary_range_group = $this->posted_jobs_model->get_searched_group_by_salary_range($param);
			
			//myPrint($company_group);exit;
		$this->outputData['title_group'] = $title_group;
		$this->outputData['city_group'] = $city_group;
		$this->outputData['company_group'] = $company_group;
		$this->outputData['salary_range_group'] = $salary_range_group;
		$this->load->view('newweb/seeker/search_job_view',$this->outputData);
	}

	public function getJobData(){
		$selJobTitle = $_POST['selJobTitle'];
		$selCity = $_POST['selCity'];
		$selCompany = $_POST['selCompany'];
		$selSal = $_POST['selSal'];
		$compCond  = "1";
		$titleCond  = "1";
		$cityCond = "1";
		$salCond = "1";
		$returnString = "";
		if($selCompany  != ""){
			$compData = $this->My_model->getSingleRowData( "tbl_companies","ID" ,"company_slug = '".$selCompany."' ");
			$compId  = $compData->ID;
			$compCond = " tbl_post_jobs.company_ID = ".$compId; 
		}
		if($selJobTitle != ""){
			$titleCond = " tbl_post_jobs.job_title = '".$selJobTitle."'";
		}
		if($selCity != ""){
			$cityCond = " tbl_post_jobs.city = '".$selCity."'";
		}
		if($selSal != ""){
			$salCond = " tbl_post_jobs.pay = '".$selSal."'";
		}
		
		$jobData = $this->db->query("select tbl_post_jobs.ID, tbl_post_jobs.job_title, tbl_post_jobs.pay, tbl_post_jobs.country,  tbl_post_jobs.job_slug,  tbl_post_jobs.country,  tbl_post_jobs.dated,  tbl_post_jobs.last_date,  tbl_post_jobs.city,  tbl_post_jobs.experience ,  tbl_post_jobs.job_description,  tbl_companies.company_name  from  tbl_post_jobs left join tbl_companies on tbl_companies.ID = tbl_post_jobs.company_ID where tbl_post_jobs.deleted = 0 AND DATE(tbl_post_jobs.last_date) >= CURDATE()  AND ".$compCond." AND ".$titleCond." AND ".$cityCond." AND ".$salCond)->result();

		if(isset($jobData) && $jobData != ""){
			foreach($jobData as $job){
				$date =  date_formats($job->dated, 'd M , Y');
                $returnString .='<li class="job-main p-3 mb-3">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-9 col-sm-7 col-lg-7 text-left">
                                          <a href="'.WEBURL.'/seeker/home/job-details/'.$job->ID.'" class="d-block">
                                        <h3 class="mb-2 j-title card-title">'. $job->job_title.'</h3>
                                        <h4 class="mb-1 comp-name text-blue card-subtitle">'. $job->company_name.', <span>'. $job->country.','. $job->city.'</span></h4>
                                        <p class="mb-1 j-date">'.$date.'</p>
                                        <p class="mb-1 j-desc">'. substr($job->job_description, 0, 100).'</p>
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
	//	myPrint($jobData);

	}


	public function is_already_applied_for_job($user_id='', $job_id){
		$is_already_applied = '';
		if($this->session->userdata('is_job_seeker')==TRUE){
			$is_already_applied = $this->applied_jobs_model->get_applied_job_by_seeker_and_job_id($user_id, $job_id);
			$is_already_applied = ($is_already_applied>0)?'yes':'no';
		}	
		return $is_already_applied;
	}

}
