<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>
<section class="main-container vheight-100">
    <div class="container">
        <div class="row">
       <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/tutorialadmin" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('View Tutorial')?></h2>
            </div>
        </div>
         <?php if(isset($tutorialData) && $tutorialData!=0){
            //myPrint($tutorialData);die;
         ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $tutorialData->tutName;?></h5>
                    <ul>
                        <!-- <li><?=lang('Industry Name')?>: <span><?php echo $tutorialData->industry_name;?></span></li> -->
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2"><?=lang('About Summary')?>:</h6>
                        <p><?php echo $tutorialData->tutDescrip;?></p>
                    </div>
                    <a href="<?php echo WEBURL; ?>/tutorialadmin" class="btn-comm btn btn-blue"><?=lang('Back')?></a>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php } ?>
        <!-- row -->
    </div>
    <!-- container -->
   </div>
</section>
<!-- section -->


<?php $this->load->view('newweb/inc/footer'); ?>