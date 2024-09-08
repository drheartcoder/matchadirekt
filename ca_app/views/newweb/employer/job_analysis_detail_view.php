
<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php $staticUrl = STATICWEBCOMPURL; ?>
<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/job-analysis" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('View Analysis')?></h2>
            </div>
        </div>
        <?php if(isset($results) && $results !=''){ ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $results->pageTitle; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $results->pageSlug; ?></h6>
                 <!--    <p>Demo NOTE: You can edit this default content on admin CMS page </p> -->
                    <ul>
                        <li><?=lang('Created On:')?> <span><?php echo $results->created_at; ?></span></li>
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2"><?=lang('About Summary')?></h6>
                        <p><?php echo $results->pageContent; ?></p>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php } ?>
        <!-- row -->
        <div class="col-12 text-center mb-3">
                <a href="<?php echo WEBURL; ?>/employer/job-analysis/" class="btn btn-comm btn-blue"><?=lang('Back')?></a>
            </div>
    </div>
    <!-- container -->
   <!--  <div class="container">
        <div class="row">
            
        </div>
    </div> -->
</div>
    </div>
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>