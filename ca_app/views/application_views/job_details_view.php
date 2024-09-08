<!DOCTYPE html>
<?php
$emp=0;
$row_job=$this->db->query("SELECT * FROM tbl_post_jobs WHERE ID='".$row_posted_job->ID."'")->result()['0'];
if(($row_posted_job->sts=='inactive' || $row_posted_job->sts=='archive') && $this->session->userdata('user_id')!=$row_posted_job->CID)
  redirect(base_url('app/Jobs'));
if($this->session->userdata('user_id')==$row_posted_job->CID && $this->session->userdata('is_employer')==TRUE)
  $emp=1;
$src=base_url()."public/uploads/employer/companies/BIXMA_JOB_".$row_posted_job->ID.".png";
$pp = $row_posted_job->job_description;
$job_title = word_limiter(strip_tags(str_replace('-',' ',$row_posted_job->job_title)),7);
$company_loc = urlencode($row_posted_job->company_location.', '.$row_posted_job->emp_city.', '.$row_posted_job->emp_country.', ('.$row_posted_job->company_name.')'); ?>

<?php if($this->session->userdata('is_employer')==TRUE)
 $this->load->view('application_views/common/header_emp'); 
 else if($this->session->userdata('is_job_seeker')==TRUE)
     $this->load->view('application_views/common/header'); 
?>

<?php if($is_already_applied=='yes' && !$this->session->userdata('message_applied_job')):?>
      <div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong><?=lang('Heads up')?>!</strong> <?=lang('You have already applied for this job')?>.</div>
      <?php endif;?>
      <div id="msg"><?php if($this->session->userdata('message_applied_job')){ 
        $this->session->unset_userdata('message_applied_job');
        ?><div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong><?=lang('Success')?>!</strong> <?=lang('You have successfully applied for this job')?>. </div><?php } ?></div>


<div class="model_app" id="japply">
    
    <div class="top_header">
        <center><div class="title_page"><?php echo lang('Apply Job');?></div></center>
         <span type="button" class="close_app_model" onclick="$('#japply').hide();"><i class="fa fa-times"></i></span>
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
      <form enctype="multipart/form-data" method="post" action="<?=base_url().'app/jobseeker/apply_job?yep=1'?>" id="formid">
      <div class="modal-body">
        <div id="emsg"></div>
        <div class="box-body">
          <div class="form-group">
            <label><?=lang('Monthly Expected Salary')?>:</label>
            <select name="expected_salary" id="expected_salary" class="form-control app_input">
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
            <textarea id="cover_letter" name="cover_letter"  class="form-control app_input" placeholder=""><?php echo set_value('cover_letter');?></textarea>
            <?php echo form_error('cover_letter'); ?> 

            <br/>
            <label><?=lang('Attach File')?> &nbsp;* <small>Only <b><?=lang('Documents')?>, <?=lang('Images')?></b> <?=lang('Type are Allowed')?></small></label>
            <div class="div_upload ara_row">
                       <label class="upload_file_btn" id="click_btn_files"><i class="fa fa-upload"></i></label>
                     
                    <input type="File" multiple="true" name="attached_file[]" id="attached_file" class="form-control app_input" style="display:none;">
                
                       <input type="text" id="files_name" class="upload_file_name" placeholder="Select Files...." disabled/>
              </div><br/>
            <input type="text" id="skills_level" name="skills_level" style="display: none;" value="" />
            <?php echo form_error('attached_file'); ?> 
            <?php 
            $val_skills="";
            $i_skills=1;
            foreach ($skills_list as $skill_row) {

                $val_skills.=$skill_row->skill_name." : $$$$".$i_skills."$$$$ <hr/>";
              ?>
              <label><?=$skill_row->skill_name?></label>
            <input id="skill_<?=$i_skills?>" style="margin-top: 4px;" class="form-control app_input" placeholder="Level (1 to 10)" type="number" min="1" max="10" />
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
                 <textarea id="quizz_text" disabled="disabled" rows="4" name="quizz_text_<?=$quizz?>"  class="form-control app_input" placeholder=""><?php echo $row_quizz->quizz;?></textarea>
                <br/>
                <b><center>
                <input type="radio" name="answer_<?=$quizz?>" id="answer_<?=$quizz?>" value="<?php echo $row_quizz->answer1;?>" checked="checked" /> &nbsp;<label><?php echo $row_quizz->answer1;?> &nbsp;</label>
                <input type="radio" name="answer_<?=$quizz?>" id="answer_<?=$quizz?>" value="<?php echo $row_quizz->answer2;?>" /> &nbsp;<label><?php echo $row_quizz->answer2;?> &nbsp;</label>
                <input type="radio" name="answer_<?=$quizz?>" id="answer_<?=$quizz?>" value="<?php echo $row_quizz->answer3;?>" /> &nbsp;<label><?php echo $row_quizz->answer3;?> &nbsp;</label>
                </center></b><br/>
                 <?php
                }
                // else
                // {
                //   echo "Quizz <b>".$quizz."</b> Not Found !<br/>";
                // }
              }
              ?>
                <input type="radio" checked="checked" id="answer" name="answer" style="display: none;" value="" />
            <?php
            endif;            
            ?>
          </div><br/>
          <div style="height: 1px;width: 100%;background: #cacaca;"></div>
          <input style="width: 25px; margin-top: 10px; margin-bottom: -10px;" id="check_agree" class="form-control" type="checkbox" />
          <label style="margin-top: -30px!important; margin-left: 40px;">﻿

          <?php echo file_get_contents(base_url().'qcsh/privacy-notice.html');?>
            
          </label>
      </div>
      <div class="modal-footer" style="text-align:center">
        <input type="hidden" id="jid" name="jid" value="<?php echo $row_posted_job->ID;?>">
       
        <button type="button" name="submitter" id="submitter" onclick="remp_bb()" class="btn btn-success" disabled="disabled"><?=lang('Apply')?></button>
      </div></div>
    </form><?php
      }
      ?>
</div>




   <?php
        $end=0;
        if(date($row_posted_job->last_date)<date('Y-m-d'))
        {
          $end=1;
          ?><div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong><?=lang('NOTE : This job offer is no longer available')?> !</div><?php
        }
        ?>
<div class="style_div_job">
                <div class="div_img_job">
                    <a href="" class="" title=""><img src="<?php echo base_url('public/uploads/employer/'.$company_logo);?>"/></a>
                </div>
                <div class="div_job_content">
                    <span class="title_job" >
                    <a href=""><?php echo humanize($job_title);?></a>
                    
                    </span>
                    <span class="company_ne" ><a title="" style="color:#7da400;"><i class="fa fa-users"></i> <?php echo $row_posted_job->company_name;?></a></span>
                    <span class="city_ne"><a style="color:black;"><i class="fa fa-home"></i> <?php echo $row_posted_job->emp_city;?> &nbsp;-&nbsp; <?php echo $row_posted_job->emp_country;?></a></span>
                      
                </div>
</div>
  
 <div class="title_div"><?=lang('Job Detail')?></div>

<div class="content_div_job">
              <div class="ara_row"> 
              
              <!--Requirements-->
                <ul class="reqlist" style="margin:10px auto auto auto;">
                  <li style="display: flex;">
                    <div class="detail_row"><?=lang('Ref.')?> :</div>
                    <div class="detail_row"><a href="#" onclick="window.location.reload();">#JB<?=str_repeat("0",5-strlen($row_posted_job->ID)).$row_posted_job->ID?></a></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Diarienummer')?> :</div>
                    <div class="detail_row"><?php echo $row_posted_job->diarie;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Industry')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->industry_name;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Total Positions')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->vacancies;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Job Type')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->job_mode;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Salary')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->pay;?> </div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Job Location')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->city.', '.$row_posted_job->country;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Minimum Education')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->qualification;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Minimum Experience')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->experience;?> <?php echo ($row_posted_job->experience<2)?'Year':'Years';?></div>
                    <div class="clear"></div>
                  </li>
                  <?php if($row_posted_job->age_required):?>
                  <li>
                    <div class="detail_row"><?=lang('Age Required')?>:</div>
                    <div class="detail_row"><?php echo $row_posted_job->age_required;?> Years</div>
                    <div class="clear"></div>
                  </li>
                  <?php endif;?>
                  <li>
                    <div class="detail_row"><?=lang('Apply By')?>:</div>
                    <div class="detail_row"><?php echo date_formats($row_posted_job->last_date, 'M d, Y');?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="detail_row"><?=lang('Job Posting Date')?>:</div>
                    <div class="detail_row"><?php echo date_formats($row_posted_job->dated, 'M d, Y');?></div>
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
                    
            <?php
            endddd23:
            }
            ?>
                </ul>
              
              <div class="clear"></div>
            </div>
    
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
                  <hr/>
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
                      <a href="<?php echo base_url('file/show/'.$row_file->file_name);?>">File N:<?=$i?><br/>
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
                          <hr/>
            </div>
                <?php if($required_skills && $required_skills[0]!=''):?>
                <div class="col-md-12">
                  <div class="subtitlebar"><?=lang('Skills Required')?></div>
                  <div class="skillBox">
                    <ul class="skillDetail">
                      <?php foreach($required_skills as $skill):?>
                      <li><a><?php echo $skill;?></a></li>
                      </li>
                      <?php endforeach;?>
                      <div class="clear"></div>
                    </ul>
                  </div>
                </div>
                <?php endif;?>
              </div>
</div>

<?php
if($this->session->userdata('is_job_seeker')==TRUE)
          {
          if($end==0)
          {
          ?>
          <div class="actionBox">
            <h4><?php echo ($is_already_applied=='yes')?lang('You have already applied for this job'):lang('To Apply for this job click below');?></h4>
            <p></p>
            <a href="javascript:;" class="<?php echo ($is_already_applied=='yes')?'applyjobgray':'applyjob';?>"><span><?=lang('Apply Now')?></span></a> <!--<a href="#" class="refferbtn"><span>Email to Friend</span></a>--> </div>
          <?php
          }
          }
    
              ?>
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
            <textarea id="reason" name="reason"  class="form-control app_input" placeholder=""><?php echo set_value('reason');?></textarea>
            <?php echo form_error('reason'); ?> </div>
          <!-- <div class="form-group">
            <label class="input-group-addon"><?=lang('Please enter')?>: <span id="ccode"><?php echo $cpt_code;?></span> <?=lang('in the text box below')?>:</label>
            <input type="text" class="form-control app_input" name="captcha" id="captcha" value="" maxlength="10" autocomplete="off"/>
            <?php echo form_error('captcha'); ?> </div> -->
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
    
<script src="<?php echo base_url('public/js/jquery-1.11.0.js');?>" type="text/javascript"></script> 

<?php if($this->session->userdata('is_job_seeker')==TRUE):?>
<script type="text/javascript">

  <?php
  if($skills_list)
  {
  ?>

 document.getElementById('click_btn_files').addEventListener('click', function() {
      document.getElementById('attached_file').click();
    });

      document.getElementById('attached_file').addEventListener('change', function() {
    document.getElementById("files_name").value = this.value;
   });
  <?php
  }
  ?>

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
    // $('#japply').modal('show');
      $('#japply').show();
  }
  /*else{
    bootbox.alert("You have already applied for this job!");  
  }*/
  $(".applyjob").click(function(){
    if(is_already_applied=='yes')
      bootbox.alert("You have already applied for this job!");
    else
      $('#japply').show();
      // $('#japply').modal('show');
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
<?php $this->load->view('application_views/common/footer_app'); ?>
</body>
</html>