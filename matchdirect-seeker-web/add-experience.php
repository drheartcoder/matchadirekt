<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100">
    <div class="container">
       <div class="col-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="my-cv.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Add Experience</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="POST">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Job Title" name="txtJobTitle" id="txtJobTitle" value="<?php //if(isset($expData) && $expData !=""){//echo $expData->job_title; } ?>">
                            <span></span>
                            <?php //echo lang(form_error('txtJobTitle')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Company Name" name="txtCompanyName" id="txtCompanyName" value="<?php //if(isset($expData) && $expData !=""){//echo $expData->company_name; } ?>">
                            <span></span>
                            <?php //echo lang(form_error('txtCompanyName')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selCountry" id="selCountry">
                                <option selected="" disabled="">Country</option>
                                <?php 
                              /*  //if(isset($result_countries) && $result_countries !=""){
                                    foreach($result_countries as $country){
                                        ?>
                                        <option value="<?php //echo $country->country_name; ?>" <?php  //if(isset($expData) && $expData != ""){ //if($expData->country == $country->country_name) {//echo "selected";} } ?> ><?php //echo $country->country_name; ?></option>
                                        <?php
                                    }
                                }*/
                                ?>
                            </select>
                            <span></span>
                            <?php //echo lang(form_error('selCountry')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="City" name="txtCity" id="txtCity"  value="<?php //if(isset($expData) && $expData !=""){//echo $expData->city; } ?>">
                            <span></span>
                            <?php //echo lang(form_error('txtCity')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="date" class="form-control" placeholder="Start Date" name="txtStartDate" id="txtStartDate"  value="<?php //if(isset($expData) && $expData !=""){//echo $expData->start_date; } ?>">
                            <span></span>
                            <?php //echo lang(form_error('txtStartDate')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label class="mb-0 text-d-grey">End Date (Keep blank //if still working)</label>
                            <input type="date" class="form-control" placeholder="End Date" name="txtEndDate" id="txtEndDate"  value="<?php //if(isset($expData) && $expData !=""){//echo $expData->end_date; } ?>">
                            <span></span>
                        </div>
                         <div class="col-12 col-lg-9 col-xl-8 mx-auto my-2">
                            <div class="row">
                        <div class="form-group col-6 mb-3">
                            <button type="submit" class="btn btn-blue">Cancel</button>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <a href="my-cv.php" class="btn btn-blue">Update</a>
                        </div>
                    </div>
                </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php include 'footer.php'; ?>