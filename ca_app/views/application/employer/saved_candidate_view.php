<?php $this->load->view('application/inc/header'); ?>

<?php 
    $staticUrl = STATICAPPCOMPURL; 
   // myPrint($wishlistedCand);exit;
?>

<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/settings" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Saved Candidates</h2>
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
                                        <li><a href="<?php echo APPURL; ?>/employer/messenger/conversation/<?php echo $saved->seeker_ID ; ?>" class="bg-success" title="send meessege"><i class="fas fa-paper-plane text-white"></i></a></li>

                                        <li><a href="<?php echo APPURL; ?>/employer/candidate/delete-wishlisted-job/<?php echo $saved->ID ; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>

                                    </ul>
                                </div>
                                <a class="media" href="<?php echo APPURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($saved->seeker_ID ); ?>/3">
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
    <!-- container -->
</section>
<!-- section -->

<?php $this->load->view('application/inc/footer'); ?>