<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
    //myPrint($data);
?>
<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                $this->load->library('Mobile_Detect');
                $detect = new Mobile_Detect();
                if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
                    $redirectUrl =WEBURL."/employer/home";
                } else {
                    $redirectUrl = WEBURL."/employer/home";
                }
                ?>
                <a href="<?php echo  $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Notification')?></h2>
            </div>
            <div class="col-2 text-right">
                <!-- <ul class="mb-0">
                    <li class="d-inline-block"><a href="<?php echo WEBURL; ?>/employer/notification/delete-notifications"><img src="<?php echo  $staticUrl; ?>/images/delete.svg" class="img-fluid"></a></li>
                </ul> -->
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <ul class="messages-list">
                    <?php
                    if(isset($data) && $data != ""){
                        foreach($data as $data){
                            if($data->seekerName != "" ){
                                if($data->notType =="applied"){
                                    $redirectUrl = WEBURL."/employer/application/index/1";
                                    $subHeading = "Applied for the job- ".$data->jobTitle;
                                } else if($data->notType =="accepted" ){
                                    $redirectUrl = WEBURL."/employer/invitations/index/1";
                                    $subHeading = "Accept Your invitation";
                                } else if($data->notType =="New Seeker" ){
                                    $redirectUrl = WEBURL."/employer/candidate/candidate-full-post/".$this->custom_encryption->encrypt_data($data->seekerId )."/6/0/0/0/1";
                                    $subHeading = "New Seeker Registered";
                                } else if($data->notType =="Withdraw From Job" ){
                                    $redirectUrl = WEBURL."/employer/candidate/candidate-full-post/".$this->custom_encryption->encrypt_data($data->seekerId )."/6/0/0/0/2";
                                    $subHeading = "Seeker Withdraw From Job";
                                }
                                ?>
                                <li class="py-2 align-items-center px-3 bdr-btm">
                                    <a class="media" href="<?php echo $redirectUrl; ?>">
                                        <div class="media-body">
                                            <div class="row">
                                                <h5 class="col-6 card-title mb-0"><?php echo $data->seekerName; ?></h5>
                                                <span class="col-6 text-right text-d-grey"><small><?php echo date("M j,Y",strtotime($data->dated)); ?></small></span>
                                            </div>
                                            <p class="last-msg mb-0"><?php echo $subHeading; ?></p>
                                        </div>
                                    </a>
                                </li>
                            <?php
                            }
                        }
                    }
                    ?>

                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
</div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>