<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php 
/*myPrint($data);
exit;*/
    $staticUrl = STATICAPPCOMPURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/home" class="d-block">
                    <img src="<?php echo $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Manage Account</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <h6 class="font-reg mt-3">Company Information</h6>
                <div class="">
                    <form class="row mt-4" action="#" method="POST">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Your Name" name="full_name" value="<?php echo $data->first_name; ?>">
                            <span></span>
                              <?php echo form_error('full_name'); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Company Name" name="company_name" value="<?php echo $data->company_name; ?>">
                            <span></span>
                             <?php echo form_error('company_name'); ?>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="industry_ID">
                                <option value="" selected><?=('Select Industry')?></option>
                                <?php 
                                foreach($result_industries as $row):
                                    $selected = ($data->industry_ID==$row->ID)?'selected="selected"':'';
                                ?>
                                <option value="<?php echo $row->ID;?>" <?php echo $selected;?>><?php echo $row->industry_name;?></option>
                                <?php endforeach;?>
                            </select>
                            <span></span>
                             <?php echo form_error('industry_ID'); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="ownership_type">
                                <option selected="" disabled="">Org. Type</option>
                                <option value="Private" <?php echo ($data->ownership_type == "Private")?"selected":"";?>>Private</option>
                                <option value="Public" <?php echo ($data->ownership_type == "Public")?"selected":"";?>>Public</option>
                                <option value="Government" <?php echo ($data->ownership_type == "Government")?"selected":"";?>>Government</option>
                                <option value="Semi-Government" <?php echo ($data->ownership_type == "Semi-Government")?"selected":"";?>>Semi-Government</option>
                                <option value="NGO" <?php echo ($data->ownership_type == "NGO")?"selected":"";?>>NGO</option>
                            </select>
                            <span></span>
                            <?php echo form_error('ownership_type'); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea class="form-control" name="company_location" id="company_location"  placeholder="<?=('Address')?>"><?php echo $data->company_location; ?></textarea>
                            <span></span>
                             <?php echo form_error('company_location'); ?>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select name="country" id="country" class="form-control">
                                <?php 
                                    foreach($result_countries as $row_country):
                                        $selected = ($data->country==$row_country->country_name)?'selected="selected"':'';
                                        
                                ?>
                                  <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
                                  <?php endforeach;?>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                             <input name="city" type="text" class="form-control" id="city_text" style="max-width:165px;" value="<?php echo $data->city; ?>" placeholder="City" maxlength="50">
                            <span></span>
                            <?php echo form_error('city_text'); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="<?=('Cell Phone')?>" name="mobile_phone" value="<?php echo $data->mobile_phone; ?>" maxlength="12">
                            <span></span>
                            <?php echo form_error('mobile_phone'); ?> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="<?=('Landline Phone')?>"  name="company_phone" value="<?php echo $data->company_phone; ?>" maxlength="15">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="url" class="form-control" placeholder="<?=('Company Website')?>" name="company_website" value="<?php echo $data->company_website; ?>" >
                            <span></span>
                            <?php //echo form_error('company_website'); ?>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control"  name="no_of_employees" >
                                <option selected="" disabled=""><?=lang('No. of Employees')?></option>
                                <option value="1-10" <?php echo ($data->no_of_employees=='1-10')?'selected':''; ?>>1-10</option>
                                <option value="11-50" <?php echo ($data->no_of_employees=='11-50')?'selected':''; ?>>11-50</option>
                                <option value="51-100" <?php echo ($data->no_of_employees=='51-100')?'selected':''; ?>>51-100</option>
                                <option value="101-300" <?php echo ($data->no_of_employees=='101-300')?'selected':''; ?>>101-300</option>
                                <option value="301-600" <?php echo ($data->no_of_employees=='301-600')?'selected':''; ?>>301-600</option>
                                <option value="601-1000" <?php echo ($data->no_of_employees=='601-1000')?'selected':''; ?>>601-1000</option>
                                <option value="1001-1500" <?php echo ($data->no_of_employees=='1001-1500')?'selected':''; ?>>1001-1500</option>
                                <option value="1501-2000" <?php echo ($data->no_of_employees=='1501-2000')?'selected':''; ?>>1501-2000</option>
                                <option value="More than 2000" <?php echo ($data->no_of_employees=='More than 2000')?'selected':''; ?>>More than 2000</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea class="form-control" placeholder="<?=('Company Description')?>" rows="2"  name="company_description" ><?php echo $data->company_description; ?></textarea>
                            <span></span>
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
<!-- Modal -->
<div class="modal fade" id="delete-acc" tabindex="-1" role="dialog" aria-labelledby="delete-acc" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="delete-acc">Do you really want to delete your account?</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="<?php echo APPURL; ?>/employer/my-account/delete-account" class="btn btn-blue">Confirm</a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('application/inc/footer'); ?>