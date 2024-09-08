<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100">
    <div class="container">
       <div class="col-10 col-lg-8 col-xl-8 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="job-tiles.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Manage Account</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-0 user-img">
                <img src="images/user.png" class="w-100">
                <div class="edit-block">
                    <ul>
                        <li><a href="edit-profile-picture.php" class="bg-blue"><img src="images/edit-pen.svg" class="w-100"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="POST"  enctype='multipart/form-data'>
                        <div class="form-group col-12 mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="txtEmailId" id="txtEmailId" value="<?php //echo ($data->email != "") ? $data->email:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Full Name" name="txtFullName" id="txtFullName" value="<?php //echo ($data->first_name != "") ? $data->first_name:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selGender" id="selGender">
                                <option <?php // if($data->gender == "" ) //echo "selected"; ?> disabled="">Gender</option>
                                <option <?php //if($data->gender == "male" ) //echo "selected"; ?> >Male</option>
                                <option <?php //if($data->gender == "female" ) //echo "selected"; ?> >Female</option>
                                <option <?php //if($data->gender == "other" ) //echo "selected"; ?> >Other</option>
                            </select>
                            <span></span>
                        </div>
                        <?php


                        ?>
                        <div class="form-group col-4 mb-3">
                            <?php ////echo date('Y',strtotime($data->dob)); ?>
                            <select class="form-control" name="selSeekerBirthDay" id="selSeekerBirthDay">
                                <option selected="" disabled="" value="0">Birth Day</option>
                                <?php
                                /*    for($i=1; $i<=31; $i++){
                                        ?>
                                <option value="<?php //echo $i; ?>" <?php if(date('d',strtotime($data->dob)) == $i) //echo "selected"; ?>>
                                    <?php //echo $i; ?>
                                </option>
                                <?php
                                    } */
                                ?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-4 mb-3">
                            <select class="form-control" name="selSeekerBirthMonth" id="selSeekerBirthMonth">
                                <option selected="" disabled="" value="0">Birth Month</option>
                                <?php
                                 /*   for($i=1; $i<=12; $i++){
                                        $month =sprintf("%02s", $i);
                                        ?>
                                <option value="<?php //echo $month; ?>" <?php if(date('m',strtotime($data->dob)) == $i) //echo "selected"; ?> >
                                    <?php //echo date('F', mktime(0,0,0,$i, 1, date('Y'))); ?>
                                </option>
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
                                    foreach ($yearArray as $year) { ?>
                                <option value="<?php //echo $year; ?>" <?php if(date('Y',strtotime($data->dob)) == $year) //echo "selected"; ?> >
                                    <?php //echo $year; ?>
                                </option>
                                <?php
                                    } */
                                ?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Current Address" name="txtSeekerAddress" id="txtSeekerAddress" value="<?php //echo ($data->present_address != "") ? $data->present_address:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerCountry" id="selSeekerCountry">
                                <option selected="" disabled="" value="">Country</option>
                                <?php 
                              /*  foreach($result_countries as $row_country):
                                    $selected = ($data->country==$row_country->country_name)?'selected="selected"':''; */
                            ?>
                                <option value="<?php //echo $row_country->country_name;?>" <?php //echo $selected;?>>
                                    <?php //echo $row_country->country_name;?>
                                </option>
                                <?php //endforeach;?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="City" name="txtSeekerCity" id="txtSeekerCity" value="<?php //echo ($data->city != "") ? $data->city:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerNationality" id="selSeekerNationality">
                                <option selected="" disabled="" value="">Nationality</option>
                                <?php 
                                /*foreach($result_countries as $row_country): 
                                      if($row_country->country_citizen!=''):
                                        $selected = ($data->nationality==$row_country->country_citizen)?'selected="selected"':'';*/
                                                
                                      ?>
                                <option value="<?php //echo $row_country->country_citizen;?>" <?php //echo $selected;?>>
                                    <?php //echo $row_country->country_citizen;?>
                                </option>
                                <?php //endif; //endforeach;?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Mobile Phone" name="txtSeekerMobile" id="txtSeekerMobile" value="<?php //echo ($data->mobile != "") ? $data->mobile:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Home Phone" name="txtSeekerPhone" id="txtSeekerPhone" value="<?php //echo ($data->home_phone != "") ? $data->home_phone:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerChannel" id="selSeekerChannel">
                                <option selected="" disabled="">Channel</option>
                                <?php 
                              /*  foreach($channel_list as $row_channel): 
                                    $selected = ($data->channel==$row_channel->channel)?'selected="selected"':'';
                                    */    
                              ?>
                                <option value="<?php //echo $row_channel->channel;?>" <?php //echo $selected;?> >
                                    <?php //echo $row_channel->channel;?>
                                </option>
                                <?php //endforeach;?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selExpectedSal" id="selExpectedSal">
                                <option selected="" disabled="">Expected Salary</option>
                                <option value="Trainee Stipend" <?php //if($data->expected_salary == "Trainee Stipend") //echo "selected"; ?>>Trainee Stipend</option>
                                <option value="5000-10000" <?php //if($data->expected_salary == "5000-10000") //echo "selected"; ?>>5000-10000</option>
                                <option value="11000-15000" <?php //if($data->expected_salary == "11000-15000") //echo "selected"; ?>>11000-15000</option>
                                <option value="16000-20000" <?php //if($data->expected_salary == "16000-20000") //echo "selected"; ?>>16000-20000</option>
                                <option value="21000-25000" <?php //if($data->expected_salary == "21000-25000") //echo "selected"; ?>>21000-25000</option>
                                <option value="26000-30000" <?php //if($data->expected_salary == "26000-30000") //echo "selected"; ?>>26000-30000</option>
                                <option value="31000-35000" <?php //if($data->expected_salary == "31000-35000") //echo "selected"; ?>>31000-35000</option>
                                <option value="36000-40000" <?php //if($data->expected_salary == "36000-40000") //echo "selected"; ?>>36000-40000</option>
                                <option value="41000-50000" <?php //if($data->expected_salary == "41000-50000") //echo "selected"; ?>>41000-50000</option>
                                <option value="51000-60000" <?php //if($data->expected_salary == "51000-60000") //echo "selected"; ?>>51000-60000</option>
                                <option value="61000-70000" <?php //if($data->expected_salary == "61000-70000") //echo "selected"; ?>>61000-70000</option>
                                <option value="71000-80000" <?php //if($data->expected_salary == "71000-80000") //echo "selected"; ?>>71000-80000</option>
                                <option value="81000-100000" <?php //if($data->expected_salary == "81000-100000") //echo "selected"; ?>>81000-100000</option>
                                <option value="100000-120000" <?php //if($data->expected_salary == "100000-120000") //echo "selected"; ?>>100000-120000</option>
                                <option value="120000-140000" <?php //if($data->expected_salary == "120000-140000") //echo "selected"; ?>>120000-140000</option>
                                <option value="140000-160000" <?php //if($data->expected_salary == "140000-160000") //echo "selected"; ?>>140000-160000</option>
                                <option value="160000-200000" <?php //if($data->expected_salary == "160000-200000") //echo "selected"; ?>>160000-200000</option>
                                <option value="200000-240000" <?php //if($data->expected_salary == "200000-240000") //echo "selected"; ?>>200000-240000</option>
                                <option value="240000-280000" <?php //if($data->expected_salary == "240000-280000") //echo "selected"; ?>>240000-280000</option>
                                <option value="281000-350000" <?php //if($data->expected_salary == "281000-350000") //echo "selected"; ?>>281000-350000</option>
                                <option value="350000-450000" <?php //if($data->expected_salary == "350000-450000") //echo "selected"; ?>>350000-450000</option>
                                <option value="450000 or above" <?php //if($data->expected_salary == "450000 or above") //echo "selected"; ?>>450000 or above</option>
                                <option value="Discuss" <?php //if($data->expected_salary == "Discuss") //echo "selected"; ?>>Discuss</option>
                                <option value="Depends" <?php //if($data->expected_salary == "Depends") //echo "selected"; ?>>Depends</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="customControlAutosizing">
                                <label class="custom-control-label text-d-grey" for="customControlAutosizing">Informations Privacy</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-10 mx-auto">
                            <div class="row">
                        <div class="form-group col-6 mb-3">
                            <button type="submit" class="btn btn-blue" name="btnUpdate">Update</button>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#delete-acc">Delete Account</button>
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




<section class="main-container vheight-100">
    <div class="container">
        <div class="col-10 col-lg-8 col-xl-8 mx-auto bg-white">
            <div class="row top-header bg-l-grey align-items-center">
                <a href="<?php echo WEBURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Manage Account</h2>
            </div>
        </div>
        <div class="row">
            <div class="user-img">
                <?php 
                    $defaultUser = $staticUrl."/images/user.png";
                    $imgUrl = "";
                    $pht=$data->photo;
                    $imgUrl = "";
                    //$pht=$photoData->photo;
                    if($pht!="" && file_exists('public/uploads/candidate/'.$pht)) 
                        $imgUrl = PUBLICURL.'/uploads/candidate/'.$pht;
                    else
                        $imgUrl= $defaultUser; 
                ?>

                <img src="<?php echo  $imgUrl; ?>" class="w-100">
                <div class="edit-block">
                    <ul>
                        <li><a href="<?php echo WEBURL; ?>/seeker/my-account/update-image" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="POST"  enctype='multipart/form-data'>
                        <div class="form-group col-12 mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="txtEmailId" id="txtEmailId" value="<?php echo ($data->email != "") ? $data->email:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Full Name" name="txtFullName" id="txtFullName" value="<?php echo ($data->first_name != "") ? $data->first_name:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selGender" id="selGender">
                                <option <?php if($data->gender == "" ) echo "selected"; ?> disabled="">Gender</option>
                                <option <?php if($data->gender == "male" ) echo "selected"; ?> >Male</option>
                                <option <?php if($data->gender == "female" ) echo "selected"; ?> >Female</option>
                                <option <?php if($data->gender == "other" ) echo "selected"; ?> >Other</option>
                            </select>
                            <span></span>
                        </div>
                        <?php


                        ?>
                        <div class="form-group col-4 mb-3">
                            <?php //echo date('Y',strtotime($data->dob)); ?>
                            <select class="form-control" name="selSeekerBirthDay" id="selSeekerBirthDay">
                                <option selected="" disabled="" value="0">Birth Day</option>
                                <?php
                                    for($i=1; $i<=31; $i++){
                                        ?>
                                <option value="<?php echo $i; ?>" <?php if(date('d',strtotime($data->dob)) == $i) echo "selected"; ?>>
                                    <?php echo $i; ?>
                                </option>
                                <?php
                                    }
                                ?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-4 mb-3">
                            <select class="form-control" name="selSeekerBirthMonth" id="selSeekerBirthMonth">
                                <option selected="" disabled="" value="0">Birth Month</option>
                                <?php
                                    for($i=1; $i<=12; $i++){
                                        $month =sprintf("%02s", $i);
                                        ?>
                                <option value="<?php echo $month; ?>" <?php if(date('m',strtotime($data->dob)) == $i) echo "selected"; ?> >
                                    <?php echo date('F', mktime(0,0,0,$i, 1, date('Y'))); ?>
                                </option>
                                <?php
                                    }
                                ?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-4 mb-3">
                            <select class="form-control" name="selSeekerBirthYear" id="selSeekerBirthYear">
                                <option selected="" disabled="" value="0">Birth Year</option>
                                <?php 
                                   $yearArray = range(date("Y", strtotime("-15 year")),1920 );
                                    foreach ($yearArray as $year) { ?>
                                <option value="<?php echo $year; ?>" <?php if(date('Y',strtotime($data->dob)) == $year) echo "selected"; ?> >
                                    <?php echo $year; ?>
                                </option>
                                <?php
                                    }
                                ?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Current Address" name="txtSeekerAddress" id="txtSeekerAddress" value="<?php echo ($data->present_address != "") ? $data->present_address:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerCountry" id="selSeekerCountry">
                                <option selected="" disabled="" value="">Country</option>
                                <?php 
                                foreach($result_countries as $row_country):
                                    $selected = ($data->country==$row_country->country_name)?'selected="selected"':'';
                            ?>
                                <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>>
                                    <?php echo $row_country->country_name;?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="City" name="txtSeekerCity" id="txtSeekerCity" value="<?php echo ($data->city != "") ? $data->city:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerNationality" id="selSeekerNationality">
                                <option selected="" disabled="" value="">Nationality</option>
                                <?php foreach($result_countries as $row_country): 
                                      if($row_country->country_citizen!=''):
                                        $selected = ($data->nationality==$row_country->country_citizen)?'selected="selected"':'';
                                                
                                      ?>
                                <option value="<?php echo $row_country->country_citizen;?>" <?php echo $selected;?>>
                                    <?php echo $row_country->country_citizen;?>
                                </option>
                                <?php endif; endforeach;?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Mobile Phone" name="txtSeekerMobile" id="txtSeekerMobile" maxlength="12" value="<?php echo ($data->mobile != "") ? $data->mobile:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Home Phone" name="txtSeekerPhone" id="txtSeekerPhone" maxlength="15" value="<?php echo ($data->home_phone != "") ? $data->home_phone:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerChannel" id="selSeekerChannel">
                                <option selected="" disabled="">Channel</option>
                                <?php 
                                foreach($channel_list as $row_channel): 
                                    $selected = ($data->channel==$row_channel->channel)?'selected="selected"':'';
                                        
                              ?>
                                <option value="<?php echo $row_channel->channel;?>" <?php echo $selected;?> >
                                    <?php echo $row_channel->channel;?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selExpectedSal" id="selExpectedSal">
                                <option selected="" disabled="">Expected Salary</option>
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
                        <div class="form-group col-12 mb-3">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="customControlAutosizing">
                                <label class="custom-control-label text-d-grey" for="customControlAutosizing">Informations Privacy</label>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <button type="submit" class="btn btn-blue" name="btnUpdate">Update</button>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#delete-acc">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->