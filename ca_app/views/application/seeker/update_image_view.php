<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/my-account" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Update Image</h2>
            </div>
        </div>
        <form class="row" action="#" method="POST" enctype="multipart/form-data">
            <div class="form-group user-img w-100">
                <?php 
                    $defaultUser = $staticUrl."/images/user.png";
                    $imgUrl = "";
                    $pht=$data->photo;
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

                <img src="<?php echo $imgUrl; ?>" class="w-100">
                <div class="wrap-custom-file w-100">
                    <input type="file" name="imageFile" id="imageFile" accept=".gif, .jpg, .png" / required="">
                    <label class="mb-0 py-3" for="imageFile">
                        <i class="fas fa-plus-circle"></i>
                        <span class="text-black font-med">Tap To Select</span>
                    </label>
                </div>
            </div>
            <div class="form-group col-12 mb-3">
                <button type="submit" name="btnUpdate" class="btn btn-blue">Update</button>
            </div>
        </form>
        <!-- col -->
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>