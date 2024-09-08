<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php $staticUrl = STATICWEBCOMPURL;  ?>
<section class="main-container vheight-100 justify-content-between">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-11 col-lg-10 col-xl-10 mx-auto bg-white">
                <div class="row top-header bg-l-grey align-items-center">
                    <div class="col-1">
                        <a href="<?php echo WEBURL; ?>/employer/home" class="d-block">
                            <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                        </a>
                    </div>
                    <div class="col-11 text-center">
                        <h2 class="mb-0"><?=lang('Search')?></h2>
                    </div>
                </div>
                <form>
                    <div class="row pt-4 pb-3 ">
                        <div class="col-12 col-sm-6 mb-2">
                         <div class="form-group">
                            <input type="text" name="searchName" id="searchName" placeholder="Search Name" class="form-control form-controlser" onkeyup="getSeekerData();">
                                <span></span>
                            </div>
                        </div> <!-- ---- job 1--- -->
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <select class="form-control form-controlser" name="selSeekerCountry" id="selSeekerCountry" onchange="getCityData(this.val);getSeekerData();">
                                    <option selected="" disabled="" value=""><?=lang('Country')?></option>
                                    <option value="">Any</option>
                                    <?php
                                     if(isset($seekerCountry) && $seekerCountry != ""){
                                        foreach($seekerCountry as $country){

                                        ?>
                                            <option value="<?php echo $country->country; ?>"><?php echo $country->country; ?>(<?php echo $country->score; ?>)</option>

                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span></span>
                            </div>
                        </div> <!-- ---- job 1--- -->
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <select class="form-control form-controlser" name="selSeekerCity" id="selSeekerCity" onchange="getSeekerData();">
                                    <option selected="" disabled="" value=""><?=lang('City')?></option>
                                    <option value="">Any</option>
                                    <?php 
                                       
                                    if(isset($seekerCity) && $seekerCity != ""){
                                        foreach($seekerCity as $city){

                                        ?>
                                            <option value="<?php echo $city->city; ?>"><?php echo $city->city; ?>(<?php echo $city->score; ?>)</option>

                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span></span>
                            </div>
                        </div> <!-- ---- job 1--- -->
                    
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <select class="form-control form-controlser" name="selSeekerDesig" id="selSeekerDesig" onchange="getSeekerData();">
                                    <option selected="" disabled="" value=""><?=lang('Designation')?></option>
                                     <option value=""><?=lang('Any')?></option>
                                    <?php 
                                       
                                    if(isset($seekerByDesig) && $seekerByDesig != ""){
                                        //foreach($obj_result as $row){
                                        foreach($seekerByDesig as $Desig){
                                            // $row_latest_exp = $this->jobseeker_experience_model->get_latest_job_by_seeker_id($row->ID);
                
                                            // $lastest_job_title = ($row_latest_exp)?word_limiter(strip_tags(ucwords($row_latest_exp->job_title)),15):'';
                                            // $edu_row = $this->jobseeker_academic_model->get_record_by_seeker_id($row->ID);

                                        ?>
                                            <option value="<?php echo $Desig->job_title; ?>"><?php echo $Desig->job_title; ?></option>

                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span></span>
                            </div>
                        </div> <!-- ---- job 1--- -->
                        <?php //myPrint($seekerByExpect);die; ?>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <select class="form-control form-controlser" name="selSeekerSalExp" id="selSeekerSalExp" onchange="getSeekerData();">
                                    <option selected="" disabled="" value=""><?=lang('Expected Salary')?></option>
                                    <option value=""><?=lang('Any')?></option>
                                    <?php if(isset($seekerByExpect) && $seekerByExpect!='' ){
                                        foreach ($seekerByExpect as $salary) {
                                        ?>
                                        <option value="<?php echo $salary->expected_salary; ?>"><?php echo $salary->expected_salary; ?>(<?php echo $salary->score; ?>)</option>
                                  <?php  } }?>
                                </select>
                                <span></span>
                            </div>
                        </div> <!-- ---- job 1--- -->
                    </div>
                </form>
                <div class="job-desc">
                    <div class="ul" id="seekerData">

                        <!-- <li class="job-main p-3 mb-3">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-9 col-sm-7 col-lg-7 text-left">
                                         
                                    </div>
                                </div>
                            </div>
                        </li> -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>

<script type="text/javascript">
    function getSeekerData(){
        var searchName = $("#searchName").val();
        var selSeekerCity = $("#selSeekerCity").val();
        var selSeekerDesig = $("#selSeekerDesig").val();
        var selSeekerSalExp = $("#selSeekerSalExp").val();
        var selSeekerCountry = $("#selSeekerCountry").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo WEBURL;?>/employer/search/getSeekerData',
            dataType: 'json',
            data: {'searchName':searchName,'selSeekerCity':selSeekerCity,'selSeekerDesig':selSeekerDesig, 'selSeekerSalExp':selSeekerSalExp, 'selSeekerCountry':selSeekerCountry},
            success: function (data) {
               
                if(data != ""){
                    $("#seekerData").html(data);
                }
            }
           
        });
    }
    
    function getCityData(){
        var val = $("#selSeekerCountry").val();
       // alert(val);
         $.ajax({
        type: "POST",
        url: "<?php echo WEBURL; ?>/registration/getCities",
        data:'country='+val,
            success: function(data){
                console.log(data);
                var finalData = '<option value="">Any</option>'+data+'';
                $("#selSeekerCity").html(finalData);
            }
        });
    }
</script>