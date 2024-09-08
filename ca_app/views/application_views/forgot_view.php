<?php $this->load->view('application_views/common/head_app'); ?>
  <div class="div_center">
             <h3 style="text-align:center;width100%;color:#3785b3"><?=lang('Account Recovery')?> </h3>
      <hr/>
              <form name="forgot_form" id="forgot_form" action="" method="post">
      
        
        <?php if($msg):?>
        <div class="alert alert-danger"><?php echo $msg;?></div>
        <?php endif;?>
        <?php echo validation_errors(); ?> <?php echo $this->session->flashdata('msg');?>
        
        <span style="" class="input_label"><?=lang('Email')?> <b>*</b></span>  
      <div class="ara_row">
          <input type="email" name="email" id="email" class="form-control app_input" value="<?php echo set_value('email'); ?>" placeholder="Email" />
          </div>
       
        
      
        
       
          <div class="ara_row">
            <input type="submit" value="<?=lang('Recover Password')?>" class="btn btn-success" />
          </div>
        
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-9"><?=lang('Already a member')?>? <a href="<?php echo base_url('app/user/login');?>"><?=lang('Click Here')?></a></div>
        </div>
     
    </form>
                <div class="signupbox">
        <h4><?=lang('Not a member yet? Click Below to Sign Up')?></h4>
        <a href="<?php echo base_url('app/jobseeker_signup');?>" class="Ara_btn"><?=lang('Sign Up Now')?></a>
        <div class="clear"></div>
      </div>
      </div>
                
       <?php $this->load->view('common/after_body_open'); ?>
        <?php $this->load->view('common/before_body_close'); ?>
       
    </body>
</html>