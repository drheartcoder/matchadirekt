<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("class.smtp.php");
include("class.phpmailer.php");
class Messenger extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->my_library->check_user_login();
    }
	public $outputData = array();
	
	public function index(){
		$convs=$this->db->query("SELECT tbl_conversation.*, tbl_employers.first_name, tbl_employers.last_login_date, tbl_companies.company_name, tbl_companies.company_logo, tbl_companies.company_phone  FROM tbl_conversation INNER JOIN tbl_employers ON tbl_employers.ID=tbl_conversation.id_employer INNER JOIN tbl_companies ON tbl_companies.ID=tbl_employers.company_id WHERE id_job_seeker=".$this->sessUserId)->result();
		if(isset($convs) && $convs){
			foreach ($convs as $con) {
				$lastMsg = $this->db->query("SELECT message, sent_at FROM tbl_conv_message WHERE id_conversation=".$con->id_conversation." order by id_conv_message desc limit 0,1 ")->result();
				//myPrint($lastMsg);
				$con->msg = $lastMsg[0]->message;
				$con->sent_at = $lastMsg[0]->sent_at;
			}
		}
		//myPrint($convs);
		$this->outputData['convs'] = $convs;
		$this->load->view('newweb/seeker/inbox_view',$this->outputData);
	}

	public function chat_history($conversationId = 0){
		$this->db->query("UPDATE `tbl_conversation` SET `isNewForSeeker`=0 WHERE id_conversation = ".$conversationId);
		//$compData=$this->My_model->selTableData();
		//echo $conversationId;exit;
		$conversationData=$this->My_model->exequery("SELECT tbl_conversation.*, tbl_employers.first_name, tbl_employers.last_login_date, tbl_companies.company_name, tbl_companies.company_logo, tbl_companies.company_phone  FROM tbl_conversation INNER JOIN tbl_employers ON tbl_employers.ID=tbl_conversation.id_employer INNER JOIN tbl_companies ON tbl_companies.ID=tbl_employers.company_id WHERE id_conversation=".$conversationId);


		// $conversationData = $this->My_model->selTableData("tbl_conversation","tbl_conversation.*, (select first_name from tbl_employers WHERE ID= tbl_conversation.id_employer) employerName","id_conversation =".$conversationId);
		//myPrint($conversationData);
		$messages=$this->db->query("SELECT * FROM tbl_conv_message WHERE id_conversation=".$conversationId)->result();

		$this->outputData['conversationData'] = $conversationData[0];
		$this->outputData['messages'] = $messages;
		//$this->outputData['convs'] = $convs;
		//myPrint($conversationData);exit;
		$this->load->view('newweb/seeker/chat_view',$this->outputData);
	}


	public function send_message($id = "")
	{
		
		$decrypted_id = $this->custom_encryption->decrypt_data($id);
		$employer_ = $this->employers_model->get_employer_by_id($decrypted_id);
		
		/*if(!$employer_){
			//			$this->load->view('404_view', $data);
			return;		
		}*/
		

		
		if(!$this->input->post("message") && empty($_FILES['upload_file']['name']))
		{
			//			$this->load->view('404_view', $data);
			return;
		}
		$message=$this->input->post("message");
		$row = $this->job_seekers_model->get_job_seeker_by_id($this->sessUserId);
		$conv=$this->db->query("SELECT id_conversation FROM tbl_conversation WHERE tbl_conversation.id_employer='$employer_->ID' AND tbl_conversation.id_job_seeker='$row->ID'")->result();
		$curr_date=date("Y-m-d H:i:s");
		/*myPrint($conv);
		exit;*/
		if(count($conv)<=0)
		{
			//			$this->load->view('404_view', $data);
			return;
		}
		$conv=$conv['0'];
		$message_to_send=lang("Hi").' '.$employer_->first_name.",<br/><br/>".lang("You have new message(s) from")." <a href='".WEBURL.'/seeker/messenger/chat-history/'.$conv->id_conversation."'>".$row->first_name.' '.$row->last_name."</a> :<br/><br/>";
		$this->db->query("UPDATE `tbl_conversation` SET `isNewForEmployer`=1 WHERE id_conversation = ".$conv->id_conversation);
		if($this->input->post("message"))
		{
			$this->db->query("INSERT INTO tbl_conv_message SET id_conversation='$conv->id_conversation',id_sender='$employer_->ID',message='$message',type_sender='job_seekers',sent_at='$curr_date'");
			$message_to_send.=$message."<br/>";
		}
		
		if (!empty($_FILES['upload_file']['name']))
		{
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
				$this->session->set_flashdata('msg', '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>'.lang('Error').'!</strong> '.strip_tags($error['error']).' </div>');
				redirect(WEBURL."/seeker/messenger/chat-history/".$conv->id_conversation);
				exit;
			}
			
			$resume = array('upload_data' => $this->upload->data());	
			$file_name = $resume['upload_data']['file_name'];
			$ull=base_url()."chat/download/".$file_name;
			$sty="text-decoration: none;color: white;";
			$message="<i style='".$sty."' class='fa fa-download'>&nbsp;</i>
                  <a style='".$sty."' href='".$ull."'>Attached File<br></a>";
			$message_to_send.="<a href='".$ull."'>Attached File</a>";
			$data_array = array(
			        'message' => $message,
			        'id_conversation' => $conv->id_conversation,
			        'id_sender' => $employer_->ID,
			        'type_sender' => 'job_seekers',
			        'sent_at' => $curr_date
			);
			// var_dump($data_array);
			// die();
			$this->db->insert('tbl_conv_message', $data_array);
		}
		$message_to_send.="<br/><br/>".lang('Regards').",";


		$config = $this->email_drafts_model->email_configuration();


		/*$this->email->initialize($config);
		
		// $this->email->clear(TRUE);
		$this->email->from("bixma@agoujil.com", "BiXma Job System");
		$this->email->to($employer_->email);
		$mail_message = $message_to_send;
		$this->email->subject($subject);
		$this->email->message($mail_message);     
		$this->email->send();*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = MAILERHOST;
		$mail->Username = MAILERUSER;
		$mail->Password = MAILERPASS; 
		$mail->From ="bixma@agoujil.com";
		$mail->FromName = "BiXma Job System";
		$mail->AddAddress($employer_->email,"Company");
		$mail->Subject =$subject;
		$mail->Body = $mail_message;
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		/*$mail->SMTPSecure = 'tls';
		$mail->Port = 587;*/
		$mail->Port = 25;
			
		$mail->Send();
		redirect(WEBURL."/seeker/messenger/chat-history/".$conv->id_conversation);
	}
	
}
