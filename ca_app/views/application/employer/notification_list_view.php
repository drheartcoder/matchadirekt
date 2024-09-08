<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($data);
?>

<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/settings" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Notification</h2>
            </div>
            <div class="col-2 text-right">
                <ul class="mb-0">
                    <li class="d-inline-block"><a href="<?php echo APPURL; ?>/employer/notification/delete-notifications"><img src="<?php echo  $staticUrl; ?>/images/delete.svg" class="img-fluid"></a></li>
                </ul>
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
                                    $redirectUrl = APPURL."/employer/application/index/1";
                                    $subHeading = "Applied for the job- ".$data->jobTitle;
                                } else if($data->notType =="accepted" ){
                                    $redirectUrl = APPURL."/employer/invitations/index/1";
                                    $subHeading = "Accept Your invitation";
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
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>