<ul class="featurlist">
      <li><a href="<?php echo base_url('jobseeker/my_account');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'my_account');?>"><i class="fa fa-user"></i> <span><?=lang('Manage Account')?></span></a></li>
      <li><a href="<?php echo base_url('jobseeker/cv_manager');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'cv_manager');?> <?php echo is_active_like($this->uri->segment(2),'cv_builder');?>"><i class="fa fa-users"></i> <span><?=lang('My Resume')?></span></a></li>
      <li><a href="<?php echo base_url('jobseeker/my_jobs');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'my_jobs');?>"><i class="fa fa-file-text-o"></i> <span><?=lang('My Applications')?></span></a></li>
      

      <li><a href="<?php echo base_url('jobseeker/chat');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'chat');?>"><i class="fa fa-send"></i> <span><?=lang('Chat with Employers')?></span></a></li>

      <li><a href="<?php echo base_url('jobseeker/calendar');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'calendar');?>"><i class="fa fa-calendar"></i> <span><?=lang('Calendar')?></span></a></li>


      <li><a href="<?php echo base_url('jobseeker/matching_jobs');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'matching_jobs');?>"><i class="fa fa-users"></i> <span><?=lang('Job Matching')?></span></a></li>
      <li><a href="<?php echo base_url('jobseeker/add_skills');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'add_skills');?>"><i class="fa fa-users"></i> <span><?=lang('Manage Skills')?></span></a></li>
      <li><a href="<?php echo base_url('jobseeker/change_password');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'change_password');?>"><i class="fa fa-lock"></i> <span><?=lang('Change Password')?></span></a></li>
      <div class="clear"></div>
    </ul>