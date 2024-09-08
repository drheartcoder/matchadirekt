<?php $this->load->view('newweb/inc/header'); ?>

<?php 
    $staticUrl = STATICWEBCOMPURL; 
   // myPrint($wishlistedCand);exit;
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
                    $redirectUrl =WEBURL."/employer/settings";
                } else {
                    $redirectUrl = WEBURL."/employer/home";
                }
                ?>
                <a href="<?php echo  $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Saved Candidates')?></h2>
            </div>
        </div>
        <?php if(isset($wishlistedCand) && $wishlistedCand != ''){
    //myPrint($wishlistedCand);exit;
 ?>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">

                            <?php foreach ($wishlistedCand as $saved) {
                                //myPrint($saved);die;
                                # code...
                            ?>

                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="<?php echo WEBURL; ?>/employer/messenger/conversation/<?php echo $saved->seeker_ID ; ?>" class="bg-success" title="send meessege"><i class="fas fa-paper-plane text-white"></i></a></li>

                                        <li><a href="<?php echo WEBURL; ?>/employer/candidate/delete-wishlisted-job/<?php echo $saved->ID ; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>

                                    </ul>
                                </div>
                                <a class="media" href="<?php echo WEBURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($saved->seeker_ID ); ?>/3">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-0"><?php echo $saved->first_name; ?>
                                                <p class="text-d-grey mb-0"><?php echo $saved->email; ?></p>
                                                <p class="text-d-grey mb-0"><?php echo date_formats($saved->dated, 'd M, Y');?></p>    
                                            </div>
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
        </div>
        <?php } ?>
    </div>
</div>
    </div>
    <!-- container -->
</section>
<!-- section -->

<?php $this->load->view('newweb/inc/footer'); ?>