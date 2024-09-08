<?php


class PrintController extends CI_Controller {

	private $exportPath;
	public function __construct() {
		parent::__construct();
	   $this->load->database();

	   $this->exportPath=FCPATH.'Print';
	   

    }

	public function print($type){

		if(method_exists ($this , $type)){
			call_user_func(array($this , $type));
		}else{
			die();
		}
		 					
	}



	private function applications(){
		$user_id=$this->session->userdata('user_id');
		$cond="";
		if($this->input->get('name_ref'))
		{
			$vr="LIKE '%".$this->input->get('name_ref')."%'";
			$ijd=explode("JS", $this->input->get('name_ref'));
			if(count($ijd)>1)
				$ijd=$ijd['1'];
			else
				$ijd=0;
			$ijd=intval($ijd);
			$ijd>0?$ijd="OR tbl_job_seekers.ID ='".$ijd."'":$ijd='';
			$cond.=" AND ( first_name $vr OR last_name $vr $ijd )";
		}
		if($this->input->get('email'))
		{
			$vr="LIKE '%".$this->input->get('email')."%'";
			$cond.=" AND ( email $vr )";
		}
		if($this->input->get('gender'))
		{
			$vr="LIKE '%".$this->input->get('gender')."%'";
			$cond.=" AND ( gender $vr )";
		}
		if($this->input->get('city'))
		{
			$vr="LIKE '%".$this->input->get('city')."%'";
			$cond.=" AND ( tbl_job_seekers.city $vr )";
		}
		 
		 
		$result_applied_jobs=$this->db->query("SELECT tbl_seeker_applied_for_job.dated AS applied_date,tbl_job_seekers.ID AS job_seeker_ID, tbl_job_seekers.*,tbl_seeker_applied_for_job.*,tbl_post_jobs.* FROM tbl_seeker_applied_for_job INNER JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_seeker_applied_for_job.seeker_ID 
			WHERE tbl_post_jobs.employer_ID='".$this->session->userdata('user_id')."' 
			and tbl_seeker_applied_for_job.deleted=0
			AND (tbl_post_jobs.sts<>'archive' or tbl_post_jobs.sts is null )
			".$cond."
		ORDER BY tbl_seeker_applied_for_job.ID DESC")->result();
		 

		$data['applications']=$result_applied_jobs;

		$this->load->view('PrintApplication',$data);
		 
	 
		
	}


}

