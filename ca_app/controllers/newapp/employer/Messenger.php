<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Messenger extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
    
	public $outputData = array();
	public function index($id=''){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		$convs=$this->db->query("SELECT * FROM tbl_conversation INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_conversation.id_job_seeker WHERE id_employer='$this->sessUserId'")->result();

		$this->outputData['convs']=$convs;
		//myPrint($convs);die;
		$this->load->view('application/employer/messenger_view',$this->outputData);
	}


	public function chat($id=''){

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		$this->db->query("UPDATE `tbl_conversation` SET `isNewForEmployer`=0 WHERE id_conversation = ".$id);
		$this->outputData['convs']='';
		$this->outputData['messages']='';
		$this->outputData['nothing']=0;
		//	$this->outputData['title']=lang('Chat').' | '.SITE_NAME;
		/*if($this->sessUserId !=TRUE && $this->sessUserId('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $this->outputData);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg', 'Please login as a employer to view the candidate profile.');
			redirect(APPURL.'/login');
			return;	
		}*/

		$employer_ = $this->employers_model->get_employer_by_id($this->sessUserId);
		$convs=$this->db->query("SELECT * FROM tbl_conversation INNER JOIN tbl_job_seekers ON tbl_job_seekers.ID=tbl_conversation.id_job_seeker WHERE id_employer='$employer_->ID'")->result();
		if($id=="" && count($convs)>0)

		{
				redirect(APPURL."/employer/messenger/chat/".$convs['0']->id_conversation);
			// redirect(APPURL.'/employer/messenger/'.$convs['0']->id_conversation);
		}
		$conv=$this->db->query("SELECT * FROM tbl_conversation WHERE id_conversation='$id' AND id_employer='$employer_->ID'")->result();
		if(count($conv)<=0){
			$this->outputData['nothing']=1;
			$this->load->view('application/employer/messenger_view', $this->outputData);
			return;	
		}
		$conv=$conv['0'];
		$this->outputData['convs']=$convs;
		$messages=$this->db->query("SELECT * FROM tbl_conv_message WHERE id_conversation='$conv->id_conversation'")->result();
		$job_seeker=$this->job_seekers_model->get_job_seeker_by_id($conv->id_job_seeker);
		$this->outputData['messages']=$messages;
		$this->outputData['employer']=$employer_;
		$this->outputData['job_seeker']=$job_seeker;

		$this->load->view('application/employer/messenger_chat_view',$this->outputData);
	}

	public function download($file_name){
		if($file_name==''){
			redirect(APPURL.'/login');
			exit;	
		}
		
		if (!file_exists(realpath(APPPATH . '../public/uploads/chat/'.$file_name))){
			echo 'Files does not exist on the server. <a href="javascript:;" onclick="window.history.back();">Back</a>';
			exit;
		}
					
		$data = file_get_contents(base_url("public/uploads/chat/".$file_name));
		force_download("Attached File_".$file_name, $data);
		exit;
	}


	public function send_message($id) {
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		/*if($id==''){
			$this->load->view('404_view', $data);
			return;	
		}*/
				
		/*if($this->session->userdata('is_employer')!=TRUE && $this->session->userdata('is_admin_login')!=TRUE){
			//$this->load->view('404_view', $data);
			$this->session->set_userdata('back_from_user_login',$this->uri->uri_string);
			$this->session->set_flashdata('msg','Please login as a employer to view the candidate profile.');
			redirect(APPURL.'/login');
			return;	
		}*/
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		
		$row = $this->job_seekers_model->get_job_seeker_by_id($decrypted_id);
		
		if(!$row){
			//$this->load->view('404_view', $data);
			return;		
		}
		


		if(!$this->input->post("message") && empty($_FILES['upload_file']['name']))
		{
			//$this->load->view('404_view', $data);
			return;
		}
		$curr_date=date("Y-m-d H:i:s");
		$message=$this->input->post("message");
		$employer_ = $this->employers_model->get_employer_by_id($this->sessUserId);
		stp:
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$employer_->ID' AND tbl_conversation.id_job_seeker='$row->ID'")->result();
		if(count($conv)<=0)
		{
			$this->db->query("INSERT INTO tbl_conversation SET id_employer='$employer_->ID',id_job_seeker='$row->ID',created_at='$curr_date'");
			goto stp;
		}
		$conv=$conv['0'];
		$message_to_send="Hi".' '.$row->first_name.",<br/><br/>"."You have new message(s) from"." <a href='".APPURL.'/seeker/chat/'.$conv->id_conversation."'>".$employer_->first_name."</a> :<br/><br/>";
		
		$this->db->query("UPDATE `tbl_conversation` SET `isNewForSeeker`=1 WHERE id_conversation = ".$conv->id_conversation);
		if($this->input->post("message"))
		{
			//echo $this->input->post("message");die;
			$this->db->query("INSERT INTO tbl_conv_message SET id_conversation='$conv->id_conversation',id_sender='$employer_->ID',message='$message',type_sender='employers',sent_at='$curr_date'");
			$message_to_send.=$message."<br/>";
		}



		if (!empty($_FILES['upload_file']['name']))
		{
			//echo $_FILES['upload_file']['name'];exit;
			$real_path = realpath(APPPATH . '../public/uploads/chat/');
			
			$config['upload_path'] = $real_path;
			$config['allowed_types'] = '*';
			$config['overwrite'] = true;
			$max_size=6000;
			$max_size=$this->db->query("SELECT * FROM tbl_settings")->result()['0']->upload_limit;
			$config['max_size'] = $max_size;
			$config['file_name'] = 'Attached_file_BiXma-'.md5($curr_date);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('upload_file')){
				
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.'Error'.'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(APPURL('employer/messenger/chat/').$conv->id_conversation);
				exit;
			}
			
			$resume = array('upload_data' => $this->upload->data());	
			$file_name = $resume['upload_data']['file_name'];
			$ull=APPURL."/employer/messenger/download/".$file_name;
			$sty="text-decoration: none;color: blue;";
			$message="<i style='".$sty."' class='fa fa-file-o'>&nbsp;</i>
                  <a style='".$sty."' href='".$ull."'>".$config['file_name']."<br></a>";
			$message_to_send.="<a href='".$ull."'>".$config['file_name']."</a>";
			$data_array = array(
			        'message' => $message,
			        'id_conversation' => $conv->id_conversation,
			        'id_sender' => $employer_->ID,
			        'type_sender' => 'employers',
			        'sent_at' => $curr_date
			);
			// var_dump($data_array);
			// die();
			$this->db->insert('tbl_conv_message', $data_array);
		}
		$message_to_send.="<br/><br/>".'Regards'.",";



		$config = $this->email_drafts_model->email_configuration();


		$this->email->initialize($config);
		
		// $this->email->clear(TRUE);
		$this->email->from("bixma@agoujil.com", "BiXma Job System");
		$this->email->to($row->email);
		$mail_message = $message_to_send;
		$this->email->subject($subject);
		$this->email->message($mail_message);     
		$this->email->send();

		redirect(APPURL.'/employer/messenger/chat/'.$conv->id_conversation);
	}


	public function conversation($seeker_ID = 0){
		//echo $seeker_ID;exit;

		$getConversation = $this->My_model->getSingleRowData("tbl_conversation","","id_employer =".$this->sessUserId." AND id_job_seeker = ".$seeker_ID);
		if(isset($getConversation) && $getConversation !=""){
			//
			redirect(APPURL."/employer/messenger/chat/".$getConversation->id_conversation);
			exit;
		} else {
			$insertData = array();
			$curr_date=date("Y-m-d H:i:s");
			$insertData['id_job_seeker'] = $seeker_ID;
			$insertData['id_employer'] = $this->sessUserId;
			$insertData['created_at'] = $curr_date;
			$insert = $this->My_model->insert("tbl_conversation",$insertData);
			//echo $this->db->last_query();exit;
			//myPrint($getConversation);exit;

			//myPrint($insert);exit;
			if($insert){
				//echo 1;exit;
				redirect(APPURL."/employer/messenger/chat/".$insert);
				exit;
			} 
			//echo 2;exit;
		}
	}


}
