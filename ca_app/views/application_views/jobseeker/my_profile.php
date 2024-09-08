<div class="div_signup"></div>
<?php $this->load->view('application_views/common/header'); ?>
<!--/Header-->
<div class="form_div" style="text-align:center;width100%;color:#3785b3">
    
    
            <?php $pht=$row->photo;
            if($pht=="") $pht='no_pic.jpg'; ?>
            <div class="uploadPhoto">
              <img class="img_update" src="<?php echo base_url('public/uploads/candidate/'.$pht);?>"  style="height: 100%;"/>
            <div class="stripBox stripBox_app">
            <form name="frm_js_up" id="frm_js_up" method="post" action="<?php echo base_url('app/jobseeker/my_account/upload_photo');?>" enctype="multipart/form-data"><input type="file" name="upload_pic" id="upload_pic" accept="image/*" style="display:none;"></form>
            <a href="javascript:;" class="upload" style="float:none;font-size:25px;" title="<?=lang('Upload Photo')?>"><i class="fa fa-camera"></i></a>
            </div>
         </div>

            <div class="clear"></div>
    
  <?php echo     form_open_multipart('app/jobseeker/my_account',array('name' => 'account_form', 'id' => 'account_form', 'onSubmit' => 'return validate_account_form(this);'));?>
    <br/>
    <?php echo $this->session->flashdata('msg');?>
      
      
      <!--Personal info-->
      
        <br/>
          <span style="" class="input_label"><?=lang('Email')?> <b>*</b></span>   
      <div class="ara_row <?php echo (form_error('email'))?'has-error':'';?>">
          <input name="email" type="email" class="form-control app_input" id="email" placeholder="" value="<?php echo set_value('email')!='' ? set_value('email') : $row->email; ?>" maxlength="40">
            <?php echo form_error('email'); ?>
           </div>
      <hr/>
    
    
    
    
    <span style="" class="input_label"><?=lang('Full Name')?> <b>*</b></span>   
        <div class="ara_row <?php echo (form_error('full_name'))?'has-error':'';?>">
          <input name="full_name" type="text" class="form-control app_input" id="full_name" placeholder="" value="<?php echo $row->first_name.' '.$row->last_name; ?>" maxlength="40"><?php echo form_error('full_name'); ?> 
          </div>
      <hr/>
          
    
    
           <span style="" class="input_label"><?=lang('Gender')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('gender'))?'has-error':'';?>">
            <select class="form-control app_input" name="gender" id="gender">
              <option value="male" <?php echo ($row->gender=='male')?'selected':''; ?>><?=lang('Male')?></option>
              <option value="female" <?php echo ($row->gender=='female')?'selected':''; ?>><?=lang('Female')?></option>
              <option value="other" <?php echo ($row->gender=='other')?'selected':''; ?>><?=lang('Other')?></option>
            </select>
            <?php echo form_error('gender'); ?> </div>
    
    
    
           <span style="" class="input_label"><?=lang('Date of Birth')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('dob_day'))?'has-error':'';?>">
    
            <select class="form-control app_input" name="dob_day" id="dob_day">
              <option value=""><?=lang('Day')?></option>
              <?php 
			  	$dob = explode('-', $row->dob);
				
			  for($dy=1;$dy<=31;$dy++):
			  	$day =sprintf("%02s", $dy);
              	$selected = ($dob[2]==$day)?'selected="selected"':'';
			  ?>
              <option value="<?php echo $day;?>" <?php echo $selected;?>><?php echo $day;?></option>
              <?php endfor;?>
            </select>
            <select class="form-control app_input" name="dob_month" id="dob_month">
              <option value=""><?=lang('Month')?></option>
              <?php for($mnth=1;$mnth<=12;$mnth++):
			  	$month =sprintf("%02s", $mnth);
			  	$selected = ($dob[1]==$month)?'selected="selected"':'';
				$dummy_date = '2014-'.$month.'-'.'01';
			  ?>
              <option value="<?php echo $month;?>" <?php echo $selected;?>><?php echo date("M", strtotime($dummy_date));?></option>
              <?php endfor;?>
            </select>
            <select class="form-control app_input" name="dob_year" id="dob_year">
              <option value=""><?=lang('Year')?></option>
              <?php for($year=date("Y")-10;$year>=1901;$year--):
			  	$selected = ($dob[0]==$year)?'selected="selected"':'';
				if(($dob[0]=='' && $year=='1980')){
					$selected = 'selected="selected"';
				}
			  ?>
              <option value="<?php echo $year;?>" <?php echo $selected;?>><?php echo $year;?></option>
              <?php endfor;?>
            </select>
            <?php echo form_error('dob_day'); echo form_error('dob_month'); echo form_error('dob_month'); ?> </div>
          <hr/>
    
         <span style="" class="input_label"><?=lang('Current     Address')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('current_address'))?'has-error':'';?>">
           
            <textarea class="form-control app_input_text" name="present_address" id="present_address" ><?php echo $row->present_address; ?></textarea>
            <?php echo form_error('current_address'); ?> </div>
          <hr/>
    
    
    
         <span style="" class="input_label"><?=lang('Location')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('country'))?'has-error':'';?>">
            <select name="country" id="country" class="form-control app_input" onChange="grab_cities_by_country(this.value);">
              <?php 
					foreach($result_countries as $row_country):
						$selected = ($row->country==$row_country->country_name)?'selected="selected"':'';
						
						
						
				?>
              <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('country'); ?>
            
            
            <input name="city" type="text" class="form-control app_input" id="city_text" value="<?php echo $row->city; ?>" maxlength="50">
            <?php echo form_error('city'); ?> </div>
    
    <hr/>
          <span style="" class="input_label"><?=lang('Nationality')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('nationality'))?'has-error':'';?>">
           
            <select class="form-control app_input" name="nationality" id="nationality app_input">
              <?php foreach($result_countries as $row_country): 
			  if($row_country->country_citizen!=''):
			  			$selected = ($row->nationality==$row_country->country_citizen)?'selected="selected"':'';
						
			  ?>
              <option value="<?php echo $row_country->country_citizen;?>" <?php echo $selected;?>><?php echo $row_country->country_citizen;?></option>
              <?php endif; endforeach;?>
            </select>
            <?php echo form_error('nationality'); ?> </div>
    
    <hr/>
    
    
         <span style="" class="input_label"><?=lang('Mobile Phone')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('mobile'))?'has-error':'';?>">
            <input name="mobile" type="text" class="form-control app_input" id="mobile" value="<?php echo $row->mobile; ?>" maxlength="15" />
            <?php echo form_error('mobile'); ?> </div>
    
           
    <hr/>
      
      <span style="" class="input_label"><?=lang('Home Phone')?> <b>*</b></span>
          <div class="ara_row">
           
            <input name="phone" type="text" class="form-control app_input" id="phone" value="<?php echo $row->phone; ?>" maxlength="15">
          </div>
          <div align="center">
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Update')?>" class="btn btn-success" />
            <hr/>
           <center> <a onclick="$('#delete_account_modal').modal('show');" style="margin-bottom: 10px;" class="btn btn-danger" ><?=lang('Delete my account')?></a></center>
          </div>
 
    <!--/Job Detail--> 
    <?php echo form_close();?>
    

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
<script>
function del_photo(){
			$.ajax({
					type: "POST",
					url: baseUrl+"jobseeker/edit_jobseeker/delete_photo"
				  })
					.done(function( msg ) {
						if(msg=='done'){
							location.reload();
						} else{
							alert("Something went wrong!");	
							location.reload();
						}
			});

}
function remove_pic(){
  Confirm("Are you sure you want to remove your photo?",function(result){
      if(result==true){
        del_photo();  
      }
  });
}
</script>

<?php $this->load->view('application_views/common/footer_app'); ?>