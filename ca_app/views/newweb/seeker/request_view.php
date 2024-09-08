<?php $this->load->view('newweb/inc/header'); ?>
<?php 
      $staticUrl = STATICWEBSEEKERURL; 
     // echo $staticUrl;exit;
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
                <h2 class="mb-0"><?=lang('Requests')?></h2>
            </div>
            <div class="col-2 text-right">
                <?php
                if($redirectTo == 1){
                    $returnUrl = WEBURL."/seeker/notification";
                } else {
                    $returnUrl = WEBURL."/seeker/settings";
                }
                ?>
               <!--  <ul class="mb-0">
                    <li class="d-inline-block"><a href="inbox.php"><img src="<?php echo  $staticUrl; ?>/images/delete.svg" class="img-fluid"></a></li>
                </ul> -->
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
                                                <a href="<?php echo WEBURL; ?>/seeker/request/accept/<?php echo $d->ID; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/tick.svg" class="w-100"></a>
                                                <?php
                                            } ?></li>
                                            <li>
                                            <?php if($d->sts == "approuved" || $d->sts == "pending"){
                                                ?>
                                                <a href="<?php echo WEBURL; ?>/seeker/request/reject/<?php echo $d->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a>
                                                <?php
                                            } ?>
                                        </li>
                                    </ul>
                                </div>

                        <a class="media" href="<?php echo WEBURL; ?>/seeker/Company/detail/<?php echo $d->employer_id; ?>/1">
                            <div class="media-body">
                                <div class="row">
                                    <h5 class="col-6 card-title mb-0"><?php echo (isset($empData) && $empData!="")?$empData->compName:""; ?></h5>
                                    <!-- <span class="col-6 text-right text-d-grey"><small>YESTERDAY, 2:30 PM</small></span> -->
                                </div>
                                  <p class="last-msg mb-0">Request From : <?php echo (isset($empData) && $empData!="")?$empData->first_name:""; ?></p>
                                        <p class="last-msg mb-0"><small><?php echo date("M j,Y",strtotime($d->dated)); ?></p>
                               <!--  <p class="last-msg mb-0">Request for job interview</p> -->
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
    </div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>