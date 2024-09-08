<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>
<section class="bg-blue vheight-100">
    <div class="container h-100">
        <a href="<?php echo WEBURL; ?>/login" class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <div class="flash-screen pb-3">
                    <img src="<?php echo  $staticUrl; ?>/images/flash-screen.png" class="img-fluid">
                </div>
                <h4 class="text-white font-bold pt-4">MATCHADIREKT</h4>
            </div>
            <!-- col -->
        </a>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
