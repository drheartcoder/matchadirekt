<?php $this->load->view('newweb/inc/header'); ?>
<?php 
        $staticUrl = STATICWEBCOMPURL; 
?>
<?php //myPrint($data);die; ?>
<section class="main-container vheight-100">
    <div class="container">
        <div class="row">
         <div class="col-12 col-md-10 col-lg-8 col-xl-8 mx-auto bg-white">
            <div class="row top-header bg-l-grey align-items-center">
                <div class="col-2">
                    <a href="<?php echo WEBURL; ?>/employer/my-account" class="d-block">
                        <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                    </a>
                </div>
                <div class="col-8 text-center">
                    <h2 class="mb-0"><?=lang('Update Image')?></h2>
                </div>
            </div>
            <form class="row" action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group user-img w-100 col-12 clearfix mx-auto mt-2">
                    <?php 
                        $defaultUser = $staticUrl."/images/user.png";
                        $imgUrl = "";
                        $pht=$data->company_logo;
                        
                       /* if($pht=="") $pht='no_pic.jpg';
                             $imgUrl = base_url('public/uploads/candidate/'.$pht);*/
                              $defaultUser = $staticUrl."/images/user.png";
                            $imgUrl = "";
                            //$pht=$photoData->photo;
                            if($pht!="" && file_exists('public/uploads/candidate/'.$pht)) 
                                $imgUrl = PUBLICURL.'/uploads/candidate/'.$pht;
                            else
                                $imgUrl= $defaultUser; 
                    ?>
                    <?php //echo $imgUrl;die; ?>
                    <img src="<?php echo $imgUrl; ?>" class="w-100">
                    <div class="wrap-custom-file w-100">
                        <input type="file" name="imageFile" id="imageFile" accept=".gif, .jpg, .png" / required="">
                        <label class="mb-0 py-3" for="imageFile">
                            <i class="fas fa-plus-circle"></i>
                            <span class="text-black font-med"><?=lang('Tap To Select')?></span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-12 col-md-12 text-center mx-auto my-3">
                    <button type="submit" name="btnUpdate" class="btn btn-comm btn-blue"><?=lang('Update')?></button>
                </div>
            </form>
        <!-- col -->
        <!-- row -->
        </div>
    </div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>