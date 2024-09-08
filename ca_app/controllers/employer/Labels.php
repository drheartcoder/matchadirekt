<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Labels extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index()
	{
		$results_un="";
		$results=$this->db->query("SELECT * FROM tbl_labels WHERE company_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
		if($results_un=$this->getArchivedUncategorizedJob())
		{
			$inserted=$this->frow(count($results_un));
			$results=array_merge(array($inserted),$results);
		}
		$data['results_un']=$results_un;
		$data['results']=$results;
		$this->load->view('employer/labels_view',$data);
	}
	private function array_to_object($array) 
	{
	    return (object) $array;
	}
	
	public function label_details($id=0)
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
	private function frow($count)
	{
		$curr_date=date("Y-m-d H:i:s");
		$inserted=array();
		$inserted['ID']="0";
		$inserted['label']=lang("Uncategorized")." (".$count.")";
		$inserted['description']="";
		$inserted['created_at']=$curr_date;
		$inserted=$this->array_to_object($inserted);
		return $inserted;
	}
	private function getArchivedUncategorizedJob()
	{
		$id=$this->session->userdata('user_id');
		$results=$this->db->query("SELECT * FROM tbl_post_jobs 
WHERE tbl_post_jobs.ID NOT IN (SELECT tbl_labels_dtl.fk_id FROM tbl_labels_dtl 
        INNER JOIN tbl_labels ON tbl_labels.ID=tbl_labels_dtl.label_id WHERE tbl_labels.company_id='$id' AND tbl_labels_dtl.fk_type='post_jobs' AND tbl_labels.deleted='0' AND tbl_labels_dtl.deleted='0')
 AND tbl_post_jobs.sts='archive'
 AND tbl_post_jobs.employer_ID='$id'")->result();
		return $results;
	}
	
	public function label_details_del($id)
	{
		$curr_date=date("Y-m-d H:i:s");
		$results=$this->db->query("SELECT tbl_labels.ID FROM tbl_labels_dtl INNER JOIN tbl_labels ON tbl_labels.ID=tbl_labels_dtl.label_id WHERE tbl_labels.company_id='".$this->session->userdata('user_id')."' AND tbl_labels.deleted='0' AND tbl_labels_dtl.deleted='0' AND tbl_labels_dtl.ID='$id'")->result();
		if(!$results)
			redirect(base_url());
		$this->db->query("UPDATE tbl_labels_dtl SET deleted='1',created_at='$curr_date' WHERE tbl_labels_dtl.ID = '$id'");
		redirect(base_url('employer/label_details/'.$results['0']->ID));
	}
	
	public function label_details_add($id,$type)
	{
		$curr_date=date("Y-m-d H:i:s");
		$label=$this->input->post('label');
		$results=$this->db->query("SELECT * FROM tbl_labels WHERE tbl_labels.company_id='".$this->session->userdata('user_id')."' AND tbl_labels.deleted='0' AND tbl_labels.ID='$label'")->result();
		if(!$results)
			redirect(base_url());			
		$this->db->query("INSERT INTO tbl_labels_dtl SET fk_id='$id',fk_type='$type',label_id='$label',deleted='0',created_at='$curr_date'");
		if($type=="post_jobs")
		{
			redirect(base_url('employer/my_posted_jobs/archive_job/'.$id.'/'.$label));
		}
		redirect(base_url('employer/label_details/'.$label));
	}
	public function add()
	{
		$label=$this->input->post('label');
		$description=$this->input->post('description');
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("INSERT INTO tbl_labels SET label = '$label',company_id='".$this->session->userdata('user_id')."',description='$description',created_at='$curr_date'");
		redirect(base_url('employer/labels'));
	}
	public function update($id)
	{
		$label=$this->input->post('label');
		$description=$this->input->post('description');
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_labels SET label = '$label',description='$description',created_at='$curr_date' WHERE tbl_labels.ID = '$id'AND company_id='".$this->session->userdata('user_id')."'");
		redirect(base_url('employer/labels'));
	}
	
	public function delete($id)
	{
		$curr_date=date("Y-m-d H:i:s");
		$this->db->query("UPDATE tbl_labels SET deleted='1',created_at='$curr_date' WHERE tbl_labels.ID = '$id' AND company_id='".$this->session->userdata('user_id')."'");
		redirect(base_url('employer/labels'));
	}
}
