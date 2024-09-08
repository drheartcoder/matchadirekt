<?php $this->load->view('newweb/inc/header'); ?>

<?php 
    $staticUrl = STATICWEBCOMPURL; 
    //myPrint($_SESSION);exit;

?>

  <section class="main-container vheight-100 justify-content-between">
     <div class="container">
        <div class="row">
       <div class="col-12 col-lg-9 col-xl-8 mx-auto">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/interview" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('View Interview')?></h2>
            </div>
        </div>
         <?php if(isset($results) && $results !=''){  ?>
        <div class="row align-items-center">
            <div class="col-12 p-0">
                <div class="card py-3 px-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $results->pageTitle; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $results->pageSlug; ?></h6>
                   <!--  <p>Demo NOTE: You can edit this default content on admin CMS page </p> -->
                    <ul>
                        <li>Created On : <span><?php echo date_formats($results->created_at,'M j,Y'); ?></span></li> 
                        <!-- <li>Classification: <span>Lorem Ipsum</span></li>
                        <li>Department/Division: <span>Lorem Ipsum</span></li>
                        <li>Location: <span>Lorem Ipsum</span></li>
                        <li>Pay Grade: <span>Lorem Ipsum</span></li> -->
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2"><?=lang('About Summary')?></h6>
                      <p><?php echo $results->pageContent; ?></p>
                    </div>
                     <a href="<?php echo WEBURL; ?>/employer/interview" class="btn-comm btn-blue my-4"><?=lang('Back')?></a>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    <?php } ?>
    </div>
    <!-- container -->
</div>
  
</section>
<!-- section -->



<?php $this->load->view('newweb/inc/footer'); ?>