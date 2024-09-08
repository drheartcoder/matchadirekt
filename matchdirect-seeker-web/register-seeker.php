<?php include 'header.php'; ?>

<section class="bg-blue">
    <div class="container bg-blue">
       <div class="col-11 col-lg-8 col-xl-7 mx-auto bg-white">
        <div class="row top-header bg-l-grey border-1 align-items-center">
            <div class="col-2">
                <a href="login.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Register here</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <h6 class="font-reg mt-3 text-center">Register as</h6>
                <ul class="nav nav-pills row" id="pills-tab" role="tablist">
                    <li class="col-6 nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills-home" role="tab" aria-selected="true">Seeker</a>
                    </li>
                    <li class="col-6 nav-item">
                        <a class="nav-link" data-toggle="pill" href="#pills-profile" role="tab" aria-selected="false">Company</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                        <form class="row mt-4" action="login-with-phone.php">
                             <form class="row mt-4" action="#" method="POST" enctype='multipart/form-data'>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Full Name" name="txtSeekerFullName" id="txtSeekerFullName">
                                <span></span>
                                <?php //echo lang(form_error('txtSeekerFullName')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Email" name="txtSeekerEmail" id="txtSeekerEmail">
                                <span></span>
                                <?php //echo lang(form_error('txtSeekerEmail')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="txtSeekerPassword" id="txtSeekerPassword">
                                <span></span>
                                <?php //echo lang(form_error('txtSeekerPassword')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="txtSeekerConfirmPassword" id="txtSeekerConfirmPassword">
                                <span></span>
                                <?php //echo lang(form_error('txtSeekerConfirmPassword')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selSeekerGender" id="selSeekerGender">
                                    <option selected="" disabled="" value="">Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <span></span>
                                <?php //echo lang(form_error('selSeekerGender')); ?> 
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control"  name="selSeekerBirthDay" id="selSeekerBirthDay">
                                    <option selected="" disabled="" value="0">Birth Day</option>
                                   </select>
                                   <?php
                                        /*for($i=1; $i<=31; $i++){
                                            ?>
                                            <option value="<?php //echo $i; ?>"><?php //echo $i; ?></option>
                                            <?php
                                        }*/
                                    ?> 
                                </select>
                                <span></span>
                               
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control" name="selSeekerBirthMonth" id="selSeekerBirthMonth">
                                    <option selected="" disabled="" value="0">Birth Month</option>
                                     <?php
                                       /* for($i=1; $i<=12; $i++){
                                            $month =sprintf("%02s", $i);
                                            ?>
                                            <option value="<?php //echo $month; ?>"><?php //echo date('F', mktime(0,0,0,$i, 1, date('Y'))); ?></option>
                                            <?php
                                        } */
                                    ?> 
                                </select>
                                <span></span>
                               
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control" name="selSeekerBirthYear" id="selSeekerBirthYear">
                                    <option selected="" disabled="" value="0">Birth Year</option>
                                    <?php 
                                      /* $yearArray = range(date("Y", strtotime("-15 year")),1920 );
                                        foreach ($yearArray as $year) {
                                            // if you want to select a particular year
                                            //$selected = ($year == 2015) ? 'selected' : '';
                                            //echo '<option value="'.$year.'">'.$year.'</option>';
                                        } */
                                    ?>
                                </select>
                                <span></span>
                                
                            </div>
                            <div class="col-12">
                                <?php //echo lang(form_error('selSeekerBirthDay')); ?> 
                                <?php //echo lang(form_error('selSeekerBirthMonth')); ?> 
                                <?php //echo lang(form_error('selSeekerBirthYear')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Current Address" name="txtSeekerAddress" id="txtSeekerAddress">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                 <select class="form-control" name="selSeekerCountry" id="selSeekerCountry">
                                    <option selected="" disabled="" value="">Country</option>
                                    <?php 
                                    // foreach($result_countries as $row_country):
                                    //     $selected = (set_value('selSeekerCountry')==$row_country->country_name)?'selected="selected"':'';
                                ?>
                                    <option value="<?php //echo $row_country->country_name;?>" <?php //echo $selected;?>><?php //echo $row_country->country_name;?></option>
                                    <?php //endforeach;?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="City"  name="txtSeekerCity" id="txtSeekerCity">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selSeekerNationality" id="selSeekerNationality">
                                    <option selected="" disabled="" value="">Nationality</option>
                                    <?php
                                     /* foreach($result_countries as $row_country): 
                                          if($row_country->country_citizen!=''):
                                            $selected = (set_value('selSeekerNationality')==$row_country->country_citizen)?'selected="selected"':''; */
                                                    
                                          ?>
                                        <option value=""></option>
                                        <?php //endif; //endforeach;?>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="Mobile Phone"  name="txtSeekerMobile" id="txtSeekerMobile">
                                <span></span>
                                 <?php //echo lang(form_error('txtSeekerMobile')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="Home Phone" name="txtSeekerPhone" id="txtSeekerPhone">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selSeekerChannel" id="selSeekerChannel">
                                    <option selected="" disabled="">Channel</option>
                                    <?php 
                                  /*  foreach($channel_list as $row_channel): 
                                            $selected = (set_value('channel')==$row_channel->channel)?'selected="selected"':'';
                                            */
                                  ?>
                                <option value="<?php //echo $row_channel->channel;?>" <?php //echo $selected;?>><?php //echo $row_channel->channel;?></option>
                                <?php ////endforeach;?>
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
                            <div class="form-group col-12 mb-3 text-center">
                                <button type="submit" class="btn-comm btn btn-blue" name="btnSeekarSaveData" id="btnSeekarSaveData">Continue</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                        <form class="row mt-4" action="#" method="POST" enctype='multipart/form-data'>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=('Full Name')?>"  name="txtCompFullName" id="txtCompFullName">
                                <span></span>
                                <?php //echo lang(form_error('txtCompFullName')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=('Company Name')?>"  name="txtCompCompanyName" id="txtCompCompanyName">
                                <span></span>
                                <?php //echo lang(form_error('txtCompCompanyName')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="email" class="form-control" placeholder="<?=('Email')?>"  name="txtCompanyEmail" id="txtCompanyEmail">
                                <span></span>
                                <?php //echo lang(form_error('txtCompanyEmail')); ?>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="<?=('Password')?>"  name="txtCompPassword" id="txtCompPassword">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="<?=('Confirm Password')?>"  name="txtCompConfirmPassword" id="txtCompConfirmPassword">
                                <span></span>
                                 <?php //echo lang(form_error('txtCompConfirmPassword')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompIndustry" id="selCompIndustry">
                                    <option value="" selected="" disabled=""><?=('Industry')?></option>
                                    <option value="" selected><?=('Select Industry')?></option>
                                      <?php
                                      /* foreach($result_industries as $row_industry):
                                                    $selected = (set_value('selCompIndustry')==$row_industry->ID)?'selected="selected"':'';*/
                                          ?>
                                      <option value="<?php //echo $row_industry->ID;?>" <?php //echo $selected;?>><?php //echo $row_industry->industry_name;?></option>
                                      <?php //endforeach;?>
                                </select>
                                <span></span>
                                 <?php //echo lang(form_error('selCompIndustry')); ?> 
                             </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompOwnershipType" id="selCompOwnershipType">
                                    <option value="Private" selected="" disabled=""><?=('Org. Type')?></option>
                                    <option value="Private"><?=('Private')?></option>
                                    <option value="Public"><?=('Public')?></option>
                                    <option value="Government"><?=('Government')?></option>
                                    <option value="Semi-Government"><?=('Semi-Government')?></option>
                                    <option value="NGO">NGO</option>
                                </select>
                                <span></span>
                                 <?php //echo lang(form_error('selCompOwnershipType')); ?> 
                            </div>
                            <div class="form-group col-12 mb-3">
                                <textarea class="form-control" placeholder="<?=('Address')?>" rows="2" name="txtCompAddress" id="txtCompAddress"></textarea>
                                <span></span>
                                 <?php //echo lang(form_error('txtCompAddress')); ?>
                             </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompCountry" id="selCompCountry">
                                    <option value="" selected="" disabled=""><?=('Country')?></option>
                                    <?php 
                                       /* foreach($result_countries as $row_country):
                                            $selected = (set_value('selCompLocation')==$row_country->country_name)?'selected="selected"':''; */
                                        ?>
                                  <option value="<?php //echo $row_country->country_name;?>" <?php //echo $selected;?>><?php //echo $row_country->country_name;?></option>
                                  <?php //endforeach;?>
                                </select>
                               
                                <span></span>
                                 <?php //echo lang(form_error('selCompCountry')); ?> 
                             </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="<?=('City')?>"  name="txtCompCity" id="txtCompCity">
                                <span></span>

                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="<?=('Landline Phone')?>"  name="txtCompLandline" id="txtCompLandline">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="<?=('Cell Phone')?>"  name="txtCompCellPhone" id="txtCompCellPhone">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="url" class="form-control" placeholder="<?=('Company Website')?>"  name="txtCompWebsite" id="txtCompWebsite">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selNoOfEmployees" id="selNoOfEmployees">
                                    <option value="1-10"><?=('No. of Employees')?></option>
                                    <option value="1-10">1-10</option>
                                    <option value="11-50">11-50</option>
                                    <option value="51-100">51-100</option>
                                    <option value="101-300">101-300</option>
                                    <option value="301-600">301-600</option>
                                    <option value="601-1000">601-1000</option>
                                    <option value="1001-1500">1001-1500</option>
                                    <option value="1501-2000">1501-2000</option>
                                    <option value="More than 2000">More than 2000</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <textarea class="form-control" placeholder="<?=('Company Information')?>" rows="2" name="txtCompDescr" id="txtCompDescr"></textarea>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control" name="selCompChannel" id="selCompChannel">
                                    <option value=""><?=('Channel')?></option>
                                    <?php 
                                      /*  foreach($channel_list as $row_channel): 
                                        $selected = (set_value('channel')==$row_channel->channel)?'selected="selected"':''; */
                                        
                                    ?>
                                        <option value="<?php //echo $row_channel->channel;?>" <?php //echo $selected;?>><?php //echo $row_channel->channel;?></option>
                                    <?php //endforeach;?>
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
<?php include 'footer.php'; ?>