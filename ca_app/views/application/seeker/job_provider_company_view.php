<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                if($redirectTo == 1){
                    $redirectionUrl = APPURL."/seeker/request";
                } else{
                    $redirectionUrl = APPURL."/seeker/settings/show-applications";
                }
                ?>

                <a href="<?php echo $redirectionUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">My Company</h2>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12">
                <div class="py-3">
                    <h5 class="card-title mb-1"><?php echo $comp->first_name; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $comp->industry_name; ?></h6>
                    <ul class="list-unstyled mb-0">
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $comp->email; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $comp->industry_name; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo date("M j,Y",strtotime($comp->dated)); ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $comp->company_phone; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $comp->present_address; ?><?php echo $comp->company_location; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $comp->company_website; ?></h6>
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
                        <h6 class="text-white mb-0">About Company</h6>
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
                                        <a class="media" href="<?php echo APPURL; ?>/seeker/home/job-details/<?php echo $job->ID; ?>">
                                            <div class="media-body">
                                                <div class="row align-items-center">
                                                    <div class="col-6 card-title mb-0"><?php echo $job->job_title; ?>
                                                        <p class="last-msg mb-0">Company Name <?php echo $job->company_name; ?></p>
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
    <!-- container -->
</section>
<?php $this->load->view('application/inc/footer'); ?>