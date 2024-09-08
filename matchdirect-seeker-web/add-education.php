<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100">
    <div class="container">
       <div class="col-10 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="my-cv.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Add Education</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selDegree" id="selDegree">
                                <option value="" selected="" disabled="">Degree Title</option>
                                <option value="BA" <?php //if($eduData->degree_title == "BA") { //echo "selected"; } ?>>BA</option>
                                <option value="BE" <?php //if($eduData->degree_title == "BE") { //echo "selected"; } ?>>BE</option>
                                <option value="BS" <?php //if($eduData->degree_title == "BS") { //echo "selected"; } ?>>BS</option>
                                <option value="CA" <?php //if($eduData->degree_title == "CA") { //echo "selected"; } ?>>CA</option>
                                <option value="Cert//ification" <?php //if($eduData->degree_title == "Cert//ification") { //echo "selected"; } ?>>Cert//ification</option>
                                <option value="Diploma" <?php //if($eduData->degree_title == "Diploma") { //echo "selected"; } ?>>Diploma</option>
                                <option value="HSSC" <?php //if($eduData->degree_title == "HSSC") { //echo "selected"; } ?>>HSSC</option>
                                <option value="MA" <?php //if($eduData->degree_title == "MA") { //echo "selected"; } ?>>MA</option>
                                <option value="MBA" <?php //if($eduData->degree_title == "MBA") { //echo "selected"; } ?>>MBA</option>
                                <option value="MS" <?php //if($eduData->degree_title == "MS") { //echo "selected"; } ?>>MS</option>
                                <option value="PhD" <?php //if($eduData->degree_title == "PhD") { //echo "selected"; } ?>>PhD</option>
                                <option value="SSC" <?php //if($eduData->degree_title == "SSC") { //echo "selected"; } ?>>SSC</option>
                                <option value="ACMA" <?php //if($eduData->degree_title == "ACMA") { //echo "selected"; } ?>>ACMA</option>
                                <option value="MCS" <?php //if($eduData->degree_title == "MCS") { //echo "selected"; } ?>>MCS</option>
                                <option value="Does not matter" <?php //if($eduData->degree_title == "Does not matter") { //echo "selected"; } ?>>Does not matter</option>
                                <option value="B.Tech" <?php //if($eduData->degree_title == "B.Tech") { //echo "selected"; } ?>>B.Tech</option>
                            </select>
                            <span></span>
                              <?php //echo lang(form_error('selDegree')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" name="txtMajorSub" id="txtMajorSub" placeholder="Major Subject" value="<?php //if(isset($eduData) && $eduData !=""){//echo $eduData->major; } ?>">
                            <span></span>
                              <?php //echo lang(form_error('txtMajorSub')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" name="txtInstitute" id="txtInstitute" placeholder="Institute" value="<?php //if(isset($eduData) && $eduData !=""){//echo $eduData->institude; } ?>">
                            <span></span>
                              <?php //echo lang(form_error('txtInstitute')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3"><?php //echo $eduData->country; ?>
                            <select class="form-control" name="selCountry" id="selCountry">
                                <option selected="" disabled="">Country</option>
                                <?php 
                              /*  //if(isset($result_countries) && $result_countries !=""){
                                    foreach($result_countries as $country){
                                        ?>
                                        <option value="<?php //echo $country->country_name; ?>" <?php  //if(isset($eduData) && $eduData != ""){ //if($eduData->country == $country->country_name) {//echo "selected";} } ?> ><?php //echo $country->country_name; ?></option>
                                        <?php
                                    } 
                                }*/
                                ?>
                            </select>
                            <span></span>
                              <?php //echo lang(form_error('selCountry')); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="City" name="txtCity" id="txtCity"  value="<?php //if(isset($eduData) && $eduData !=""){//echo $eduData->city; } ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selYear" id="selYear">
                                <option value="" selected="selected" disabled="">Select Year</option>
                                <?php 
                                /*   $yearArray = range(date("Y"),1920 );
                                    foreach ($yearArray as $year) { ?>
                                <option value="<?php //echo $year; ?>" <?php //if($eduData->completion_year == $year) //echo "selected"; ?> >
                                    <?php //echo $year; ?>
                                </option>
                                <?php
                                    } */
                                ?>
                            </select>
                            <span></span>
                            <?php //echo lang(form_error('selYear')); ?> 
                        </div>
                        <div class="col-12 col-lg-9 col-xl-8 mx-auto my-3">
                            <div class="row">
                        <div class="form-group col-6 mb-3">
                            <button type="submit" class="btn btn-blue">cancel</button>
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