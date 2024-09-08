<?php $this->load->view('application_views/common/head_app'); ?>
             <h3 style="text-align:center;width100%;color:#3785b3"><?=lang('SIGN UP')?> </h3>

                 <?php echo form_open_multipart('app/employer_signup',array('name' => 'emp_form', 'id' => 'emp_form', 'onSubmit' => 'return validate_employer_form(this);'));?>
    <div class="col-md-12">
      
      <!--Account info-->

        <div class="title_div"><?=lang('Account Information')?></div>
                  <hr/>
          <span style="" class="input_label"><?=lang('Email')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('email'))?'has-error':'';?>">
                <input name="email" type="text" class="form-control app_input" id="email" placeholder="" value="<?php echo set_value('email'); ?>" maxlength="150">
          </div>
        
         <hr/>
        <span style="" class="input_label"><?=lang('Password')?> <b>*</b></span>
          <div class="ara_row <?<?php echo (form_error('pass_code'))?'has-error':'';?>">
                <input name="pass" type="password" class="form-control app_input" id="pass" placeholder="" value="<?php echo set_value('pass_code'); ?>" maxlength="100">
            <?php echo form_error('pass_code'); ?> 
          </div>
        
        
         <hr/>
        
        <span style="" class="input_label"><?=lang('Confirm Password')?> <b>*</b></span>
          <div class="ara_row <?<?php echo (form_error('confirm_pass'))?'has-error':'';?>">
                <input name="confirm_pass" type="password" class="form-control app_input" id="confirm_pass" placeholder="" value="<?php echo set_value('confirm_pass'); ?>" maxlength="100">
            <?php echo form_error('confirm_pass'); ?>
          </div>
        
      
      <!--Personal info-->
        <div class="title_div"><?=lang('Company Information')?></div>
                <hr/>
              <span style="" class="input_label"><?=lang('Your Name')?> <b>*</b></span>
          <div class="ara_row <?<?php echo (form_error('full_name'))?'has-error':'';?>">
                <input name="full_name" type="text" class="form-control app_input" id="full_name" placeholder="" value="<?php echo set_value('full_name'); ?>" maxlength="40">
            <?php echo form_error('full_name'); ?> 
          </div>
            <hr/>  
              <span style="" class="input_label"><?=lang('Company Name')?> <b>*</b></span>
          <div class="ara_row <?<?php echo (form_error('company_name'))?'has-error':'';?>">
                 <input name="company_name" type="text" class="form-control app_input" id="company_name" value="<?php echo set_value('company_name'); ?>" maxlength="50" />
            <?php echo form_error('company_name'); ?>
          </div>
         
         <hr/>
          <span style="" class="input_label"><?=lang('Industry')?> <b>*</b>
              <small >(This field is essential for matching)</small>
          </span>
          <div class="ara_row <?php echo (form_error('industry_id'))?'has-error':'';?>">
            <select name="industry_id" id="industry_id" class="form-control app_input" style="max-width:350px;">
              <option value="" selected><?=lang('Select Industry')?></option>
              <?php foreach($result_industries as $row_industry):
				  			$selected = (set_value('industry_id')==$row_industry->ID)?'selected="selected"':'';
				  ?>
              <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('industry_id'); ?> </div>
          <hr/>
        <span style="" class="input_label"><?=lang('Org. Type')?> <b>*</b></span>      
          <div class="ara_row <?php echo (form_error('ownership_type'))?'has-error':'';?>">
            <select class="form-control app_input" name="ownership_type" id="ownership_type">
              <option value="Private"><?=lang('Private')?></option>
              <option value="Public"><?=lang('Public')?></option>
              <option value="Government"><?=lang('Government')?></option>
              <option value="Semi-Government"><?=lang('Semi-Government')?></option>
              <option value="NGO">NGO</option>
            </select>
            <?php echo form_error('ownership_type'); ?> </div>
          
        
        <hr/>
           <span style="" class="input_label"><?=lang('Address')?> </span> 
          <div class="ara_row <?php echo (form_error('company_location'))?'has-error':'';?>">
            <textarea class="form-control app_input_text" name="company_location" id="company_location" ><?php echo set_value('company_location'); ?></textarea>
            <?php echo form_error('company_location'); ?>
         </div>
          <hr/>
        
        <span style="" class="input_label"><?=lang('Location')?>  </span> 
          <div class="ara_row <?php echo (form_error('country'))?'has-error':'';?>">
            <select name="country" id="country" class="form-control app_input" onChange="grab_cities_by_country(this.value);" >
              <?php 
					foreach($result_countries as $row_country):
						$selected = (set_value('country')==$row_country->country_name)?'selected="selected"':'';
						
						
				?>
              <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('country'); ?>
           
            <div class="demo">
              <input name="city" type="text" class="form-control app_input" id="city_text"  value="<?php echo set_value("city"); ?>">
            </div>
            
            <?php echo form_error('city'); ?> </div>
        
        
        <hr/>
          <span style="" class="input_label"><?=lang('Landline Phone')?>  </span> 
          <div class="ara_row <?php echo (form_error('company_phone'))?'has-error':'';?>">
            <input type="phone" class="form-control app_input" name="company_phone" id="company_phone" value="<?php echo set_value('company_phone'); ?>" maxlength="20" />
            <?php echo form_error('company_phone'); ?> </div>
          
        <hr/>
        <span style="" class="input_label"><?=lang('Cell Phone')?>  </span>
          <div class="ara_row <?php echo (form_error('mobile_phone'))?'has-error':'';?>">
            <input name="mobile_phone" type="text" class="custom-control app_input" id="mobile_phone" value="<?php echo set_value('mobile_phone'); ?>" maxlength="15" />
            <?php echo form_error('mobile_phone'); ?> </div>
          
        <hr/>
        <span style="" class="input_label"><?=lang('Company Website')?> </span>
          <div class="ara_row <?php echo (form_error('company_website'))?'has-error':'';?>">
            <input name="company_website" type="text" class="form-control app_input" id="company_website" value="<?php echo set_value('company_website'); ?>" maxlength="155">
            <?php echo form_error('company_website'); ?> </div>
          
           <span style="" class="input_label"><?=lang('No. of Employees')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('no_of_employees'))?'has-error':'';?>">

            <select name="no_of_employees" id="no_of_employees" class="form-control app_input">
              <option value="1-10" <?php echo (set_value('no_of_employees')=='1-10')?'selected':''; ?>>1-10</option>
              <option value="11-50" <?php echo (set_value('no_of_employees')=='11-50')?'selected':''; ?>>11-50</option>
              <option value="51-100" <?php echo (set_value('no_of_employees')=='51-100')?'selected':''; ?>>51-100</option>
              <option value="101-300" <?php echo (set_value('no_of_employees')=='101-300')?'selected':''; ?>>101-300</option>
              <option value="301-600" <?php echo (set_value('no_of_employees')=='301-600')?'selected':''; ?>>301-600</option>
              <option value="601-1000" <?php echo (set_value('no_of_employees')=='601-1000')?'selected':''; ?>>601-1000</option>
              <option value="1001-1500" <?php echo (set_value('no_of_employees')=='1001-1500')?'selected':''; ?>>1001-1500</option>
              <option value="1501-2000" <?php echo (set_value('no_of_employees')=='1501-2000')?'selected':''; ?>>1501-2000</option>
              <option value="More than 2000" <?php echo (set_value('no_of_employees')=='More than 2000')?'selected':''; ?>><?=lang('More than')?> 2000</option>
            </select>
            <?php echo form_error('no_of_employees'); ?> </div>
          
        <hr/>
           <span style="" class="input_label"><?=lang('Company Description')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('company_description'))?'has-error':'';?>">
            <textarea class="form-control app_input_text" name="company_description" id="company_description" ><?php echo set_value('company_description'); ?></textarea>
            <?php echo form_error('company_description'); ?> </div>
        <hr/>
            
        <span style="" class="input_label"><?=lang('Company Logo')?> <b>*</b></span>
                <div class="div_upload ara_row">
                         <label class="upload_file_btn" id="click_btn_logo_company" ><i class="fa fa-upload"></i></label>
                         <input type="file" class="form-control" name="company_logo" id="company_logo" accept="image/*" style="display:none;"/>
                         <input type="text" id="imgcompany_name" class="upload_file_name" placeholder="Select Picture...." disabled/>
                </div>
          
            <p><?=lang('Upload files only in')?> .jpg, .jpeg, .gif or .png <?=lang('format with max size of')?> 6 MB.</p>
                <?php echo form_error('company_logo'); ?> 

        <hr/>
           
          <div align="center">
          <div class="input-group"><hr/>
            <input style="width: 25px;margin-top: 10px;" id="check_agree" class="form-control" type="checkbox">
                  <label style="margin-top: -30px;margin-left: 40px;text-align: left;"><?php echo file_get_contents(base_url().'qcsh/privacy-notice.html');?></label>
          </div><hr/>
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Sign Up')?>" class="btn btn-success" style="float:right"/>
              <a style="float: left;
         margin-top: -2px;
        border-radius: 5px;
    padding: 8px 16px 8px 16px;" href="<?php echo base_url('app/User/login');?>" class="Ara_btn"><?=lang('Login')?></a>
          </div>


      <!--Professional info-->
      
    </div>
    <!--/Job Detail--> 
    <?php echo form_close();?>
 
           
        
       <?php $this->load->view('common/after_body_open'); ?>
        <?php $this->load->view('common/before_body_close'); ?>
   
<script type="text/javascript">
/*$(document).ready(function(){
	$('button').css('display','none');
	if(cy!='USA' && cy!='')
		$(".ui-autocomplete-input.ui-widget.ui-widget-content.ui-corner-left").css('display','none');			
});*/
    $( document ).ready(function() {
    $("#submit_button").attr("disabled", "disabled");
    $('#check_agree').change(function() {
          if(this.checked) {
              $("#submit_button").removeAttr("disabled");
          }
          else
          {
            $("#submit_button").attr("disabled", "disabled");
          }     
      });              
  });
    document.getElementById('click_btn_logo_company').addEventListener('click', function() {
	    document.getElementById('company_logo').click();
    });

      document.getElementById('company_logo').addEventListener('change', function() {
	  document.getElementById("imgcompany_name").value = this.value;
   });

     
</script>
    </body>
</html>