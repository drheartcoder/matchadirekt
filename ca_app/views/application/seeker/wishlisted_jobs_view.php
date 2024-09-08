<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Wishlist</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php
                            if(isset($wishlistedJobs) && $wishlistedJobs != "" ){
                                foreach($wishlistedJobs as $job){
                                    ?>
                                    <li class="py-3 align-items-center px-3 bdr-btm">
                                        <div class="edit-block">
                                            <ul>
                                                <li><a href="<?php echo APPURL; ?>/seeker/job/remove-wishlist-jobs/<?php echo $job->ID; ?>" class="bg-red"><img src="<?php echo $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                            </ul>
                                        </div>
                                        <a class="media" href="<?php echo APPURL; ?>/seeker/home/job-details/<?php echo $job->job_ID; ?>">
                                            <div class="media-body">
                                                <div class="row align-items-center">
                                                    <div class="col-12 card-title mb-0">Looking for <?php echo $job->job_title; ?></div>
                                                        <p class="col-12 text-blue mb-0">Company Name <?php echo $job->company_name; ?></p>
                                                        <p class="col-12 text-d-grey mb-0"><?php echo date('d M Y', strtotime($job->dated)); ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>