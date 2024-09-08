<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>
<section class="main-container vheight-100">
    <div class="container">
        <div class="row">
       <div class="col-12 col-md-10 col-lg-8 col-xl-8 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Manage Account')?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-0 user-img mx-auto">
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
                    <form class="row mt-4" action="#" method="POST"  enctype='multipart/form-data'  onsubmit="return seekerValidation();">
                        <div class="form-group col-12 mb-3">
                            <input type="email" class="form-control" placeholder="<?=lang('Email')?>" name="txtEmailId" id="txtEmailId" value="<?php echo ($data->email != "") ? $data->email:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="<?=lang('Full Name')?>" name="txtFullName" id="txtFullName" value="<?php echo ($data->first_name != "") ? $data->first_name:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selGender" id="selGender" required >
                                <!-- <option <?php  if($data->gender == "" ) echo "selected"; ?> disabled=""><?=lang('Gender')?></option> -->
                                <option <?php if($data->gender == "male" ) echo "selected"; ?> ><?=lang('Male')?></option>
                                <option <?php if($data->gender == "female" ) echo "selected"; ?> ><?=lang('Female')?></option>
                                <option <?php if($data->gender == "other" ) echo "selected"; ?> ><?=lang('Other')?></option>
                            </select>
                            <span></span>
                        </div>
                        <?php


                        ?>
                        <div class="form-group col-4 mb-3">
                            <select class="form-control" name="selSeekerBirthDay" id="selSeekerBirthDay" required >
                                <option disabled="" value="0"><?=lang('Birth Day')?></option>
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
                            <select class="form-control" name="selSeekerBirthMonth" id="selSeekerBirthMonth" required >
                                <option  disabled="" value="0"><?=lang('Birth Month')?></option>
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
                            <select class="form-control" name="selSeekerBirthYear" id="selSeekerBirthYear" required >
                                <option  disabled="" value="0"><?=lang('Birth Year')?></option>
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
                         <div class="form-group col-12"><small id="errDate" class="form-text text-muted"><?=lang('Select Valid Date')?></small></div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="<?=lang('Current Address')?>" name="txtSeekerAddress" id="txtSeekerAddress" value="<?php echo ($data->present_address != "") ? $data->present_address:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerCountry" id="selSeekerCountry" required onchange="getRegionSeeker(this.value);">
                                <option disabled="" value=""><?=lang('Country')?></option>
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
                            <!-- <input type="text" class="form-control" placeholder="<?=lang('City')?>" name="txtSeekerCity" id="txtSeekerCity" value="<?php echo ($data->city != "") ? $data->city:""; ?>"> -->
                             <select class="form-control" name="txtSeekerCity" id="txtSeekerCity">
                                <option disabled="" value=""><?=lang('City')?></option>
                                <?php 
                                    $countryID = $this->My_model->getSingleRowData("tbl_countries","ID","country_name = '".$data->country."'");
                                    $cities = $this->My_model->selTableData("tbl_cities","","country_ID = ".$countryID->ID);
                                    if(isset($cities) && $cities != ""){
                                        foreach($cities as $city){
                                            if($city->city_name ==$data->city ) $selected = "selected";
                                            else
                                                $selected="";
                                            ?>
                                            <option value="<?php echo $city->city_name; ?>" <?php echo $selected; ?> ><?php echo $city->city_name; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerNationality" id="selSeekerNationality" required="">
                                <option selected="" disabled="" value=""><?=lang('Nationality')?></option>
                                <?php 
                                foreach($result_countries as $row_country): 
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
                            <input type="number" maxlength="13" class="form-control" placeholder="<?=lang('Mobile Phone')?>" name="txtSeekerMobile" id="txtSeekerMobile" value="<?php echo ($data->mobile != "") ? $data->mobile:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="<?=lang('Home Phone')?>" name="txtSeekerPhone" id="txtSeekerPhone" value="<?php echo ($data->home_phone != "") ? $data->home_phone:""; ?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="selSeekerChannel" id="selSeekerChannel">
                                <option disabled=""><?=lang('Channel')?></option>
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
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="customControlAutosizing" checked="checked" required="required">
                                <label class="custom-control-label text-d-grey" for="customControlAutosizing"><?=lang('Informations Privacy')?></label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-10 mx-auto">
                            <div class="row">
                        <div class="form-group col-12 col-sm-6 mb-3">
                            <button type="submit" class="btn btn-blue" name="btnUpdate"><?=lang('Update')?></button>
                        </div>
                        <div class="form-group col-12 col-sm-6 mb-3">
                            <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#delete-acc"><?=lang('Delete Account')?></button>
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
</div>
    <!-- container -->
</section>
<!-- section -->
<!-- Modal -->
<div class="modal fade" id="delete-acc" tabindex="-1" role="dialog" aria-labelledby="delete-acc" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="delete-acc"><?=lang('Do you really want to delete your account?')?></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('Close')?></button>
                <a href="<?php echo WEBURL; ?>/seeker/my-account/delete-account" class="btn btn-blue"><?=lang('Confirm')?></a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('newweb/inc/footer'); ?>
 
<script type="text/javascript">
     $(document).ready(function(){
        $("#errDate").hide();
    });
   function seekerValidation(){
        var selSeekerBirthDay   =    $("#selSeekerBirthDay").val();
        var selSeekerBirthMonth =  $("#selSeekerBirthMonth").val();
        var selSeekerBirthYear  =   $("#selSeekerBirthYear").val();
        var d = $('#selSeekerBirthYear').val()+'-'+ $('#selSeekerBirthMonth').val()+'-'+ $('#selSeekerBirthDay').val();
        if( selSeekerBirthDay   == "" || selSeekerBirthMonth == "" || selSeekerBirthYear  == "" ){
            return false;
        } else if(!moment(d, ["YYYY-MM-DD"]).isValid()) {
             return false;
         } else {
            return true;
        }
    } 

     function getRegionSeeker(val){
        $.ajax({
            type: "POST",
            url: "<?php echo WEBURL; ?>/registration/getCities",
            data:'country='+val,
                success: function(data){
                    $("#txtSeekerCity").html(data);
                }
            });
    }

</script>