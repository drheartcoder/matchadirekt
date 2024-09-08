<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                if($redirectTo ==1){
                    $redirectUrl = APPURL."/employer/notification";
                } else {
                    $redirectUrl =APPURL."/employer/settings";
                }
                ?>
                <a href="<?php echo $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Applications</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php 

                            if(isset($applicationData) && $applicationData != ""){
                                foreach($applicationData as $app){
                                   //myPrint($app);
                                    ?>
                                    <li class="py-3 align-items-center px-3 bdr-btm">
                                        <div class="edit-block">
                                            <ul>
                                                <li><a href="<?php echo APPURL; ?>/employer/candidate/view-candidate-details/<?php echo $app->seeker_ID; ?>/<?php echo $app->job_ID; ?>/1/<?php echo $app->ID; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                            </ul>
                                        </div>
                                        <div class="media-body">
                                            <div class="row align-items-center">
                                                <div class="col-6 card-title mb-2"><a href="<?php echo APPURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($app->seeker_ID); ?>/1"><?php echo $app->first_name; ?></a></div>
                                                <p class="col-6 text-d-grey mb-0"><?php echo date("M d, Y", strtotime($app->dated)); ?></p>
                                                <div class="col-12 card-title mb-0"><a href="<?php echo APPURL; ?>/employer/job/view-job/<?php echo $app->job_ID; ?>/1"><?php echo $app->job_title; ?></a></div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>

                                <li class="py-3 align-items-center px-3 bdr-btm">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-2">No applications recieved yet</div>
                                        </div>
                                    </div>
                                </li>
                                <?php
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