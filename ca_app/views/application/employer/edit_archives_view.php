<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php $staticUrl = STATICAPPCOMPURL; ?>

<form class="vheight-100 justify-content-between" action="#" method="POST">
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/archives" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Edit Archive</h2>
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
        <!-- row -->
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-blue" value="Update">
            </div>
        </div>
    </div>
    <!-- container -->
</form>
<!-- section -->

<?php $this->load->view('application/inc/footer'); ?>