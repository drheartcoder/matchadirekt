<?php $this->load->view('application_views/common/head_app'); ?>
       
     
             <h3 style="text-align:center;width100%;color:#3785b3"><?=lang('SIGN UP')?> </h3>
            
           
                <?php echo form_open_multipart('app/jobseeker_signup',array('name' => 'seeker_form', 'id' => 'seeker_form', 'onSubmit' => 'return validate_form(this);'));?>
  <div class="col-md-12">
   
  
    <!--Account info-->
      <div class="title_div"><?=lang('Account Information')?></div>
      <br/>
      <span style="" class="input_label"><?=lang('Email')?> <b>*</b></span>   
      <div class="ara_row <?php echo (form_error('email'))?'has-error':'';?>">
          <input name="email" type="email" class="form-control app_input" id="email" placeholder="" value="<?php echo set_value('email'); ?>" maxlength="150">
            <?php echo form_error('email'); ?>
           </div>
      <hr/>
      
      <span style="" class="input_label"><?=lang('Password')?> <b>*</b></span>  
      <div class="ara_row <?php echo (form_error('pass'))?'has-error':'';?>">
          <input name="pass" type="password" class="form-control app_input" id="pass" autocomplete="off" placeholder="" value="<?php echo set_value('pass'); ?>" maxlength="100">
          <?php echo form_error('pass'); ?> </div>
      <hr/>
      <span style="" class="input_label"><?=lang('Confirm Password')?> <b>*</b></span>  
        <div class="ara_row <?php echo (form_error('confirm_pass'))?'has-error':'';?>">
          <input name="confirm_pass" type="password" class="form-control app_input" id="confirm_pass" placeholder="" value="<?php echo set_value('confirm_pass'); ?>" maxlength="100">
          <?php echo form_error('confirm_pass'); ?> </div>
    
    <!--Personal info-->
    
      <div class="title_div"><?=lang('Personal Information')?></div>
      
      <br/>
      <span style="" class="input_label"><?=lang('Full Name')?> <b>*</b></span>   
        <div class="ara_row <?php echo (form_error('full_name'))?'has-error':'';?>">
          <input name="full_name" type="text" class="form-control app_input" id="full_name" placeholder="" value="<?php echo set_value('full_name'); ?>" maxlength="40"><?php echo form_error('full_name'); ?> 
          </div>
      <hr/>
      <span style="" class="input_label"><?=lang('Gender')?></span>   
        <div class="ara_row <?php echo (form_error('gender'))?'has-error':'';?>">
          <select class="form-control app_input" name="gender" id="gender">
            <option value="male" <?php echo (set_value('gender')=='male')?'selected':''; ?>><?=lang('Male')?></option>
            <option value="female" <?php echo (set_value('gender')=='female')?'selected':''; ?>><?=lang('Female')?></option>
            <option value="other" <?php echo (set_value('gender')=='other')?'selected':''; ?>><?=lang('Other')?></option>
          </select>
          <?php echo form_error('gender'); ?> </div>
      
      <hr/>
      <span style="" class="input_label"><?=lang('Date of Birth')?></span>
        <div class="ara_row <?php echo (form_error('dob_day'))?'has-error':'';?>">
          <select class="form-control app_input" name="dob_day" id="dob_day">
            <option value=""><?=lang('Day')?></option>
            <?php 
			  	for($dy=1;$dy<=31;$dy++):
				$day =sprintf("%02s", $dy);
              	$selected = (set_value('dob_day')==$day)?'selected="selected"':'';
			  ?>
            <option value="<?php echo $day;?>" <?php echo $selected;?>><?php echo $day;?></option>
            <?php endfor;?>
          </select>
          <select class="form-control app_input" name="dob_month" id="dob_month">
            <option value=""><?=lang('Month')?></option>
            <?php for($mnth=1;$mnth<=12;$mnth++):
			  	$month =sprintf("%02s", $mnth);
				$dummy_date = '2014-'.$month.'-'.'01';
			  	$selected = (set_value('dob_month')==$month)?'selected="selected"':'';
			  ?>
            <option value="<?php echo $month;?>" <?php echo $selected;?>><?php echo date("M", strtotime($dummy_date));?></option>
            <?php endfor;?>
          </select>
          <select class="form-control app_input" name="dob_year" id="dob_year">
            <option value=""><?=lang('Year')?></option>
            <?php for($year=date("Y")-10;$year>=1901;$year--):
			  	$selected = (set_value('dob_year')==$year)?'selected="selected"':'';
				if((set_value('dob_year')=='' && $year=='1980')){
					$selected = 'selected="selected"';
				}
			  ?>
            <option value="<?php echo $year;?>" <?php echo $selected;?>><?php echo $year;?></option>
            <?php endfor;?>
          </select>
          <?php echo form_error('dob_day'); echo form_error('dob_month'); echo form_error('dob_month'); ?> </div>
      
      
      
      <hr/>
          <span style="" class="input_label"><?=lang('Current Address')?> </span>
        <div class="ara_row <?php echo (form_error('current_address'))?'has-error':'';?>">
          <textarea class="form-control app_input_text" name="current_address" id="current_address" ><?php echo set_value('current_address'); ?></textarea>
          <?php echo form_error('current_address'); ?> </div>
      <hr/>
      <span style="" class="input_label"><?=lang('Location')?> </span>
        <div class="ara_row <?php echo (form_error('country'))?'has-error':'';?>">
          <select name="country" id="country" class="form-control app_input" >
            <?php 
					foreach($result_countries as $row_country):
						$selected = (set_value('country')==$row_country->country_name)?'selected="selected"':'';
						
						
						
				?>
            <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
            <?php endforeach;?>
          </select>
          <?php echo form_error('country'); ?>
         
          <div class="demo">
            <input name="city" type="text" class="form-control app_input" id="city_text"  value="<?php echo set_value("city"); ?>" maxlength="50" placeholder="<?=lang('City')?>">
          </div>
          
          <?php echo form_error('city'); ?> </div>
      <hr/>
      <span style="" class="input_label"><?=lang('Nationality')?></span>
        <div class="ara_row <?php echo (form_error('nationality'))?'has-error':'';?>">
          <select class="form-control app_input" name="nationality" id="nationality" >
            <?php foreach($result_countries as $row_country): 
			  if($row_country->country_citizen!=''):
			  			$selected = (set_value('nationality')==$row_country->country_citizen)?'selected="selected"':'';
						
			  ?>
            <option value="<?php echo $row_country->country_citizen;?>" <?php echo $selected;?>><?php echo $row_country->country_citizen;?></option>
            <?php endif; endforeach;?>
          </select>
          <?php echo form_error('nationality'); ?> </div>
      <hr/>
      <span style="" class="input_label"><?=lang('Mobile Phone')?></span>
        <div class="ara_row <?php echo (form_error('mobile_number'))?'has-error':'';?>">
          <input name="mobile_number" type="text" class="form-control app_input" id="mobile_number" value="<?php echo set_value('mobile_number'); ?>" maxlength="15" />
          <?php echo form_error('mobile_number'); ?> </div>
      <hr/>
      
      <span style="" class="input_label"><?=lang('Home Phone')?></span>
        <div class="ara_row">
          <input name="phone" type="text" class="form-control app_input" id="phone" value="<?php echo set_value('phone'); ?>" maxlength="15">
        </div>
    
    <!--Professional info-->
      <div class="title_div"><?=lang('Upload Resume')?></div>
         <br/>
      <span style="" class="input_label"><?=lang('Upload Resume')?></span>
          <div class="div_upload ara_row <?php echo (form_error('cv_file') || $msg)?'has-error':'';?>">
                         <label class="upload_file_btn" id="click_btn_cv"><i class="fa fa-upload"></i></label>
                       
                         <input type="file" class="form-control" name="cv_file" id="cv_file" value="<?php echo set_value('cv_file'); ?>" style="display:none;"/>
              
                         <input type="text" id="cv_name" class="upload_file_name" placeholder="Select File...." disabled/>
                </div>
          
          <p><?=lang('Upload files only in')?> .doc, .docx or .pdf <?=lang('format with maximum size of')?> 6 MB.</p>
          <?php 
					echo form_error('cv_file'); 
					echo ($msg!='')?'<div class="alert alert-error"> <a class="close" data-dismiss="alert">×</a>'.$msg.'</div>':'';
			?>
      
          <div align="center">
          <div class="input-group"><hr/>
            <input style="width: 25px;margin-top: 10px;" id="check_agree" class="form-control" type="checkbox">
                  <label style="margin-top: -30px;margin-left: 40px;text-align: left;"><?php echo file_get_contents(base_url().'qcsh/privacy-notice.html');?></label>
          </div><hr/>
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Sign Up')?>" class="btn btn-success" style="float:right;"/>
              <a style="float: left;
         margin-top: -2px;
        border-radius: 5px;
    padding: 8px 16px 8px 16px;" href="<?php echo base_url('app/User/login');?>" class="Ara_btn"><?=lang('Login')?></a>
          </div>
      
    <!--/Job Detail--> 
    <?php echo form_close();?>    
               
         
        
        
        
        
        
        
        
       <?php $this->load->view('common/after_body_open'); ?>
        <?php $this->load->view('common/before_body_close'); ?>
   
<script type="text/javascript">
$(document).ready(function(){
	/*$('button').css('display','none');
	if(cy!='USA' && cy!='')
		$(".ui-autocomplete-input.ui-widget.ui-widget-content.ui-corner-left").css('display','none');*/
});
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
    
     document.getElementById('click_btn_cv').addEventListener('click', function() {
	    document.getElementById('cv_file').click();
    });

      document.getElementById('cv_file').addEventListener('change', function() {
	  document.getElementById("cv_name").value = this.value;
   });
  
</script>
    </body>
</html>