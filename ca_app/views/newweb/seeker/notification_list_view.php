<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>

<section class="main-container vheight-100">
    <div class="container h-100">
        <div class="row">
         <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Notification')?></h2>
            </div>
            <div class="col-2 text-right">
                <ul class="mb-0">
                    <li class="d-inline-block"><a href="<?php echo WEBURL; ?>/seeker/notification/delete-notifications"><img src="<?php echo  $staticUrl; ?>/images/delete.svg" class="img-fluid"></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <ul class="messages-list">
                     <?php
                    if(isset($data) && $data != ""){
                        foreach($data as $data){
                            if($data->employerName != "" ){
                                if($data->notType =="invite"){
                                    $redirectUrl = WEBURL."/seeker/request/index/1";
                                    $subHeading = "Invited you";
                                } else if($data->notType =="notType" || $data->notType =="todayEvent" ){
                                    $redirectUrl = WEBURL."/seeker/calender/index/1";
                                    if($data->notType =="notType"){
                                        $subHeading = "Event for you";
                                    }
                                    if($data->notType =="todayEvent" ){
                                        $subHeading = "Your todays event";
                                    }
                                } else if($data->notType =="New Job" ){
                                    $redirectUrl = WEBURL."/seeker/home/job-details/".$data->jobId."/3";
                                    $subHeading = "New Job Added";
                                }


                                ?>
                    <li class="py-2 align-items-center px-3 bdr-btm">
                        <a class="media" href="<?php echo $redirectUrl ;?>">
                            <div class="media-body">
                                <div class="row">
                                    <h5 class="col-6 card-title mb-0"><?php echo $data->employerName."-".$data->companyName; ?></h5>
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
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>