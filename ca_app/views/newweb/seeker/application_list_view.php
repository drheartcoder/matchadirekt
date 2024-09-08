<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
    //myPrint($data['result_applied_jobs']);exit;
        $jobData = $data;
?>
<section class="main-container vheight-100">
    <div class="container">
        <div class="row">
        <div class="col-12 col-md-10 col-lg-9 col-xl-9 mx-auto bg-white">
            <div class="row top-header bg-l-grey align-items-center">
                <div class="col-2">
                    <a href="<?php echo WEBURL; ?>/seeker/home" class="d-block">
                        <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                    </a>
                </div>
                <div class="col-8 text-center">
                    <h2 class="mb-0"><?=lang('Applications')?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card border-0 mt-1 details-block">
                        <div class="card-body px-0 py-2">
                            <ul class="messages-list mb-0">
                                <?php 
                                if(isset( $jobData ) &&  $jobData  != ""){
                                  // myPrint($jobData);die;
                                    foreach( $jobData  as $job){
                                    ?>      
                                    <li class="py-3 align-items-center px-3 bdr-btm">
                                        <div class="edit-block">
                                            <ul>
                                                <li><a href="<?php echo WEBURL; ?>/seeker/my-cv/delete-applied-job/<?php echo $job->applied_id; ?>/1" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                            </ul>
                                        </div>
                                        <div class="media-body">
                                            <div class="row align-items-center">
                                                <div class="col-6 card-title mb-0"><a href="<?php echo WEBURL; ?>/seeker/company/detail/<?php echo $job->company_ID;  ?>"><?php echo $job->company_name; ?> </a></div>
                                                <p class="col-6 text-d-grey mb-0"><?php echo date("F d,Y",strtotime($job->applied_date)); ?></p>
                                                <div class="col-12 card-title mb-0"><a href="<?php echo WEBURL; ?>/seeker/home/job-details/<?php echo $job->job_ID; ?>/1" class="text-blue"><small>Looking For <?php echo  $job->job_title; ?></small></a></div>
                                            </div>
                                        </div>
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
        </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>