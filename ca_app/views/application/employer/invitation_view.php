<?php $this->load->view('application/inc/header'); ?>
<?php $staticUrl = STATICAPPCOMPURL; ?>
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
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Invitations</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">

                            <?php 
                            if(isset($invitedCandidates) && $invitedCandidates != ""){
                                foreach($invitedCandidates as $data){
                                   // myPrint($data);
                                    ?>
                                    <li class="py-3 align-items-center px-3 bdr-btm">
                                        <div class="edit-block">
                                            <ul>
                                                <?php 
                                                if($data->sts == "approuved" ){
                                                    ?>
                                                    <li><a href="<?php echo APPURL; ?>/employer/invitations/manage-schedule/<?php echo $data->employer_id; ?>/<?php echo $data->jobseeker_id; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                                    <?php
                                                }
                                                ?>

                                                <li><a href="<?php echo APPURL; ?>/employer/invitations/delete-invitation/<?php echo $data->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                            </ul>
                                        </div>
                                        <a class="media" href="<?php echo APPURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($data->jobseeker_id); ?>/2">
                                            <div class="media-body">
                                                <div class="row align-items-center">
                                                    <div class="col-6 card-title mb-0"><?php echo $data->first_name; ?>
                                                        <p class="text-d-grey mb-0"><?php echo date_formats($data->dated, 'd M, Y');?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li class="py-3 align-items-center px-3 bdr-btm">
                                    <div class="media-body">
                                        No candidates invited yet
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