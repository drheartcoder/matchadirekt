<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Frontend
$route['company/(:any)'] = 'company/index/$1';
$route['jobs/(:any)'] = 'job_details/index/$1';
$route['job_listing/(:any)'] = 'job_listing/index/$1';
$route['(:any).html'] = 'content/index/$1';
$route['qcsh/(:any).html'] = 'content/show/$1';
$route['aqcsh/(:any)'] = 'content/show_it/$1';
$route['login'] = 'user/login/$1';
$route['logout'] = 'user/logout/$1';
$route['forgot'] = 'user/forgot/$1';
$route['search-jobs'] = 'job_search/index/$1';
$route['search-jobs/(:any)'] = 'job_search/index/$1';
$route['search-jobs/(:any)/(:any)'] = 'job_search/index/$1/$2';
$route['search-resume'] = 'resume_search/index/$1';
$route['search-resume/(:any)'] = 'resume_search/index/$1';
$route['search/(:any)'] = 'search/index/$1';
$route['candidate/(:any)'] = 'candidate/index/$1';
$route['industry/(:any)'] = 'industry/index/$1';
$route['employer-signup'] = 'employer_signup';
$route['jobseeker-signup'] = 'jobseeker_signup';
$route['contact-us'] = 'contact_us';
//Employer Section
$route['employer/job_applications/send_message_to_candidate'] 	= 'employer/job_applications/send_message_to_candidate/$1';
$route['employer/job_applications/(:any)'] 	= 'employer/job_applications/index/$1';
$route['employer/download/(:any)'] 	= 'employer/job_applications/download/$1';
$route['employer/my_posted_jobs/(:any)'] 	= 'employer/my_posted_jobs/index/$1';
$route['employer/edit_posted_job/(:num)'] 	= 'employer/edit_posted_job/index/$1';
$route['employer/chat/(:num)'] 	= 'employer/chat/index/$1';
$route['employer/calendar/'] 	= 'employer/calendar';

$route['jobseeker/chat/(:num)'] 	= 'jobseeker/chat/index/$1';
$route['jobseeker/download/(:any)'] 	= 'jobseeker/my_jobs/download/$1';
$route['jobseeker/calendar/'] 	= 'jobseeker/calendar';
$route['export/(:any)'] 	= 'ExportController/toxls/$1';
$route['token/jobseeker/(:any)'] 	= 'Confermation/seeker/$1';



//Backend
$route['admin/employers/(:num)'] 	= 'admin/employers/index/$1';
$route['admin/job_seekers/(:num)'] = 'admin/job_seekers/index/$1';
$route['admin/posted_jobs/(:num)'] = 'admin/posted_jobs/index/$1';

$route['admin/menu/load_menu_pages/(:num)'] = 'admin/menu/load_menu_pages/$1';
