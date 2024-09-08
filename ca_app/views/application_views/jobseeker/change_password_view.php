<?php $this->load->view('application_views/common/header'); ?>

<?php echo form_open_multipart('app/jobseeker/Change_password',array('name' => 'change_password_form', 'id' => 'change_password_form'));?>
   
   <?php echo $this->session->flashdata('msg');?> 
      
      <!--Account info-->
          

          <span style="" class="input_label"><?=lang('Old Password')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('old_password'))?'has-error':'';?>">
            <input name="old_password" type="password" class="form-control app_input" id="old_password" placeholder="<?=lang('Old Password')?>" value="<?php echo set_value('password'); ?>" maxlength="100">
            <?php echo form_error('old_password'); ?> </div>

           <span style="" class="input_label"><?=lang('New Password')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('new_password'))?'has-error':'';?>">
            <input name="new_password" type="password" class="form-control app_input" id="new_password" placeholder="<?=lang('New Password')?>" value="<?php echo set_value('password'); ?>" maxlength="100">
            <?php echo form_error('new_password'); ?> </div>

    
            <span style="" class="input_label"><?=lang('Confirm Password')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('confirm_password'))?'has-error':'';?>">
            <input name="confirm_password" type="password" class="form-control app_input" id="confirm_password" placeholder="<?=lang('Confirm Password')?>" value="<?php echo set_value('confirm_password'); ?>" maxlength="100">
            <?php echo form_error('confirm_password'); ?> </div>
          <div align="center">
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Change Password')?>" class="btn btn-success" />
          </div>
       
   
    <!--/Job Detail--> 
    <?php echo form_close();?>
   
<?php $this->load->view('application_views/common/footer_app'); ?>