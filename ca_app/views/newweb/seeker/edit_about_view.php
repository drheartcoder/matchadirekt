<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>

<section class="main-container vheight-100">
    <div class="container">
            <div class="row">
        <div class="col-12 col-md-10  col-lg-9 col-xl-9 mx-auto bg-white">
            <div class="row top-header bg-l-grey align-items-center">
                <div class="col-2">
                    <a href="<?php echo WEBURL; ?>/seeker/my-cv" class="d-block">
                        <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                    </a>
                </div>
                <div class="col-8 text-center">
                    <h2 class="mb-0"><?=lang('Professional Summary')?></h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="">

                        <form class="row mt-4" action="#" method="POST">
                            <?php if(isset($additionalData) && $additionalData !=''){
                            // myPrint($additionalData);die;  ?>
                            <div class="form-group col-12 mb-3">
                               <textarea class="form-control" placeholder="<?=lang('Professional Summary')?>" rows="6" maxlength="250" name="txtSummary"><?php echo $additionalData->summary; ?></textarea>
                                <span></span>
                            </div>
                        <?php } ?>
                            <div class="form-group col-6 mb-3">
                                <a href="<?php echo WEBURL; ?>/seeker/my-cv" class="btn btn-blue"><?=lang('Cancel')?></a>
                            </div>
                            <div class="form-group col-6 mb-3">
                                <button type="submit" name="btnUpdate" class="btn btn-blue"><?=lang('Update')?></button>
                            </div>
                        </form>
                    </div>
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