<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>



<div class="main-container  vheight-100">
    <div class="container">
        <div class="row">
        <div class="col-12 col-lg-9 col-xl-9 mx-auto  pb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-11 text-center bg-white mx-auto">
                <!-- <div class="flash-screen px-4">
                    <img src="<?php echo  $staticUrl; ?>/images/flash-screen.png" class="img-fluid">
                </div> -->
                 <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                $this->load->library('Mobile_Detect');
                $detect = new Mobile_Detect();
                if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
                    $redirectUrl =WEBURL."/seeker/settings";
                } else {
                    $redirectUrl = WEBURL."/seeker/home";
                }
                ?>
                <a href="<?php echo  $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Change Password')?></h2>
            </div>
           
        </div>
                <form action="#" method="POST">
                            <?php if($msg):?>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <?php echo $msg;?>
                                    </div>
                                </div>
                            <?php endif;?>
                        
                    <div class="row mt-4">
                        <div class="form-group col-12">
                            <input type="password" class="form-control" name="old_pass" placeholder="<?php echo lang('Current Password')?>">
                        </div>
                        <div class="form-group col-12">
                            <input type="password" class="form-control" name="new_pass" placeholder="<?php echo lang('New Password')?>">
                        </div>
                         <div class="form-group col-12">
                            <input type="password" class="form-control" name="confirm_pass" placeholder="<?php echo lang('Confirmed Password')?>">
                        </div>
                    </div>
                    <div class="form-group text-center mb-3 mt-2">
                        <button type="submit" class="btn btn-comm btn-blue" name="btnChangePass"><?php echo lang('Submit'); ?></button>
                    </div>
                </form>
              
               
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
</div>
    </div>

    <style>

</style>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>


