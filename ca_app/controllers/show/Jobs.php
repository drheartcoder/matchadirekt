<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'libraries/guzzle/vendor/autoload.php');

use GuzzleHttp\Exception\GuzzleException;

use GuzzleHttp\Client;


class Jobs extends CI_Controller {
	
	protected $client;

	protected $url='http://api.arbetsformedlingen.se/af/v0/platsannonser/';

	public function __construct(){
        parent::__construct();
		$this->ads = '';
		$this->ads = $this->ads_model->get_ads();
		$this->client = new Client();
    }
	
	public function index()
	{
		$jobs=$this->db->query("SELECT *,tbl_employers.city AS emp_city,tbl_employers.country AS emp_country,tbl_post_jobs.ID AS JID from tbl_post_jobs
								LEFT JOIN tbl_companies ON tbl_post_jobs.company_ID=tbl_companies.ID
								LEFT JOIN tbl_employers ON tbl_post_jobs.employer_ID=tbl_employers.ID
								LEFT JOIN tbl_job_industries ON tbl_post_jobs.industry_ID=tbl_job_industries.ID
								WHERE tbl_post_jobs.sts='active' and tbl_post_jobs.deleted=0")->result();
		$data['jobs'] = $jobs;
		$data['title'] = 'Jobs';
		$this->load->view('jobs_view',$data);
	}

	private function Execute($url){
		
		try
		{
			$response = $this->client->request('GET', $url,[
	    	'headers' => [
		        'Accept-Language' => 'en',
		        'Accept'     => 'application/json'
		        ]
        ]);
		//dd($response->getBody());
        return json_decode($response->getBody());
		}
		catch(RequestException $e)
		{	
			return false;
		}
	}

	private function getCities(){

		$url=$this->url.'soklista/lan';

		$data=$this->Execute($url);

		return $data->soklista->sokdata;
		
	}

	private function getJobsBylan($id){
		$jobsData=[];

		$url=$this->url.'matchning?lanid='.$id;
		$jobs=$this->Execute($url);

		$jobs=$jobs->matchningslista->matchningdata;

		foreach ($jobs as $job) {
			$url=$this->url.$job->annonsid;
			$jobsData[]=$this->Execute($url)->platsannons;
		}

		return $jobsData;

	}

	public function api(){

		$data['jobs'] = [];
		$lanID=$this->input->get('lan');
		if($lanID)
		{
			$data['jobs']=$this->getJobsBylan($lanID);	 
		}
		$data['cities']=$this->getCities();
		
		$data['title'] = 'Jobs';
		$this->load->view('jobs_view_api',$data);
	}
}
