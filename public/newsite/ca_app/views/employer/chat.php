<!DOCTYPE html>

<html lang="en">

<head>

<?php $this->load->view('common/meta_tags'); ?>

<title><?php echo $title;?></title>

<link rel="stylesheet" href="http://jquery-ui.googlecode.com/svn/tags/1.8.7/themes/base/jquery.ui.all.css">

<link rel="stylesheet" href="<?php echo base_url('public/autocomplete/demo.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('public/chat/style.css'); ?>">


<style>

.ui-button {

	margin-left: -1px;

}

.ui-button-icon-only .ui-button-text {

	padding: 0.35em;

}

.ui-autocomplete-input {

	margin: 0;

	padding: 0.48em 0 0.47em 0.45em;

}

</style>

<?php $this->load->view('common/before_head_close'); ?>

</head>

<body>

<?php $this->load->view('common/after_body_open'); ?>

<div class="siteWraper">

<!--Header-->

<?php $this->load->view('common/header'); ?>

<!--/Header-->

<div class="container detailinfo">

  <div class="row">

  <div class="col-md-3">

  <div class="dashiconwrp">

    <?php $this->load->view('employer/common/employer_menu');?>

  </div>

  </div>

  

    <div class="col-md-9"> <?php echo $this->session->flashdata('msg');?> 
    <div class="formwraper">
    <div class="titlehead"><?=lang('Chat')?></div>
    <div class="row" style="overflow: hidden!important;">
      

        <div class="container clearfix">
         <?php 
        if($nothing==1)
        {
          ?><h3><b><br/>&nbsp;<i class="fa fa-close"></i>&nbsp;<?=lang('Nothing to Show')?><br/><br/></b></h3><?php
            goto end;
        }
        ?>
    <div class="people-list" id="people-list">
      <ul class="list" style="list-style-type: none;height: 635px;overflow: auto!important;">
        <?php
        foreach ($convs as $cnv):
          ?>
          <li class="clearfix" style="height: 65px;">
              <a href="<?=base_url().'employer/chat/'.$cnv->id_conversation?>" >
                <img style="width: 56px;border-radius: 50%;" class="thumbnail" src="<?php $candidate_logo = ($cnv->photo)?$cnv->photo:'no_pic.jpg'; echo base_url('public/uploads/candidate/'.$candidate_logo);?>" alt="avatar" />
              </a>
                <div class="about">
              <a href="<?=base_url().'employer/chat/'.$cnv->id_conversation?>" >
                  <div class="name"><?=$cnv->first_name?></div>
              </a>
              <?php
              if($cnv->last_login_date!=""):
                ?>
                  <div class="status">
                    <small><?=lang('Last Login')?> : <?=date_formats($cnv->last_login_date, 'M d, Y')?></small>
                  </div>
                <?php
              endif;
              ?>
                </div>
              </li><hr/>
          <?php
        endforeach;
        ?>

        
      </ul>
    </div>
    
    <div class="col-md-9 chat">
      <div class="chat-header clearfix">
        <img style="width: 56px;border-radius: 50%;" src="<?php $candidate_logo = ($job_seeker->photo)?$job_seeker->photo:'no_pic.jpg';echo base_url('public/uploads/candidate/'.$candidate_logo);?>" alt="avatar" />
        
        <div class="chat-about">
          <div class="chat-with"><?=lang('Chat with')?> <a href="<?=base_url().'candidate/'.$this->custom_encryption->encrypt_data($job_seeker->ID)?>"><?=$job_seeker->first_name?></a></div>
          <div class="chat-num-messages"><?=lang('already')?> <?=count($messages)?> <?=lang('messages')?></div>
        </div>
      </div> <!-- end chat-header -->
      
      <div class="chat-history" id="chat-history" style="height: 356px;">
        <ul style="list-style-type: none;">
          <?php
          foreach ($messages as $msg) {
              if($msg->type_sender=="employers")
              {
                  ?>
                  <li class="clearfix">
                      <div class="message-data align-right">
                        <span class="message-data-time" ><?=date_formats($msg->sent_at, 'H:i - M d, Y')?></span> &nbsp; &nbsp;
                        <span class="message-data-name" >Me</span> <i class="fa fa-circle me"></i>
                        
                      </div>
                      <div class="message other-message float-right">
                        <?=$msg->message?>
                      </div>
                  </li>
                  <?php
              }
              else
              {
                ?>
                <li>
                  <div class="message-data">
                    <span class="message-data-name"><i class="fa fa-circle online"></i> <?=$job_seeker->first_name?></span>
                    <span class="message-data-time"><?=date_formats($msg->sent_at, 'H:i - M d, Y')?></span>
                  </div>
                  <div class="message my-message">
                        <?=$msg->message?>
                  </div>
                </li>
                <?php
              }
          }
          ?>
          
          
          
        </ul>
        
      </div> <!-- end chat-history -->
      <form method="post" action="<?=base_url().'candidate/send_message/'.$this->custom_encryption->encrypt_data($job_seeker->ID)?>">
      <div class="chat-message clearfix">
        <textarea name="message" required="required" id="message-to-send" placeholder ="<?=lang('Type your message')?>" rows="3"></textarea>
        
        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i>&nbsp; <?=lang('Send')?></button>

      </div> <!-- end chat-message -->
      </form>
    </div> <!-- end chat -->
    
    <?php end:?>
  </div> <!-- end container -->

    </div>
    </div>      
   </div>

  </div>
</div>

<?php $this->load->view('common/bottom_ads');?>

<!--Footer-->

<?php $this->load->view('common/footer'); ?>

<script src="<?php echo base_url('public/js/bad_words.js'); ?>"></script>

<?php $this->load->view('common/before_body_close'); ?>

<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script> 

<script src="<?php echo base_url('public/autocomplete/jquery-1.4.4.js'); ?>"></script> 

<script src="<?php echo base_url('public/autocomplete/jquery.ui.core.js'); ?>"></script> 

<script src="<?php echo base_url('public/autocomplete/jquery.ui.widget.js'); ?>"></script> 

<script src="<?php echo base_url('public/autocomplete/jquery.ui.button.js'); ?>"></script> 

<script src="<?php echo base_url('public/autocomplete/jquery.ui.position.js'); ?>"></script> 

<script src="<?php echo base_url('public/autocomplete/jquery.ui.autocomplete.js'); ?>"></script> 

<script type="text/javascript"> var cy = '<?php echo $country;?>'; </script> 

<script type="text/javascript">
  $( document ).ready(function() {
var objDiv = document.getElementById("chat-history");
objDiv.scrollTop = objDiv.scrollHeight;
});
</script>
</body>

</html>