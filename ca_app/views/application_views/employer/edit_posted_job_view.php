<?php $this->load->view('application_views/common/header_emp'); ?>
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


<div class="siteWraper">
<!--Header-->
<!--/Header-->

    <?php echo $this->session->flashdata('msg');?>


            <div class="title_div"><?=lang('File Manager')?></div>
            <div style="text-align: center;
                            background-color: rgba(0,0,0,0.05);
                            font-size: 22px;
                            padding: 5px;">
                <a href="javascript:;" class="upload_cv" style="color: #878787;" title="<?=lang('Upload File')?>"><i class="fa fa-upload"></i></a> <a href="javascript:;" class="upload_cv" class="editlink" title="<?=lang('Upload File')?>"></i></a></div>
            
            <form name="frm_js_up_cv" id="frm_js_up_cv" method="post" action="<?php echo base_url('app/employer/edit_posted_job/upload_file/'.$row->ID);?>" enctype="multipart/form-data"><input type="file" name="upload_file" id="upload_file" style="display:none;"></form>
            
          
        <!--Job Description-->
        
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
                <a href="<?=base_url()?>app/employer/edit_posted_job/delete_file/<?=$row_file->ID?>/<?=$row->ID?>" onClick="return confirm(<?="'".lang('Do you really want to delete this file ?')."'"?>)"  title="<?=lang('Delete')?>" class="delete-ico">
                  <i class="fa fa-times">&nbsp;</i>
                </a>
              </div>
            </li>
            <?php   endforeach; 
          else:?>
                  <div style="text-align:center;">
                      <?=lang('No file uploaded yet')?>!
                  </div>
            
            <?php endif;?>
          </ul>
            
        
  


        <?php echo form_open_multipart('app/employer/edit_posted_job/index/'.$id,array('name' => 'post_job_form', 'id' => 'post_job_form', 'onSubmit' => 'return validate_new_post_job_form(this);'));?>




     
        <div class="title_div"><?=lang('Edit Posted Job')?></div>
      <br/>
    
        <span style="" class="input_label"><?=lang('Category')?> <b>*</b> 
        </span>  
          <div class="ara_row <?php echo (form_error('industry_id'))?'has-error':'';?>">
              
            <select name="industry_id" id="industry_id" class="form-control app_input" required="">
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
    
       <hr/>
    
        <span style="" class="input_label"><?=lang('Job Title')?> <b>*</b></span>  
          <div class="ara_row <?php echo (form_error('job_title'))?'has-error':'';?>">
            <input name="job_title" type="text" class="form-control app_input" id="job_title" placeholder="<?=lang('Job Title')?>" value="<?php echo $row->job_title; ?>" maxlength="150">
            <?php echo form_error('job_title'); ?> </div>
    
    <hr/>
    
        <span style="" class="input_label"><?=lang('Diarienummer')?> <b>*</b></span>  
          <div class="ara_row <?php echo (form_error('diarie'))?'has-error':'';?>">
            <input name="diarie" type="text" class="form-control app_input" id="diarie" placeholder="<?=lang('Diarie Number')?>" value="<?php echo $row->diarie; ?>" maxlength="150">
            <?php echo form_error('job_title'); ?> </div>
    
    <hr/>
    
        <span style="" class="input_label"><?=lang('No.of Vacancies')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('vacancies'))?'has-error':'';?>">
            <select name="vacancies" id="vacancies" class="form-control app_input">
              <?php for($i=1;$i<=50;$i++):
            $selected = ($row->vacancies==$i)?'selected="selected"':'';
        ?>
              <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
              <?php endfor;?>
            </select>
            <?php echo form_error('vacancies'); ?> </div>
    
     <hr/>
    
        <span style="" class="input_label"><?=lang('Experience Required')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('experience'))?'has-error':'';?>">
            <select name="experience" id="experience" class="form-control app_input">
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
    
    
    
    
     <hr/>
    
        <span style="" class="input_label"><?=lang('Job Mode')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('job_mode'))?'has-error':'';?>">
            <select name="job_mode" id="job_mode" class="form-control app_input">
              <option value="Full Time" <?php echo ($row->job_mode=='Full Time')?'selected="selected"':'';?>><?=lang('Full Time')?></option>
              <option value="Part Time" <?php echo ($row->job_mode=='Part Time')?'selected="selected"':'';?>><?=lang('Part Time')?></option>
              <option value="Home Based" <?php echo ($row->job_mode=='Home Based')?'selected="selected"':'';?>><?=lang('Home Based')?></option>
            </select>
            <?php echo form_error('job_mode'); ?> </div>
    
    <hr/>
    
        <span style="" class="input_label"><?=lang('Salary Offer(Pk Rs.)')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('pay'))?'has-error':'';?>">
            <select name="pay" id="pay" class="form-control app_input">
              <?php
          foreach($result_salaries as $row_salaries):
            $selected = ($row->pay==$row_salaries->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_salaries->val;?>" <?php echo $selected;?>><?php echo $row_salaries->text;?></option>
              <?php endforeach;?>
            </select>(<em><?=lang('in thousands')?></em>)
            <?php echo form_error('pay'); ?> </div>
    
    
          <hr/>
    
        <span style="" class="input_label"><?=lang('Apply Before')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('last_date'))?'has-error':'';?>">
            <input name="last_date" type="text" readonly class="form-control app_input" id="last_date" placeholder="<?=lang('Apply Before')?>" value="<?php echo date_formats($row->last_date,'m/d/Y'); ?>" maxlength="40">
            <?php echo form_error('last_date'); ?> </div>
          
    <hr/>
    
        <span style="" class="input_label"><?=lang('Location')?> <b>*</b></span>
          
          <div class="ara_row <?php echo (form_error('country'))?'has-error':'';?>">
            <select name="country" id="country" class="form-control app_input" onChange="grab_cities_by_country(this.value);" >
              <?php 
          foreach($result_countries as $row_country):
            $selected = ($row->country==$row_country->country_name)?'selected="selected"':'';
            
            
        ?>
              <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('country'); ?>
            
       
            
            <input name="city" type="text" class="form-control app_input" id="city_text"  value="<?php echo $row->city; ?>" maxlength="50">
            <?php echo form_error('city'); ?>
</div>
    
    <hr/>
    
        <span style="" class="input_label"><?=lang('Qualification')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('qualification'))?'has-error':'';?>">
            <select name="qualification" id="qualification" class="form-control app_input">
              <option value=""><?=lang('Select Qualification')?></option>
              <?php 
          foreach($result_qualification as $row_qualification):
            $selected = ($row->qualification==$row_qualification->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_qualification->val;?>" <?php echo $selected;?>><?php echo $row_qualification->text;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('qualification'); ?> </div>
    
    <hr/>
    
        <span style="" class="input_label"><?=lang('Job Description')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('job_description'))?'has-error':'';?>">
            <textarea name="editor1" id="editor1" cols="60" rows="10" class="form-control app_input_text"><?php echo $row->job_description; ?></textarea>
          </div><hr/>
    <span style="" class="input_label"><?=lang('Quizzes')?> <b>*</b></span>
          <div class="ara_row">
            <select multiple="multiple" style="width: 100%;" class="form-control app_input" name="quizzes[]">
              <option value=""><b><?=lang('No Quizzes')?></b></option>
              <?php
              $quizzes_ids=explode(",", $row->quizz_text);
              foreach ($quizzes as $row_) {
                ?><option <?php echo (in_array($row_->ID, $quizzes_ids))? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->title?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
    
    <span style="" class="input_label"><?=lang('Job Analysis')?> <b>*</b></span>
          <div class="ara_row">
            <select  class="form-control app_input" name="job_analysis">
              <option value=""><?=lang('Choose an Job Analysis')?></option>
              <?php
              foreach ($job_analysis as $row_) {
                ?><option <?php echo ($row->job_analysis_id==$row_->ID)? " selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
    
     <span style="" class="input_label"><?=lang('Employer Certificate')?> <b>*</b></span>
          <div class="ara_row">
            <label class="input-group-addon"><?=lang('Employer Certificate')?></label>
            <select  class="form-control app_input" name="employer_certificate">
              <option value=""><?=lang('Choose an Employer Certificate')?></option>
              <?php
              foreach ($employer_certificates as $row_) {
                ?><option <?php echo ($row->employer_certificate_id==$row_->ID)? " selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
    
    <span style="" class="input_label"><?=lang('Interview')?> <b>*</b></span>
          <div class="ara_row">
            <select  class="form-control app_input" name="interview">
              <option value=""><?=lang('Choose an Interview')?></option>
              <?php
              foreach ($interviews as $row_) {
                ?><option <?php echo ($row->interview_id==$row_->ID)? " selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div>
          <hr/>
          <span style="" class="input_label"><?=lang('Note')?> <b>*</b></span>
          <div class="ara_row">
            <textarea name="Note" class="form-control app_input_text" cols="60" rows="10" ><?php echo $row->note; ?></textarea>
          </div>

      
      <!--Required Skills-->
     
        <div class="title_div"><?=lang('Required Skills')?></div>
       
         <br/>
            
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
            <div class="clear"></div>
         
    
    <hr/>
    
    <span style="" class="input_label"><?=lang('Add Skill')?> <b>*</b></span>
          <div class="ara_row">
              <div class="ui-widget">
                <input type="text" name="skill" id="skill" value="" autocomplete="off" class="form-control app_input" />
                <input type="hidden" name="s_val" id="s_val" value="<?php echo (set_value('s_val'))?set_value('s_val'):$row->required_skills; ?>" class="form-control" />
              </div>
             
                <input type="button" name="js_skill_add" id="js_skill_add" style="margin-top:10px;" value="<?=lang('Add')?>" class="btn btn-success" />
            
            
            <small><?=lang('Single skill at a time')?>.</small>
            
          </div>
       
      <!--Professional info-->
      
        <div class="title_div"><?=lang('Contact Information')?></div>
    <br/>
    
    <span style="" class="input_label"><?=lang('Contact Person')?> <b>*</b></span>
     
          <div class="ara_row <?php echo (form_error('contact_person'))?'has-error':'';?>">
            <input name="contact_person" type="text" class="form-control app_input" id="contact_person" value="<?php echo (set_value('contact_person'))?set_value('contact_person'):$row->contact_person; ?>" maxlength="50" />
            <?php echo form_error('contact_person'); ?> </div>
    
     <hr/>
    
    <span style="" class="input_label"><?=lang('Email')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('contact_email'))?'has-error':'';?>">
            <input name="contact_email" type="text" class="form-control app_input" id="contact_email" value="<?php echo (set_value('contact_email'))?set_value('contact_email'):$row->contact_email; ?>" maxlength="50" />
            <?php echo form_error('contact_email'); ?> </div>
    
    <hr/>
    
    <span style="" class="input_label"><?=lang('Phone')?> <b>*</b></span>
          <div class="ara_row <?php echo (form_error('contact_phone'))?'has-error':'';?>">
            <input type="phone" class="form-control app_input" name="contact_phone" id="contact_phone" value="<?php echo (set_value('contact_phone'))?set_value('contact_phone'):$row->contact_phone; ?>" maxlength="20" />
            <?php echo form_error('contact_phone'); ?> </div>
    
          <div align="center">
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Update')?>" class="btn btn-success" />
            <a class="btn btn-primary" href="<?= base_url('app/employer/edit_posted_job/Clone_1/'.$id);  ?>"><?=lang('Clone')?></a>
          </div>
       
      
      <!--Advertise-->
      
      

       <!--Advertise-->
     
        <div class="title_div" style="background: darkred;"><?=lang('Delete permanently this job')?></div>
       
        <br/>
              <?=lang('NOTE: By deleting this job , all job applications and chats will be lost forever. please make sure that you are doing the right thing !')?>
          

          <div class="" style="text-align:center;margin-top: 10px;">
              <input onclick="$('#deleteJob').modal('show');" type="button" name="capture" value="<?=lang('Delete this Job')?>" class="btn btn-danger" style="background: darkred;border-radius:5px!important;" />
          </div>
       


    <?php echo form_close();?>

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
      <form action="<?=base_url()?>app/employer/my_posted_jobs/delete/<?=$row->ID?>" method="post">
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
<?php $this->load->view('application_views/common/footer_app'); ?>