<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>
<section class="vheight-100 justify-content-between">
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="login.php" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <!-- <h2 class="mb-0">View Interview</h2> -->
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <h2 class="heading-1 text-blue mt-3">My number is</h2>
                <form class="row mt-4" action="" method="POST">
                    <div class="form-group col-4 mb-3">
                        <select class="form-control">
                            <option>+91</option>
                            <option>+1</option>
                            <option>+2</option>
                            <option>+3</option>
                            <option>+4</option>
                        </select>
                        <span></span>
                    </div>
                    <div class="form-group col-8 mb-3">
                        <input type="number" class="form-control" placeholder="Phone Number">
                        <span></span>
                    </div>
                    <div class="form-group col-7">
                        <div class="font-med">
                            <a href="#">Change your phone number?</a>
                        </div>
                    </div>
                    <div class="form-group col-5 text-right">
                        <div class="font-med">
                            <a href="<?php echo WEBURL.'/login/login-with-email'; ?>" class="text-underline">Login by Email</a>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <p>When you tap Continue, This app will send a text with verification code. Message and data rates may apply. The verified phone number can be used to login.</p>
                    </div>
                </form>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="mobile-otp.php" class="btn btn-blue">Continue</a>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
