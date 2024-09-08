<?php include 'header.php'; ?>
<section class="vheight-100 justify-content-between">
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="login-with-phone.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <!-- <h2 class="mb-0">View Interview</h2> -->
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <h2 class="heading-1 text-blue mt-3">Login by Email</h2>
                <form class="row mt-4" action="login-with-phone.php">
                    <div class="form-group col-12">
                        <input type="email" class="form-control" placeholder="Your Email Is">
                    </div>
                    <div class="form-group col-12">
                        <div class="font-med">We'll email you a link that will instantly log you in</div>
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
                <a href="check-email.php" class="btn btn-blue">Continue</a>
            </div>
        </div>
    </div>
</section>
<!-- section -->
<?php include 'footer.php'; ?>