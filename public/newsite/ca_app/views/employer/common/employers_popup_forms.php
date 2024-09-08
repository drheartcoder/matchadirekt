<!-- Starts Edit Company Profile -->
<div class="modal fade" id="edit_profile_modal">
  <div class="modal-dialog">
    <form name="frm_cms" id="frm_cms" role="form" method="post" action="<?php echo base_url('');?>">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?=lang('Update Company Profile')?></h4>
        </div>
        <div class="modal-body"> 
          <div class="box-body">
          
            <div class="form-group">
              <label><?=lang('Company Name')?></label>
              <input type="text" class="form-control"  id="company_name" name="company_name" value="<?php echo set_value('company_name');?>" placeholder="<?=lang('Company Name')?>">
              <?php echo form_error('company_name'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Company Email')?></label>
              <input type="text" class="form-control" name="company_email" id="company_email" value="<?php echo set_value('company_email');?>" placeholder="<?=lang('Company Email')?>">
              <?php echo form_error('company_email'); ?>
            </div>
            
            <div class="form-group">
              <label><?=lang('CEO Name')?></label>
              <input type="text" class="form-control"  id="company_ceo" name="company_ceo" value="<?php echo set_value('company_ceo');?>" placeholder="<?=lang('CEO Name')?>">
              <?php echo form_error('company_ceo'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Company Website')?></label>
              <input type="text" class="form-control"  id="company_website" name="company_website" value="<?php echo set_value('company_website');?>" placeholder="<?=lang('Company Website')?>">
              <?php echo form_error('company_website'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Industry')?></label>
              <input type="text" class="form-control"  id="industry_id" name="industry_id" value="<?php echo set_value('industry_id');?>" placeholder="<?=lang('Industry')?>">
              <?php echo form_error('industry_id'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Established In')?></label>
              <input type="text" class="form-control"  id="established_in" name="established_in" value="<?php echo set_value('established_in');?>" placeholder="<?=lang('Established In')?>">
              <?php echo form_error('established_in'); ?> 
           	</div>
  
            <div class="form-group">
              <label><?=lang('Mobile Number')?></label>
              <input type="text" class="form-control"  id="company_phone" name="company_phone" value="<?php echo set_value('company_phone');?>" placeholder="<?=lang('Mobile Number')?>">
              <?php echo form_error('company_phone'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('No. Of Offices')?></label>
              <input type="text" class="form-control"  id="no_of_offices" name="no_of_offices" value="<?php echo set_value('no_of_offices');?>" placeholder="<?=lang('No. Of Offices')?>">
              <?php echo form_error('no_of_offices'); ?> 
           	</div>
  
            <div class="form-group">
              <label><?=lang('No. Of Employees')?></label>
              <input type="text" class="form-control"  id="no_of_employees" name="no_of_employees" value="<?php echo set_value('no_of_employees');?>" placeholder="<?=lang('No. Of Employees')?>">
              <?php echo form_error('no_of_employees'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Company Address')?></label>
              <input type="text" class="form-control"  id="company_location" name="company_location" value="<?php echo set_value('company_location');?>" placeholder="<?=lang('Company Address')?>">
              <?php echo form_error('company_location'); ?> 
           	</div>
              
            <div class="form-group">
              <label><?=lang('Company Logo')?></label>
              <input type="file" id="company_logo" name="company_logo" class="form-control">
              <?php echo form_error('company_logo'); ?> 
           	</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
          <button type="submit" name="submitter" class="btn btn-primary"><?=lang('Update')?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Ends Edit Company Profile -->
<!-- Starts Edit Company Profile Description-->
<div class="modal fade" id="edit_profile_description_modal">
  <div class="modal-dialog">
    <form name="frm_employer_desc" id="frm_employer_desc" role="form" method="post" action="">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?=lang('Update Company Info')?></h4>
        </div>
        <div class="modal-body"> 
          <div class="box-body">
              
            <div class="form-group">
              <label><?=lang('About Company')?></label>
              <textarea id="content" name="content"  class="form-control" rows="10" placeholder=""><?php echo $row->company_description;?></textarea>
              <?php echo form_error('editor1'); ?> </div>
          </div>     
        </div>
        <div class="modal-footer">
          <input type="hidden" name="cid" id="cid" value="<?php echo $row->company_ID;?>" />
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
          <button type="button" name="summary_submit" id="summary_submit" class="btn btn-primary"><?=lang('Update')?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Ends Edit Company Profile Description-->
<!-- Starts Edit Posted Job-->
<div class="modal fade" id="edit_posted_job">
  <div class="modal-dialog">
    <form name="frm_cms" id="frm_cms" role="form" method="post" action="<?php echo base_url('');?>">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?=lang('Edit Posted Job')?></h4>
        </div>
        <div class="modal-body"> 
          <div class="box-body">
          
            <div class="form-group">
              <label><?=lang('Company Name')?></label>
              <input type="text" class="form-control"  id="company_name" name="company_name" value="<?php echo set_value('company_name');?>" placeholder="<?=lang('Company Name')?>">
              <?php echo form_error('company_name'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Company Email')?></label>
              <input type="text" class="form-control" name="company_email" id="company_email" value="<?php echo set_value('company_email');?>" placeholder="<?=lang('Company Email')?>">
              <?php echo form_error('company_email'); ?>
            </div>
            
            <div class="form-group">
              <label><?=lang('CEO Name')?></label>
              <input type="text" class="form-control"  id="company_ceo" name="company_ceo" value="<?php echo set_value('company_ceo');?>" placeholder="<?=lang('CEO Name')?>">
              <?php echo form_error('company_ceo'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Company Website')?></label>
              <input type="text" class="form-control"  id="company_website" name="company_website" value="<?php echo set_value('company_website');?>" placeholder="<?=lang('Company Website')?>">
              <?php echo form_error('company_website'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Industry')?></label>
              <input type="text" class="form-control"  id="industry_id" name="industry_id" value="<?php echo set_value('industry_id');?>" placeholder="<?=lang('Industry')?>">
              <?php echo form_error('industry_id'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Established In')?></label>
              <input type="text" class="form-control"  id="established_in" name="established_in" value="<?php echo set_value('established_in');?>" placeholder="<?=lang('Established In')?>">
              <?php echo form_error('established_in'); ?> 
           	</div>
  
            <div class="form-group">
              <label><?=lang('Mobile Number')?></label>
              <input type="text" class="form-control"  id="company_phone" name="company_phone" value="<?php echo set_value('company_phone');?>" placeholder="<?=lang('Mobile Number')?>">
              <?php echo form_error('company_phone'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('No. Of Offices')?></label>
              <input type="text" class="form-control"  id="no_of_offices" name="no_of_offices" value="<?php echo set_value('no_of_offices');?>" placeholder="<?=lang('No. Of Offices')?>">
              <?php echo form_error('no_of_offices'); ?> 
           	</div>
  
            <div class="form-group">
              <label><?=lang('No. Of Employees')?></label>
              <input type="text" class="form-control"  id="no_of_employees" name="no_of_employees" value="<?php echo set_value('no_of_employees');?>" placeholder="<?=lang('No. Of Employees')?>">
              <?php echo form_error('no_of_employees'); ?> 
           	</div>
            
            <div class="form-group">
              <label><?=lang('Company Address')?></label>
              <input type="text" class="form-control"  id="company_location" name="company_location" value="<?php echo set_value('company_location');?>" placeholder="<?=lang('Company Address')?>">
              <?php echo form_error('company_location'); ?> 
           	</div>
              
            <div class="form-group">
              <label><?=lang('Company Logo')?></label>
              <input type="file" id="company_logo" name="company_logo" class="form-control">
              <?php echo form_error('company_logo'); ?> 
           	</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
          <button type="submit" name="submitter" class="btn btn-primary"><?=lang('Update')?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Ends <?=lang('Edit Posted Job')?> -->