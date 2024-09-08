<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">My CV</h2>
            </div>
        </div>
        <div class="row">
            <div class="user-img">
                <?php 
                    $defaultUser = $staticUrl."/images/user.png";
                    $imgUrl = "";
                    $pht=$data->photo;
                   /* if($pht=="") $pht='no_pic.jpg';
                         $imgUrl = base_url('public/uploads/candidate/'.$pht);*/
                        $defaultUser = $staticUrl."/images/user.png";
                        $imgUrl = "";
                        //$pht=$photoData->photo;
                        if($pht!="" && file_exists('public/uploads/candidate/'.$pht)) 
                            $imgUrl = PUBLICURL.'/uploads/candidate/'.$pht;
                        else
                            $imgUrl= $defaultUser; 
                ?>

                <img src="<?php echo  $imgUrl; ?>" class="w-100">
                <div class="user-info">
                    <h5 class="card-title mb-1 text-white font-semi"><?php echo $data->first_name; ?></h5>
                    <h6 class="card-subtitle mb-2 text-white"><?php //echo $data->first_name; ?> Designer</h6>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12">
                <div class="py-3">
                    <ul class="list-unstyled mb-0">
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $data->email; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $data->mobile; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo date('d M Y', strtotime($data->dated)); ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $data->present_address; ?>,<?php echo $data->city; ?>,<?php echo $data->country; ?></h6>
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
                <div class="card border-0 details-block">
                    <div class="card-header py-0 px-3 bg-blue border-0 rounded-0">
                        <div class="row align-items-center">
                            <h6 class="text-white mb-0 col-10">Document</h6>
                            <div class="col-2 px-0 text-right">
                                <a href="<?php echo APPURL; ?>/seeker/my-cv/add-document" class="btn btn-blue add-btn rounded-0">
                                    <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                </a>
                            </div> 
                        </div>
                    </div>
                    <div class="card-body px-3">
                        <ul>
                            <?php 
                            if(isset($resumeData) && $resumeData !=""){
                                foreach($resumeData as $data){
                                    ?>
                                    <li>
                                        <h6><img src="<?php echo  $staticUrl; ?>/images/file.svg" class="mr-2">File N:1</h6>
                                        <a href="https://docs.google.com/viewerng/viewer?url=<?php echo BASEURL; ?>/public/uploads/candidate/resumes/<?php echo $data->file_name;?>" target="_blank" ><?php echo $data->file_name; ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-0 px-3 bg-blue border-0 rounded-0">
                        <div class="row align-items-center">
                            <h6 class="text-white mb-0 col-10">Professional Summary</h6>
                            <div class="col-2 px-0 text-right">
                                <a href="<?php echo APPURL; ?>/seeker/my-cv/edit-about" class="btn btn-blue add-btn rounded-0">
                                    <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-3">
                        <p class="mb-0"><?php echo $additionalData->summary; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-0 px-3 bg-blue border-0 rounded-0">
                        <div class="row align-items-center">
                            <h6 class="text-white mb-0 col-10">Experience</h6>
                            <div class="col-2 px-0 text-right">
                                <a href="<?php echo APPURL; ?>/seeker/my-cv/add-experience" class="btn btn-blue add-btn rounded-0">
                                    <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0" id="expUl">
                            <?php 
                            if(isset($experienceData) && $experienceData != ""){
                                $countExpData = count($experienceData );
                                $i =1;
                                foreach($experienceData as $exp){
                                    ?>
                                    <li class="py-3 align-items-center px-3 <?php if($i<$countExpData) echo 'bdr-btm'; ?> ">
                                        <div class="edit-block">
                                            <ul>
                                                <li><a href="<?php echo APPURL;?>/seeker/my-cv/delete-experience/<?php echo $exp->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                                <li><a href="<?php echo APPURL;?>/seeker/my-cv/edit_experience/<?php echo $exp->ID; ?>" class="bg-blue"><img src="<?php echo $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                            </ul>
                                        </div>
                                        <a class="media" href="javascript:void(0)">
                                            <div class="media-body">
                                                <div class="row align-items-center">
                                                    <div class="col-12 card-title mb-2"><?php echo $exp->job_title; ?></div>
                                                    <p class="col-12 h6 last-msg mb-2 text-blue"><?php echo $exp->company_name; ?></p>
                                                    <span class="col-12 text-d-grey"> <?php echo $exp->city; ?> , <?php echo $exp->country; ?></span>
                                                    <span class="col-12 text-d-grey"><?php echo date('M Y', strtotime($exp->start_date)); ?>  to  <?php echo ($exp->end_date != "") ? date('M Y', strtotime($exp->end_date)) : "Present" ; ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                    $i++;
                                }
                            }

                            ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-0 px-3 bg-blue border-0 rounded-0">
                        <div class="row align-items-center">
                            <h6 class="text-white mb-0 col-10">Education</h6>
                            <div class="col-2 px-0 text-right">
                                <a href="<?php echo APPURL; ?>/seeker/my-cv/add_education" class="btn btn-blue add-btn rounded-0">
                                    <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0" id="eduUl">
                            <?php 
                            
                            if(isset($educationData) && $educationData != ""){
                                $countEduData = count($educationData );
                                $i =1;
                                foreach($educationData as $edu){
                            ?>
                            <li class="py-3 align-items-center px-3  <?php if($i<$countEduData) echo 'bdr-btm'; ?>">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="<?php echo APPURL;?>/seeker/my-cv/delete-education/<?php echo $edu->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                        <li><a href="<?php echo APPURL;?>/seeker/my-cv/edit-education/<?php echo $edu->ID; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2"><?php echo $edu->degree_title; ?></div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue"><?php echo $edu->institude; ?></p>
                                            <span class="col-12 text-d-grey"><?php echo $edu->completion_year; ?></span>
                                            <span class="col-12 text-d-grey"><?php echo $edu->city; ?> , <?php echo $edu->country; ?> </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php 
                            $i++;
                            }
                        }
                            ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">Applications</h6>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0" id="jobAppUl">
                            <?php
                            if(isset($jobApplicationData) && $jobApplicationData != ""){
                                $countAppData = count($jobApplicationData );
                                $i =1;
                                foreach($jobApplicationData as $job){
                            ?>
                            <li class="py-3 align-items-center px-3 <?php if($i<$countAppData) echo 'bdr-btm'; ?>">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="<?php echo APPURL; ?>/seeker/my-cv/delete-applied-job/<?php echo $job->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                        <!-- <li><a href="edit-certificate.php" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li> -->
                                    </ul>
                                </div>
                                <h5 class="card-title mb-2"><a href="<?php echo APPURL; ?>/seeker/home/job-details/<?php echo $job->job_ID; ?>/2"><?php echo $job->job_title; ?></a></h5>
                                <h6 class="card-subtitle mb-2">Company <span><?php echo $job->company_name; ?></span></h6>
                                <h6 class="card-subtitle mb-2">Skills level <span><?php echo str_replace("<hr>","",$job->skills_level); ?></span></h6>
                                <h6 class="card-subtitle mb-2">Pay <span><?php echo $job->pay; ?></span></h6>
                                <h6 class="card-subtitle mb-0">Date <span> <?php echo date('d M Y', strtotime($job->dated)); ?></span></h6>
                            </li>
                            <?php 
                                    $i++;
                                }
                            }
                            ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-0 px-3 bg-blue border-0 rounded-0">
                        <div class="row align-items-center">
                            <h6 class="text-white mb-0 col-10">Skills</h6>
                            <div class="col-2 px-0 text-right">
                                <a href="<?php echo APPURL; ?>/seeker/my-cv/add_skills" class="btn btn-blue add-btn rounded-0">
                                    <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-3 py-3">
                        <ul class="skill-group">
                            <?php if(isset($skillData) && $skillData != ""){
                                foreach($skillData as $skill){ ?>
                                <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                                    <a href="<?php echo APPURL; ?>/seeker/my-cv/add_skills" class="close">
                                        <img src="<?php echo  $staticUrl; ?>/images/skill-close.svg" class="w-100 svg">
                                    </a>
                                    <?php echo $skill->skill_name; ?>
                                </li>
                            <?php
                                }
                            } 
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>