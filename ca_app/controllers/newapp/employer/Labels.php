<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Labels extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index(){
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_labels WHERE company_id='".$this->sessCompanyId."' AND deleted='0'")->result();
		if($results_un=$this->getArchivedUncategorizedJob())
		{
			$inserted=$this->frow(count($results_un));
			$results=array_merge(array($inserted),$results);
		}
		$data['results_un']=$results_un;
		$data['results']=$results;
		$this->load->view('employer/labels_view',$data);
	}

	private function getArchivedUncategorizedJob()
	{
		$id=$this->sessUserId;
		$results=$this->db->query("SELECT * FROM tbl_post_jobs 
			WHERE tbl_post_jobs.ID NOT IN (SELECT tbl_labels_dtl.fk_id FROM tbl_labels_dtl 
			    INNER JOIN tbl_labels ON tbl_labels.ID=tbl_labels_dtl.label_id WHERE tbl_labels.company_id='$id' AND tbl_labels_dtl.fk_type='post_jobs' AND tbl_labels.deleted='0' AND tbl_labels_dtl.deleted='0')
			AND tbl_post_jobs.sts='archive'
			AND tbl_post_jobs.employer_ID='$id'")->result();
		return $results;
	}
	

	/*public function label_details($id=0)
	{
		$data['un']="";
		if($id!=0)
		{
			$row=$this->db->query("SELECT * FROM tbl_labels WHERE company_id='".$this->session->userdata('user_id')."' AND ID='$id' AND deleted='0'")->result();
			if(!$row)
				redirect(base_url());
			$results=$this->db->query("SELECT tbl_labels_dtl.* FROM tbl_labels_dtl INNER JOIN tbl_labels ON tbl_labels.ID=tbl_labels_dtl.label_id WHERE tbl_labels.company_id='".$this->session->userdata('user_id')."' AND tbl_labels.deleted='0' AND tbl_labels_dtl.deleted='0' AND tbl_labels.ID='$id' ORDER BY tbl_labels_dtl.created_at DESC")->result();
			$frow=$row['0'];
		}
		else
		{
			if(!$results=$this->getArchivedUncategorizedJob())
				redirect(base_url('employer/labels'));
			$data['un']="true";
			$frow=$this->frow(count($results));
		}
		$data['results']=$results;
		$data['rowLabel']=$frow;
		$this->load->view('employer/labels_details_view',$data);
	}

	public function archive_job($jobId = 0,$type= '', $redirectTo = 0){
		$statut="archive";
		$this->db->query("UPDATE `tbl_post_jobs` SET `sts` = '".$statut."' WHERE `tbl_post_jobs`.`ID` = ".$jobId." and employer_ID= ".$this->sessUserId);

		$curr_date=date("Y-m-d H:i:s");
		$label=$this->input->post('label');
		$results=$this->db->query("SELECT * FROM tbl_labels WHERE tbl_labels.company_id='".$this->session->userdata('user_id')."' AND tbl_labels.deleted='0' AND tbl_labels.ID='$label'")->result();
		if(!$results)
			redirect(APPURL."/employer/home");			
		$this->db->query("INSERT INTO tbl_labels_dtl SET fk_id='$id',fk_type='$type',label_id='$label',deleted='0',created_at='$curr_date'");
		if($type=="post_jobs")
		{
			redirect(APPURL.'/employer/labels/archived-jobs/'.$id.'/'.$label);
		}

		redirect(APPURL.'/employer/label_details/'.$label);

	}
*/
	public function label_details_add($id,$type)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$curr_date=date("Y-m-d H:i:s");
		$label=$this->input->post('label');
		$results=$this->db->query("SELECT * FROM tbl_labels WHERE tbl_labels.company_id='".$this->sessUserId."' AND tbl_labels.deleted='0' AND tbl_labels.ID='$label'")->result();
		if(!$results)
			redirect(base_url());			
		$this->db->query("INSERT INTO tbl_labels_dtl SET fk_id='$id',fk_type='$type',label_id='$label',deleted='0',created_at='$curr_date'");
		if($type=="post_jobs")
		{
			redirect(APPURL.'/employer/job/archive_job/'.$id.'/'.$label);
		}
		//redirect(base_url('employer/label_details/'.$label));
	}


}
