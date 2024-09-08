<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Splash extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
    }
	
	public function index(){
		$this->load->view('application/splash_view');
	}
}
