<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>
<form  action="" method="POST">
<section class="vheight-100 justify-content-between">
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="login-with-phone.php" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <!-- <h2 class="mb-0">View Interview</h2> -->
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <h2 class="heading-1 text-blue mt-3">Login by Email</h2>
                <div class="row mt-4">
                    <div class="form-group col-12">
                        <input type="email" class="form-control" placeholder="Your Email Is">
                    </div>
                    <div class="form-group col-12">
                        <div class="font-med">We'll email you a link that will instantly log you in</div>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <button type="submit" name="btnContinue" class="btn btn-blue">Continue</button>
            </div>
        </div>
    </div>
</section>
</form>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
