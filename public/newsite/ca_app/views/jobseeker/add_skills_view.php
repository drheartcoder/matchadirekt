<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
<link rel="stylesheet" href="http://jquery-ui.googlecode.com/svn/tags/1.8.7/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="<?php echo base_url('public/autocomplete/demo.css'); ?>">
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); 
$style = ($count_skills>2)?'wrap_enable':'wrap_disable';
?>
<!--/Header-->
<div class="container detailinfo">
  <div class="row">
  	
   <div class="col-md-3"> <div class="dashiconwrp">
        <div class=" <?php echo $style;?> "><?php $this->load->view('jobseeker/common/jobseeker_menu');?></div>
      </div></div>
  
    <div class="col-md-9"> <?php echo $this->session->flashdata('msg');?>
      
      
      <!--Personal info-->
      <div class="formwraper">
        <div class="titlehead"><?=lang('Add Skills')?></div>
        <div class="formint">
          <p class="normal-details" style="font-size:13px;"><?=lang('Please enter your skills keywords below. Please know that your resume will be searched based on these skills. If you do not enter all skills, your resume will not be included in our search for your desired jobs.')?><br>
            <br />
            <strong><?=lang('Example')?>: </strong><br>
          <?=lang('PHP developer may put following keywords:  PHP developer, PHP coder, PHP programmer, website developer, Word Press, Java Script, JS, Ajax etc.')?>
          <br>
          <?=lang('Accountant may enter following:   Accountant, cost accountant, ACCA, Chartered Accountant')?> </p>
          <div class="jobdescription" style="border-top:0px;">
            <div class="row">
              <div class="col-md-12">
              <div id="emsg"></div>
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
          <div class="input-group">
            <label class="input-group-addon"><?=lang('Add Skill')?><span>*</span></label>
            <div class="row">
              <div class="col-md-8">
                <input type="text" name="skill" id="skill" value="" autocomplete="off" class="form-control" autofocus />
                <input type="hidden" name="s_val" id="s_val" value="<?php echo (set_value('s_val'))?set_value('s_val'):''; ?>" class="form-control" />
              </div>
              <div class="col-md-2">
                <input type="submit" name="js_skill_submit" id="js_skill_submit" value="<?=lang('Add')?>" class="btn btn-success" />
              </div>
              <div class="<?php echo $style;?>">
              <div class="col-md-2">
                <input type="button" onClick="document.location='<?php echo base_url('jobseeker/cv_manager/?a=d');?>'" name="finish" id="finish" value="<?=lang('Finish')?>" class="btn btn-primary" />
              </div>
              </div>
            </div>
            
            <small><?=lang('Single skill at a time. Atleat 3 skills are required.')?> </small>
            
          </div>
          <div class="clear">&nbsp;</div>
          <div class="clear">&nbsp;</div>
          <div class="clear">&nbsp;</div>
        </div>
      </div>
    </div>
    <!--/Job Detail-->
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<script src="<?php echo base_url('public/js/jquery-ui.js'); ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/validate_jobseeker.js');?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    var availableSkills = <?php echo $available_skills;?>;
    $( "#skill" ).autocomplete({source: availableSkills});
  });
</script>
</body>
</html>
