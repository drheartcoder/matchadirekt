<?php $this->load->view('application_views/common/header'); ?>
     
          <div class="jobdescription" style="border-top:0px;">
            <div class="row">
              <div class="col-md-12">
                  <center><div style="font-size: 16px;" id="emsg"></div></center>
                <div class="subtitlebar"><?=lang('Your Skills')?></div>
                <div class="skillBox">
                  <ul class="skillDetail" id="myskills">
                    <?php 
				  	if($result):
				  		foreach($result as $skill_row):
						if(trim($skill_row->skill_name)!=''): ?>
                    <li><?php echo trim($skill_row->skill_name);?> <a href="javascript:remove_skill('<?php echo trim($skill_row->ID);?>');" class="delete"><i class="fa fa-times-circle"></i></a></li>
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
            
            <span style="" class="input_label"><?=lang('Add Skill')?> <b>*</b></span>
          <div class="ara_row">
            
                <input type="text" name="skill" id="skill" value="" autocomplete="off" class="form-control app_input" autofocus />
                <input type="hidden" name="s_val" id="s_val" value="<?php echo (set_value('s_val'))?set_value('s_val'):''; ?>" class="form-control app_input" />
                
             <div style="text-align:center;">
                <input type="submit" name="js_skill_submit" id="js_skill_submit" value="<?=lang('Add')?>" class="btn btn-success" style="margin-top:10px;"/>
              </div>
          </div>
<div style="margin-top:45px;text-align:center;">
            <small ><?=lang('Single skill at a time. Atleat 3     skills are required.')?> </small>
            </div>
          <div class="clear">&nbsp;</div>
          <div class="clear">&nbsp;</div>
          <div class="clear">&nbsp;</div>
 
     
<?php $this->load->view('application_views/common/footer_app'); ?>