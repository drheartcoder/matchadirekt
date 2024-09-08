<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo APPURL.'/employer/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;
?>
<?php  //myPrint($compDetails);die;

if(isset($compDetails) && $compDetails !=''){ 
//echo $compDetails->company_name;die;
    ?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/home" class="d-block">
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
                    <h5 class="card-title mb-1"><?php echo $compDetails->company_name; ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $compDetails->company_slug; ?></h6>
                    <ul class="list-unstyled mb-0">
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $compDetails->company_email; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $compDetails->company_phone; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $compDetails->established_in; ?></h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg"><?php echo $compDetails->company_location; ?></h6>
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
                        <p class="mb-0"><?php echo $compDetails->company_description; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">Job Applications Received</h6>
                    </div>
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php //myPrint($seekerDatils);die;
                                foreach ($seekerDatils as $applications ) {
                                    # code...

                                    //myPrint($$applications->job_seeker_ID);die;
                            
                             ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="<?php echo APPURL;?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($applications->job_seeker_ID); ?>">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-0"><?php echo $applications->first_name; ?>
                                                <p class="last-msg mb-0"><?php echo $applications->job_title; ?></p>
                                            </div>
                                            <span class="col-6 text-right text-d-grey"><?php echo date_formats($applications->applied_date, 'M d, Y');?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                        <!-- nav ul list -->
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
                            <?php 
                            if(isset($currentJobs) && $currentJobs != ""){
                                foreach ($currentJobs as $jobs) {
                          
                            ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="<?php echo APPURL; ?>/employer/job/delete-job/<?php echo $jobs->ID; ?>/1" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                        <li><a href="<?php echo APPURL; ?>/employer/job/edit/<?php echo $jobs->ID; ?>/1" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title"><?php echo $jobs->job_title; ?>
                                                <p class="last-msg mb-0"><?php echo $jobs->job_slug; ?></p>
                                            </div>
                                            <span class="col-5 text-d-grey"><?php echo date_formats($jobs->dated, 'M d, Y');?></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="mb-0"><?php echo $jobs->job_description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php }
                          }
                         ?>
                            <!-- <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="#" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                        <li><a href="#" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-0">Web Designer
                                                <p class="last-msg mb-0">Company Name Inc</p>
                                            </div>
                                            <span class="col-5 text-d-grey">Sep 12, 2019</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="#" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                        <li><a href="#" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-0">Web Designer
                                                <p class="last-msg mb-0">Company Name Inc</p>
                                            </div>
                                            <span class="col-5 text-d-grey">Sep 12, 2019</span>
                                        </div>
                                    </div>
                                </a>
                            </li> -->
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<?php } ?>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>