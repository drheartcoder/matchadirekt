<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
   // myPrint($data);exit;
?>
<section class="main-container vheight-100">
    <div class="container">
        <div class="row">
        <div class="col-12 col-md-10 col-lg-9 col-xl-9 mx-auto bg-white">
            <div class="row top-header bg-l-grey align-items-center">
                <div class="col-2">
                    <a href="<?php echo WEBURL; ?>/seeker/my-cv" class="d-block">
                        <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                    </a>
                </div>
                <div class="col-8 text-center">
                    <h2 class="mb-0"><?=lang('Udpdate Expected Salary')?></h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="">
                        <form class="row mt-4" action="#" method="POST">
                            <div class="form-group col-12 mb-3">
                               <?=lang('Current Expecetd Salary')?>: <?php echo $data->expected_salary; ?>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selExpectedSal" id="selExpectedSal" required="">
                                    <option selected="" value="" disabled=""><?=lang('Expected Salary')?></option>
                                    <option value="Trainee Stipend" <?php if($data->expected_salary == "Trainee Stipend") echo "selected"; ?>>Trainee Stipend</option>
                                    <option value="5000-10000" <?php if($data->expected_salary == "5000-10000") echo "selected"; ?>>5000-10000</option>
                                    <option value="11000-15000" <?php if($data->expected_salary == "11000-15000") echo "selected"; ?>>11000-15000</option>
                                    <option value="16000-20000" <?php if($data->expected_salary == "16000-20000") echo "selected"; ?>>16000-20000</option>
                                    <option value="21000-25000" <?php if($data->expected_salary == "21000-25000") echo "selected"; ?>>21000-25000</option>
                                    <option value="26000-30000" <?php if($data->expected_salary == "26000-30000") echo "selected"; ?>>26000-30000</option>
                                    <option value="31000-35000" <?php if($data->expected_salary == "31000-35000") echo "selected"; ?>>31000-35000</option>
                                    <option value="36000-40000" <?php if($data->expected_salary == "36000-40000") echo "selected"; ?>>36000-40000</option>
                                    <option value="41000-50000" <?php if($data->expected_salary == "41000-50000") echo "selected"; ?>>41000-50000</option>
                                    <option value="51000-60000" <?php if($data->expected_salary == "51000-60000") echo "selected"; ?>>51000-60000</option>
                                    <option value="61000-70000" <?php if($data->expected_salary == "61000-70000") echo "selected"; ?>>61000-70000</option>
                                    <option value="71000-80000" <?php if($data->expected_salary == "71000-80000") echo "selected"; ?>>71000-80000</option>
                                    <option value="81000-100000" <?php if($data->expected_salary == "81000-100000") echo "selected"; ?>>81000-100000</option>
                                    <option value="100000-120000" <?php if($data->expected_salary == "100000-120000") echo "selected"; ?>>100000-120000</option>
                                    <option value="120000-140000" <?php if($data->expected_salary == "120000-140000") echo "selected"; ?>>120000-140000</option>
                                    <option value="140000-160000" <?php if($data->expected_salary == "140000-160000") echo "selected"; ?>>140000-160000</option>
                                    <option value="160000-200000" <?php if($data->expected_salary == "160000-200000") echo "selected"; ?>>160000-200000</option>
                                    <option value="200000-240000" <?php if($data->expected_salary == "200000-240000") echo "selected"; ?>>200000-240000</option>
                                    <option value="240000-280000" <?php if($data->expected_salary == "240000-280000") echo "selected"; ?>>240000-280000</option>
                                    <option value="281000-350000" <?php if($data->expected_salary == "281000-350000") echo "selected"; ?>>281000-350000</option>
                                    <option value="350000-450000" <?php if($data->expected_salary == "350000-450000") echo "selected"; ?>>350000-450000</option>
                                    <option value="450000 or above" <?php if($data->expected_salary == "450000 or above") echo "selected"; ?>>450000 or above</option>
                                    <option value="Discuss" <?php if($data->expected_salary == "Discuss") echo "selected"; ?>>Discuss</option>
                                    <option value="Depends" <?php if($data->expected_salary == "Depends") echo "selected"; ?>>Depends</option>
                                </select>
                                <span></span>
                            </div>
                            
                            <div class="form-group col-6 mb-3">
                                <a href="<?php echo WEBURL; ?>/seeker/my-cv" class="btn btn-blue"><?=lang('Cancel')?></a>
                            </div>
                            <div class="form-group col-6 mb-3">
                                <button type="submit" class="btn btn-blue" name="btnSubmit"><?=lang('Submit')?></button>
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