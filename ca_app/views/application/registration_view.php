<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/login" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Register here</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <h6 class="font-reg mt-3">Register as</h6>
                <?php
                if($msg != ""){
                    echo '<h6 class="font-reg">'.$msg.'</h6>';
                }
                ?>
                <ul class="nav nav-pills row" id="pills-tab" role="tablist">
                    <li class="col-6 nav-item">
                        <a class="nav-link <?php if($tab == "seeker") echo 'active'; ?>" data-toggle="pill" href="#pills-home" role="tab" aria-selected="true">Seeker</a>
                    </li>
                    <li class="col-6 nav-item">
                        <a class="nav-link <?php if($tab == "company") echo 'active'; ?>" data-toggle="pill" href="#pills-profile" role="tab" aria-selected="false">Company </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade <?php if($tab == "seeker") echo 'show active'; ?>" id="pills-home" role="tabpanel">
                        <form class="row mt-4" action="#" method="POST" enctype='multipart/form-data' onsubmit="return seekerValidation();">
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Full Name" name="txtSeekerFullName" id="txtSeekerFullName" value="<?php echo set_value('txtSeekerFullName'); ?>">
                                <span></span>
                                <?php echo (form_error('txtSeekerFullName')); ?>
                                    <small id="errtxtSeekerFullName" class="form-text text-muted">This Field is required</small>
  <!-- $selected = (set_value('industry_id')==$row_industry->ID)?'selected="selected"':''; -->
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Email" name="txtSeekerEmail" id="txtSeekerEmail"  value="<?php echo set_value('txtSeekerEmail'); ?>"  value="<?php echo set_value('txtSeekerEmail'); ?>">
                                <span></span>
                                <?php echo (form_error('txtSeekerEmail')); ?>
                                    <small id="errtxtSeekerEmail" class="form-text text-muted">This Field is required</small>
 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="txtSeekerPassword" id="txtSeekerPassword"   value="<?php echo set_value('txtSeekerPassword'); ?>">
                                <span></span>
                                <?php echo (form_error('txtSeekerPassword')); ?> 
                                <small id="errSeekerPassword" class="form-text text-muted">This Field is required</small> 

                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="txtSeekerConfirmPassword" id="txtSeekerConfirmPassword" onkeyup="chkSeekerPwd();"  value="<?php echo set_value('txtSeekerConfirmPassword'); ?>">
                                <span></span>
                                <?php echo (form_error('txtSeekerConfirmPassword')); ?> 
                                <small id="errtxtSeekerConfirmPassword" class="form-text text-muted">Confirm password should be same as Password.</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selSeekerGender" id="selSeekerGender">
                                    <option selected="" disabled="" value="">Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <span></span>
                                <?php echo (form_error('selSeekerGender')); ?>
                                    <small id="errselSeekerGender" class="form-text text-muted">This Field is required</small>
 
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control"  name="selSeekerBirthDay" id="selSeekerBirthDay">
                                    <option selected="" disabled="" value="0">Birth Day</option>
                                    <?php
                                        for($i=1; $i<=31; $i++){
                                             $selected = (set_value('selSeekerBirthDay')==$i)?'selected="selected"':'';
                                            ?>
                                            <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <span></span>
                                    <small id="errDob" class="form-text text-muted">Select Valid Day</small>
                                  <?php echo (form_error('selSeekerBirthDay')); ?> 
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control" name="selSeekerBirthMonth" id="selSeekerBirthMonth">
                                    <option selected="" disabled="" value="0">Birth Month</option>
                                    <?php
                                        for($i=1; $i<=12; $i++){
                                            $month =sprintf("%02s", $i);
                                             $selected = (set_value('selSeekerBirthMonth')==$month)?'selected="selected"':'';
                                            ?>
                                            <option value="<?php echo $month; ?>" <?php echo $selected; ?>><?php echo date('F', mktime(0,0,0,$i, 1, date('Y'))); ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <span></span>
                                <small id="errMob" class="form-text text-muted">select birth month</small>
                                <?php echo (form_error('selSeekerBirthMonth')); ?> 
                              
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control" name="selSeekerBirthYear" id="selSeekerBirthYear">
                                    <option selected="" disabled="" value="0">Birth Year</option>
                                    <?php 
                                       $yearArray = range(date("Y", strtotime("-15 year")),1920 );
                                        foreach ($yearArray as $year) {
                                             $selected = (set_value('selSeekerBirthYear')==$year)?'selected="selected"':'';

                                            // if you want to select a particular year
                                            //$selected = ($year == 2015) ? 'selected' : '';
                                            echo '<option value="'.$year.'" '. $selected.'>'.$year.'</option>';
                                        }
                                    ?>
                                </select>
                                <span></span>
                                 <small id="errYob" class="form-text text-muted">Select Birth Year</small>
                                <?php echo (form_error('selSeekerBirthYear')); ?> 
                              
                            </div>

                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Current Address" name="txtSeekerAddress" id="txtSeekerAddress"  value="<?php echo set_value('txtSeekerAddress'); ?>">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                 <select class="form-control" name="selSeekerCountry" id="selSeekerCountry">
                                    <option selected="" disabled="" value="">Country</option>
                                    <?php 
                                    foreach($result_countries as $row_country):
                                        $selected = (set_value('selSeekerCountry')==$row_country->country_name)?'selected="selected"':'';
                                ?>
                                    <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
                                    <?php endforeach;?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="City"  name="txtSeekerCity" id="txtSeekerCity"  value="<?php echo set_value('txtSeekerCity'); ?>">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selSeekerNationality" id="selSeekerNationality">
                                    <option selected="" disabled="" value="">Nationality</option>
                                    <?php foreach($result_countries as $row_country): 
                                          if($row_country->country_citizen!=''):
                                            $selected = (set_value('selSeekerNationality')==$row_country->country_citizen)?'selected="selected"':'';
                                                    
                                          ?>
                                        <option value="<?php echo $row_country->country_citizen;?>" <?php echo $selected;?>><?php echo $row_country->country_citizen;?></option>
                                        <?php endif; endforeach;?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="Mobile Phone"  name="txtSeekerMobile" id="txtSeekerMobile"  value="<?php echo set_value('txtSeekerMobile'); ?>"   maxlength="15">
                                <span></span>
                                 <?php echo (form_error('txtSeekerMobile')); ?> 
                                   <small id="errMobile" class="form-text text-muted">This field is required.</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="Home Phone" name="txtSeekerPhone" id="txtSeekerPhone"  value="<?php echo set_value('txtSeekerPhone'); ?>"  maxlength="15">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selSeekerChannel" id="selSeekerChannel">
                                    <option selected="" disabled="">Channel</option>
                                    <?php 
                                    foreach($channel_list as $row_channel): 
                                            $selected = (set_value('selSeekerChannel')==$row_channel->channel)?'selected="selected"':'';
                                            
                                  ?>
                                <option value="<?php echo $row_channel->channel;?>" <?php echo $selected;?>><?php echo $row_channel->channel;?></option>
                                <?php endforeach;?>
                                </select>
                                <span></span>
                            </div>

                            <div class="form-group col-12 mb-3">
                                <div class="wrap-custom-file">
                                    <input type="file" name="seekerResume" id="seekerResume" accept="application/pdf,application/msword,
  application/vnd.openxmlformats-officedocument.wordprocessingml.document" >
                                    <label for="seekerResume">
                                        <i class="fas fa-plus-circle"></i>
                                        <span><?=('Upload Resume')?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <p><input type="checkbox" name="chkSeekerTerms" name="chkSeekerTerms"> I accept the <u>Terms and Conditions</u></p>
                                <span></span>
                                 <small id="errSeekerTerms" class="form-text text-muted">Accept Terms and conditions</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <button type="submit" class="btn btn-blue" name="btnSeekarSaveData" id="btnSeekarSaveData">Continue</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade <?php if($tab == "company") echo 'show active'; ?>" id="pills-profile" role="tabpanel">
                        <form class="row mt-4" action="#" method="POST" enctype='multipart/form-data'  onsubmit="return compValidation();">
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=('Full Name')?>"  name="txtCompFullName" id="txtCompFullName"   value="<?php echo set_value('txtCompFullName'); ?>">
                                <span></span>
                                <?php echo (form_error('txtCompFullName')); ?> 
                                 <small id="errtxtCompFullName" class="form-text text-muted">This Field is required</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=('Company Name')?>"  name="txtCompCompanyName" id="txtCompCompanyName" value="<?php echo set_value('txtCompCompanyName'); ?>">
                                <span></span>
                                <?php echo (form_error('txtCompCompanyName')); ?> 
                                 <small id="errtxtCompCompanyName" class="form-text text-muted">This Field is required</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="email" class="form-control" placeholder="<?=('Email')?>"  name="txtCompanyEmail" id="txtCompanyEmail" value="<?php echo set_value('txtCompanyEmail'); ?>">
                                <span></span>
                                <?php echo (form_error('txtCompanyEmail')); ?>
                                 <small id="errtxtCompanyEmail" class="form-text text-muted">This Field is required</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="<?=('Password')?>"  name="txtCompPassword" id="txtCompPassword" value="<?php echo set_value('txtCompPassword'); ?>">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="<?=('Confirm Password')?>"  name="txtCompConfirmPassword" id="txtCompConfirmPassword" value="<?php echo set_value('txtCompConfirmPassword'); ?>"  onkeyup="chkCompPwd();" >
                                <span></span>
                                 <?php echo (form_error('txtCompConfirmPassword')); ?> 
                                  <small id="errtxtCompConfirmPassword" class="form-text text-muted">This Field is required</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompIndustry" id="selCompIndustry">
                                    <option value="" selected="" disabled=""><?=('Industry')?></option>
                                    <option value="" selected><?=('Select Industry')?></option>
                                      <?php foreach($result_industries as $row_industry):
                                                    $selected = (set_value('selCompIndustry')==$row_industry->ID)?'selected="selected"':'';
                                          ?>
                                      <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
                                      <?php endforeach;?>
                                </select>
                                <span></span>
                                 <?php echo (form_error('selCompIndustry')); ?> 
                                  <small id="errselCompIndustry" class="form-text text-muted">This Field is required</small>
                             </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompOwnershipType" id="selCompOwnershipType">
                                    <option value="Private" selected="" disabled=""><?=('Org. Type')?></option>
                                    <option value="Private" <?php echo (set_value('selCompOwnershipType')=="Private")?'selected="selected"':'';?>><?=('Private')?></option>
                                    <option value="Public" <?php echo (set_value('selCompOwnershipType')=="Public")?'selected="selected"':'';?>><?=('Public')?></option>
                                    <option value="Government" <?php echo (set_value('selCompOwnershipType')=="Government")?'selected="selected"':'';?>><?=('Government')?></option>
                                    <option value="Semi-Government" <?php echo (set_value('selCompOwnershipType')=="Semi-Government")?'selected="selected"':'';?>><?=('Semi-Government')?></option>
                                    <option value="NGO" <?php echo (set_value('selCompOwnershipType')=="NGO")?'selected="selected"':'';?>>NGO</option>
                                </select>
                                <span></span>
                                 <?php echo (form_error('selCompOwnershipType')); ?> 
                                  <small id="errselCompOwnershipType" class="form-text text-muted">This Field is required</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <textarea class="form-control" placeholder="<?=('Address')?>" rows="2" name="txtCompAddress" id="txtCompAddress"><?php echo set_value('txtCompAddress'); ?></textarea>
                                <span></span>
                                 <?php echo (form_error('txtCompAddress')); ?>
                                  <small id="errtxtCompAddress" class="form-text text-muted">This Field is required</small>
                             </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompCountry" id="selCompCountry">
                                    <option value="" selected="" disabled=""><?=('Country')?></option>
                                    <?php 
                                        foreach($result_countries as $row_country):
                                            $selected = (set_value('selCompCountry')==$row_country->country_name)?'selected="selected"':'';
                                        ?>
                                  <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
                                  <?php endforeach;?>
                                </select>
                               
                                <span></span>
                                 <?php echo (form_error('selCompCountry')); ?> 
                                  <small id="errselCompCountry" class="form-text text-muted">This Field is required</small>
                             </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=('City')?>"  name="txtCompCity" id="txtCompCity" value="<?php echo set_value('txtCompCity'); ?>">
                                <span></span>

                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="<?=('Landline Phone')?>"  name="txtCompLandline" id="txtCompLandline" value="<?php echo set_value('txtCompLandline'); ?>"  maxlength="13">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="<?=('Cell Phone')?>"  name="txtCompCellPhone" id="txtCompCellPhone" value="<?php echo set_value('txtCompCellPhone'); ?>"  maxlength="13">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="url" class="form-control" placeholder="<?=('Company Website')?>"  name="txtCompWebsite" id="txtCompWebsite"   value="<?php echo set_value('txtCompWebsite'); ?>">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selNoOfEmployees" id="selNoOfEmployees">
                                    <option value="1-10" <?php echo (set_value('selNoOfEmployees')=="1-10")?'selected="selected"':'';?>><?=('No. of Employees')?></option>
                                    <option value="1-10" <?php echo (set_value('selNoOfEmployees')=="1-10")?'selected="selected"':'';?>>1-10</option>
                                    <option value="11-50" <?php echo (set_value('selNoOfEmployees')=="11-50")?'selected="selected"':'';?>>11-50</option>
                                    <option value="51-100" <?php echo (set_value('selNoOfEmployees')=="51-100")?'selected="selected"':'';?>>51-100</option>
                                    <option value="101-300" <?php echo (set_value('selNoOfEmployees')=="101-300")?'selected="selected"':'';?>>101-300</option>
                                    <option value="301-600" <?php echo (set_value('selNoOfEmployees')=="301-600")?'selected="selected"':'';?>>301-600</option>
                                    <option value="601-1000" <?php echo (set_value('selNoOfEmployees')=="601-1000")?'selected="selected"':'';?>>601-1000</option>
                                    <option value="1001-1500" <?php echo (set_value('selNoOfEmployees')=="1001-1500")?'selected="selected"':'';?>>1001-1500</option>
                                    <option value="1501-2000" <?php echo (set_value('selNoOfEmployees')=="1501-2000")?'selected="selected"':'';?>>1501-2000</option>
                                    <option value="More than 2000" <?php echo (set_value('selNoOfEmployees')=="More than 2000")?'selected="selected"':'';?>>More than 2000</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <textarea class="form-control" placeholder="<?=('Company Information')?>" rows="2" name="txtCompDescr" id="txtCompDescr"><?php echo set_value('txtCompDescr'); ?></textarea>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompChannel" id="selCompChannel">
                                    <option value=""><?=('Channel')?></option>
                                    <?php 
                                        foreach($channel_list as $row_channel): 
                                        $selected = (set_value('selCompChannel')==$row_channel->channel)?'selected="selected"':'';       
                                    ?>
                                        <option value="<?php echo $row_channel->channel;?>" <?php echo $selected;?>><?php echo $row_channel->channel;?></option>
                                    <?php endforeach;?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <div class="wrap-custom-file">
                                    <input type="file" name="companyLogo" id="companyLogo" accept=".gif, .jpg, .png" >
                                    <label for="companyLogo">
                                        <i class="fas fa-plus-circle"></i>
                                        <span><?=('Company Logo')?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <p><input type="checkbox" name="chkCompTerms" name="chkCompTerms"> I accept the <u>Terms and Conditions</u></p>
                                <span></span>
                                 <small id="errCompTerms" class="form-text text-muted">Accept Terms and conditions</small>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <button type="submit" name="btnCompanySaveData" id="btnCompanySaveData" class="btn btn-blue">Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        /*$("#errtxtSeekerFullName").hide();
        $("#errtxtSeekerEmail").hide();
        $("#errSeekerPassword").hide();
        $("#errselSeekerGender").hide();
        $("#errDob").hide();
        $("#errMob").hide();
        $("#errYob").hide();
        $("#errMobile").hide();
        $("#errSeekerTerms").hide();

        $("#errtxtCompFullName").hide();
        $("#errtxtCompCompanyName").hide();
        $("#errtxtCompanyEmail").hide();
        $("#errselCompIndustry").hide();
        $("#errselCompOwnershipType").hide();
        $("#errtxtCompAddress").hide();
        $("#errselCompCountry").hide();
        $("#errCompTerms").hide();*/
        $("#errtxtCompConfirmPassword").hide();
        $("#errtxtSeekerConfirmPassword").hide();
    });

    function seekerValidation(){
        var txtSeekerFullName  =    $("#txtSeekerFullName").val();
        var txtSeekerEmail  =   $("#txtSeekerEmail").val();
        var txtSeekerPassword  =    $("#txtSeekerPassword").val();
        // var txtSeekerConfirmPassword  =     $("#txtSeekerConfirmPassword").val();
        var selSeekerGender  =  $("#selSeekerGender").val();
        var selSeekerBirthDay  =    $("#selSeekerBirthDay").val();
        var selSeekerBirthMonth  =  $("#selSeekerBirthMonth").val();
        var selSeekerBirthYear  =   $("#selSeekerBirthYear").val();
        var txtSeekerMobile  =  $("#txtSeekerMobile").val();

        if(txtSeekerFullName    == "" || txtSeekerEmail  == "" || txtSeekerPassword   == "" || txtSeekerConfirmPassword    == "" || selSeekerGender == "" || selSeekerBirthDay   == "" || selSeekerBirthMonth == "" || selSeekerBirthYear  == "" || txtSeekerMobile == "" ){
            if(txtSeekerFullName    == ""){
                $("#errtxtSeekerFullName").removeClass("text-muted");
                $("#errtxtSeekerFullName").addClass("text-danger");
            }
            if(txtSeekerEmail  == "" ){
                $("#errtxtSeekerEmail").removeClass("text-muted");
                $("#errtxtSeekerEmail").addClass("text-danger");
            }
            if(txtSeekerPassword   == ""){
                $("#errSeekerPassword").removeClass("text-muted");
                $("#errSeekerPassword").addClass("text-danger");
            }
            if(txtSeekerConfirmPassword    == ""){
                $("#txtSeekerConfirmPassword").removeClass("text-muted");
                $("#txtSeekerConfirmPassword").addClass("text-danger");
            }
            if(selSeekerGender == ""){
                $("#errselSeekerGender").removeClass("text-muted");
                $("#errselSeekerGender").addClass("text-danger");
            }
            if(selSeekerBirthDay   == ""){
                $("#errDob").removeClass("text-muted");
                $("#errDob").addClass("text-danger");
            }
            if(selSeekerBirthMonth == "" ){
                $("#errMob").removeClass("text-muted");
                $("#errMob").addClass("text-danger");
            }
            if(selSeekerBirthYear  == ""){
                $("#errYob").removeClass("text-muted");
                $("#errYob").addClass("text-danger");
            }
            if(txtSeekerMobile == ""){
                $("#errMobile").removeClass("text-muted");
                $("#errMobile").addClass("text-danger");
            }
            if ($('#chkSeekerTerms').is(':checked')) {
                $("#errSeekerTerms").removeClass("text-muted");
                $("#errSeekerTerms").addClass("text-danger");
            }    
            return false;
        } else {
            return true;
        }
    }

    function chkSeekerPwd(){
        var txtSeekerPassword = $("#txtSeekerPassword").val();
        var txtSeekerConfirmPassword = $("#txtSeekerConfirmPassword").val();

        if(txtSeekerPassword != txtSeekerConfirmPassword ){
            $("#errtxtSeekerConfirmPassword").removeClass("text-muted");
            $("#errtxtSeekerConfirmPassword").addClass("text-danger");
        } else {
            $("#errtxtSeekerConfirmPassword").hide();

        }
    }

    function compValidation(){
        var txtCompFullName  =    $("#txtCompFullName").val();
        var txtCompCompanyName  =   $("#txtCompCompanyName").val();
        var txtCompanyEmail  =    $("#txtCompanyEmail").val();
        var selCompIndustry  =  $("#selCompIndustry").val();
        var selCompOwnershipType  =    $("#selCompOwnershipType").val();
        var txtCompAddress  =  $("#txtCompAddress").val();
        var selCompCountry  =   $("#selCompCountry").val();

        if(txtCompFullName    == "" || txtCompCompanyName  == "" || txtCompanyEmail   == "" || selCompIndustry    == "" || selCompOwnershipType == "" || txtCompAddress   == "" || selCompCountry == "" ){
            if(txtCompFullName    == ""){
                $("#errtxtCompFullName").removeClass("text-muted");
                $("#errtxtCompFullName").addClass("text-danger");
            }
            if(txtCompCompanyName  == "" ){
                $("#errtxtCompCompanyName").removeClass("text-muted");
                $("#errtxtCompCompanyName").addClass("text-danger");
            }
            if(txtCompanyEmail   == ""){
                $("#errtxtCompanyEmail").removeClass("text-muted");
                $("#errtxtCompanyEmail").addClass("text-danger");
            }
            if(selCompIndustry    == ""){
                $("#errselCompIndustry").removeClass("text-muted");
                $("#errselCompIndustry").addClass("text-danger");
            }
            if(selCompOwnershipType == ""){
                $("#errselCompOwnershipType").removeClass("text-muted");
                $("#errselCompOwnershipType").addClass("text-danger");
            }
            if(txtCompAddress   == ""){
                $("#errtxtCompAddress").removeClass("text-muted");
                $("#errtxtCompAddress").addClass("text-danger");
            }
            if(selCompCountry == "" ){
                $("#errselCompCountry").removeClass("text-muted");
                $("#errselCompCountry").addClass("text-danger");
            }
            if ($('#chkCompTerms').is(':checked')) {
                $("#errSeekerTerms").removeClass("text-muted");
                $("#errSeekerTerms").addClass("text-danger");
            }
            return false;
        } else {
            return true;
        }
    }

    function chkCompPwd(){
        var txtSeekerPassword = $("#txtSeekerPassword").val();
        var txtSeekerConfirmPassword = $("#txtSeekerConfirmPassword").val();

        if(txtSeekerPassword != txtSeekerConfirmPassword ){
            $("#errtxtSeekerConfirmPassword").removeClass("text-muted");
            $("#errtxtSeekerConfirmPassword").addClass("text-danger");
            $("#errtxtSeekerConfirmPassword").show();
        } else {
            $("#errtxtSeekerConfirmPassword").hide();

        }
    }

</script>