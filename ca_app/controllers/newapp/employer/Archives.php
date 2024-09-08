<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Archives extends CI_Controller {
	
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
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_labels WHERE company_id='".$this->sessUserId."' AND deleted='0'")->result();
		if($results_un=$this->getArchivedUncategorizedJob())
		{
			$inserted=$this->frow(count($results_un));
			$results=array_merge(array($inserted),$results);
		}
		$this->outputData['results_un']=$results_un;
		$this->outputData['results']=$results;
		$this->load->view('application/employer/archives_list_view',$this->outputData);
	}

	public function add_archives(){
		if(isset($_POST['btnSubmit'])){
			$label=$this->input->post('label');
			$description=$this->input->post('description');
			$curr_date=date("Y-m-d H:i:s");
			$this->db->query("INSERT INTO tbl_labels SET label = '$label',company_id='".$this->sessUserId."',description='$description',created_at='$curr_date'");
			redirect(APPURL."/employer/archives");
		}

		$this->load->view('application/employer/add_archievs_view',$this->outputData);
	}

	public function edit($id = 0){
		$data = $this->My_model->getSingleRowData("tbl_labels","","ID = ".$id);
		if(isset($_POST['btnSubmit'])){
			$label=$this->input->post('label');
			$description=$this->input->post('description');
			$curr_date=date("Y-m-d H:i:s");
			$this->db->query("UPDATE tbl_labels SET label = '$label',description='$description'  WHERE tbl_labels.ID = '$id'AND company_id='".$this->sessUserId."'");
			redirect(APPURL."/employer/archives");
		}
		$this->outputData['data'] = $data;
		$this->load->view('application/employer/edit_archives_view',$this->outputData);
	}

	public function archived_job($id = 0){
		$this->outputData['un']="";
		if($id!=0)
		{
			$row=$this->db->query("SELECT * FROM tbl_labels WHERE company_id='".$this->sessUserId."' AND ID='$id' AND deleted='0'")->result();
			if(!$row)
				redirect(APPURL.'/employer/archives');
			$results=$this->db->query("SELECT tbl_labels_dtl.* FROM tbl_labels_dtl INNER JOIN tbl_labels ON tbl_labels.ID=tbl_labels_dtl.label_id WHERE tbl_labels.company_id='".$this->sessUserId."' AND tbl_labels.deleted='0' AND tbl_labels_dtl.deleted='0' AND tbl_labels.ID='$id' ORDER BY tbl_labels_dtl.created_at DESC")->result();
			$frow=$row['0'];
		} else {
			if(!$results=$this->getArchivedUncategorizedJob())
				redirect(APPURL.'/employer/archives');
			$this->outputData['un']="true";
			$frow=$this->frow(count($results));
		}
		//echo $frow;
		/*myPrint($results);
		exit;*/
		$this->outputData['results']=$results;
		$this->outputData['rowLabel']=$frow;
		$this->outputData['archiveId']=$id;

		$this->load->view('application/employer/archived_job_view',$this->outputData);
	}

	public function frow($count)
	{
		$curr_date=date("Y-m-d H:i:s");
		$inserted=array();
		$inserted['ID']="0";
		$inserted['label']=("Uncategorized")." (".$count.")";
		$inserted['description']="";
		$inserted['created_at']=$curr_date;
		$inserted=$this->array_to_object($inserted);
		return $inserted;
	}

	public function restore($id = 0,$archiveId = 0)
	{	
		//echo $id;
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		$status = "active";
		//exit;
		$this->db->query("UPDATE `tbl_post_jobs` SET `sts` = '".$status."' WHERE `tbl_post_jobs`.`ID` = ".$id." and employer_ID=  ".$this->sessUserId);
		// echo $this->db->last_query();
		// exit;
		redirect(APPURL.'/employer/archives/archived-job/'.$archiveId);
		
	}

	public function delete_detail_archive_job($id= 0){
		$curr_date=date("Y-m-d H:i:s");
		$results=$this->db->query("SELECT tbl_labels.ID FROM tbl_labels_dtl INNER JOIN tbl_labels ON tbl_labels.ID=tbl_labels_dtl.label_id WHERE tbl_labels.company_id='".$this->sessUserId."' AND tbl_labels.deleted='0' AND tbl_labels_dtl.deleted='0' AND tbl_labels_dtl.ID='$id'")->result();
		if(!$results)
			redirect(APPURL);
		
		$this->db->query("UPDATE tbl_labels_dtl SET deleted='1',created_at='$curr_date' WHERE tbl_labels_dtl.ID = '$id'");
		redirect(APPURL.'/employer/archives/archived-job/'.$results['0']->ID);
	}

	public function getArchivedUncategorizedJob()
	{
		$id=$this->sessUserId;
		$results=$this->db->query("SELECT * FROM tbl_post_jobs 
		WHERE tbl_post_jobs.ID NOT IN (SELECT tbl_labels_dtl.fk_id FROM tbl_labels_dtl 
		        INNER JOIN tbl_labels ON tbl_labels.ID=tbl_labels_dtl.label_id WHERE tbl_labels.company_id='$id' AND tbl_labels_dtl.fk_type='post_jobs' AND tbl_labels.deleted='0' AND tbl_labels_dtl.deleted='0')
		 AND tbl_post_jobs.sts='archive'
		 AND tbl_post_jobs.employer_ID='$id'")->result();
		return $results;
	}

	public function array_to_object($array) 
	{
	    return (object) $array;
	}

	public function delete($id)
	{
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_labels SET deleted='1',created_at='$curr_date' WHERE tbl_labels.ID = '$id' AND company_id='".$this->sessUserId."'");
		redirect(APPURL."/employer/archives");
	}
}
