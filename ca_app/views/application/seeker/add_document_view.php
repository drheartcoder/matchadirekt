<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/my-cv" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Add Document</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <form class="row mt-4" action="#" method="POST" enctype='multipart/form-data'>
                    <div class="form-group col-12 skill-block py-3 bg-l-grey">
                        <ul>
                            <?php 
                            if(isset($resumeData) && $resumeData !=""){
                                foreach($resumeData as $data){
                                    ?>
                                    <li class="bdr-btm py-3 position-relative">
                                        <div class="edit-block">
                                            <ul>
                                                <li><a href="#" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                            </ul>
                                        </div>
                                        <h6><img src="<?php echo  $staticUrl; ?>/images/file.svg" class="mr-2">File N:1</h6>
                                        <a href="javascript:void(0)"><?php echo $data->file_name; ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="form-group col-12 mb-3">
                        <div class="input-group justify-content-center">
                            <div class="wrap-custom-file w-100">
                                <input type="file" name="upload_resume" id="upload_resume" required="">
                                <label for="upload_resume">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Select File</span>
                                </label>
                            </div>
                            <!-- <div class="input-group-append ml-0 mt-3">
                                <button class="btn btn-blue add-btn rounded-0" type="button" name="btnSubmit" id="btnSubmit">
                                    <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                </button>
                            </div> -->
                        </div>
                        <span></span>
                    </div>
                    <div class="form-group col-6 mb-3">
                        <button type="submit" class="btn btn-blue" name="btnSubmit" id="btnSubmit">Update</button>
                    </div>
                    <div class="form-group col-6 mb-3">
                        <a href="<?php echo APPURL; ?>/seeker/my-cv" class="btn btn-blue">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>