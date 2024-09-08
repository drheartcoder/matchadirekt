<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<section class="bg-blue vheight-100 justify-content-between">
    <div class="container">
        <div class="col-11 col-md-10 col-lg-7 col-xl-6 mx-auto bg-white vh-center pb-4">
        	<div class="row">
        	<div class="col-11 col-sm-10 mx-auto recovery-sec">

        	 <h2 class="text-blue  font-bold pb-3 pb-lg-2 pt-4 text-center"><?=lang('Account Recovery')?></h2>

        	   <!--Login-->
    <form name="forgot_form" id="forgot_form" action="" method="POST">
      
      <div class="loginbox">
      <?php if($msg):?>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <?php echo $msg;?>
                                    </div>
                                </div>
                            <?php endif;?>
        <div class="row">
         <!--  <div class="col-md-3">
            <label class="input-group-addon"><?=lang('Email')?> <span>*</span></label>
          </div> -->
          <div class="col-md-12 mb-3">
            <input type="email" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="<?=lang('Email')?>" required/>
          </div>
        </div>
        <div class="row">
      
        </div>
    <!--     <div class="row">
        	<div class="col-md-12">
            <label class="input-group-addon"><?=lang(' Please enter the code below ')?> : <?php echo $cpt_code;?></label>
          </div>
          <div class="col-md-9"> -->
           <!--  <label class="input-group-addon"></label> -->
          <!-- </div>
          <div class="col-md-12 mb-3">
            <input type="text" name="captcha" id="captcha" class="form-control" placeholder="<?=lang('Verification Code')?>" required/>
          </div>
        </div> -->
        <div class="row">
        <!--   <div class="col-md-12"></div> -->    
        <div class="col-md-12 text-center my-2">
            <input type="submit" value="<?=lang('Recover Password')?>" class="btn btn-comm bg-blue text-white" name="btnForgotPass" />
          </div>
        </div>
        <div class="row">
    <!--       <div class="col-md-3"></div> -->
          <div class="col-md-12 mb-3 text-center mt-3"><?=lang('Already a member')?>? <a href="<?php echo WEBURL; ?>/login"><?=lang('Click Here')?></a></div>
        </div>
      </div>
    </form>
    <!--/Login-->
     
        <!-- row -->
    </div>
</div>
</div>
    </div>

    <style>

/*.socil-icon {
    height: 40px;
    line-height: 40px;
    width: 40px;
    margin:0px 5px;

    border-radius: 50%;
   border:1px solid #f2f2f2;
    font-size: 20px;
  
}*/
</style>
    <!-- container -->
</section>






<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>


