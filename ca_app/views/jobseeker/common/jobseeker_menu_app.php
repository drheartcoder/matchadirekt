
<div class="head_dash_app">
   <ul>
       <li><a href="<?php echo base_url();?>" class="matcha_dash"><img src="<?php echo base_url('public/images/matcha.png');?>"/></a></li>
    
        <li class="frist_dashboard_li"><a href="<?php echo base_url('jobseeker/my_account');?>" class="frist_dashboard_icon <?php echo is_active_like($this->uri->segment(2),'my_account');?>"><i class="fa fa-user"></i> <label><?=lang('Manage Account')?></label></a></li>
    </ul>

</div>



<div class="body_dash_app">


<ul class="dash_list_app">
    
      <li><a href="<?php echo base_url('jobseeker/cv_manager');?>" class="dashboard_icon <?php echo is_active_like($this->uri->segment(2),'cv_manager');?> <?php echo is_active_like($this->uri->segment(2),'cv_builder');?>"><i class="fa fa-users"></i> <span><?=lang('My Resume')?></span></a></li>
      <li><a href="<?php echo base_url('jobseeker/my_jobs');?>" class="dashboard_icon <?php echo is_active_like($this->uri->segment(2),'my_jobs');?>"><i class="fa fa-file-text-o"></i> <span><?=lang('My Applications')?></span></a></li>
      

      <li><a href="<?php echo base_url('jobseeker/chat');?>" class="dashboard_icon <?php echo is_active_like($this->uri->segment(2),'chat');?>"><i class="fa fa-send"></i> <span><?=lang('Chat with Employers')?></span></a></li>

      <li><a href="<?php echo base_url('jobseeker/calendar');?>" class="dashboard_icon <?php echo is_active_like($this->uri->segment(2),'calendar');?>"><i class="fa fa-calendar"></i> <span><?=lang('Calendar')?></span></a></li>


      <li><a href="<?php echo base_url('jobseeker/matching_jobs');?>" class="dashboard_icon <?php echo is_active_like($this->uri->segment(2),'matching_jobs');?>"><i class="fa fa-users"></i> <span><?=lang('Job Matching')?></span></a></li>
      <li><a href="<?php echo base_url('jobseeker/add_skills');?>" class="dashboard_icon <?php echo is_active_like($this->uri->segment(2),'add_skills');?>"><i class="fa fa-users"></i> <span><?=lang('Manage Skills')?></span></a></li>
      <li><a href="<?php echo base_url('jobseeker/change_password');?>" class="dashboard_icon <?php echo is_active_like($this->uri->segment(2),'change_password');?>"><i class="fa fa-lock"></i> <span><?=lang('Change Password')?></span></a></li>
      <div class="clear"></div>
</ul>
    </div>

