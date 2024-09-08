<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>
<section class="vheight-100">
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="login-with-email.php" class="d-block">
                    <img src="<?php echo $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <!-- <h2 class="mb-0">View Interview</h2> -->
            </div>
        </div>
        <div class="row h-100-header align-items-center">
            <div class="col-12 text-center">
              <h5 class="mb-4">Check your email!</h5>
              <p class="mb-3">If we found an account with test@test.com, an email has been sent. Please check your email in a moment.</p>
              <h6 class="mb-3">Didn't receive a link?</h6>
              <h5 class="mb-3"><small><a href="<?php echo  WEBURL.'/login/login-with-email'; ?>" class="text-underline">Use a different email</a></small></h5>
              <h5><small><a href="<?php echo  WEBURL.'/login/login-with-mobile'; ?>" class="text-underline">Use your phone number</a></small></h5>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
