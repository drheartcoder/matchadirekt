<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Statistics extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();

	public function index(){

		$data['Ages']=[];
		$data['count_Primary']=0;
		$data['count_Success']=0;
		$data['count_Interview']=0;
		$data['status_series']="";
		$data['count_males']=0;
		$data['count_females']=0;
		$data['count_others']=0;
		$data['sexe_series']="";

	 

		$SQL="select 
					count(gender) AS count_gender,
					sum(CASE gender WHEN 'male' THEN 1 ELSE 0 END) male,
					sum(CASE gender WHEN 'female' THEN 1 ELSE 0 END) female,
					sum(CASE gender WHEN 'other' THEN 1 ELSE 0 END) other 
				from
					tbl_seeker_applied_for_job 
				inner join 
					tbl_post_jobs on tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID
				inner join 
					tbl_job_seekers on tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID 
				WHERE 
					tbl_seeker_applied_for_job.deleted=0 
				and 
					tbl_post_jobs.employer_id='".$this->session->userdata('user_id')."'";

		$row=$this->db->query($SQL)->result();
		if(!$row)
			goto enn;
		$row=$row['0'];
		$data['count_jobs']=$row->count_gender;
		$data['count_males']=$row->male*100/$row->count_gender;
		$data['count_females']=$row->female*100/$row->count_gender;
		$data['count_others']=$row->other*100/$row->count_gender;
		$data['sexe_series'].=$data['count_males']!="" ? $data['count_males']: '';
		$data['sexe_series'].=$data['count_females']!="" ? ',': '';
		$data['sexe_series'].=$data['count_females']!="" ? $data['count_females']: '';
		$data['sexe_series'].=$data['count_others']!="" ? ',': '';
		$data['sexe_series'].=$data['count_others']!="" ? $data['count_others']: '';

		enn:


		// Age 
		$SQL="select  TIMESTAMPDIFF(YEAR, dob, CURDATE()) age , count(dob) count
				 from tbl_seeker_applied_for_job 
				 inner join tbl_post_jobs on tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID 
				 inner join tbl_job_seekers on tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID
				 WHERE tbl_post_jobs.employer_id='".$this->session->userdata('user_id')."'
				 and tbl_seeker_applied_for_job.deleted=0 
				 group by age ";

		$rows=$this->db->query($SQL)->result();
		 if($rows)
		 {
		 	 foreach ($rows as $row) {
		 	 	$data['Ages'][$row->age]=$row->count;
		 	 }
		 }

		 //status

		$SQL="select count(*) AS count_status,
				 tbl_seeker_applied_for_job.flag 
				 from tbl_seeker_applied_for_job 
				 inner join tbl_post_jobs on tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID 
				 inner join tbl_job_seekers on tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID 
				WHERE tbl_post_jobs.employer_id='".$this->session->userdata('user_id')."' 
				and tbl_seeker_applied_for_job.deleted=0 
				GROUP BY tbl_seeker_applied_for_job.flag";

	
		
		$rows=$this->db->query($SQL)->result();
		 if($rows)
		 {
		 	foreach ($rows as $row) {
		 		$total+=$row->count_status;
		 	}

			foreach ($rows as $row) {
				if($row->flag){

					$data['count_'.$row->flag]=$row->count_status*100/$total;

				}else{

					$data['count_Primary']=$row->count_status*100/$total;
				}
				
			}
		 }
		
		//profession

		 $SQL="SELECT tbl_job_industries.industry_name,
		 		COUNT(tbl_post_jobs.ID) Nbr 
		 		from tbl_post_jobs
				left JOIN tbl_job_industries on tbl_job_industries.ID=tbl_post_jobs.industry_ID
				where tbl_post_jobs.employer_ID='".$this->session->userdata('user_id')."' 
				GROUP BY industry_name";

		$rows=$this->db->query($SQL)->result();
		 if($rows)
		 {

		 	foreach ($rows as $row) {
		 	 	$data['Professions'][$row->industry_name]=$row->Nbr;
		 	 }
		 }

		//myPrint($data);
		$this->load->view('newweb/employer/statistics_view',$data);
	}

}
