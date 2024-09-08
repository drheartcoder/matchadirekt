<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;?>

<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/certificate" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">View Certificate</h2>
            </div>
        </div>
        <?php if(isset($results) && $results !='' ){ ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $results->pageTitle; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $results->pageSlug; ?></h6>
                    <ul>
                        <li>Created On: <span><?php echo date_formats($results->created_at, 'M j,Y'); ?></span></li>
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2">About Summary</h6>
                        <p><?=$results->pageContent; ?></p>
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
                <a href="<?php echo APPURL; ?>/employer/certificate" class="btn btn-blue">Back</a>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('application/inc/footer'); ?>
