<!DOCTYPE html>
<?php
$emp=0;
$row_job=$this->db->query("SELECT * FROM tbl_post_jobs WHERE ID='".$row_posted_job->ID."'")->result()['0'];
if((  ($row_posted_job->sts=='inactive' && $row_job->job_type!='Internal') || $row_posted_job->sts=='archive') && $this->session->userdata('user_id')!=$row_posted_job->CID)
  redirect(base_url());
if($this->session->userdata('user_id')==$row_posted_job->CID && $this->session->userdata('is_employer')==TRUE)
  $emp=1;
$src=base_url()."public/uploads/employer/companies/BIXMA_JOB_".$row_posted_job->ID.".png";
$pp = $row_posted_job->job_description;
$job_title = word_limiter(strip_tags(str_replace('-',' ',$row_posted_job->job_title)),7);
$company_loc = urlencode($row_posted_job->company_location.', '.$row_posted_job->emp_city.', '.$row_posted_job->emp_country.', ('.$row_posted_job->company_name.')'); ?>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?><!-- 
<meta property="og:description" content="<?php 
          $pp = str_replace(chr(13),'<br />',$row_posted_job->job_description);
        echo strip_tags($pp,'<br>');
        ?>" /> -->
<!--<meta property="og:url"                content="" />-->
<!--<meta property="og:type"               content="article" />-->
<meta property="og:title"              content="<?=$job_title?>" />
<!-- <meta property="og:description"        content="<?=$pp?>" /> -->
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


<?php
if($row_job->job_type=='Internal')
{
$tst=1;
    if(!$_GET["local_mdp"])
    {
      form_get:
?>
<div class="container detailinfo">
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">
<div class="row">
<div class="boxwraper">
    <div class="formwraper">
      <div class="titlehead">
        <div class="row">

        <div class="col-sm-12"><?=lang('Please enter the password to access to this job')?></div>
                      </div>
      </div>
    </div>
    <?php
    if($tst==0)
    {
      ?>
          <center><label style="color:red;font-size: 18px;">Invalid Password !</label></center><hr/>
      <?php
      $tst=1;
    }
    ?>
      <form method="GET" action="" style="margin: 20px;">
        <div class="form-group">
          <label>Access Password</label>
          <input class="form-control" name="local_mdp" />
        </div>
        <input style="width: 100px;" type="submit" class="form-control"/>
      </form>
      </div></div></div></div></div>
      <?php
      goto end_sc;
    }
    else
    {
      if($_GET["local_mdp"]!=$row_job->local_mdp)
       {
        $tst=0;
          goto form_get;
       }  
    }
}
?>

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
        <?php
        if($row_posted_job->sts=='inactive' && $row_job->job_type!='Internal')
        {
          $ull=base_url().'employer/edit_posted_job/status/'.$row_posted_job->ID;
          ?><div id="mehhhh" style="font-size: 20px;background: lightgoldenrodyellow;" class="alert alert-warning"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong><?=lang('NOTE : This job is not yet published')?> !
            <br/>
            <small style="font-size: 14px;"> <a href="<?=base_url().'employer/edit_posted_job/'.$row_posted_job->ID?>"><?=lang('Edit it Now')?></a> <?=lang('or')?> <a style="cursor:pointer" onClick="update_posted_job_status_employer(<?php echo $row_posted_job->ID;?>);$('#mehhhh').hide();"><?=lang('Make It Public')?></a></small>
            </div><?php

        }
        if($row_posted_job->sts=='archive')
        {
          ?><div style="font-size: 20px;background: #8d989c;" class="alert alert-primary"> <a href="#" class="close" data-dismiss="alert">×</a> <strong>NOTE : This job is in your archive, is not published anymore !
            </strong></div><?php

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
              <a href="<?php echo base_url('company/'.$row_posted_job->company_slug);?>" class="currentopen" title="<?php echo $currently_opened_jobs.' Job'.$s.' in '.$row_posted_job->company_name;?>"><?php echo $currently_opened_jobs;?> <?=lang('Current Jobs Openings')?></a> </div>
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
            <a href="javascript:;" class="<?php echo ($is_already_applied=='yes')?'applyjobgray':'applyjob';?>"><span><?=lang('Apply Now')?></span></a> <!--<a href="#" class="refferbtn"><span>Email to Friend</span></a>--> </div>
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
                    <div class="col-sm-6"><?=lang('Ref.')?> :</div>
                    <div class="col-sm-6"><a href="#" onclick="window.location.reload();">#JB<?=str_repeat("0",5-strlen($row_posted_job->ID)).$row_posted_job->ID?></a></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Diarienummer')?> :</div>
                    <div class="col-sm-6"><?php echo $row_posted_job->diarie;?></div>
                    <div class="clear"></div>
                  </li>
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
            <?php
            if($emp)
            {
              $job_analysis=$this->db->query("SELECT * FROM tbl_job_analysis WHERE ID='".$row_job->job_analysis_id."' AND  deleted='0'")->result();
              if(!$job_analysis) goto endddd23;
              $job_analysis=$job_analysis['0'];
              ?>
            <li>
              <center><h4><a href="#" onclick="$('#ifrm_').modal('show')"><label style="margin: 10px;cursor: pointer;"><i class="fa fa-signal"></i> &nbsp;<?=lang('Job Analysis').' : '.$job_analysis->pageTitle?></label></a></h4></center>
            </li>
      <div class="modal fade" id="ifrm_">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="title_link"><?=$job_analysis->pageTitle?></h4>
          </div>
          <div class="modal-body">
              <iframe src="<?=base_url().'/ja/'.$job_analysis->pageSlug?>" style="height: 500px;" class="form-control">
             </iframe> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" class="close" data-dismiss="modal"><?=lang('Close')?></button>
          </div>
        </div>
      </div>
    </div>
            <?php
            endddd23:
            }
            ?>
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
                    <?php echo "<html><body>".$pp."</body></html>";?>
                  </h2>
                  </p>
                </div><br/>
                      <div class="col-md-12">
                        <div class="subtitlebar"><?=lang('Attachment Files')?></div>
              <!--Job Description-->
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
                    <div class="col-md-8">
                    <i class="fa fa-file-<?php echo $icon_name;?>-o">&nbsp;</i>
                      <a target="_blank" href="<?php echo base_url('file/show/'.$row_file->file_name);?>">File N:<?=$i?><br/>
                        <small style="font-size: 12px;"><?=$row_file->file_name?></small></a>
                    </div>
                    <div class="col-md-4"><?php echo date_formats($row_file->created_at, "d M, Y");?></div>
                  </li>
                  <?php   endforeach; 
                else:?>
                  <?=lang('No file uploaded yet')?>!
                  <?php endif;?>
                </ul>
                  </div>
              </div>
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

          <?php if(count($applications)>0) : ?>   
          <div class="boxwraper">

            <div class="formwraper">
            <div class="titlehead">
              <div class="row">
                  <div class="col-sm-6"><?= lang('Applications') ?></div>
               </div>
             </div>
             <div class="row">

              <div class="col-md-12">
                      <ul class="myjobList">
                    <li class="row">
                      <div class="col-md-2"><strong><?=lang('Ref.')?></strong></div>
                      <div class="col-md-6"><strong><?=lang('Candidate Name')?></strong></div>
                      <div class="col-md-4"><strong><?=lang('Applied Date')?></strong></div>
                    </li>

                  <?php foreach($applications as $app): ?>

                    <li class="row">
                        <?php 
                          $link=base_url('candidate/'.$this->custom_encryption->encrypt_data($app->seeker_ID));
                         ?>
                        <div class="col-md-2"><small><a href="<?= $link?>" style="font-size: 13px; color: #6b6b6b;">#JS<?=str_repeat("0",5-strlen($app->seeker_ID)).$app->seeker_ID?></a></small></div>
                        <div class="col-md-6"><a href="<?= $link?>" ><?php echo $app->first_name.' '.$app->last_name;?></a></div>
                        <div class="col-md-4"><?php echo date_formats($app->applied_date, 'M d, Y');?></div>

                    </li>
                <?php endforeach ?>
                </ul>
              </div>
              </div>

             </div>     
          </div>

          </div>  
          
        <?php endif;?> 



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
      <?php
      $skills_list=$this->db->query("SELECT tbl_seeker_skills.skill_name from tbl_seeker_skills WHERE tbl_seeker_skills.seeker_ID='".$this->session->userdata('user_id')."' AND INSTR('".$row_job->required_skills."',tbl_seeker_skills.skill_name)>0")->result(); 
      if(!$skills_list)
      {
          ?>
          <div class="modal-body">
          <h4 style="color: red;text-align: center;">
            <?=lang("You haven't any matching skills to apply this job !")?>
          </h4>
          </div>
          <?php
      }
      else
      {
        ?>
        <form enctype="multipart/form-data" method="post" action="<?=base_url().'jobseeker/apply_job?yep=1'?>" id="formid">
        <div class="modal-body">
          <div id="emsg"></div>
          <div class="box-body">
        <?php
          $myjobs=$this->db->query("SELECT tbl_post_jobs.job_title,tbl_seeker_applied_for_job.ID AS app_id FROM `tbl_seeker_applied_for_job` LEFT JOIN tbl_post_jobs ON tbl_post_jobs.ID=tbl_seeker_applied_for_job.job_ID AND tbl_post_jobs.deleted=0 WHERE tbl_seeker_applied_for_job.seeker_ID='".$this->session->userdata('user_id')."' AND tbl_seeker_applied_for_job.withdraw=0 AND tbl_seeker_applied_for_job.deleted=0")->result();
          if($myjobs)
          {
              ?>
              <div class="form-group">
                <label><?=lang('Add from old application')?>:</label>
                <select id="old_application" name="old_application" class="form-control">
                  <option selected="selected" value=""><?=lang('Select old application')?></option>
                  <?php
                  foreach ($myjobs as $row_old_job) {
                    ?><option value="<?=$row_old_job->app_id?>"><?=$row_old_job->job_title?></option><?php
                  }

                  ?>
                </select>
              </div>
              <?php
          }
          else
          {
            ?><select style="display: none;" name="old_application" id="old_application"><option selected="selected" value=""></option></select><?php
          }
        ?>
          <div class="form-group" id="expected_salary_fm">
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
          <div class="form-group" id="cover_letter_fm">
            <label><?=lang('Cover Letter')?></label>
            <textarea id="cover_letter" name="cover_letter"  class="form-control" placeholder=""><?php echo set_value('cover_letter');?></textarea>
            <?php echo form_error('cover_letter'); ?> 
          </div>
          <div class="form-group" id="attached_file_fm">
            <br/>
            <label><?=lang('Attach File')?> &nbsp;* <small>Only <b><?=lang('Documents')?>, <?=lang('Images')?></b> <?=lang('Type are Allowed')?></small></label>
            <input type="File" multiple="true" name="attached_file[]" id="attached_file" class="form-control"/>
          </div>
          <div class="form-group">
            <input type="text" id="skills_level" name="skills_level" style="display: none;" value="" />
            <?php echo form_error('attached_file'); ?> 
            <?php 
            $val_skills="";
            $i_skills=1;
            foreach ($skills_list as $skill_row) {

                $val_skills.=$skill_row->skill_name." : $$$$".$i_skills."$$$$ <hr/>";
              ?>
              <label><?=$skill_row->skill_name?></label>
            <input id="skill_<?=$i_skills?>" style="margin-top: 4px;" class="form-control" placeholder="Level (1 to 10)" type="number" min="1" max="10" />
              <?php
              $i_skills++;
            }
            $val_ans="";
            if($row_posted_job->quizz_text!=""):
            ?>

              <br/>
              <label><?=lang('Please read and pick an answer bellow')?></label>
              <?php
              $quizzes_ids=explode(",", $row_posted_job->quizz_text);
              foreach ($quizzes_ids as $quizz) {
              $row_quizz=$this->db->query("SELECT * FROM tbl_quizzes WHERE ID='$quizz' AND deleted='0'")->result();
              if($row_quizz)
              {
                $row_quizz=$row_quizz['0'];
                $val_ans.=$row_quizz->quizz." : $$$$".$quizz."$$$$ <hr/>";
               ?>
               <textarea id="quizz_text" disabled="disabled" rows="4" name="quizz_text_<?=$quizz?>"  class="form-control" placeholder=""><?php echo $row_quizz->quizz;?></textarea>
              <br/>
              <b><center>
              <input type="radio" name="answer_<?=$quizz?>" id="answer_<?=$quizz?>" value="<?php echo $row_quizz->answer1;?>" checked="checked" /> &nbsp;<label><?php echo $row_quizz->answer1;?> &nbsp;</label>
              <input type="radio" name="answer_<?=$quizz?>" id="answer_<?=$quizz?>" value="<?php echo $row_quizz->answer2;?>" /> &nbsp;<label><?php echo $row_quizz->answer2;?> &nbsp;</label>
              <input type="radio" name="answer_<?=$quizz?>" id="answer_<?=$quizz?>" value="<?php echo $row_quizz->answer3;?>" /> &nbsp;<label><?php echo $row_quizz->answer3;?> &nbsp;</label>
              </center></b><br/>
               <?php
              }
              }
              ?>
                <input type="radio" checked="checked" id="answer" name="answer" style="display: none;" value="" />
            <?php
            endif;            
            ?>
          </div><br/>
          <div style="height: 1px;width: 100%;background: #cacaca;"></div>
          <input style="width: 25px; margin-top: 10px; margin-bottom: -10px;" id="check_agree" class="form-control" type="checkbox" />
          <label style="margin-top: -30px!important; margin-left: 40px;"><?php echo file_get_contents(base_url().'qcsh/privacy-notice.html');?></label>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="jid" name="jid" value="<?php echo $row_posted_job->ID;?>"/>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
        <button type="button" name="submitter" id="submitter" onclick="remp_bb()" class="btn btn-primary"><?=lang('Apply')?></button>
      </div></div>
    </form><?php
      }
      ?>
    </div>
  </div>
</div>



<!-- <div class="modal fade" id="japply_before">
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
</div> -->


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
 <?php
end_sc:
?>
<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5a6ba621344b890012fe78af&product=inline-share-buttons' async='async'></script>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<?php if($this->session->userdata('is_job_seeker')==TRUE):?>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#submitter").attr("disabled", "disabled");
    $('#check_agree').change(function() {
          if(this.checked) {
              $("#submitter").removeAttr("disabled");
          }
          else
          {
            $("#submitter").attr("disabled", "disabled");
          }     
      });              
  });
  <?php
  if($myjobs)
  {
    ?>
    $('#old_application').change(function() {
      if($("#old_application").val()!="")
      {
        $("#expected_salary").prop("selectedIndex", 1);
        $("#cover_letter").val("1");
        $("#expected_salary_fm").hide();
        $("#cover_letter_fm").hide();
        $("#attached_file_fm").hide();
      }
      else
      {
        $("#expected_salary").prop("selectedIndex", 0);
        $("#cover_letter").val("");
        $("#expected_salary_fm").show();
        $("#cover_letter_fm").show();
        $("#attached_file_fm").show();
      }
    });

    <?php
  }

  ?>
  function remp_bb()
  {
    var val_ans="<?=$val_ans?>";
    <?php
    foreach ($quizzes_ids as $quizz) 
    {
        ?>
        val_ans=val_ans.replace("$$$$<?=$quizz?>$$$$",$("#answer_<?=$quizz?>:checked").val());
        <?php
    }
    ?>
    $("#answer").val(val_ans);
    var val_skills="<?=$val_skills?>";
    <?php
    $i_skills=1;
    foreach ($skills_list as $skill_row) 
    {
        ?>
        val_skills=val_skills.replace("$$$$<?=$i_skills?>$$$$",$("#skill_<?=$i_skills?>").val());
        <?php
        $i_skills++;
    }
    ?>
    $("#skills_level").val(val_skills);
  }
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
// $( document ).ready(function() {
//     $("#submitter_af").attr("disabled", "disabled");
//     $('#check_agree').change(function() {
//           if(this.checked) {
//               $("#submitter_af").removeAttr("disabled");
//           }
//           else
//           {
//             $("#submitter_af").attr("disabled", "disabled");
//           }     
//       });              
//   });
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