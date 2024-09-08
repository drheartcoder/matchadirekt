<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index($page_slug=''){
		$data['ads_row'] = $this->ads;
		if($page_slug!=''){
			$row = $this->cms_model->get_cms_by_slug($page_slug);
			
			if(!$row){
				$this->load->view('404_view', $data);
				return;	
			}
			
			$data['title'] = $row->seoMetaTitle;
			$data['vide'] = '0';
			$data['meta_keyword'] = $row->seoMetaKeyword;
			$data['meta_description'] = $row->seoMetaDescription;
			//$data['title'] = $row->heading;
			$data['row'] = $row;
			$this->load->view('content_view', $data);
			return;
		}
		redirect(base_url());
	}
	
	public function show($page_slug=''){
		if($page_slug!=''){
			$row = $this->cms_model->get_cms_by_slug($page_slug);
			
			if(!$row){
				return;	
			}
			
			$data['title'] = $row->seoMetaTitle;
			$data['meta_keyword'] = $row->seoMetaKeyword;
			$data['meta_description'] = $row->seoMetaDescription;
			$data['vide'] = '1';
			//$data['title'] = $row->heading;
			$data['row'] = $row;
			$this->load->view('content_view', $data);
			return;
		}
		return;
	}
	public function show_it($id=''){
		if($id!=''){
			$row = $this->cms_model->get_cms_by_slug('privacy-notice.html');
			
			if(!$row){
				return;	
			}
			$content=$this->db->query("select * from tbl_post_jobs where ID='$id'")->result()['0']->advertise;
			$row->pageContent=$content;
			$data['title'] = $row->seoMetaTitle;
			$data['meta_keyword'] = $row->seoMetaKeyword;
			$data['meta_description'] = $row->seoMetaDescription;
			$data['vide'] = '1';
			//$data['title'] = $row->heading;
			$data['row'] = $row;
			$this->load->view('content_view', $data);
			return;
		}
		return;
	}
}