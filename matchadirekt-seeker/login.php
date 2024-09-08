<?php include 'header.php'; ?>
<section class="bg-blue py-4 vheight-100">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <div class="flash-screen px-4">
                    <img src="images/flash-screen.png" class="img-fluid">
                </div>
                <h4 class="text-white font-bold py-4">MATCHADIREKT</h4>
                <form action="login-with-phone.php">
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-white">Login with Google</button>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-white-outline">Login with Phone Number</button>
                    </div>
                </form>
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="font-med text-white">
                            New user? <a href="register-seeker.php" class="text-white text-underline">Sign up!</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php include 'footer.php'; ?>