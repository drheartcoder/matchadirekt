<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo WEBURL.'/employer/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php $staticUrl = STATICWEBCOMPURL; ?>
<?php if(isset($candidateDetails) && $candidateDetails !=''){ ?>

<section class="main-container vheight-100 justify-content-between">
  <div class="container">
      <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                if($redirectTo ==1){
                    $redirectUrl =  WEBURL."/employer/application";
                } else if($redirectTo == 2){
                    $redirectUrl =  WEBURL."/employer/invitations";
                }  else if($redirectTo == 3){
                    $redirectUrl =  WEBURL."/employer/candidate/wishlisted-candidates";
                }  else if($redirectTo == 4){
                    $redirectUrl =  WEBURL."/employer/candidate/view-candidate-details/". $candidateDetails->ID."/".$jobId;
                }  else if($redirectTo == 5){
                    $redirectUrl =  WEBURL."/employer/invitations/manage-schedule/".$employer_id."/".$jobseeker_id;
                }   else if($redirectTo == 6){
                    $redirectUrl =  WEBURL."/employer/notification";
                } else if($redirectTo == 7){
                    $redirectUrl =  WEBURL."/employer/search";
                } else {
                    $redirectUrl = WEBURL."/employer/company";
                }
                ?>

                <a href="<?php echo $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Full Post')?></h2>
            </div>
        </div>
        <?php //myPrint($candidateDetails);die; ?>
        <div class="row mt-1">
            <div class="col-12">
                <div class="py-3">
                    <h5 class="card-title mb-1"><?php echo $candidateDetails->first_name; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $latest_job_title; ?></h6>
                    <ul class="list-unstyled mb-0">
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo $staticUrl; ?>/images/envelope.svg" class="mr-2"><?php echo $candidateDetails->email; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo $staticUrl; ?>/images/cell-phone.svg" class="mr-2"><?php echo $candidateDetails->mobile; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo $staticUrl; ?>/images/apply-date.svg" class="mr-2"><?php echo date_formats($candidateDetails->dob, 'd M, Y');?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><img src="<?php echo $staticUrl; ?>/images/job-location.svg" class="mr-2"><?php echo $candidateDetails->present_address; ?></h6>
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
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0"><?=lang('Document')?></h6>
                    </div>
                    <div class="card-body px-3">
                        <ul>
                            <?php 
                            if(isset($documents) && $documents != ""){
                                foreach ($documents as $doc) {
                                
                                ?>
                                <li>
                                    <h6><img src="<?php echo  $staticUrl; ?>/images/file.svg" class="mr-2"><?php echo $doc->file_name;?></h6>
                                    <a href="javascript:void(0)"><?php echo $doc->file_name;?></a>
                                </li>
                                <?php  }
                            }else{ echo "No Data found";} ?>
                        
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0"><?=lang('About')?> <?php echo $candidateDetails->first_name; ?></h6>
                    </div>
                    <div class="card-body px-3">
                        <p class="mb-0"><?php echo $additionalInfo->summary;?></p>
                    </div>
                </div>
            </div>
           <!--  <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">References</h6>
                    </div>
                    <div class="card-body px-3">
                        <h5 class="card-title mb-2">test test</h5>
                        <h6 class="card-subtitle mb-2">Title: <span>Test</span></h6>
                        <h6 class="card-subtitle mb-2">Phone: <span>7965423640</span></h6>
                        <h6 class="card-subtitle mb-2">Email: <span>test@test.com</span></h6>
                    </div>
                </div>
            </div> -->
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0"><?=lang('Experience')?></h6>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0">
                            <?php
                            if(isset($experience) && $experience != ""){
                             foreach ($experience as $exp) {
                                # code...
                            ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2"><?php echo $exp->job_title; ?></div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue"><?php echo $exp->company_name; ?></p>
                                            <span class="col-12 text-d-grey"><?php echo $exp->city.",".$exp->country; ?></span>
                                            <span class="col-12 text-d-grey"><?php echo $exp->start_date ." to " . $exp->end_date; ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } }else{ echo "No Data found";}  ?>
                            <!-- <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">Web Designer</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">Crystal Web Techs</p>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                            <span class="col-12 text-d-grey">Apr 2018 to Present</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">Web Designer</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">Crystal Web Techs</p>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                            <span class="col-12 text-d-grey">Apr 2018 to Present</span>
                                        </div>
                                    </div>
                                </a>
                            </li> -->
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0"><?=lang('Education')?></h6>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0">
                            <?php 
                            if(isset($qualification) && $qualification != "") {
                            foreach ($qualification as $qualif) {
                                # code...
                            ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2"><?php echo $qualif->degree_title; ?></div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue"><?php echo $qualif->institude; ?></p>
                                            <span class="col-12 text-d-grey"><?php echo $qualif->completion_year; ?></span>
                                            <span class="col-12 text-d-grey"><?php  echo $qualif->city.",".$qualif->country; ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } 
                            }else{ echo "No Data found";}   ?>
                      
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0"><?=lang('Applications')?></h6>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0">
                            <?php 
                            // if(isset($applications) && $applications != ""){

                            // foreach ($applications as $appli) {
                                # code...
                            ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <h5 class="card-title mb-2"><?=lang('Web Designer')?></h5>
                              <h6 class="card-subtitle mb-2">Ref. <span>Test</span></h6> 
                                <h6 class="card-subtitle mb-2">status <span><?php echo $appli->flag;?></span></h6>
                                <h6 class="card-subtitle mb-2">Comment <span><?php echo $appli->comment;?> </span></h6>
                                <h6 class="card-subtitle mb-2">Rate <span><?php echo $appli->rate;?> </span></h6>
                                <h6 class="card-subtitle mb-0">Date <span>><?php echo date_formats($appli->dated, 'd M, Y');?> </span></h6>
                            </li>
                        <?php //}          
                            //}else{ echo "No Data found";}   ?>
                        </ul>
                       
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
    </div>
    <!-- container -->
</section>
<?php } ?>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>