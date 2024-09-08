<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>

<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;

//myPrint($candidateDetails);die;?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php
                    if($redirectTo == 1){
                        $redirectUrl = APPURL."/employer/application";
                    } else if($redirectTo == 2){
                         $redirectUrl = APPURL."/employer/archives/archived-job/".$archiveId ;
                    }  else if($redirectTo == 3){
                         $redirectUrl = APPURL."/employer/candidate/view-candidate-details/".$candidateId."/".$jobId ;
                    } else {
                        $redirectUrl = APPURL."/employer/job";
                    }
                ?>
                <a href="<?php echo $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">View Job</h2>
            </div>
        </div> <?php //myPrint($jobData);die; ?>
        <?php if(isset($jobData) && $jobData !=''){ 
            $industryName = $this->My_model->getSingleRowData("tbl_job_industries","industry_name","ID = ".$jobData->industry_ID);
            //myPrint($jobData);die;
        ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1">Looking for <?php echo $jobData->job_title; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo date_formats($jobData->dated,'d,M'); ?></h6>
                    <ul>
                        <li class="h6">Ref. : <span>#JB<?=str_repeat("0",5-strlen($jobData->ID)).$jobData->ID?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/book.svg">Diary Number : <span><?php echo $jobData->diarie; ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/factory.svg">Industry: <span><?php echo $industryName->industry_name; ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/vacancy.svg">Total Positions: <span><?php echo $jobData->vacancies; ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/job-type.svg">Job Type: <span><?php echo $jobData->job_mode; ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/salary.svg">Salary: <span><?php echo $jobData->pay; ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/job-location.svg">Job Location: <span><?php echo $jobData->city.",".$jobData->country; ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/education.svg">Minimum Education: <span><?php echo $jobData->qualification; ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/experience.svg">Minimum Experience: <span><?php echo $jobData->experience ;?> years</span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/apply-date.svg">Apply By: <span><?php echo date_formats($jobData->last_date,'M d,Y'); ?></span></li>
                        <li class="h6"><img class="mr-2" src="<?php echo $staticUrl; ?>/images/apply-date.svg">Job Posting Date: <span><?php echo date_formats($jobData->dated,'M d,Y'); ?></span></li>
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2">Job Description</h6>
                        <p><?php echo $jobData->job_description; ?></p>
                    </div>
                    <h6 class="mb-2">Attachment Files</h6>
                     <ul>
                        <?php if(isset($result_files) && $result_files!="" ){
                               // myPrint($result_files);die;
                                  $i=0;
                  foreach($result_files as $row_file){
                $file_name = $row_file->file_name;
                $file_array = explode('.',$file_name);
                $file_array = array_reverse($file_array);
                $icon_name = get_extension_name($file_array[0]);$i++
            ?>                         
                        <li id="file_<?php echo $row_file->ID;?>">
                            <h6><img src="<?php echo  $staticUrl; ?>/images/file.svg" class="mr-2">File N:<?=$i?></h6>
                            <a href="<?php echo APPURL.'/employer/showfile'.$row_file->file_name;?>"><?php echo $row_file->file_name; ?></a>
                        </li>
                    <?php } 
                }
                    else{ echo "No file uploaded yet";} ?>

                    </ul>
                    <h6 class="mb-2">Skills Required</h6>

                    <ul class="skill-group mb-0">

                        <?php 
                              $skillList = $jobData->required_skills;
                              if($skillList != ""){
                                $skillArray = explode(",", $skillList);
                                foreach ($skillArray as $skill) {
                                  ?>
                        <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                           <?php echo $skill; ?>
                        </li>

                    <?php } 
                    }else{
                     echo "No Skills uploaded yet";
                    }  
                    ?>
                       <!--  <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                            CSS
                        </li>
                        <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                            JS
                        </li> -->
                    </ul>

                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    <?php } ?>

    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="<?php echo $redirectUrl; ?>" class="btn btn-blue">Back</a>
            </div>
        </div>
    </div>
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>