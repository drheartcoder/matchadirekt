<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Languages extends CI_Controller {
	public function index(){
		$data['title'] = SITE_NAME.': Languages';
		$data['msg'] = '';

		$obj_result = $this->db->query("SELECT * FROM tbl_lang")->result();
		$data['result'] = $obj_result;
		$this->load->view('admin/languages_view', $data);

		return;
	}
	
	public function get_language_by_id($id=''){
		if($id!=''){
			$row = $this->db->query("SELECT * FROM tbl_lang WHERE ID='$id'")->result()['0'];
            $str_array= array();
            $str_array=include (APPPATH."/helpers/".$row->Abbreviation.".php");
            
            foreach ($str_array as $key => $value) {
            	
            	
            	$str.=' "'.$key.'" => "'.$Cleanvalue.'" ,'.PHP_EOL;
            }
             

            $row->content=$str;
			$json_data = json_encode($row);
			echo $json_data;
			exit;
		}
		return;
	}
	
	public function edit_lang($id){



		$row = $this->db->query("SELECT * FROM tbl_lang WHERE ID='$id'")->result()['0'];

		$str_array= array();
		$LangFile=APPPATH."/helpers/".$row->Abbreviation.".php";
		if(file_exists($LangFile))
		{
			$str_array=include ($LangFile);
		}else{
			$str_array=include (APPPATH."/helpers/Model.php");
		}
        


		$data['row']=$row;
		$data['trans']=$str_array;
		$this->load->view('admin/edit_lang_view', $data);
	}

	public function add(){
		$data['title'] = SITE_NAME.': Add Language';
		$data['msg'] = '';
		
		$rtl=$this->input->post('rtl');

		if($rtl){
			$rtl='rtl';
		}
		else{
			$rtl='ltr';
		}
		

		$data_array = array('name' => $this->input->post('name'),'abbreviation' => $this->input->post('abbreviation'),'rtl'=>$rtl);
		$this->db->insert("tbl_lang",$data_array);
        
        //$this->set_file($this->input->post('abbreviation').".php",$this->input->post('content'));
        
		$this->session->set_flashdata('added_action', true);
		redirect(base_url('admin/languages'));
	}
    
    private function set_file($fichier,$content)
    {
    	//$content=str_replace("'","\'",$content);

        $content="<?php return array(".$content.");";
        file_put_contents(APPPATH."/helpers/".$fichier, $content);
    }
    

    public function update($id){


    	$rtl=$this->input->post('rtl');

		if($rtl){
			$rtl='rtl';
		}
		else{
			$rtl='ltr';
		}

    	$data_array = array('name' => $this->input->post('edit_name'),'abbreviation' => $this->input->post('edit_abbreviation'),'rtl'=>$rtl);

		$Content= $this->setFileContent($this->input->post('key'),$this->input->post('value'));
    	
		$this->set_file($this->input->post('edit_abbreviation').".php",$Content);

		$this->db->where("ID",$id);
		$this->db->update("tbl_lang",$data_array);

		redirect(base_url('admin/languages/edit_lang/'.$id));
    }


    private function setFileContent($key,$value){
    	$nbr=count($key);
    	$Content='';

    	for ($i=0; $i <$nbr ; $i++) { 

    		$Cleanvalue=str_replace('"','\"',$value[$i]);

    		$Content.='"'.$key[$i].'" => "'.$Cleanvalue.'" ,'.PHP_EOL;
    	}
 		
 		return $Content;
    }


	/*public function update(){
		
		$id = $this->input->post('key_id');
		if($id==''){
			redirect(base_url().'admin/languages','');
			exit;
		}
		
		$data['title'] = SITE_NAME.': Edit Language';
		$data['msg'] = '';
		
		$data_array = array('name' => $this->input->post('edit_name'),'abbreviation' => $this->input->post('edit_abbreviation'));
		$this->db->where("ID",$id);
		$this->db->update("tbl_lang",$data_array);

        $this->set_file($this->input->post('edit_abbreviation').".php",$this->input->post('edit_content'));
        
		$this->session->set_flashdata('update_action', true);
		redirect(base_url('admin/languages'));
		return;
	}*/
	
	public function delete($id=''){
		
		if($id==''){
			echo 'error';
			exit;
		}
		
		$this->db->query("DELETE FROM tbl_lang WHERE ID='$id'");
		echo 'done';
		exit;
	}
}