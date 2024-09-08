
<?php $this->load->view('application_views/common/head_app'); ?>

       <div class="div_center">
             <h3 style="text-align:center;width100%;color:#3785b3"><?=lang('LOGIN')?> </h3>
            
  <hr/>
         <form name="login_form" id="login_form" action="" method="post">
        
        <?php if($msg):?>
        	<div class="alert alert-danger"><?php echo $msg;?></div>
        <?php endif;?>
        <?php echo validation_errors(); ?>
        <?php echo $this->session->flashdata('success_msg');?>
               <span style="" class="input_label"><?=lang('Email')?> <b>*</b></span>
          <div class="ara_row">
            
              <input type="email" name="email" id="email" class="app_input form-control" value="<?php echo set_value('email'); ?>" placeholder="" />
         </div>
              <span style="" class="input_label"><?=lang('Password')?> <b>*</b></span>
        <div class="ara_row">
              <input type="password" name="pass" id="pass" autocomplete="off" value="<?php echo set_value('pass'); ?>" class="app_input form-control"   placeholder="" />
             
        </div>
             <div class="ara_row" style="">
             <a href="<?php echo base_url('app/user/forgot');?>">
              <b><?=lang('Forgot Your Password')?>?</b> 
            </a>
             </div>
        <div class="ara_row" style="text-align:center;">
              <button type="submit" class="Ara_btn" style="background-color: #26a022;"><?=lang('Sign In')?> <i class="fa fa-sign-in"></i></button>
        </div>
       
    <div class="ara_row" style="text-align:center;">
        <b><?=lang('Not a member yet? Click Below to Sign Up')?></b>
       
        <div class="clear"></div>
      
        
      </div>
             
    <div class="ara_row" style="margin-top:15px;text-align:center;">
        <div></div>
        <a style="background-color:#002367;" href="<?php echo base_url('app/employer_signup');?>" class="Ara_btn"><?=lang('As Employer')?></a>
        <a style="background-color:#505C73;" href="<?php echo base_url('app/jobseeker_signup');?>" class="Ara_btn"><?=lang('As Jobseeker')?></a>
        <div class="clear"></div>
     </div>
   
    </form>
</div>
      
       <?php $this->load->view('common/after_body_open'); ?>
        <?php $this->load->view('common/before_body_close'); ?>
       
    </body>
</html>