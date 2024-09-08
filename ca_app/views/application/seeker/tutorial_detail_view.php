<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/tutorials" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">View Tutorial</h2>
            </div>
        </div>
        <?php if(isset($tutorialData) && $tutorialData!=0){
            //myPrint($tutorialData);die;
         ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $tutorialData->tutorial_name;?></h5>
                    <ul>
                        <li>Industry Name: <span><?php echo $tutorialData->industry_name;?></span></li>
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2">About Summary</h6>
                        <p><?php echo $tutorialData->tutorial_description;?></p>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php } ?>
        <!-- row -->
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="<?php echo APPURL; ?>/seeker/tutorials" class="btn btn-blue">Back</a>
            </div>
        </div>
    </div>
</section>
<!-- section -->

<?php $this->load->view('application/inc/footer'); ?>