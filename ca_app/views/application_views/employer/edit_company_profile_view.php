
<?php $this->load->view('application_views/common/header_emp'); ?>
<div class="div_signup"></div>
<!--/Header-->
<div class="form_div" style="text-align:center;width100%;color:#3785b3">
  
            <div class="uploadPhoto">
              <?php $image_name = ($row->company_logo)?$row->company_logo:'no_logo.jpg';?>
              <img src="<?php echo base_url('public/uploads/employer/'.$image_name);?>"  style="height: 100%;"/>
              <div class="stripBox stripBox_app">
                <form name="frm_emp_up" id="frm_emp_up" method="post" action="<?php echo base_url('app/employer/edit_employer/upload_logo');?>" enctype="multipart/form-data">
                  <input type="file" name="upload_logo" id="upload_logo" accept="image/*" style="display:none;">
                </form>
                <a href="javascript:;" id="my_logo_image" class="upload" title="<?=lang('Upload Logo')?>" style="float: none;font-size: 25px;"><i class="fa fa-camera" ></i></a>
              </div>
                </div>

            <div class="clear"></div>
   
      <!--Professional info-->
      
   
        <?php echo form_open_multipart('app/employer/edit_company',array('name' => 'emp_comp_form', 'id' => 'emp_comp_form', 'onSubmit' => 'return validate_employer_company_form(this);'));?>
            <br/>
             <?php echo $this->session->flashdata('msg');?> 
          
    
    
          <br/>
          <span style="" class="input_label"><?=lang('Email')?> <b>*</b></span> 
              <div class="ara_row <?php echo (form_error('full_name'))?'has-error':'';?>">
                <input name="full_name" type="text" class="form-control app_input" id="full_name" value="<?php echo $full_name; ?>" maxlength="40">
                <?php echo form_error('full_name'); ?> 
              </div>

              <hr/>
    
    
    
    
             <span style="" class="input_label"><?=lang('Company Name')?> <b>*</b></span>   
              
              <div class="ara_row <?php echo (form_error('company_name'))?'has-error':'';?>">
                <input name="company_name" type="text" class="form-control app_input" id="company_name" value="<?php echo $company_name; ?>" maxlength="50" />
                <?php echo form_error('company_name'); ?> </div>
            <hr/>
    
               <span style="" class="input_label"><?=lang('Industry')?> <b>*</b> <small >(This field is essential for matching)</small>
               </span>  
              <div class="ara_row <?php echo (form_error('industry_id'))?'has-error':'';?>">
                <select name="industry_id" id="industry_id" class="form-control app_input">
                  <option value="" selected><?=lang('Select Industry')?></option>
                  <?php foreach($result_industries as $row_industry):
				  			$selected = ($industry_id==$row_industry->ID)?'selected="selected"':'';
				  ?>
                  <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
                  <?php endforeach;?>
                </select>
                <?php echo form_error('industry_id'); ?> </div>
    
              <hr/>
    
               <span style="" class="input_label">Org. Type <b>*</b></span>  
              <div class="ara_row <?php echo (form_error('ownership_type'))?'has-error':'';?>">
                <select class="form-control app_input" name="ownership_type" id="ownership_type">
                  <option value="Private" <?php echo ($ownership_type==lang('Private'))?'selected="selected"':'';?>>Private</option>
                  <option value="Public" <?php echo ($ownership_type==lang('Public'))?'selected="selected"':'';?>>Public</option>
                  <option value="Government" <?php echo ($ownership_type==lang('Government'))?'selected="selected"':'';?>>Government</option>
                  <option value="Semi-Government" <?php echo ($ownership_type==lang('Semi-Government'))?'selected="selected"':'';?>>Semi-Government</option>
                  <option value="NGO" <?php echo ($ownership_type=='NGO')?'selected="selected"':'';?>>NGO</option>
                </select>
                <?php echo form_error('ownership_type'); ?> </div>
    
    
           <hr/>
    
               <span style="" class="input_label"><?=lang('Address')?> <b>*</b></span>  
              <div class="ara_row <?php echo (form_error('company_location'))?'has-error':'';?>">
                <textarea class="form-control app_input_text" name="company_location" id="company_location" ><?php echo $company_location; ?></textarea>
                <?php echo form_error('company_location'); ?> </div>
    
         <hr/>
    
               <span style="" class="input_label"><?=lang('Location')?> <b>*</b></span>  
              <div class="ara_row <?php echo (form_error('country'))?'has-error':'';?>">
                <select name="country" id="country" class="form-control app_input">
                  <?php 
					foreach($result_countries as $row_country):
						$selected = ($country==$row_country->country_name)?'selected="selected"':'';
						
				?>
                  <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
                  <?php endforeach;?>
                </select>
                <?php echo form_error('country'); ?>
               
                
                <input name="city" type="text" class="form-control app_input" id="city_text" value="<?php echo $city; ?>" maxlength="50">
                <?php echo form_error('city'); ?> </div>
    
    
    <hr/>
    
               <span style="" class="input_label"><?=lang('Landline Phone')?> <b>*</b></span> 
    
              <div class="ara_row <?php echo (form_error('company_phone'))?'has-error':'';?>">
                <input type="phone" class="form-control app_input" name="company_phone" id="company_phone" value="<?php echo $company_phone; ?>" maxlength="20" />
                <?php echo form_error('company_phone'); ?> </div>


<hr/>
    
               <span style="" class="input_label"><?=lang('Cell Phone')?> <b>*</b></span> 
              <div class="ara_row <?php echo (form_error('mobile_phone'))?'has-error':'';?>">
               
                <input name="mobile_phone" type="text" class="custom-control app_input" id="mobile_phone" value="<?php echo $mobile_phone; ?>" maxlength="15" />
                <?php echo form_error('mobile_phone'); ?> </div>
    
    <hr/>
    
               <span style="" class="input_label"><?=lang('Company Website')?> <b>*</b></span> 
              <div class="ara_row <?php echo (form_error('company_website'))?'has-error':'';?>">
                <input name="company_website" type="text" class="form-control app_input" id="company_website" value="<?php echo $company_website; ?>" maxlength="155">
                <?php echo form_error('company_website'); ?> </div>
    
     <hr/>
    
               <span style="" class="input_label"><?=lang('No. of Employees')?> <b>*</b></span> 
              <div class="ara_row <?php echo (form_error('no_of_employees'))?'has-error':'';?>">
                <select name="no_of_employees" id="no_of_employees" class="form-control app_input">
                  <option value="1-10" <?php echo ($no_of_employees=='1-10')?'selected':''; ?>>1-10</option>
                  <option value="11-50" <?php echo ($no_of_employees=='11-50')?'selected':''; ?>>11-50</option>
                  <option value="51-100" <?php echo ($no_of_employees=='51-100')?'selected':''; ?>>51-100</option>
                  <option value="101-300" <?php echo ($no_of_employees=='101-300')?'selected':''; ?>>101-300</option>
                  <option value="301-600" <?php echo ($no_of_employees=='301-600')?'selected':''; ?>>301-600</option>
                  <option value="601-1000" <?php echo ($no_of_employees=='601-1000')?'selected':''; ?>>601-1000</option>
                  <option value="1001-1500" <?php echo ($no_of_employees=='1001-1500')?'selected':''; ?>>1001-1500</option>
                  <option value="1501-2000" <?php echo ($no_of_employees=='1501-2000')?'selected':''; ?>>1501-2000</option>
                  <option value="More than 2000" <?php echo ($no_of_employees=='More than 2000')?'selected':''; ?>>More than 2000</option>
                </select>
                <?php echo form_error('no_of_employees'); ?> </div>
    <hr/>
    <span style="" class="input_label"><?=lang('Company Description')?> <b>*</b></span> 
              <div class="ara_row <?php echo (form_error('company_description'))?'has-error':'';?>">
                <textarea class="form-control app_input" name="company_description" id="company_description" rows="8" cols="30" ><?php echo $company_description; ?></textarea>
                <?php echo form_error('company_description'); ?> </div>
              <div align="center">
                <input type="submit" name="submit_button" id="submit_button" value="Update" class="btn btn-success" />
            <hr/>
           <center> <a onclick="$('#delete_account_modal').modal('show');" style="margin-bottom: 10px;" class="btn btn-danger" ><?=lang('Delete my account')?></a></center>
              </div>
            
          <?php echo form_close();?>
          
   
    <!--/Job Detail-->
    
    
  </div>

    <div class="modal fade" id="delete_account_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?=lang('Delete my account')?></h4>
          </div>
          <div class="modal-body">
            <div>
               <h3>
                 <?=lang('Are you sure that you want to delete completely your account ?')?>
               </h3>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default"  data-dismiss="modal" aria-hidden="true"><?=lang('Cancel')?></button>
            <button type="button" class="btn btn-danger" onclick="location.href='<?=base_url()?>user/deleteAccount?mobile=true';"><?=lang('Confirm')?></button>
          </div>
        </div>
      </div>
    </div>
<script src="<?php echo base_url('public/js/bad_words.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jquery-1.11.0.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script> 
<script type="text/javascript">

   $(document).ready(function(){

  $(".fa-camera").click(function(){
    $("#upload_logo").click();
  });
  $("#upload_logo").change(function(){
    ext_array = ['png','jpg','jpeg','gif']; 
    var ext = $('#upload_logo').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ext_array) == -1) {
      alert("<?=lang('Invalid file provided')?>!");
      return false;
    }
   this.form.submit();
  });
    });
    


</script>

<?php $this->load->view('application_views/common/footer_app'); ?>