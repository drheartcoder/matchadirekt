<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
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
                    <h2 class="mb-0"><?=lang('Add Experience')?></h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="">
                        <form class="row mt-4" action="#" method="POST">
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=lang('Job Title')?>" name="txtJobTitle" id="txtJobTitle" value="<?php if(isset($expData) && $expData !=""){echo $expData->job_title; } ?>">
                                <span></span>
                                <?php echo lang(form_error('txtJobTitle')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=lang('Company Name')?>" name="txtCompanyName" id="txtCompanyName" value="<?php if(isset($expData) && $expData !=""){echo $expData->company_name; } ?>">
                                <span></span>
                                <?php echo lang(form_error('txtCompanyName')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCountry" id="selCountry">
                                    <option selected="" disabled=""><?=lang('Country')?></option>
                                    <?php 
                                    if(isset($result_countries) && $result_countries !=""){
                                        foreach($result_countries as $country){
                                            ?>
                                            <option value="<?php echo $country->country_name; ?>" <?php  if(isset($expData) && $expData != ""){ if($expData->country == $country->country_name) {echo "selected";} } ?> ><?php echo $country->country_name; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span></span>
                                <?php echo lang(form_error('selCountry')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=lang('City')?>" name="txtCity" id="txtCity"  value="<?php if(isset($expData) && $expData !=""){echo $expData->city; } ?>">
                                <span></span>
                                <?php echo lang(form_error('txtCity')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <label class="mb-0 text-d-grey"><?=lang('Start Date')?></label>
                                <input type="date" class="form-control" placeholder="<?=lang('Start Date')?>" name="txtStartDate" id="txtStartDate"  value="<?php if(isset($expData) && $expData !=""){echo $expData->start_date; } ?>">
                                <span></span>
                                <?php echo lang(form_error('txtStartDate')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <label class="mb-0 text-d-grey"><?=lang('End Date (Keep blank if still working)')?></label>
                                <input type="date" class="form-control" placeholder="<?=lang('End Date')?>" name="txtEndDate" id="txtEndDate"  value="<?php if(isset($expData) && $expData !=""){echo $expData->end_date; } ?>">
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