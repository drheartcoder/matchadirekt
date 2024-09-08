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
  <?php echo form_open_multipart('employer/post_new_job',array('name' => 'post_job_form', 'id' => 'post_job_form', 'onSubmit' => 'return validate_new_post_job_form(this);'));?>
    <div class="col-md-9 ">
      <div class="formwraper">
        <div class="titlehead"><?=lang('Post New Job')?></div>
        <div class="formint">
          <div class=" input-group <?php echo (form_error('industry_id'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Category')?> <span>*</span></label>
            <select name="industry_id" id="industry_id" class="form-control">
              <option value="" selected><?=lang('Select Industry')?></option>
              <?php foreach($result_industries as $row_industry):
                $selected = (set_value('industry_id')==$row_industry->ID)?'selected="selected"':'';
          ?>
              <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
              <?php endforeach;?>
            </select>
             <div><br><br>
                  <small >(This field is essential for matching)</small>
                </div>
            <?php echo form_error('industry_id'); ?> </div>
          <div class="input-group <?php echo (form_error('job_title'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Job Title')?> <span>*</span></label>
            <input name="job_title" type="text" class="form-control" id="job_title" placeholder="Job Title" value="<?php echo set_value('job_title'); ?>" maxlength="150">
            <?php echo form_error('job_title'); ?>
          </div>
          <div class="input-group <?php echo (form_error('diarie'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Diarienummer')?></label>
            <input name="diarie" type="text" class="form-control" id="diarie" placeholder="<?=lang('Diarie Number')?>" value="<?php echo set_value('diarie'); ?>" maxlength="150">
            <?php echo form_error('job_title'); ?> </div>
          <div class="input-group <?php echo (form_error('vacancies'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('No.of Vacancies')?> <span>*</span></label>
            <input type="text" class="form-control" name="vacancies" id="vacancies" value="1" maxlength="3" />
            <?php echo form_error('vacancies'); ?> </div>
          <div class="input-group <?php echo (form_error('experience'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Experience Required')?> <span>*</span></label>
            <select name="experience" id="experience" class="form-control">
              <option value="Fresh" <?php echo (set_value('experience')=='Fresh')?'selected="selected"':'';?>><?=lang('Fresh')?></option>
              <option value="Less than 1" <?php echo (set_value('experience')=='Less than 1 year')?'selected="selected"':'';?>><?=lang('Less than 1 year')?></option>
              <?php for($i=1;$i<=10;$i++):
            $selected = (set_value('experience')==$i)?'selected="selected"':'';
          $year = ($i<2)?'year':'years';
        ?>
              <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i?></option>
              <?php endfor;?>
              <option value="10+" <?php echo (set_value('experience')=='10+')?'selected="selected"':'';?>>10+</option>
            </select>
            (<em>years</em>) <?php echo form_error('job_mode'); ?> </div>
          <div class="input-group <?php echo (form_error('job_mode'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Job Mode')?> <span>*</span></label>
            <select name="job_mode" id="job_mode" class="form-control">
              <option value="Full Time" <?php echo (set_value('job_mode')=='Full Time')?'selected="selected"':'';?>><?=lang('Full Time')?></option>
              <option value="Part Time" <?php echo (set_value('job_mode')=='Part Time')?'selected="selected"':'';?>><?=lang('Part Time')?></option>
              <option value="Home Based" <?php echo (set_value('job_mode')=='Home Based')?'selected="selected"':'';?>><?=lang('Home Based')?></option>
            </select>
            <?php echo form_error('job_mode'); ?> </div>
          <div class="input-group <?php echo (form_error('pay'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Salary Offer(Pk Rs.)')?> <span>*</span></label>
            <select name="pay" id="pay" class="form-control">
              <?php
          foreach($result_salaries as $row_salaries):
            $selected = (set_value('pay')==$row_salaries->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_salaries->val;?>" <?php echo $selected;?>><?php echo $row_salaries->text;?></option>
              <?php endforeach;?>
            </select>(<em><?=lang('in thousands')?></em>)
            <?php echo form_error('pay'); ?> </div>
          <div class="input-group <?php echo (form_error('last_date'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Apply Before')?> <span>*</span></label>
            <input name="last_date" type="text" readonly class="form-control" id="last_date" placeholder="<?=lang('Apply Before')?>" value="<?php echo (set_value('last_date'))?set_value('last_date'):$last_date_dummy; ?>" maxlength="40">
            <?php echo form_error('last_date'); ?> </div>
          
          <div class="input-group <?php echo (form_error('country'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Location')?> <span>*</span></label>
            <select name="country" id="country" class="form-control" style="width:50%">
              <?php 
          foreach($result_countries as $row_country):
            $selected = (set_value('country')==$row_country->country_name)?'selected="selected"':'';
            
            if(set_value('country')=='' && $row->country==$row_country->country_name){
              $selected = 'selected="selected"';
            }
        ?>
              <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('country'); ?>
            
           
            <div class="demo">
              
            
            <input name="city" type="text" class="form-control" id="city_text" style="max-width:165px;" value="<?php echo (set_value('city')!='')?set_value('city'):$row->city; ?>" maxlength="50">
            <?php echo form_error('city'); ?>
            </div>
</div>
          <div class="input-group <?php echo (form_error('qualification'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Qualification')?> <span>*</span></label>
            <select name="qualification" id="qualification" class="form-control" style="width:50%">
              <option value=""><?=lang('Select Qualification')?></option>
              <?php 
          foreach($result_qualification as $row_qualification):
            $selected = (set_value('qualification')==$row_qualification->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_qualification->val;?>" <?php echo $selected;?>><?php echo $row_qualification->text;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('qualification'); ?> </div>
          <div class="input-group <?php echo (form_error('job_description'))?'has-error':'';?>">
            <label class="input-group-addon"><?=lang('Job Description')?></label>
            <textarea name="editor1" id="editor1" cols="60" rows="10" ><?php echo set_value('editor1'); ?></textarea>
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Quizzes')?></label>
            <select multiple="multiple" style="width: 100%;" class="form-control" name="quizzes[]">
              <option value=""><b><?=lang('No Quizzes')?></b></option>
              <?php
              foreach ($quizzes as $row_) {
                ?><option <?php echo (set_value('quizzes')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row->ID?>"><?=$row_->title?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Job Analysis')?></label>
            <select style="width: 100%;" class="form-control" name="job_analysis">
              <option value=""><?=lang('Choose a Job Analysis')?></option>
              <?php
              foreach ($job_analysis as $row) {
                ?><option <?php echo (set_value('job_analysis')==$row->ID)? "selected='selected'" : ''; ?> value="<?=$row->ID?>"><?=$row->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Employer Certificate')?></label>
            <select style="width: 100%;" class="form-control" name="employer_certificate">
              <option value=""><?=lang('Choose a Employer Certificate')?></option>
              <?php
              foreach ($employer_certificates as $row_) {
                ?><option <?php echo (set_value('employer_certificate')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Interview')?></label>
            <select style="width: 100%;" class="form-control" name="interview">
              <option value=""><?=lang('Choose a Interview')?></option>
              <?php
              foreach ($interviews as $row_) {
                ?><option <?php echo (set_value('interview')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div>


          <hr/>

          <div class="input-group">
            <label class="input-group-addon"><?=lang('Job type')?></label>
            <select name="job_type" class="form-control">
              <option <?php echo (set_value('local_mdp')=="Internal")? " selected='selected'" : ''; ?> value="Internal">Internal</option>
              <option <?php echo (set_value('local_mdp')=="External")? " selected='selected'" : ''; ?> value="External">External</option>
              <option <?php echo (set_value('local_mdp')=="Local")? " selected='selected'" : ''; ?> value="Local">Local</option>
              <option <?php echo (set_value('local_mdp')=="National")? " selected='selected'" : ''; ?> value="National">National</option>
              <option <?php echo (set_value('local_mdp')=="Social channels")? " selected='selected'" : ''; ?> value="Social channels">Social channels</option>
              <option <?php echo (set_value('local_mdp')=="Newspapers")? " selected='selected'" : ''; ?> value="Newspapers">Newspapers</option>
            </select>
          </div>

          <div class="input-group">
            <label class="input-group-addon"><?=lang('Password (* Internal only)')?></label>
            <input name="local_mdp" class="form-control" value="<?php echo (set_value('local_mdp')); ?>"/>
          </div>

          <hr/>

          <div class="input-group">
            <label class="input-group-addon"><?=lang('Note')?></label>
            <textarea name="Note" class="form-control" cols="60" rows="10" ><?php echo (set_value('Note')); ?></textarea>
          </div>


        </div>
        
      </div>
      
      <!--Required Skills-->
      <div class="formwraper">
        <div class="titlehead"><?=lang('Please choose the set of skills (Individually) you are looking to hire')?>.</div>
        <div class="formint">
          <div class="jobdescription" style="border-top:0px;">
            <div class="row">
              <div class="col-md-12">
                <div class="skillBox">
                  <ul class="skillDetail" id="myskills">
                    <?php 
            if(set_value('s_val')):
            $selected_skills = explode(', ',set_value('s_val'));
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
                <input type="hidden" name="s_val" id="s_val" value="<?php echo (set_value('s_val'))?set_value('s_val'):''; ?>" class="form-control" />
              </div>
              </div>
              <div class="col-md-2">
                <input type="button" name="js_skill_add" id="js_skill_add" value="Add" class="btn btn-success" />
              </div>
            </div>
            
            <small><?=lang('Single skill at a time')?>.</small>
            <div class="clear">&nbsp;</div>
          </div>
          <div align="center" class="footeraction">
            <input name="draft" id="chk" value="1" style="display: none;" class="form-control" type="checkbox">
            <input name="preview" id="prv" value="1" style="display: none;" class="form-control" type="checkbox">
           <br/>
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Post Job')?>" class="btn btn-success" />
            <input onclick="$('#chk').prop('checked', true);$('#post_job_form').submit();" style="background-color:#757572;border-color: #70716d;width: 100px;" value="<?=lang('Save Draft')?>" type="button" class="btn btn-success" />
            <input onclick="$('#chk').prop('checked', true);$('#prv').prop('checked', true);$('#post_job_form').submit();" style="background-color: #9a5e5e;border-color: #7d5151;width: 150px;" value="<?=lang('Preview')?>" type="button" class="btn btn-success">
            <hr/>
            <input onclick="$('#laterJob').modal('show');" type="button" name="capture" value="<?=lang('Post this Job later')?>" class="btn btn-danger" style="background-color: #5c0580; border-color: #3a0450;width: 200px;margin-top: -50px;"/>
          </div>
        </div>
      </div>
      <div class="modal fade" id="laterJob">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Post this Job later')?></h4>
      </div>
      <div class="modal-body">
        <label>Date</label>
           <input type="date" name="dated" class="form-control" required="required" value="" placeholder="Date" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
        <button type="button" onclick="$('#chk').prop('checked', true);$('#post_job_form').submit();" class="btn btn-success"><?=lang('Post')?></button>
      </div>
    </div>
  </div>
</div>
    </div>
    <!--/Job Detail--> 
    
    <?php echo form_close();?> </div>
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
  $(function() {
   var editor = CKEDITOR.replace( 'editor1');
    });
  //$.noConflict(); 
  $(document).ready(function($) {
    $( "#last_date" ).datepicker({ setDate:<?php echo $last_date_dummy;?>, minDate: 0 });
  });
   </script>
<script type="text/javascript"> var cy = '<?php echo set_value('country');?>'; </script>
<script type="text/javascript">
$(document).ready(function(){
  // $('button').css('display','none');
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