<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header-->
<div class="container detailinfo">
  <div class="row"> <?php echo form_open_multipart('contact_us',array('name' => 'frm_contact_us', 'id' => 'frm_contact_us', 'onSubmit' => 'return validate_contact_form(this);'));?>
    <div class="col-md-12">
      <p></p>
      <h2> <?=lang('Contact Us')?></h2><br/>
      <!--Account info-->
		<?php echo $this->session->flashdata('success_msg');?>
      <!--Professional info-->
      <div class="formwraper">
        <div class="titlehead"><?=lang('Support Form')?></div>
        <div class="formint">
          <div class="input-group <?php echo (form_error('full_name') || $msg)?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Your Full Name')?> <span>*</span></label>
            <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo set_value('full_name'); ?>" />
            <?php echo form_error('full_name'); ?>
          </div>
          
          <div class="input-group <?php echo (form_error('email') || $msg)?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Your Email Address')?> <span>*</span></label>
            <input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" />
            <?php echo form_error('email'); ?>
          </div>
          
          <div class="input-group <?php echo (form_error('phone') || $msg)?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Your Phone Number')?> <span>*</span></label>
            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" />
            <?php echo form_error('phone'); ?>
          </div>
          
          <div class="input-group <?php echo (form_error('phone') || $msg)?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('City')?> </label>
            <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city'); ?>" />
            <?php echo form_error('city'); ?>
          </div>
          
          <div class="input-group <?php echo (form_error('message') || $msg)?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Message')?> / <?=lang('Question')?><span>*</span></label>
            <textarea name="message" id="message" class="form-control" rows="8"><?php echo set_value('message'); ?></textarea>
            
            <?php echo form_error('message'); ?>
          </div>
          
          <div class="formsparator">
            <div class="input-group">
              <label class="input-group-addon captcha"><?=lang('Please enter')?> this <?=lang('in the text box below')?> : <?php echo $cpt_code;?></label></div>
            <div class="input-group <?php echo (form_error('captcha'))?'has-error':'';?>">
              <label class="input-group-addon"></label>
              <input type="text" class="form-control" name="captcha" id="captcha" value="" maxlength="10" autocomplete="off" />
              <?php echo form_error('captcha'); ?> </div>
          </div>
          <div align="center">
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Submit')?>" class="btn btn-success" />
          </div>
        </div>
      </div>
    </div>
    <!--/Job Detail--> 
    <?php echo form_close();?>
    <?php $this->load->view('common/right_ads');?>
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?> 
</body>
</html>
