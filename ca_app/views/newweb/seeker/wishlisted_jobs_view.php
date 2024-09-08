<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>
<section class="main-container vheight-100">
    <div class="container">
        <div class="row">
          <div class="col-12 col-lg-8 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Wishlist')?></h2>
            </div>
        </div>

        <?php if(isset($wishlistedJobs) && $wishlistedJobs != "" ){ 
           // myPrint($wishlistedJobs);die;?>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php
                                foreach($wishlistedJobs as $job){
                                    ?>
                                    <li class="py-3 align-items-center px-3 bdr-btm">
                                        <div class="edit-block">
                                            <ul>
                                                <li><a href="<?php echo WEBURL; ?>/seeker/job/remove-wishlist-jobs/<?php echo $job->ID; ?>" class="bg-red"><img src="<?php echo $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                            </ul>
                                        </div>
                                        <a class="media" href="<?php echo WEBURL; ?>/seeker/home/job-details/<?php echo $job->job_ID; ?>">
                                            <div class="media-body">
                                                <div class="row align-items-center">
                                                    <div class="col-12 card-title mb-0">Looking for <?php echo $job->job_title; ?></div>
                                                        <p class="col-12 text-blue mb-0"><?=lang('Company Name')?> <?php echo $job->company_name; ?></p>
                                                        <p class="col-12 text-d-grey mb-0"><?php echo date('d M Y', strtotime($job->dated)); ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>