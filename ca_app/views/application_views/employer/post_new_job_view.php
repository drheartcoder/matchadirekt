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

  <?php echo form_open_multipart('app/employer/post_new_job',array('name' => 'post_job_form', 'id' => 'post_job_form', 'onSubmit' => 'return validate_new_post_job_form(this);'));?>
           
          <span style="" class="input_label"><?=lang('Category')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('industry_id'))?'has-error':'';?>">
            <select name="industry_id" id="industry_id" class="form-control app_input">
              <option value="" selected><?=lang('Select Industry')?></option>
              <?php foreach($result_industries as $row_industry):
                $selected = (set_value('industry_id')==$row_industry->ID)?'selected="selected"':'';
          ?>
              <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('industry_id'); ?> </div>
<hr/>
          <span style="" class="input_label"><?=lang('Job Title')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('job_title'))?'has-error':'';?>">
            <input name="job_title" type="text" class="form-control app_input" id="job_title" placeholder="Job Title" value="<?php echo set_value('job_title'); ?>" maxlength="150">
            <?php echo form_error('job_title'); ?> </div>

<hr/>
          <span style="" class="input_label"><?=lang('Diarienummer')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('diarie'))?'has-error':'';?>">
            <input name="diarie" type="text" class="form-control app_input" id="diarie" placeholder="<?=lang('Diarie Number')?>" value="<?php echo set_value('diarie'); ?>" maxlength="150">
            <?php echo form_error('job_title'); ?> </div>

<hr/>
          <span style="" class="input_label"><?=lang('No.of Vacancies')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('vacancies'))?'has-error':'';?>">
            <input type="text" class="form-control app_input" name="vacancies" id="vacancies" value="1" maxlength="3" />
            <?php echo form_error('vacancies'); ?> </div>


<hr/>
          <span style="" class="input_label"><?=lang('Experience Required')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('experience'))?'has-error':'';?>">
            <select name="experience" id="experience" class="form-control app_input">
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


<hr/>
          <span style="" class="input_label"><?=lang('Job Mode')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('job_mode'))?'has-error':'';?>">
            <select name="job_mode" id="job_mode" class="form-control app_input">
              <option value="Full Time" <?php echo (set_value('job_mode')=='Full Time')?'selected="selected"':'';?>><?=lang('Full Time')?></option>
              <option value="Part Time" <?php echo (set_value('job_mode')=='Part Time')?'selected="selected"':'';?>><?=lang('Part Time')?></option>
              <option value="Home Based" <?php echo (set_value('job_mode')=='Home Based')?'selected="selected"':'';?>><?=lang('Home Based')?></option>
            </select>
            <?php echo form_error('job_mode'); ?> </div>

<hr/>
          <span style="" class="input_label"><?=lang('Salary Offer(Pk Rs.)')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('pay'))?'has-error':'';?>">
            <select name="pay" id="pay" class="form-control app_input">
              <?php
          foreach($result_salaries as $row_salaries):
            $selected = (set_value('pay')==$row_salaries->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_salaries->val;?>" <?php echo $selected;?>><?php echo $row_salaries->text;?></option>
              <?php endforeach;?>
            </select>(<em><?=lang('in thousands')?></em>)
            <?php echo form_error('pay'); ?> </div>

<hr/>
          <span style="" class="input_label"><?=lang('Apply Before')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('last_date'))?'has-error':'';?>">
            <input name="last_date" type="text" readonly class="form-control app_input" id="last_date" placeholder="<?=lang('Apply Before')?>" value="<?php echo (set_value('last_date'))?set_value('last_date'):$last_date_dummy; ?>" maxlength="40">
            <?php echo form_error('last_date'); ?> </div>

  <hr/>
          <span style="" class="input_label"><?=lang('Location')?> <b>*</b></span> 
          
          <div class="ara_row <?php echo (form_error('country'))?'has-error':'';?>">
            <select name="country" id="country" class="form-control app_input">
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
            
           
            
              
            
            <input name="city" type="text" class="form-control app_input" id="city_text" value="<?php echo (set_value('city')!='')?set_value('city'):$row->city; ?>" maxlength="50">
            <?php echo form_error('city'); ?>
           
</div>

<hr/>
          <span style="" class="input_label"><?=lang('Qualification')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('qualification'))?'has-error':'';?>">
            <select name="qualification" id="qualification" class="form-control app_input">
              <option value=""><?=lang('Select Qualification')?></option>
              <?php 
          foreach($result_qualification as $row_qualification):
            $selected = (set_value('qualification')==$row_qualification->val)?'selected="selected"':'';
        ?>
              <option value="<?php echo $row_qualification->val;?>" <?php echo $selected;?>><?php echo $row_qualification->text;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('qualification'); ?> </div>

<hr/>
          <span style="" class="input_label"><?=lang('Job Description')?> <b>*</b></span> 
          <div class="ara_row <?php echo (form_error('job_description'))?'has-error':'';?>">
            <textarea name="editor1" id="editor1" cols="60" rows="10" class="form-control app_input_text"><?php echo set_value('editor1'); ?></textarea>
          </div><hr/>

        <span style="" class="input_label"><?=lang('Quizzes')?> <b>*</b></span> 
          <div class="ara_row">
            <select multiple="multiple"  class="form-control app_input" name="quizzes[]">
              <option value=""><b><?=lang('No Quizzes')?></b></option>
              <?php
              foreach ($quizzes as $row_) {
                ?><option <?php echo (set_value('quizzes')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row->ID?>"><?=$row_->title?></option><?php
              }
              ?>
            </select>            
          </div><hr/>

    <span style="" class="input_label"><?=lang('Job Analysis')?> <b>*</b></span> 
          <div class="ara_row">
            <select  class="form-control app_input" name="job_analysis">
              <option value=""><?=lang('Choose an Job Analysis')?></option>
              <?php
              foreach ($job_analysis as $row) {
                ?><option <?php echo (set_value('job_analysis')==$row->ID)? "selected='selected'" : ''; ?> value="<?=$row->ID?>"><?=$row->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>

           <span style="" class="input_label"><?=lang('Employer Certificate')?> <b>*</b></span> 
          <div class="ara_row">
            <select class="form-control app_input" name="employer_certificate">
              <option value=""><?=lang('Choose an Employer Certificate')?></option>
              <?php
              foreach ($employer_certificates as $row_) {
                ?><option <?php echo (set_value('employer_certificate')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div><hr/>

        <span style="" class="input_label"><?=lang('Interview')?> <b>*</b></span> 
          <div class="ara_row">
            <select style="width: 100%;" class="form-control app_input" name="interview">
              <option value=""><?=lang('Choose an Interview')?></option>
              <?php
              foreach ($interviews as $row_) {
                ?><option <?php echo (set_value('interview')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
              }
              ?>
            </select>            
          </div>


          <hr/>
            <span style="" class="input_label"><?=lang('Note')?> <b>*</b></span> 
          <div class="ara_row">
            <textarea name="Note" class="form-control app_input_text" cols="60" rows="10" ><?php echo (set_value('Note')); ?></textarea>
          </div>

        
     <br/>
      
      <!--Required Skills-->
        <div class="title_div" style="height: unset;"><?=lang('Please choose the set of skills (Individually) you are looking to hire')?>.</div>

          <div class="jobdescription ara_row" style="margin-top:20px;">
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
             
            <div class="clear"></div>
          </div>

<hr/>

        <span style="" class="input_label"><?=lang('Add Skill')?> <b>*</b></span> 
          <div class="ara_row">
              <div class="ui-widget">
                <input type="text" name="skill" id="skill" value="" autocomplete="off" class="form-control app_input" />
                <input type="hidden" name="s_val" id="s_val" value="<?php echo (set_value('s_val'))?set_value('s_val'):''; ?>" class="form-control" />
              </div>
              
                <input type="button" name="js_skill_add" id="js_skill_add" value="Add" class="btn btn-success preview_app" />
              
            
            <small style=""><?=lang('Single skill at a time')?>.</small>
            <div class="clear">&nbsp;</div>
          </div>
          <div align="center" class="footeraction">
            <input name="draft" id="chk" value="1" style="display: none;" class="form-control" type="checkbox">
            <input name="preview" id="prv" value="1" style="display: none;" class="form-control" type="checkbox">
           <br/>
            <input type="submit" name="submit_button" id="submit_button" value="<?=lang('Post Job')?>" class="btn btn-success Ara_btn" />
            <input onclick="$('#chk').prop('checked', true);$('#post_job_form').submit();" style="background-color:#757572;border-color: #70716d;" value="<?=lang('Save Draft')?>" type="button" class="btn btn-success Ara_btn" />
              <br/>
            <input onclick="$('#chk').prop('checked', true);$('#prv').prop('checked', true);$('#post_job_form').submit();" style="background-color: #9a5e5e;border-color: #7d5151;margin-top: -15px;
    border-radius: 20px!important;" value="<?=lang('Preview')?>" type="button" class="btn btn-success Ara_btn">
          </div>
    <!--/Job Detail--> 
    
    <?php echo form_close();?> 

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
/*$(document).ready(function(){
  $('button').css('display','none');
  if(cy!='USA' && cy!='')
    $(".ui-autocomplete-input.ui-widget.ui-widget-content.ui-corner-left").css('display','none');
});*/
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