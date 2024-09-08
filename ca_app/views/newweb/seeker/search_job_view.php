<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<section class="main-container vheight-100 justify-content-between">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-11 col-lg-10 col-xl-10 mx-auto bg-white">
                <div class="row top-header bg-l-grey align-items-center">
                    <div class="col-1">
                        <a href="" class="d-block">
                            <img src="https://l5lpcuqo-site.atempurl.com/jobsystemv2dev/static/web/company/images/back-arrow.png" class="back-arrow">
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
                                <select  class="form-control form-controlser" name="selJobTitle" id="selJobTitle" onchange="getJobData();">
                                    <option selected="" disabled="" value=""><?=lang('Job Title')?></option>
                                    <option value="">Any</option>
                                    <?php 
                                    if(isset($title_group) && $title_group != ""){
                                        foreach($title_group as $title){

                                        ?>
                                            <option value="<?php echo $title->job_title; ?>"><?php echo $title->job_title; ?>(<?php echo $title->score; ?>)</option>

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
                                <select  class="form-control form-controlser" name="selCity" id="selCity" onchange="getJobData();">
                                    <option selected="" disabled="" value=""><?=lang('City')?></option>
                                    <option value="">Any</option>
                                    <?php 
                                    if(isset($city_group) && $city_group != ""){
                                        foreach($city_group as $city){

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
                                <select  class="form-control form-controlser" name="selCompany" id="selCompany" onchange="getJobData();">
                                    <option selected="" disabled="" value=""><?=lang('Top Companies')?></option>
                                    <option value="">Any</option>
                                    <?php 
                                    if(isset($company_group) && $company_group != ""){
                                        foreach($company_group as $company){

                                        ?>
                                            <option value="<?php echo $company->company_slug; ?>"><?php echo $company->company_name; ?>(<?php echo $company->score; ?>)</option>

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
                                <select  class="form-control form-controlser" name="selSal" id="selSal" onchange="getJobData();">
                                    <option selected="" disabled="" value=""><?=lang('Sel Salary')?></option>
                                    <option value="">Any</option>
                                   <?php 
                                    if(isset($salary_range_group) && $salary_range_group != ""){
                                        foreach($salary_range_group as $payment){

                                        ?>
                                            <option value="<?php echo $payment->pay; ?>"><?php echo $payment->pay; ?>(<?php echo $payment->score; ?>)</option>

                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span></span>
                            </div>
                        </div> <!-- ---- job 1--- -->
                    </div>
                </form>
                <div class="job-desc">
                    <div class="ul" id="jobData">
                        <!--   <li class="job-main p-3 mb-3">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3 col-sm-2 px-0">
                                        <div class="comp-logo text-center">
                                            <img src="https://l5lpcuqo-site.atempurl.com/jobsystemv2dev/static/web/company/images/logo1.png" alt="img">
                                        </div>
                                    </div>
                                    <div class="col-9 col-sm-7 col-lg-7 text-left">
                                        <h3 class="mb-2 j-title card-title">Web Designer</h3>
                                        <h4 class="mb-1 comp-name text-blue card-subtitle">Crystal Web Techs <span>Nashik</span></h4>
                                        <p class="mb-1 j-date">Oct 20 2019</p>
                                        <p class="mb-1 j-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </div>
                                    <div class="col-12 col-sm-3 col-lg-3 px-0 my-2 my-sm-0 text-center">
                                        <a href="#" class="btn btn-blue  btn-comm">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </li> -->
                        
                        <!-- <li class="job-main p-3 mb-3">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-9 col-sm-7 col-lg-7 text-left">
                                          <a href="#" class="d-block">
                                        <h3 class="mb-2 j-title card-title">Web Designer</h3>
                                        <h4 class="mb-1 comp-name text-blue card-subtitle">Crystal Web Techs <span>Nashik</span></h4>
                                        <p class="mb-1 j-date">Oct 20 2019</p>
                                        <p class="mb-1 j-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="job-main p-3 mb-3">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-9 col-sm-7 col-lg-7 text-left">
                                          <a href="#" class="d-block">
                                        <h3 class="mb-2 j-title card-title">Web Designer</h3>
                                        <h4 class="mb-1 comp-name text-blue card-subtitle">Crystal Web Techs <span>Nashik</span></h4>
                                        <p class="mb-1 j-date">Oct 20 2019</p>
                                        <p class="mb-1 j-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </li> -->
                        <li></li>
                        <li></li>
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
    function getJobData(){
        var selJobTitle = $("#selJobTitle").val();
        var selCity = $("#selCity").val();
        var selCompany = $("#selCompany").val();
        var selSal = $("#selSal").val();

      
        $.ajax({
            type: 'POST',
            url: '<?php echo WEBURL;?>/seeker/search/getJobData',
            //contentType: 'application/json; charset=utf-8',
           // dataType: "json",
            //data: "{'selJobTitle':'"+selJobTitle+"','selCity':'"+selCity+"','selCompany':'"+selCompany+"','selSal':'"+selSal+"'}",
            dataType: 'json',
            data: {'selJobTitle':selJobTitle,'selCity':selCity,'selCompany':selCompany,'selSal':selSal},
            success: function (data) {
                console.log(data)
                if(data != ""){
                    $("#jobData").html(data);
                }
            }
           
        });
    }
</script>