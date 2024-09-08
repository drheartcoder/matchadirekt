<?php $this->load->view('newweb/inc/header'); ?>
<?php 
       $staticUrl = STATICWEBCOMPURL; 
?>
<section class="main-container vheight-100">
    <div class="container">
         <div class="row">
          <div class="col-12 col-md-10  col-lg-8 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">

                <?php 

                if($redirectTo == 1){
                    $redirectionUrl = WEBURL."/seeker/request";
                } else{
                    $redirectionUrl = WEBURL."/seeker/settings/show-applications";
                }
                ?>

                <a href="<?php echo $redirectionUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('My Company')?></h2>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12">
                <div class="py-3">
                    <h5 class="card-title mb-1"><?php echo $comp->first_name; ?></h5>
                  <!--   <h6 class="card-subtitle mb-2"><?php //echo $comp->industry_name; ?></h6> -->
                    <ul class="list-unstyled mb-0">
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo  $staticUrl; ?>/images/envelope.svg" alt="img" class="mr-2"><?php echo $comp->email; ?></h6>
                            </div>
                        </li>
                        <?php if(isset($comp->industry_name) && $comp->industry_name !=''){ ?>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo  $staticUrl; ?>/images/factory.svg" alt="img" class="mr-2"><?php echo $comp->industry_name; ?></h6>
                            </div>
                        </li>
                    <?php } ?>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo  $staticUrl; ?>/images/location.svg" alt="img" class="mr-2"><?php echo $comp->present_address; ?><?php echo $comp->company_location; ?></h6>
                            </div>
                        </li>
                         <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo  $staticUrl; ?>/images/cell-phone.svg" alt="img" class="mr-2"><?php echo $comp->company_phone; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo  $staticUrl; ?>/images/apply-date.svg" alt="img" class="mr-2"><?php echo date("M j,Y",strtotime($comp->dated)); ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo  $staticUrl; ?>/images/job-location.svg" alt="img" class="mr-2"><?php echo $comp->company_website; ?></h6>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12 p-0">
                <div class="card mt-1 border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0"><?=lang('About Company')?></h6>
                    </div>
                    <div class="card-body px-3 py-2">
                        <p class="mb-0"><?php echo $comp->company_description; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">Current Jobs in Crystal web techs</h6>
                    </div>
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php if(isset($postedJobs) && $postedJobs != ""){
                                foreach($postedJobs as $job){
                                    ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="<?php echo WEBURL; ?>/seeker/home/job-details/<?php echo $job->ID; ?>">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-0"><?php echo $job->job_title; ?>
                                                <p class="last-msg mb-0"><?php echo $job->company_name; ?></p>
                                            </div>
                                            <span class="col-5 text-d-grey">Last Date : <?php echo date("M j,Y",strtotime($job->last_date)); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                                }
                            } ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>