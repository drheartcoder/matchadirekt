<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
?>
<section class="bg-blue py-4 vheight-100">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <!-- <div class="flash-screen px-4">
                    <img src="<?php echo  $staticUrl; ?>/images/flash-screen.png" class="img-fluid">
                </div> -->
                <h4 class="text-white font-bold py-4">MATCHADIREKT</h4>
                <form action="" method="POST" >
                    
                            <?php if($msg):?>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="alert alert-danger"><?php echo $msg;?></div>
                                    </div>
                                </div>
                            <?php endif;?>
                        
                    <div class="row mt-4">
                        <div class="form-group col-12">
                            <input type="email" class="form-control text-white" name="email" placeholder="Your Email Is">
                        </div>
                        <div class="form-group col-12">
                            <input type="password" class="form-control text-white" name="pass" placeholder="Your Password">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-white-outline" name="btnLogin">Login</button>
                    </div>
                </form>
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="font-med text-white">
                            New user? <a href="<?php echo APPURL; ?>/registration" class="text-white text-underline">Sign up!</a>
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
<?php $this->load->view('application/inc/footer'); ?>
