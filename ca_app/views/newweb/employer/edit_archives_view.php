<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php $staticUrl = STATICWEBCOMPURL; ?>

<form class="main-container vheight-100 justify-content-between" action="#" method="POST">
    <div class="container">
        <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
            <div class="row top-header bg-l-grey align-items-center">
                <div class="col-2">
                    <a href="<?php echo WEBURL; ?>/employer/archives" class="d-block">
                        <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                    </a>
                </div>
                <div class="col-8 text-center">
                    <h2 class="mb-0"><?=lang('Edit Archive')?></h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="">
                        <div class="row mt-4">
                            <div class="form-group col-12 mb-3">
                                <input type="text" name="label" id="label" class="form-control" value="<?php echo $data->label; ?>">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" name="description" id="description" class="form-control" value="<?php echo $data->description; ?>">
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- col -->
            </div>

            <div class="col-12 text-center mb-3 mx-auto bg-white">
                 <div class="row">
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-comm btn-blue" value="Update">
            </div>
        </div>
            <!-- row -->
        </div>
    <!-- container -->
        
    </div>
</div>
    <!-- container -->
</form>
<!-- section -->

<?php $this->load->view('newweb/inc/footer'); ?>