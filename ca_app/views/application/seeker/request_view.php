<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>

<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/settings" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Requests</h2>
            </div>
            <div class="col-2 text-right">
                <?php
                if($redirectTo == 1){
                    $returnUrl = APPURL."/seeker/notification";
                } else {
                    $returnUrl = APPURL."/seeker/settings";
                }
                ?>
                <!--<ul class="mb-0">
                    <li class="d-inline-block"><a href="<?php //echo $returnUrl; ?>/seeker/settings/inbox"><img src="<?php //echo  $staticUrl; ?>/images/delete.svg" class="img-fluid"></a></li> 
                </ul>-->
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <ul class="messages-list">
                    <?php
                    if(isset($data) && $data != ""){
                        foreach($data as $d){
                            $empData = $this->My_model->getSingleRowData("tbl_employers","tbl_employers.first_name,tbl_employers.company_ID,(select company_name from tbl_companies where ID = tbl_employers.company_ID) compName","ID= ".$d->employer_id)
                            ?>
                            <li class="py-2 align-items-center px-3 bdr-btm">
                                <div class="edit-block">
                                    <ul>
                                        <li>
                                            <?php if($d->sts == "not approuved" || $d->sts == "pending"){
                                                ?>
                                                <a href="<?php echo APPURL; ?>/seeker/request/accept/<?php echo $d->ID; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/tick.svg" class="w-100"></a>
                                                <?php
                                            } ?></li>
                                            <li>
                                            <?php if($d->sts == "approuved" || $d->sts == "pending"){
                                                ?>
                                                <a href="<?php echo APPURL; ?>/seeker/request/reject/<?php echo $d->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a>
                                                <?php
                                            } ?>
                                        </li>
                                    </ul>
                                </div>
                                <a class="media" href="<?php echo APPURL; ?>/seeker/Company/detail/<?php echo $d->employer_id; ?>/1">
                                    <div class="media-body">
                                        <div class="row">
                                            <h5 class="col-6 card-title mb-0">Company Name <?php echo (isset($empData) && $empData!="")?$empData->compName:""; ?></h5>
                                            <!-- <span class="col-6 text-right text-d-grey"><small><?php //echo date("M j,Y",strtotime($d->dated)); ?></small></span> -->
                                        </div>
                                        <p class="last-msg mb-0">Request From : <?php echo (isset($empData) && $empData!="")?$empData->first_name:""; ?></p>
                                        <p class="last-msg mb-0"><small><?php echo date("M j,Y",strtotime($d->dated)); ?></p>
                                    </div>
                                </a>
                            </li>
                        <?php
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