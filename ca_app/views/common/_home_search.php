<?php if($this->session->userdata('is_user_login')!=TRUE): ?>


  <div class="candidatesection">
  
  <h1><?=lang('One million success stories')?>. <span><?=lang('Start yours today')?>.</span></h1>
  
  <?php echo form_open_multipart('job_search/search',array('name' => 'jsearch', 'id' => 'jsearch'));?>
       <div class="col-md-5 col-xs-5">
      <select class="form-control" name="jcity" id="jcity" style="height: 52px;">
      	
        <option value="" selected><?=lang('Select City')?></option>
        <?php if($cities_res): foreach($cities_res as $cities):?>
        	<option value="<?php echo $cities->city_name;?>"><?php echo $cities->city_name;?></option>
        <?php endforeach; endif;?>
       </select>
        
       </div>
        <div class="col-md-7 col-xs-7" style="margin-left: -3px;">
        
             <div class="input-group">
             
              <input type="text" required name="job_params" id="job_params" class="form-control" placeholder="<?=lang('Job title or Skill')?>" />
                  <span class="input-group-addon basic-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
             </div>
        
        </div>
   <input type="submit"  id="input_search"/>   
   
<?php echo form_close();?> 
    <div class="clear"></div>
  </div>




<br/>
  <div class="employersection">   
      <h3><?=lang('Get Started Now')?></h3>
      <a href="<?php echo base_url('employer/post_new_job');?>" class="postjobbtn" title="<?=lang('USA jobs')?>"><?=lang('Post a Job')?></a>
      <a title="<?=lang('job search engine USA')?>" class="postjobbtn" style="background:#505C73;" alt="<?=lang('job search engine USA')?>" href="<?php echo base_url('login');?>" ><?=lang('Upload Resume')?></a>
      <div class="clear"></div>
    </div>


<?php else: 

if($this->session->userdata('is_employer')==TRUE): ?>
<div class="col-md-12">
  <div class="employersection">
    <div class="col-md-6 col-md-offset-3">
      <h1><?=lang('Search Resume')?></h1>
      <?php echo form_open_multipart('resume_search/search',array('name' => 'rsearch', 'id' => 'rsearch'));?>
      <div class="input-group">
        <input type="text" name="resume_params" class="form-control" id="resume_params" placeholder="<?=lang('Search Resume with Skill or Job Title')?>" />
        <span class="input-group-btn">
        <input type="submit" name="resume_submit" class="btn" id="resume_submit" value="<?=lang('Search')?>" />
        </span> </div>
      <?php echo form_close();?> </div>
    <div class="col-md-12">
      <h1></h1>
      <a href="<?php echo base_url('employer/post_new_job');?>" class="postjobbtn" title="<?=lang('USA jobs')?>"><?=lang('Post a Job')?></a>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<?php else: ?>
<div class="col-md-12">
  <div class="candidatesection">
    <div class="row">
    
    <div class="col-md-8 col-md-offset-2">
      <h1><?=lang('Search a job')?></h1>
      <?php echo form_open_multipart('job_search/search',array('name' => 'jsearch', 'id' => 'jsearch'));?>
      <div class="input-group">
        <input type="text" name="job_params" id="job_params" class="form-control" placeholder="<?=lang('Job title or Skill')?>" />
        <span class="input-group-btn">
        <input type="submit" name="job_submit" id="job_submit" class="btn" value="<?=lang('Find')?>"  />
        </span> </div>
      <?php echo form_close();?> </div>
      
     <div class="col-md-12">
       <div class="employersection">
      <h3><?=lang('Upload your resume')?></h3>
      <input type="submit" value="<?=lang('Upload Resume')?>" title="<?=lang('job search engine USA')?>" class="postjobbtn" alt="<?=lang('job search engine USA')?>" onClick="document.location='<?php echo base_url('login');?>'" />
      </div>
      <div class="clear"></div>
    </div> 
    </div>
    <div class="clear"></div>
  </div>
</div>
<?php endif;?>
<?php endif;?>
