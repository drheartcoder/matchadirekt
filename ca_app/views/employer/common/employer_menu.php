<ul class="featurlist">
      <li><a href="<?php echo base_url('employer/dashboard');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'dashboard');?>"><i class="fa fa-tachometer"></i> &nbsp;<span><?=lang('Dashboard')?></span></a></li>
      <li><a href="<?php echo base_url('employer/edit_company');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'edit_company');?>"><i class="fa fa-users"></i> &nbsp;<span><?=lang('Company Profile')?></span></a></li>
      
      <li><a href="<?php echo base_url('employer/post_new_job');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'post_new_job');?>"><i class="fa fa-file-text-o"></i> &nbsp;<span><?=lang('Post New Job')?></span></a></li>
        
      <li><a href="<?php echo base_url('employer/my_posted_jobs');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'my_posted_jobs');?>"><i class="fa fa-cogs"></i> &nbsp;<span><?=lang('Manage My Jobs')?></span></a></li>
      
        
      <li><a href="<?php echo base_url('employer/quizzes');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'quizzes');?>"><i class="fa fa-question-circle"></i> &nbsp;<span><?=lang('Quizzes')?></span></a></li>
      
      <li><a href="<?php echo base_url('employer/job_applications');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'job_applications');?>"><i class="fa fa-users"></i> &nbsp;<span><?=lang('View Candidates')?></span></a></li>
      
      
      <li><a href="<?php echo base_url('employer/statistics');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'statistics');?>"><i class="fa fa-file"></i> &nbsp;<span><?=lang('Statistics')?></span></a></li>
      
      <li><a href="<?php echo base_url('employer/chat');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'chat');?>"><i class="fa fa-send"></i> &nbsp;<span><?=lang('Chat with Candidates')?></span></a></li>

      
      <li><a href="<?php echo base_url('employer/labels');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'labels');?>"><i class="fa fa-archive"></i> &nbsp;<span><?=lang('Archives')?></span></a></li>

      <li><a href="<?php echo base_url('employer/calendar');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'calendar');?>"><i class="fa fa-calendar"></i> &nbsp;<span><?=lang('Calendar')?></span></a></li>

      <li><a href="<?php echo base_url('employer/job_analysis');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'job_analysis');?>"><i class="fa fa-signal"></i> &nbsp;<span><?=lang('Job Analysis')?></span></a></li>


      <li><a href="<?php echo base_url('employer/employer_certificate');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'employer_certificate');?>"><i class="fa fa-desktop"></i> &nbsp;<span><?=lang('Employer Certificate')?></span></a></li>



      <li><a href="<?php echo base_url('employer/interview');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'interview');?>"><i class="fa fa-calendar-o"></i> &nbsp;<span><?=lang('Interview')?></span></a></li>


      <li><a href="<?php echo base_url('search-resume');?>" class="innerfetbox"><i class="fa fa-search"></i> &nbsp;<span><?=lang('Resume Search')?></span></a></li>
      
      <li><a href="<?php echo base_url('employer/change_password');?>" class="innerfetbox <?php echo is_active_like($this->uri->segment(2),'change_password');?>"><i class="fa fa-lock"></i> &nbsp;<span><?=lang('Password Change')?></span></a></li>      
      <div class="clear"></div>
</ul>