<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
    //myPrint($_SESSION);exit;?>
<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/certificate" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('View Certificate')?></h2>
            </div>
        </div>
        <?php if(isset($results) && $results !='' ){ ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $results->pageTitle; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $results->pageSlug; ?></h6>
                    <ul>
                        <li><?=lang('Created On')?>: <span><?php echo date_formats($results->created_at, 'M j,Y'); ?></span></li>
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2"><?=lang('About Summary')?></h6>
                        <p><?=$results->pageContent; ?></p>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
        <?php } ?>
        <!-- row -->
        <div class="col-12 mx-auto bg-white text-center mb-3">
                    <a href="<?php echo WEBURL; ?>/employer/certificate" class="btn btn-comm btn-blue"><?=lang('Back')?></a>
            </div>
    </div>
    <!-- container -->
       <!--  <div class="container">
            
        </div> -->
    </div>
</div>
</section>
<?php $this->load->view('newweb/inc/footer'); ?>
