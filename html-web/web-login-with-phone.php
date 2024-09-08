<?php include 'header.php'; ?>

   <section class="vheight-100 justify-content-between">
       <div class="container">
           <div class="col-11 col-lg-8 col-xl-6 mx-auto bg-white vh-center">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="web-login.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <!-- <h2 class="mb-0">View Interview</h2> -->
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 mx-auto p-4 bg-f-blue">
                <h2 class="heading-1 text-blue mt-3">My number is</h2>
                <form class="row mt-4 no-form" action="web-login-with-phone.php">
                    <div class="form-group col-4 col-xl-3 mb-3">
                        <select class="form-control">
                            <option>+91</option>
                            <option>+1</option>
                            <option>+2</option>
                            <option>+3</option>
                            <option>+4</option>
                        </select>
                        <span></span>
                    </div>
                    <div class="form-group col-8 col-xl-9  mb-3">
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
                            <a href="web-login-with-email.php" class="text-underline">Login by Email</a>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <p>When you tap Continue, This app will send a text with verification code. Message and data rates may apply. The verified phone number can be used to login.</p>
                    </div>
                     <a href="web-mobile-otp.php" class="btn-comm btn-blue mx-3 my-2">Continue</a>
                </form>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
    </div>
 
        
</section>
   
     


<!-- section -->
<?php include 'footer.php'; ?>
