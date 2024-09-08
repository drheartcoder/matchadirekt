<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<?php //myPrint($jobData); ?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php $returnUrl = APPURL.'/seeker/home';
                if($returnTo == 1){
                    $returnUrl  = APPURL.'/seeker/settings/show-applications';
                } else if($returnTo == 2){
                    $returnUrl  = APPURL.'/seeker/my-cv';
                } 
                //echo $returnUrl;exit;
                 ?>
                <a href="<?php echo  $returnUrl ;?>" class="d-block">
                    <img src="<?php echo $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">View Job</h2>
            </div>
        </div>
        <?php if(isset($jobData) && $jobData!=''){ 
          // myPrint($jobData);die;
        ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $jobData->job_title; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $jobData->dated; ?></h6>
                    <ul>
                       <!--  <li class="h6">Ref. : <span>#JB00158</span></li> -->
                        <!-- <li class="h6">Diarienummer : <span>1</span></li> -->
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Industry: </h6><span class="font-med"><?php echo $jobData->industry_name; ?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/vacancy.svg">Total Positions: </h6><span class="font-med"><?php echo $jobData->vacancies;?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Job Type: </h6><span class="font-med"><?php echo $jobData->job_mode;?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Salary: </h6><span class="font-med"><?php echo $jobData->pay; ?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Job Location: </h6><span class="font-med"><?php echo $jobData->city; ?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Minimum Education: </h6><span class="font-med"><?php echo $jobData->qualification; ?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Minimum Experience: </h6><span class="font-med"><?php echo $jobData->experience; ?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Apply By: </h6><span class="font-med"><?php echo $jobData->last_date; ?></span></li>
                        <li class="py-1"><h6 class="h6 d-inline-block mb-0 mr-2"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Job Posting Date: </h6><span class="font-med"><?php echo $jobData->dated; ?></span></li>
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2">Job Description</h6>
                        <p><?php echo $jobData->job_description; ?></p>
                    </div>
                    <!-- <h6 class="mb-2">Attachment Files</h6>
                    <ul>
                        <li>
                            <h6><img src="images/file.svg" class="mr-2">File N:1</h6>
                            <a href="javascript:void(0)">Certificate.docx</a>
                        </li>
                    </ul> -->
                    <h6 class="mb-2">Skills Required</h6>
                    <ul class="skill-group mb-0">

                        
                        <?php
                          
                            if($jobData->required_skills != ""){
                                $skills = explode(",", $jobData->required_skills);
                                foreach($skills as $skill){
                                   ?>
                                    <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                                        <!-- <button type="button" class="close">
                                            <img src="<?php //echo $staticUrl;?>/images/skill-close.svg" class="w-100 svg">
                                        </button> -->
                                       <?php echo $skill; ?>
                                    </li>
                                   <?php
                                }     
                            }
                          
                           ?>
                       
                    </ul>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php 
} ?>
        <!-- row -->

    </div>
    <!-- container -->
    <?php if($returnTo == 0){
        ?>
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">

                    <a href="<?php echo APPURL; ?>/seeker/job/apply/<?php echo $jobData->JID; ?>" class="btn btn-blue">Apply Now</a>
                </div>
            </div>
        </div>
        <?php
    } else { ?>
         <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="javascript:void(0);" disabled="disabled" class="btn btn-blue">Alredy Applied</a>
                </div>
            </div>
        </div>
    <?php
    } ?>
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>