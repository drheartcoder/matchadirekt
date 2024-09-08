<!DOCTYPE html>
<?php
$src=base_url()."public/uploads/employer/companies/BIXMA_JOB_".$row_posted_job->ID.".png";
$pp = str_replace(chr(13),'<br />',$row_posted_job->job_description);
$job_title = word_limiter(strip_tags(str_replace('-',' ',$row_posted_job->job_title)),7);
$company_loc = urlencode($row_posted_job->company_location.', '.$row_posted_job->emp_city.', '.$row_posted_job->emp_country.', ('.$row_posted_job->company_name.')'); ?>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<meta property="og:description" content="<?php 
			  	$pp = str_replace(chr(13),'<br />',$row_posted_job->job_description);
				echo strip_tags($pp,'<br>');
			  ?>" />
<!--<meta property="og:url"                content="" />-->
<!--<meta property="og:type"               content="article" />-->
<meta property="og:title"              content="<?=$job_title?>" />
<meta property="og:description"        content="<?=$pp?>" />
<meta property="og:image"              content="<?=$src?>" />
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
<?php $len=0;
if($_SERVER['HTTP_REFERER']!=''){
	$len = 1;	
}
?>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=sda&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); 
$s = ($currently_opened_jobs>1)?'s':'';
?>
<!--/Header--> 
<!--Detail Info-->
<div class="container detailinfo">
  <div class="row">
    <div class="col-md-12">
      <?php if($is_already_applied=='yes' && !$this->session->userdata('message_applied_job')):?>
      <div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong><?=lang('Heads up')?>!</strong> <?=lang('You have already applied for this job')?>.</div>
      <?php endif;?>
      <div id="msg"><?php if($this->session->userdata('message_applied_job')){ 
        $this->session->unset_userdata('message_applied_job');
        ?><div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong><?=lang('Success')?>!</strong> <?=lang('You have successfully applied for this job')?>. </div><?php } ?></div>

        <?php
        $end=0;
        if(date($row_posted_job->last_date)<date('Y-m-d'))
        {
          $end=1;
          ?><div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong><?=lang('NOTE : This job offer is no longer available')?> !</div><?php
        }
        ?>
      <div class="row"> 
        
        <!--Company Info-->
        
      <img src="<?=$src?>" style="display: none;" />
        <div class="col-md-4">
          <div class="companyinfoWrp">
            <h1 class="jobname"><?php echo humanize($job_title);?></h1>
            <div class="jobthumb"><img src="<?php echo base_url('public/uploads/employer/'.$company_logo);?>" alt="<?php echo base_url('company/'.$row_posted_job->company_slug);?>" /></div>
            <div class="jobloc"> <a href="<?php echo base_url('company/'.$row_posted_job->company_slug);?>" class="companyname" title="<?php echo $row_posted_job->company_name;?>"><?php echo $row_posted_job->company_name;?></a>
              <div class="location"><?php echo $row_posted_job->emp_city;?> &nbsp;-&nbsp; <?php echo $row_posted_job->emp_country;?></div>
              <a href="<?php echo base_url('company/'.$row_posted_job->company_slug);?>" class="currentopen" title="<?php echo $currently_opened_jobs.' Job'.$s.' in '.$row_posted_job->company_name;?>"><?php echo $currently_opened_jobs;?> Current Job<?php echo $s;?> Openings</a> </div>
            <div class="clear"></div>
          </div>
          
          <!--Apply-->
          <br/>
          <div class="sharethis-inline-share-buttons"></div>

          <?php
          if($end==0)
          {
          ?>
          <div class="actionBox">
            <h4><?php echo ($is_already_applied=='yes')?lang('You have already applied for this job'):lang('To Apply for this job click below');?></h4>
            <p></p>
            <a href="javascript:;" class="<?php echo ($is_already_applied=='yes')?'applyjobgray':'applyjob';?>"><span>Apply Now</span></a> <!--<a href="#" class="refferbtn"><span>Email to Friend</span></a>--> </div>
          <?php
          }
          ?>
          <div class="mapbox">
            <iframe src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $company_loc;?>&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo $company_loc;?>&amp;t=m&amp;z=14&amp;iwloc=near&amp;output=embed" width="100%" height="250" frameborder="0" style="border:0"></iframe>
          </div>
          <div style="text-align:center;"><?php echo $row_posted_job->company_location.', '.$row_posted_job->emp_country;?></div>
        </div>
        <div class="col-md-8"> 
          
          <!--Job Detail-->
          
          <div class="boxwraper">
            <div class="formwraper">
              <div class="titlehead">
                <div class="row">
                <div class="col-sm-6"><?=lang('Job Detail')?></div>
                <?php if($len){?>
                <div class="col-sm-6 text-right"><a href="javascript:;" onClick="window.history.back(-1);"><?=lang('Back to Search')?></a></div>
                <?php }?>
              </div>
              </div>
            </div>
            
            <!--Job Detail-->
            
            <div class="row"> 
              
              <!--Requirements-->
              
              <div class="col-md-12">
                <ul class="reqlist">
                  <li>
                    <div class="col-sm-6"><?=lang('Industry')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->industry_name;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Total Positions')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->vacancies;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Job Type')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->job_mode;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Salary')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->pay;?> </div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Job Location')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->city.', '.$row_posted_job->country;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Minimum Education')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->qualification;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Minimum Experience')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->experience;?> <?php echo ($row_posted_job->experience<2)?'Year':'Years';?></div>
                    <div class="clear"></div>
                  </li>
                  <?php if($row_posted_job->age_required):?>
                  <li>
                    <div class="col-sm-6"><?=lang('Age Required')?>:</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->age_required;?> Years</div>
                    <div class="clear"></div>
                  </li>
                  <?php endif;?>
                  <li>
                    <div class="col-sm-6"><?=lang('Apply By')?>:</div>
                    <div class="col-sm-6"><?php echo date_formats($row_posted_job->last_date, 'M d, Y');?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Job Posting Date')?>:</div>
                    <div class="col-sm-6"><?php echo date_formats($row_posted_job->dated, 'M d, Y');?></div>
                    <div class="clear"></div>
                  </li>
                </ul>
              </div>
              
              <div class="clear"></div>
            </div>
            
            <!--Job Description-->
            
            <div class="jobdescription">
              <div class="row">
                <div class="col-md-12">
                  <div class="subtitlebar"><?=lang('Job Description')?></div>
                  <p>
                  <h2 class="normal-details">
                    <?php
				echo strip_tags($pp,'<br>');
			  ?>
                  </h2>
                  </p>
                </div>
                <?php if($required_skills && $required_skills[0]!=''):?>
                <div class="col-md-12">
                  <div class="subtitlebar"><?=lang('Skills Required')?></div>
                  <div class="skillBox">
                    <ul class="skillDetail">
                      <?php foreach($required_skills as $skill):?>
                      <li><a href="<?php echo base_url();?>search-jobs/<?php echo make_slug($skill);?>" target="_blank"><?php echo $skill;?></a></li>
                      </li>
                      <?php endforeach;?>
                      <div class="clear"></div>
                    </ul>
                  </div>
                </div>
                <?php endif;?>
              </div>
              <?php
              if($end==0)
              {
              ?>
              <div class="actionBox footeraction">
                <h4><?php echo ($is_already_applied=='yes')?lang('You have already applied for this job'):lang('To Apply for this job click below');?></h4>
                <a href="javascript:;" class="<?php echo ($is_already_applied=='yes')?'applyjobgray':'applyjob';?>"><span><?=lang('Apply Now')?></span></a> </div>
                <?php
                }
                ?>
              <div class="clear">&nbsp;</div>
              <div class="footeraction">
                <p><strong><?=lang('Note')?>:</strong> <?=lang('By reporting this employer')?>...</p>
                <h4 style="text-align:center;"><a href="javascript:;" id="scammer" class="btn btn-danger"><span><?=lang('Report this Employer')?></span></a></h4>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    
    <!--/Job Detail-->
    
    <?php $this->load->view('common/right_ads');?>
  </div>
</div>
<div class="modal fade" id="japply">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Apply For This Job')?></h4>
      </div>
      <form enctype="multipart/form-data" method="post" action="<?=base_url().'jobseeker/apply_job?yep=1'?>" id="formid">
      <div class="modal-body">
        <div id="emsg"></div>
        <div class="box-body">
          <div class="form-group">
            <label><?=lang('Monthly Expected Salary')?>:</label>
            <select name="expected_salary" id="expected_salary" class="form-control">
              <?php
					foreach($result_salaries as $row_salaries):
						$selected = (set_value('expected_salary')==$row_salaries->val)?'selected="selected"':'';
				?>
              <option value="<?php echo $row_salaries->val;?>" <?php echo $selected;?>><?php echo $row_salaries->val;?></option>
              <?php endforeach;?>
            </select>
            <?php echo form_error('expected_salary'); ?> </div>
          <div class="form-group">
            <label><?=lang('Cover Letter')?></label>
            <textarea id="cover_letter" name="cover_letter"  class="form-control" placeholder=""><?php echo set_value('cover_letter');?></textarea>
            <?php echo form_error('cover_letter'); ?> 

            <br/>
            <label>Attach File &nbsp;* <small>Only <b><?=lang('Documents')?>, <?=lang('Images')?></b> <?=lang('Type are Allowed')?></small></label>
            <input type="File" multiple="true" name="attached_file[]" id="attached_file" class="form-control"/>
            <?php echo form_error('attached_file'); ?> 

            <?php 
            if($row_posted_job->quizz_text!=""):
            ?>

              <br/>
              <label><?=lang('Please read and pick an answer bellow')?></label>
              <textarea id="quizz_text" disabled="disabled" rows="4" name="quizz_text"  class="form-control" placeholder=""><?php echo $row_posted_job->quizz_text;?></textarea>
              <br/>
              <b><center>
              <input type="radio" name="answer" id="answer" value="<?php echo $row_posted_job->answer_1;?>" checked="checked" /> &nbsp;<label><?php echo $row_posted_job->answer_1;?> &nbsp;</label>
              <input type="radio" name="answer" id="answer" value="<?php echo $row_posted_job->answer_2;?>" /> &nbsp;<label><?php echo $row_posted_job->answer_2;?> &nbsp;</label>
              <input type="radio" name="answer" id="answer" value="<?php echo $row_posted_job->answer_3;?>" /> &nbsp;<label><?php echo $row_posted_job->answer_3;?> &nbsp;</label>
              </center></b>
              <?php echo form_error('answer');?>

            <?php
            endif;            
            ?>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="jid" name="jid" value="<?php echo $row_posted_job->ID;?>"/>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
        <button type="button" name="submitter" id="submitter" class="btn btn-primary"><?=lang('Apply')?></button>
      </div>
    </form>
    </div>
  </div>
</div>



<div class="modal fade" id="japply_before">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Apply For This Job')?></h4>
      </div>
      <div class="modal-body">
          <input style="width: 25px;margin-top: 10px;" id="check_agree" class="form-control" type="checkbox">
          <label style="margin-top: -30px;margin-left: 30px;"><?php echo file_get_contents(base_url().'qcsh/privacy-notice.html');?></label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="$('#japply_before').modal('hide');$('#japply').modal('show');"><?=lang('Go Back')?></button>
        <button type="button" name="submitter_af" id="submitter_af" onclick="$('#japply_before').modal('hide');$('#japply').modal('show');apply_job(0);" class="btn btn-success"><?=lang('Submit')?></button>
      </div>
    </div>
  </div>
</div>


<!--Scam-->
<div class="modal fade" id="scam">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Report this Employer')?></h4>
      </div>
      <div class="modal-body">
        <div id="scam_emsg"></div>
        <div class="box-body">
          <div class="form-group">
            <label><?=lang('Company Name')?>: <span style="font-weight:normal;"><?php echo $row_posted_job->company_name;?></span></label>
          </div>
          <div class="form-group">
            <label><?=lang('Job')?>: <span style="font-weight:normal;"><?php echo $row_posted_job->job_title;?></span></label>
          </div>
          <div class="form-group">
            <label><?=lang('Reason')?></label>
            <textarea id="reason" name="reason"  class="form-control" placeholder=""><?php echo set_value('reason');?></textarea>
            <?php echo form_error('reason'); ?> </div>
          <div class="form-group">
            <label class="input-group-addon"><?=lang('Please enter')?>: <span id="ccode"><?php echo $cpt_code;?></span> <?=lang('in the text box below')?>:</label>
            <input type="text" class="form-control" name="captcha" id="captcha" value="" maxlength="10" autocomplete="off"/>
            <?php echo form_error('captcha'); ?> </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="scjid" name="scjid" value="<?php echo $row_posted_job->ID;?>"/>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
        <button type="button" name="scam_submit" id="scam_submit" class="btn btn-primary"><?=lang('Report this Employer')?></button>
      </div>
    </div>
  </div>
</div>
<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5a6ba621344b890012fe78af&product=inline-share-buttons' async='async'></script>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<?php if($this->session->userdata('is_job_seeker')==TRUE):?>
<script type="text/javascript">
$( document ).ready(function() {
	var apply = '<?php echo $is_apply;?>';
	var is_already_applied = '<?php echo $is_already_applied;?>';
	if(apply=='yes' && is_already_applied=='no'){
		$('#japply').modal('show');
	}
	/*else{
		bootbox.alert("You have already applied for this job!");	
	}*/
	$(".applyjob").click(function(){
		if(is_already_applied=='yes')
			bootbox.alert("You have already applied for this job!");
		else
			$('#japply').modal('show');
	});	
	
	$("#scammer").click(function(){
		$('#scam').modal('show');
	});
	
	<?php 
	if(@$_GET['sc']=='yes'){?>
		$('#scam').modal('show');
	<?php } ?>
	
});
$( document ).ready(function() {
    $("#submitter_af").attr("disabled", "disabled");
    $('#check_agree').change(function() {
          if(this.checked) {
              $("#submitter_af").removeAttr("disabled");
          }
          else
          {
            $("#submitter_af").attr("disabled", "disabled");
          }     
      });              
  });
</script>
<?php else: ?>
<script type="text/javascript">
$(".applyjob").click(function(){
	<?php if($this->session->userdata('is_job_seeker')!=TRUE && $this->session->userdata('is_user_login')==TRUE):?>
	$('#msg').html('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong>Error!</strong> You are not logged in with a jobseeker account. Please re-login with a jobseeker account to apply for this job. </div>');
		return false;
	<?php endif; ?>
		document.location = "<?php echo base_url('/jobs/'.$row_posted_job->job_slug.'?apply=yes');?>";
	});	
$("#scammer").click(function(){
	document.location = "<?php echo base_url('/jobs/'.$row_posted_job->job_slug.'?sc=yes');?>";
});		
</script>
<?php endif;?>
</body>
</html>