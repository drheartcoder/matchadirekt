<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<link href="<?php echo base_url('public/css/jquery-ui.css');?>" rel="stylesheet" type="text/css" />
<?php $this->load->view('common/before_head_close'); ?>
<link rel="stylesheet" href="http://jquery-ui.googlecode.com/svn/tags/1.8.7/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="<?php echo base_url('public/autocomplete/demo.css'); ?>">
<style>
.ui-button {
  margin-left: -1px;
}
.ui-button-icon-only .ui-button-text {
  padding: 0.35em;
}
.ui-autocomplete-input {
  margin: 0;
  padding: 0.48em 0 0.47em 0.45em;
}
</style>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header-->
<div class="container detailinfo">
  <div class="row"> 
  <div class="col-md-3">
  <div class="dashiconwrp">
    <?php $this->load->view('employer/common/employer_menu');?>
  </div>
  </div>
  
  
    <div class="col-md-9">
    <?php echo $this->session->flashdata('msg');?>


    <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-8"><b><?=lang('File Manager')?></b></div>
            <div class="col-md-4 text-right"><a href="javascript:;" class="upload_cv" title="<?=lang('Upload File')?>"><?=lang('Upload File')?></a> <a href="javascript:;" class="upload_cv" class="editlink" title="<?=lang('Upload File')?>"><i class="fa fa-plus-square">&nbsp;</i></a></div>
            
            <form name="frm_js_up_cv" id="frm_js_up_cv" method="post" action="<?php echo base_url('employer/edit_posted_job/upload_file/'.$row->ID);?>" enctype="multipart/form-data"><input type="file" name="upload_file" id="upload_file" style="display:none;"></form>
            
          </div>
        </div>
        <!--Job Description-->
        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <ul class="myjobList">
            <?php if($result_files): 
              $i=0;
            foreach($result_files as $row_file):
          $file_name = $row_file->file_name;
          $file_array = explode('.',$file_name);
          $file_array = array_reverse($file_array);
          $icon_name = get_extension_name($file_array[0]);$i++
      ?>
            <li class="row" id="file_<?php echo $row_file->ID;?>">
              <div class="col-md-4">
              <i class="fa fa-file-<?php echo $icon_name;?>-o">&nbsp;</i>
                <a target="_blank" href="<?php echo base_url('file/show/'.$row_file->file_name);?>">File N:<?=$i?><br/>
                  <small style="font-size: 12px;"><?=$row_file->file_name?></small></a>
              </div>
              <div class="col-md-4"><?php echo date_formats($row_file->created_at, "d M, Y");?></div>
              <div class="col-md-2">
              <?php
              if($row_file->private=="yes") 
              { 
                ?>
                <a style="font-size: 13px;" href="<?=base_url()?>employer/edit_posted_job/edit_file/1/<?=$row_file->ID?>/<?=$row->ID?>"><?=lang('Mark as public')?></a>
               <?php 
              } 
              else 
              { 
                  ?>

                  <a style="font-size: 13px;" href="<?=base_url()?>employer/edit_posted_job/edit_file/0/<?=$row_file->ID?>/<?=$row->ID?>"><?=lang('Mark as private')?></a>

                  <?php
              }
              ?>              
              </div>
              <div class="col-md-2 text-right">
                <a href="<?=base_url()?>employer/edit_posted_job/delete_file/<?=$row_file->ID?>/<?=$row->ID?>" onClick="return confirm(<?="'".lang('Do you really want to delete this file ?')."'"?>)"  title="<?=lang('Delete')?>" class="delete-ico">
                  <i class="fa fa-times">&nbsp;</i>
                </a>
              </div>
            </li>
            <?php   endforeach; 
          else:?>
            <?=lang('No file uploaded yet')?>!
            <?php endif;?>
          </ul>
            </div>
          </div>
        </div>
      </div>


        <?php echo form_open_multipart('employer/edit_posted_job/'.$id,array('name' => 'post_job_form', 'id' => 'post_job_form', 'onSubmit' => 'return validate_new_post_job_form(this);'));?>




      <div class="formwraper">
        <div class="titlehead"><?=lang('Edit Posted Job')?></div>
        <div class="formint">
          <div class="input-group <?php echo (form_error('industry_id'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Category')?> <span>*</span></label>
            <select name="industry_id" id="industry_id" class="form-control" >
              <option value="" selected><?=lang('Select Industry')?></option>
              <?php foreach($result_industries as $row_industry):
                $selected = ($row->industry_ID==$row_industry->ID)?'selected="selected"':'';
          ?>
              <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
              <?php endforeach;?>
            </select>
             <div><br><br>
                  <small >(This field is essential for matching)</small>
                </div>
            <?php echo form_error('industry_id'); ?> </div>
          <div class="input-group <?php echo (form_error('job_title'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Job Title')?></label>
            <input name="job_title" type="text" class="form-control" id="job_title" placeholder="<?=lang('Job Title')?>" value="<?php echo $row->job_title; ?>" maxlength="150">
            <?php echo form_error('job_title'); ?> </div>
          <div class="input-group <?php echo (form_error('diarie'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Diarienummer')?> <span>*</span></label>
            <input name="diarie" type="text" class="form-control" id="diarie" placeholder="<?=lang('Diarie Number')?>" value="<?php echo $row->diarie; ?>" maxlength="150">
            <?php echo form_error('job_title'); ?> </div>
          <div class="input-group <?php echo (form_error('vacancies'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('No.of Vacancies')?> <span>*</span></label>
            <select name="vacancies" id="vacancies" class="form-control">
              <?php for($i=1;$i<=50;$i++):
            $selected = ($row->vacancies==$i)?'selected="selected"':'';
        ?>
              <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
              <?php endfor;?>
            </select>
            <?php echo form_error('vacancies'); ?> </div>
          <div class="input-group <?php echo (form_error('experience'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Experience Required')?> <span>*</span></label>
            <select name="experience" id="experience" class="form-control">
              <option value="Fresh" <?php echo ($row->experience=='Fresh')?'selected="selected"':'';?>><?=lang('Fresh')?></option>
              <option value="Less than 1" <?php echo ($row->experience=='Less than 1 year')?'selected="selected"':'';?>><?=lang('Less than 1 year')?></option>
              <?php for($i=1;$i<=10;$i++):
            $selected = ($row->experience==$i)?'selected="selected"':'';
          $year = ($i<2)?lang('year'):lang('years');
        ?>
              <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i?></option>
              <?php endfor;?>
              <option value="10+" <?php echo ($row->experience=='10+')?'selected="selected"':'';?>>10+</option>
            </select>
            (<em><?=lang('years')?></em>) <?php echo form_error('experience'); ?> </div>
          <div class="input-group <?php echo (form_error('job_mode'))?'has-error':'';?>">
            <label class="input-group-addon">Job Mode <span>*</span></label>
            <select name="job_mode" id="job_mode" class="form-control">
              <option value="Full Time" <?php echo ($row->job_mode=='Full Time')?'selected="selected"':'';?>><?=lang('Full Time')?></option>
              <option value="Part Time" <?php echo ($row->job_mode=='Part Time')?'selected="selected"':'';?>><?=lang('Part Time')?></option>
              <option value="Home Based" <?php echo ($row->job_mode=='Home Based')?'selected="selected"':'';?>><?=lang('Home Based')?></option>
            </select>
            <?php echo form_error('job_mode'); ?> </div>
          <div class="input-group <?php echo (form_error('pay'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Salary Offer(Pk Rs.)')?> <span>*</span></label>
            <select name="pay" id="pay" class="form-control">
              <?php
          foreach($result_salaries as $row_salaries):
            $selected = ($row->pay==$row_salaries->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_salaries->val;?>" <?php echo $selected;?>><?php echo $row_salaries->text;?></option>
              <?php endforeach;?>
            </select>(<em><?=lang('in thousands')?></em>)
            <?php echo form_error('pay'); ?> </div>
          <div class="input-group <?php echo (form_error('last_date'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Apply Before')?> <span>*</span></label>
            <input name="last_date" type="text" readonly class="form-control" id="last_date" placeholder="<?=lang('Apply Before')?>" value="<?php echo date_formats($row->last_date,'m/d/Y'); ?>" maxlength="40">
            <?php echo form_error('last_date'); ?> </div>
          
          
          <div class="input-group <?php echo (form_error('country'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Location')?> <span>*</span></label>
            <select name="country" id="country" class="form-control" onChange="grab_cities_by_country(this.value);" style="width:50%">
              <?php 
          foreach($result_countries as $row_country):
            $selected = ($row->country==$row_country->country_name)?'selected="selected"':'';
            
            
        ?>
              <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('country'); ?>
            
       
            
            <input name="city" type="text" class="form-control" id="city_text" style="max-width:165px;" value="<?php echo $row->city; ?>" maxlength="50">
            <?php echo form_error('city'); ?>
</div>
          <div class="input-group <?php echo (form_error('qualification'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Qualification')?> <span>*</span></label>
            <select name="qualification" id="qualification" class="form-control" style="width:50%">
              <option value=""><?=lang('Select Qualification')?></option>
              <?php 
          foreach($result_qualification as $row_qualification):
            $selected = ($row->qualification==$row_qualification->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_qualification->val;?>" <?php echo $selected;?>><?php echo $row_qualification->text;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('qualification'); ?> </div>
          <div class="input-group <?php echo (form_error('job_description'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Job Description')?></label>
            <textarea name="editor1" id="editor1" cols="60" rows="10" ><?php echo $row->job_description; ?></textarea>
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Quizzes')?></label>
            <select multiple="multiple" style="width: 100%;" class="form-control" name="quizzes[]">
              <option value=""><b><?=lang('No Quizzes')?></b></option>
              <?php
              $quizzes_ids=explode(",", $row->quizz_text);
              foreach ($quizzes as $row_) {
                ?><option <?php echo (in_array($row_->ID, $quizzes_ids))? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->title?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Job Analysis')?></label>
            <select style="width: 100%;" class="form-control" name="job_analysis">
              <option value=""><?=lang('Choose an Job Analysis')?></option>
              <?php
              foreach ($job_analysis as $row_) {
                ?><option <?php echo ($row->job_analysis_id==$row_->ID)? " selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Employer Certificate')?></label>
            <select style="width: 100%;" class="form-control" name="employer_certificate">
              <option value=""><?=lang('Choose an Employer Certificate')?></option>
              <?php
              foreach ($employer_certificates as $row_) {
                ?><option <?php echo ($row->employer_certificate_id==$row_->ID)? " selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Interview')?></label>
            <select style="width: 100%;" class="form-control" name="interview">
              <option value=""><?=lang('Choose an Interview')?></option>
              <?php
              foreach ($interviews as $row_) {
                ?><option <?php echo ($row->interview_id==$row_->ID)? " selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div>
          <hr/>

          <div class="input-group">
            <label class="input-group-addon"><?=lang('Job type')?></label>
            <select name="job_type" class="form-control">
              <option <?php echo ($row->job_type=="Internal")? " selected='selected'" : ''; ?> value="Internal">Internal</option>
              <option <?php echo ($row->job_type=="External")? " selected='selected'" : ''; ?> value="External">External</option>
              <option <?php echo ($row->job_type=="Local")? " selected='selected'" : ''; ?> value="Local">Local</option>
              <option <?php echo ($row->job_type=="National")? " selected='selected'" : ''; ?> value="National">National</option>
              <option <?php echo ($row->job_type=="Social channels")? " selected='selected'" : ''; ?> value="Social channels">Social channels</option>
              <option <?php echo ($row->job_type=="Newspapers")? " selected='selected'" : ''; ?> value="Newspapers">Newspapers</option>
            </select>
          </div>

          <div class="input-group">
            <label class="input-group-addon"><?=lang('Password (* Internal only)')?></label>
            <input name="local_mdp" class="form-control" value="<?php echo ($row->local_mdp); ?>"/>
          </div>

          <hr/>

          <div class="input-group">
            <label class="input-group-addon"><?=lang('Note')?></label>
            <textarea name="Note" class="form-control" cols="60" rows="10" ><?php echo $row->note; ?></textarea>
          </div>

        </div>
        
      </div>
      
      <!--Required Skills-->
      <div class="formwraper">
        <div class="titlehead"><?=lang('Required Skills')?></div>
        <div class="formint">
          <div class="jobdescription" style="border-top:0px;">
            <div class="row">
              <div class="col-md-12">
                <div class="skillBox">
                  <ul class="skillDetail" id="myskills">
                    <?php 
            if($row->required_skills):
            $selected_skills = explode(', ',$row->required_skills);
              foreach($selected_skills as $each_skill):
            if(trim($each_skill)!=''): ?>
                    <li><?php echo trim($each_skill);?> <a href="javascript:remove_job_skill('<?php echo trim($each_skill);?>');" class="delete"><i class="fa fa-times-circle"></i></a></li>
                   <?php 
              endif;
              endforeach;
            endif;
           ?>
                  </ul>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Add Skill')?><span>*</span></label>
            <div class="row">
              <div class="col-md-8">
              <div class="ui-widget">
                <input type="text" name="skill" id="skill" value="" autocomplete="off" class="form-control" />
                <input type="hidden" name="s_val" id="s_val" value="<?php echo (set_value('s_val'))?set_value('s_val'):$row->required_skills; ?>" class="form-control" />
              </div>
              </div>
              <div class="col-md-2">
                <input type="button" name="js_skill_add" id="js_skill_add" value="<?=lang('Add')?>" class="btn btn-success" />
              </div>
            </div>
            
            <small><?=lang('Single skill at a time')?>.</small>
            
          </div>
        </div>
      </div>
      <!--Professional info-->
      <div class="formwraper">
        <div class="titlehead"><?=lang('Contact Information')?></div>
        <div class="formint">
          <div class="input-group <?php echo (form_error('contact_person'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Contact Person')?> <span>*</span></label>
            <input name="contact_person" type="text" class="form-control" id="contact_person" value="<?php echo (set_value('contact_person'))?set_value('contact_person'):$row->contact_person; ?>" maxlength="50" />
            <?php echo form_error('contact_person'); ?> </div>
          <div class="input-group <?php echo (form_error('contact_email'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Email')?> <span>*</span></label>
            <input name="contact_email" type="text" class="form-control" id="contact_email" value="<?php echo (set_value('contact_email'))?set_value('contact_email'):$row->contact_email; ?>" maxlength="50" />
            <?php echo form_error('contact_email'); ?> </div>
          <div class="input-group <?php echo (form_error('contact_phone'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Phone')?> <span>*</span></label>
            <input type="phone" class="form-control" name="contact_phone" id="contact_phone" value="<?php echo (set_value('contact_phone'))?set_value('contact_phone'):$row->contact_phone; ?>" maxlength="20" />
            <?php echo form_error('contact_phone'); ?> </div>
          <div align="center">
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Update')?>" class="btn btn-success" />
            <a class="btn btn-success" href="<?= base_url('employer/clone_job/'.$id);  ?>"><?=lang('Clone')?></a>
          </div>
        </div>
      </div>
      
      <!--Advertise-->
      <div class="formwraper">
        <div class="titlehead"><?=lang('Advertise')?></div>
        <div class="formint">
          <?php
        $job_title = word_limiter(strip_tags(str_replace('-',' ',$row->job_title)),7);
        $company_logo = ($row->company_logo)?$row->company_logo:'thumb/no_pic.jpg';
        if (!file_exists(realpath(APPPATH . '../public/uploads/employer/'.$company_logo))){
        $company_logo='thumb/no_pic.jpg';
        }
        $bsr=base_url('public/uploads/employer/'.$company_logo);
        $html=$row->advertise;
        $job_advertise_name=file_get_contents(base_url()."public/uploads/employer/companies/BIXMA_JOB_".$row->ID.".png");
        $base64 = base64_encode($job_advertise_name);  
        $src="data:image/png;base64,".$base64
        ?>
          <div style="margin: auto;max-width: 700px;"><img id="img_adv" src="<?=$src?>" /></div>
          <div align="center" style="margin-top: 20px;">
          <input onclick="$('#edit_advertise').modal('show');" type="button" name="capture" value="<?=lang('Edit Advertise')?>" class="btn btn-success" />
          <a href="./download/<?=$row->ID.'/'.$row->job_slug?>.png" style="background: #3d6d00;" type="button" name="capture" class="btn btn-primary"><?=lang('Download')?> <i class="fa fa-download"></i></a>
          </div>



        </div>
      </div>
      

       <!--Advertise-->
      <div class="formwraper">
        <div class="titlehead" style="background: darkred;"><?=lang('Delete permanently this job')?></div>
        <div class="formint row">
          <div class="col-md-10">
              <?=lang('NOTE: By deleting this job , all job applications and chats will be lost forever. please make sure that you are doing the right thing !')?>
          </div>

          <div class="col-md-2">
              <input onclick="$('#deleteJob').modal('show');" type="button" name="capture" value="<?=lang('Delete this Job')?>" class="btn btn-danger" style="background: darkred;" />
          </div>
        </div>
      </div>


    <?php echo form_close();?>
    </div>



           </div>
</div>
<div class="modal fade" id="edit_advertise">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?=base_url()?>employer/edit_posted_job/edit_advertise/<?=$row->ID?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Edit Advertise')?></h4>
      </div>
      <div class="modal-body">
           <textarea cols="60" id="html_code" name="html_code" rows="10" class="form-control"><?php echo $html;?></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
        <button type="submit" name="submit_btn" id="submit_btn" class="btn btn-success"><?=lang('Update')?></button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteJob">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?=base_url()?>employer/delete_posted_job/<?=$row->ID?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Delete job')?></h4>
      </div>
      <div class="modal-body">
             <?=lang('Are you really wanna delete this job ?')?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
        <button type="submit"  name="submit_btn" id="submit_btn" class="btn btn-danger"><?=lang('Delete')?></button>
      </div>
    </form>
    </div>
  </div>
</div>



<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<script src="<?php echo base_url('public/js/bad_words.js'); ?>"></script>
<?php $this->load->view('common/before_body_close'); ?>
<script src="<?php echo base_url('public/js/jquery-ui.js'); ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/admin/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script> 


<script type="text/javascript">

  $(".upload_cv").click(function(){
    $("#upload_file").click();
  });

  $("#upload_file").change(function(){
    ext_array = ['doc','docx','pdf','rtf','png','jpg','jpeg','mp4','txt','gif'];  
    var ext = $('#upload_file').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ext_array) == -1) {
      alert('Invalid file provided!');
      return false;
    }
   this.form.submit();
  });

  $(function() {
   var editor = CKEDITOR.replace( 'editor1');
   var editor = CKEDITOR.replace( 'html_code');
    });
  //$.noConflict(); 
  $(document).ready(function($) {
    $( "#last_date" ).datepicker({ minDate: 0, maxDate: "+12M +10D" });
  });
   </script>
<script type="text/javascript"> var cy = '<?php echo set_value('country');?>'; </script>
<script type="text/javascript">
$(document).ready(function(){
  
  if(cy!='USA' && cy!='')
    $(".ui-autocomplete-input.ui-widget.ui-widget-content.ui-corner-left").css('display','none');
});
$(function() {
    var availableSkills = <?php echo $available_skills;?>;
    $( "#skill" ).autocomplete({source: availableSkills});
  });
</script>
<script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          /*.appendTo( this.wrapper )*/
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":hidden" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " <?=lang('didn\'t match any item')?>" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( "#city_dropdown" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#city_dropdown" ).toggle();
    });
  });
  </script>
</body>
</html>