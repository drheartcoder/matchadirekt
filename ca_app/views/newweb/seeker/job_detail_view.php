<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>
<?php //myPrint($jobData); ?>



<section class="main-container vheight-100">
    <div class="container">
<div class="row">
          <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                  <?php $returnUrl = WEBURL.'/seeker/home';
                if($returnTo == 1){
                    $returnUrl  = WEBURL.'/seeker/settings/show-applications';
                } else if($returnTo == 2){
                    $returnUrl  = WEBURL.'/seeker/my-cv';
                }  else if($returnTo == 3){
                    $returnUrl  = WEBURL.'/seeker/notification';
                } 
                //echo $returnUrl;exit;
                 ?>
                  <a href="<?php echo  $returnUrl ;?>" class="d-block">
                    <img src="<?php echo $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
                <!-- <a href="job-tiles.php" class="d-block">
                    <img src="<?php //echo $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a> -->
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('View Job')?></h2>
            </div>
        </div>
        <?php if(isset($jobData) && $jobData!=''){ 
          //myPrint($jobData);
//myPrint(strtotime($jobData->dated));

          // die;
        ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="py-3">
                    <h5 class="card-title mb-1"><?php echo $jobData->job_title; ?></h5>
                    <h6 class="card-subtitle mb-2 text-blue"><span class="text-d-grey"><?php echo date_formats($jobData->dated, 'd M , Y'); ?></span></h6>
                    <ul id="main">
                      <!--   <li class="h6"><img src="<?php //echo $staticUrl; ?>/images/refer.svg" alt="img" class="mr-2">Ref. : <span>#JB00158</span></li> -->
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/daino.svg" alt="img" class="mr-2"><?=lang('Diarienummer')?> : <span><?php echo $jobData->diarie; ?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/factory.svg" alt="img" class="mr-2"><?=lang('Industry')?>: <span><?php echo $jobData->industry_name; ?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/vacancy.svg" alt="img" class="mr-2"><?=lang('Total Positions')?>: <span><?php echo $jobData->vacancies;?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/job-type.svg" alt="img" class="mr-2"><?=lang('Job Type')?>: <span><?php echo $jobData->job_mode;?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/salary.svg" alt="img" class="mr-2"><?=lang('Salary')?>: <span><?php echo $jobData->pay; ?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/job-location.svg" alt="img" class="mr-2"><?=lang('Job Location')?>: <span><?php echo $jobData->city; ?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/education.svg" alt="img" class="mr-2"><?=lang('Minimum Education')?>: <span><?php echo $jobData->qualification; ?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/experience.svg" alt="img" class="mr-2"><?=lang('Minimum Experience')?>: <span><?php echo $jobData->experience; ?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/apply-date.svg" alt="img" class="mr-2"><?=lang('Apply By')?>: <span><?php echo date_formats($jobData->last_date, 'd M , Y'); ?></span></li>
                        <li class="h6"><img src="<?php echo $staticUrl; ?>/images/apply-date.svg" alt="img" class="mr-2"><?=lang('Job Posting Date')?>: <span><?php echo date_formats($jobData->dated, 'd M , Y'); ?></span></li>
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2"><?=lang('Job Description')?></h6>
                        <p><?php echo $jobData->job_description; ?></p>
                    </div>
                    <h6 class="mb-2"><?=lang('Skills Required')?></h6>
                    <ul class="skill-group">
                         <?php
                          
                            if($jobData->required_skills != ""){
                                $skills = explode(",", $jobData->required_skills);
                                foreach($skills as $skill){
                                   ?>
                        <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2"> <?php echo $skill; ?></li>
                              <?php
                                }     
                            }
                          
                           ?>
                    </ul>
                   <a class="text-white bg-blue px-2 py-2 " href="#" id="mapID" title="" onclick="funAccept();"><i class="fas fa-map-marker-alt mr-2"></i>Location</a> 
                   <!--  <div class="about-summary">
                        <h6 class="mb-2">Responsibilities and Duties</h6>
                        <ul class="style-list">
                            <li class="mb-2">Should be able to create creative UI for mobile application and website as per requirements.</li>
                            <li class="mb-2">Proficiency in HTML, HTML5, CSS, CSS3, and JavaScript, jQuery.</li>
                            <li class="mb-2">Should be able to create creative UI for mobile application and website as per requirements.</li>
                            <li class="mb-2">Proficiency in HTML, HTML5, CSS, CSS3, and JavaScript, jQuery.</li>
                            <li class="mb-2">Should be able to create creative UI for mobile application and website as per requirements.</li>
                            <li class="mb-2">Proficiency in HTML, HTML5, CSS, CSS3, and JavaScript, jQuery.</li>
                        </ul>
                    </div> -->
                    <!-- <div class="about-summary">
                        <h6 class="mb-2">Required Experience, Skills and Qualifications</h6>
                        <ul class="style-list mb-0">
                            <li class="mb-2">Min 1 to 3 years relevant experience.</li>
                            <li class="mb-2">Up-to-date knowledge of design software</li>
                            <li class="mb-2">Team spirit, Strong communication skills</li>
                            <li class="mb-2">Good time-management skills</li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <!-- col -->
        </div>
          <?php 
} ?>
     
        <!-- row -->
    </div>
</div>
</div>
    <!-- container -->
    <?php if($returnTo == 0){
        ?>
        <div class="container">
            <div class="row">
                <div class="col-5 my-3 mx-auto">

                    <a href="<?php echo WEBURL; ?>/seeker/job/apply/<?php echo $jobData->JID; ?>" class="btn btn-blue"><?=lang('Apply Now')?></a>
                </div>
            </div>
        </div>
        <?php
    } else { ?>
         <div class="container">
            <div class="row">
                <div class="col-12  my-3 mx-auto text-center">
                    <a href="javascript:void(0);" disabled="disabled" class="btn btn-comm btn-blue">Alredy Applied</a>
                </div>
            </div>
        </div>
    <?php
    } ?>

</section>
<!-- section -->
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
<script type="text/javascript">
    
function funAccept() {
    var jobId =<?php echo $jobData->JID; ?> ;
   // console.log(jobId);exit;
    // $("#main :input").attr("value");
    var myKeyVals = { "jobId": jobId };
    $.ajax({
        type: 'POST',
        url: "<?php echo WEBURL.'/seeker/job/job_location';?>",
        data: myKeyVals,
        //alert(data);die;
        dataType: "text",
        success: function(resultData) {
            if (resultData === "0") {
                $('#mapID').attr('title','No Data defined');
                //alert(0)
            } else {
                //window.location.reload();
                //window.open($(this).attr("https://www.google.com/maps/@"+resultData+",23569m/data=!3m1!1e3?hl=en-US"), "popupWindow", "width=600,height=600,scrollbars=yes");
                window.open("https://www.google.com/maps/@"+resultData+",23569m/data=!3m1!1e3?hl=en-US");
            }
        }
    });
}
</script>


