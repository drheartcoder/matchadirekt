<style>
    div#google_translate_element div.goog-te-gadget-simple {
        font-size: 19px;
        text-align: center;
        text-decoration: none;
    }
    @media (max-width: 667px) {
#google_translate_element {
    top: 33px;
    right: 60px;
  }
}
</style>
<div class="topheader">
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



<div class="modal fade" id="chngLngg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Change Website Language')?></h4>
      </div>
      <div class="modal-body">
        <div id="google_translate_element"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
      </div>
    </div>
  </div>
</div>





  <div class="navbar navbar-default" role="navigation">


    
        <div class="col-md-2">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/logo.png');?>" /></a> </div>
        </div>
        <div class="col-md-<?php echo ($this->session->userdata('is_user_login')==TRUE)?'6':'6';?>">
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
              <?php 
        
        if($this->session->userdata('is_employer')==TRUE): 
      ?>
              <li <?php echo active_link('');?>><a href="<?php echo base_url();?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
              <li <?php echo active_link('employer');?>><a href="<?php echo base_url('employer/dashboard');?>" title="<?=lang('My Dashboard')?>"><?=lang('My Dashboard')?></a> </li>
              <li <?php echo active_link('search-resume');?>><a href="<?php echo base_url('search-resume');?>" title="<?=lang('Search Resume')?>"><?=lang('Search Resume')?></a></li>
              <li <?php echo active_link('contact-us');?>><a href="<?php echo base_url('contact-us');?>" title="Contact Us"><?=lang('Contact Us')?></a></li>
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
        
    <?php elseif($this->session->userdata('is_job_seeker')==TRUE):?>
              <li <?php echo active_link('');?>><a href="<?php echo base_url();?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
              <li <?php echo active_link('jobseeker');?>><a href="<?php echo base_url('jobseeker/dashboard');?>" title="<?=lang('My Dashboard')?>"><?=lang('My Dashboard')?></a> </li>
              <li <?php echo active_link('search-jobs');?>><a href="<?php echo base_url('search-jobs');?>" title="<?=lang('Search Jobs')?>"><?=lang('Search Jobs')?></a></li>
              <li <?php echo active_link('contact-us');?>><a href="<?php echo base_url('contact-us');?>" title="<?=lang('Contact Us')?>"><?=lang('Contact Us')?></a></li>
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
         
         <?php else:?>
              <li <?php echo active_link('');?>><a href="<?php echo base_url();?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
              <li <?php echo active_link('search-jobs');?>><a href="<?php echo base_url('search-jobs');?>" title="<?=lang('Search a Job')?>"><?=lang('Search a Job')?></a> </li>
              <li <?php echo active_link('search-resume');?>><a href="<?php echo base_url('search-resume');?>" title="<?=lang('Search Resume')?>"><?=lang('Search Resume')?></a></li>
              <li <?php echo active_link('about-us.html');?>><a href="<?php echo base_url('about-us.html');?>" title="<?=lang('About Us')?>"><?=lang('About Us')?></a></li>
              <li <?php echo active_link('contact-us');?>><a href="<?php echo base_url('contact-us');?>" title="<?=lang('Contact Us')?>"><?=lang('Contact Us')?></a></li>
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
              <?php endif;?>

<li class="btn" title="Change Website Language" style="font-size: 20px;margin-top:5px;color:darkgreen;border-radius: 20px;" onclick="$('#chngLngg').modal('show');" id="chngLng"><i class="fa fa-language"></i></li>
            </ul>
          </div>
        </div>
        <!--/.nav-collapse -->
        
        <div class="col-md-<?php echo ($this->session->userdata('is_user_login')==TRUE)?'4':'4';?>">
          <div class="usertopbtn">
      <?php if($this->session->userdata('is_user_login')!=TRUE): ?>          
          <a href="<?php echo base_url('employer-signup');?>" class="lookingbtn"><?=lang('Post a Job')?></a>
          <a href="<?php echo base_url('jobseeker-signup');?>" class="hiringbtn"><?=lang('Job Seeker')?></a>
          <a href="<?php echo base_url('login');?>" class="loginBtn" title="Jobs openings"><?=lang('Login')?></a>
          <?php else:
       $c_folder = ($this->session->userdata('is_employer')==TRUE)?'employer':'jobseeker';
       ?>
          <a href="<?php echo base_url('user/logout');?>"  class="regBtn"><?=lang('Logout')?></a>
          <div class="pull-right loginusertxt"><?=lang('Welcome')?>, <a href="<?php echo base_url($c_folder.'/dashboard');?>" class="username"><?php echo $this->session->userdata('first_name');?>!</a></div>
          <?php endif;?>
          <div class="clear"></div>
          </div>
        </div>
      
        <div class="clearfix"></div>
  </div>
</div>
