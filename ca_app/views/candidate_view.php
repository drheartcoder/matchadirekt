<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
<link href="<?php echo base_url('public/css/jquery-ui.css');?>" rel="stylesheet" type="text/css" />
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--Header-->
<div class="container detailinfo">
  <div class="row">
    <div class="col-md-12">
    <div id="msg"></div>
      <div class="row"> 
        <!--Company Info-->
        <div class="col-md-12">
        
          <div class="userinfoWrp">
            <div class="col-md-2 uploadPhoto">
      
            <img src="<?php echo base_url('public/uploads/candidate/'.$photo);?>"  />
            
            </div>
            <div class="col-md-6">
              <h1 class="username"><?php echo $row->first_name.' '.$row->last_name;?></h1>
              <?php
              $permited=false;
              $sts="";
              if($this->session->userdata('is_employer')==TRUE)
              {
                $prv=$this->db->query("SELECT private FROM tbl_job_seekers WHERE ID='".$row->ID."'")->result();
                if($prv['0']->private==false)
                  {
                    $permited=true;
                    goto else_goto;
                  }
                $low=$this->db->query("SELECT * FROM tbl_requests_info WHERE employer_id='".$this->session->userdata('user_id')."' AND jobseeker_id='".$row->ID."'")->result();
                if(count($low)>0)
                {
                  $low=$low['0'];
                  $sts=$low->sts;
                  if($sts=="approuved")
                    $permited=true;
                }
                else
                {
                  if($_GET['req'])
                  {
                      $this->db->query("INSERT INTO tbl_requests_info SET sts='pending',employer_id='".$this->session->userdata('user_id')."',jobseeker_id='".$row->ID."' ");

      //                	$this->load->library('email');

						// $this->email->from('support@matchadirekt.com', 'Matchadirekt');
						// $this->email->to('a37killer@gmail.com');

						// $this->email->subject('Request Info');
						// $this->email->message('An employer request to view your personnel info , click here to check your requests list');

						// $this->email->send();

                      header("Refresh:0");
                  } 
                }
              }
              else_goto:
              if($permited)
              {
                ?>
              <h1 class="username"><small style="font-size: 14px;"><?=lang('Ref.')?> <a href="#" onclick="window.location.reload();">#JS<?=str_repeat("0",5-strlen($row->ID)).$row->ID?></a></small></h1>
               <div class="comtxt"><?php echo $latest_job_title;?></div>
              <div class="comtxt-blue"><?php echo $latest_job_company_name;?></div> 
              <div class="comtxt-blue">
                <?php
              }
              else
              {
                ?>
                <h1 class="username"><small style="font-size: 14px;"><?=lang('Ref.')?> #JS*****</small></h1>
               <div class="comtxt">*****</div>
              <div class="comtxt-blue">*****</div> 
              <div class="comtxt-blue">
                <?php
                if($sts=="pending")
                {
                  echo lang('Request status ')."<i class='fa fa-clock'></i>".lang('Pending');
                }
                else if($sts=="not approuved")
                {
                    echo lang('Request Status : ')."<i class='fa fa-times'></i> ".lang('Not Approuved');
                }
                else
                {
                  ?>
                <a href="?req=true"><?=lang('Request candidate informations !')?></a>
                  <?php
                }
              }
              ?></div> 
            </div>
            <div class="col-md-4">
              <?php
              if($permited)
              {
                ?>
              <div class="usercel"><?php echo $row->city;?>, <?php echo $row->country;?></div>
                <?php
              }
              else
              {
                ?>
              <div class="usercel">*****, *****</div>
              <?php
              }
              ?>
              <?php if($this->session->userdata('is_employer')==TRUE):?><a href="javascript:;" id="sendcandidatemsg" style="margin-top: 10px;" class="btn btn-success btn-sm"><span><?=lang('Send Message')?></span></a>
              	<?php
              	if(count($employer_jobs)>0)
              	{
              		?>
              		<a href="javascript:;" style="margin-top: 10px;" onclick="$('#invite_job').modal('show');" class="btn btn-default btn-sm"><span><?=lang('Invite to Job')?></span></a>
              		<div class="modal fade" id="invite_job">
			            <div class="modal-dialog">
			              <div class="modal-content">
			                <div class="modal-header">
			                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                  <h4 class="modal-title"><?=lang('Choose Job')?></h4>
			                </div>
			                <!-- <form action="<?=base_url()?>employer/candidate/invite/<?=$row->ID?>/" method="post"> -->
			              <div class="modal-body" style="min-height: 100px;">
			                   <div class="col-md-12">
			                     <div class="form-group">
			                       <label><?=lang('My Jobs')?></label> 
			                       <select class="form-control" name="job" id="job" required="required">
			                         <?php
			                         foreach ($employer_jobs as $row_) {
			                           ?><option value="<?=$row_->job_slug?>"><?=$row_->job_title?></option><?php
			                         }
			                         ?>
			                       </select>
			                     </div>
			                   </div>
			              </div>
			                <div class="modal-footer">
			                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
			                  <button type="button" onclick="invite_job()" class="btn btn-success"><?=lang('Submit')?></button>
			                </div>
			                <!-- </form> -->
			              </div>
			            </div>
			          </div>
              		<?php
              	}
              	?>
              	
         <a href="javascript:;" onclick="$('#add_archive').modal('show')" style="margin-top: 10px;" class="btn btn-primary btn-sm"><span><?=lang('Add to Archive')?></span></a>
        <div class="modal fade" id="add_archive">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Choose Label')?></h4>
                </div>
                <form action="<?=base_url()?>employer/labels/label_details_add/<?=$row->ID?>/job_seekers" method="post">
              <div class="modal-body" style="min-height: 100px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Label')?></label> 
                       <select class="form-control" name="label" required="required">
                         <option value=""><?=lang('Choose Label')?></option>
                         <?php
                         $result_labels=$this->db->query("SELECT * FROM tbl_labels WHERE company_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
                         foreach ($result_labels as $row2) {
                           ?><option value="<?=$row2->ID?>"><?=$row2->label?></option><?php
                         }
                         ?>
                       </select>
                     </div>
                   </div>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                  <button type="submit" class="btn btn-success"><?=lang('Add')?></button>
                </div>
                </form>
              </div>
            </div>
        </div>

          <a href="<?php echo base_url('candidate/Add/'.$row->ID); ?>"  style="margin-top: 10px;" class="btn btn-primary btn-sm">
            <span>Add to candidates</span>
          </a>
          <a href="#" onclick="$('#add_to_job').modal('show');"  style="margin-top: 10px;" class="btn btn-warning btn-sm">
            <span>Add to Job</span>
          </a>
 <div class="modal fade" id="add_to_job">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Change Website Language')?></h4>
      </div>
      <form enctype="multipart/form-data" method="post" action="<?php echo base_url('candidate/add_to_job/'.$row->ID); ?>">
      <div class="modal-body">
        <div class="form-group">
        <select required="required" class="form-control" name="job_id">
          <?php
          $jobs_list=$this->db->query("SELECT * FROM tbl_post_jobs WHERE (sts='active' OR sts='inactive') AND employer_id='".$this->session->userdata('user_id')."' AND dated<=CURDATE() AND deleted='0' ")->result();
          foreach ($jobs_list as $row_job_) {
            ?><option value="<?=$row_job_->ID?>"><?=$row_job_->job_title?></option><?php
          }
          ?>          
        </select>
        </div>
        <div class="form-group" id="attached_file_fm">
            <br/>
            <label><?=lang('Attach File')?> &nbsp;* <small>Only <b><?=lang('Documents')?>, <?=lang('Images')?></b> <?=lang('Type are Allowed')?></small></label>
            <input type="File" multiple="true" name="attached_file[]" id="attached_file" class="form-control"/>
          </div>
      </div> 
      <div class="modal-footer">
        <button type="submit" class="btn btn-success"><?=lang('Submit')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
      </div>
    </form>
    </div>
  </div>
</div>
        <?php endif;?>
          </div>
            <div class="clear"></div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      
      <!--My CV-->
      <?php if($result_resume):?>
      <div class="innerbox2">
        <div class="titlebar">
          <div class="row">
            <div class="col-md-7"><b><?=lang('Document')?></b></div>
            <div class="col-md-5 text-right"></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <ul class="myjobList">
            <?php if($result_resume): 
              $chk=1;
		  			foreach($result_resume as $row_resume):
					$file_name = ($row_resume->is_uploaded_resume)?$row_resume->file_name:'';
					$file_array = explode('.',$file_name);
					$file_array = array_reverse($file_array);
					$icon_name = get_extension_name($file_array[0]);
          if($row_resume->is_default_resume=='yes')
          {
		  ?>
            <li class="row" id="cv_<?php echo $row_resume->ID;?>">
              <div class="col-md-4">
              <i class="fa fa-file-<?php echo $icon_name;?>-o">&nbsp;</i>
              <?php if($row_resume->is_uploaded_resume): ?>
              	<a href="<?php echo base_url('resume/download/'.$row_resume->file_name);?>"><?=lang('My Document')?> <small>(<?=lang('Download to your computer')?>)</small></a>
              <?php else: ?>
			         	<a href="#"><?=lang('My Document')?></a>
			         <?php endif;?>
              </div>
              <div class="col-md-8"><?php echo date_formats($row_resume->dated, "d M, Y");?></div>
            </li>
            <?php
             $chk=0;
             //break;
           }
            ?>
            <?php 	endforeach; 
		  		else:?>
            <?=lang('No resume uploaded yet')?>!
            <?php endif;
            if($chk==1)
              echo lang('No resume uploaded yet').' !';
            ?>

          </ul>
        </div>
      </div>
      <?php endif;?>
      
      <!--Job Detail-->
      <?php if($row_additional->summary):?>
      <div class="innerbox2">
        <div class="titlebar">
          <div class="row">
            <div class="col-md-9"><b><?=lang('Professional Summary')?></b></div>
            <div class="col-md-3 text-right"></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <p><?php echo ($row_additional->summary)?character_limiter($row_additional->summary,500):'';?></p>
            </div>
          </div>
        </div>
      </div>
      <?php endif;?>
      <!--References-->
      <?php if($result_reference):?>
      <div class="innerbox2">
        <div class="titlebar">
          <div class="row">
            <div class="col-md-9"><b><?=lang('References')?></b></div>
            <div class="col-md-3 text-right"></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <?php 
      if($result_reference):
        foreach($result_reference as $row_reference):
    ?>
          <div class="row expbox">
            <div class="col-md-12">
              <h4><?php echo $row_reference->name;?></h4>
              <ul class="useradon">
                <li>Title: <?php echo $row_reference->title;?></li>
                <li>Phone: <?php echo $row_reference->phone;?></li>
                <li>Email: <?php echo $row_reference->email;?></li>
              </ul>
              <div class="action"> </div>
            </div>
          </div>
          <?php endforeach; endif;?>
          <div class="clear"></div>
        </div>
      </div>
      <?php endif;?>
      <!--Experiance-->
      <?php if($result_experience):?>
      <div class="innerbox2">
        <div class="titlebar">
          <div class="row">
            <div class="col-md-9"><b><?=lang('Experience')?></b></div>
            <div class="col-md-3 text-right"></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <?php 
			if($result_experience):
				foreach($result_experience as $row_experience):
				$date_to = ($row_experience->end_date)?date_formats($row_experience->end_date, 'M Y'):'Present';
		?>
          <div class="row expbox">
            <div class="col-md-12">
              <h4><?php echo $row_experience->job_title;?></h4>
              <ul class="useradon">
                <li class="company"><?php echo $row_experience->company_name;?></li>
                <?php if($row_experience->city || $row_experience->country):?>
                	<li><?php echo ($row_experience->city)?$row_experience->city.', ':'';?>, <?php echo $row_experience->country;?></li>
                <?php endif;?>
                <li><?php echo date_formats($row_experience->start_date, 'M Y');?> to <?php echo $date_to;?></li>
              </ul>
              <div class="action"> </div>
            </div>
          </div>
          <?php endforeach; endif;?>
          <div class="clear"></div>
        </div>
      </div>
      <?php endif;?>
      
      <?php if($result_qualification):?>
      <!--Education-->
      <div class="innerbox2">
        <div class="titlebar">
          <div class="row">
            <div class="col-md-9"><b><?=lang('Education')?></b></div>
            <div class="col-md-3 text-right"></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <?php 
			if($result_qualification):
				foreach($result_qualification as $row_qualification):
			?>
          <div class="row expbox">
            <div class="col-md-12">
              <h4><?php echo $row_qualification->institude;?> <?php echo ($row_qualification->city)?', '.$row_qualification->city:'';?></h4>
              <ul class="useradon">
                <li><?php echo $row_qualification->degree_title;?>, <?php echo $row_qualification->completion_year;?></li>
                <li><?php echo $row_qualification->major;?></li>
              </ul>
              <div class="action"></div>
            </div>
          </div>
          <?php endforeach; endif;?>
          <div class="clear"></div>
        </div>
      </div>
       <?php endif;?>    
      
      

       <?php if($applications!=0) : ?>
       <div class="innerbox2">
        <div class="titlebar">
          <div class="row">
            <div class="col-md-7"><b><?=lang('Applications') ?></b></div>
            <div class="col-md-5 text-right"></div>
          </div>
        </div>
        
         
        <div class="experiance">
          <ul class="myjobList">
            
            <li class="row">

              <div class="col-md-1"><strong><?=lang('Ref.')?></strong></div>
              <div class="col-md-1"><strong><?=lang('status')?></strong></div>
              <div class="col-md-4"><strong><?=lang('Job title')?></strong></div>
              <div class="col-md-2"><strong><?=lang('Comment')?></strong></div>
              <div class="col-md-2"><strong><?=lang('Rate')?></strong></div>
              <div class="col-md-2"><strong><?=lang('Date')?></strong></div>

            </li>

            <?php foreach($applications as $app): ?>
              <li class="row">

                <?php 
                  $link=base_url('jobs/'.$app->job_slug);
                 ?>
                  <div class="col-md-1"><small><a href="<?= $link?>" style="font-size: 13px; color: #6b6b6b;">#<?=$app->diarie?></a></small></div>
                  <div class="col-md-1"><a href="<?= $link?>" ><?php  if($app->flag=="") echo lang("Primary"); else echo lang($app->flag) ;?></a></div>
                  <div class="col-md-4"><a href="<?= $link?>" ><?php echo $app->job_title.' '.$app->last_name;?></a>

                    <?php 
                    if($app->file_name!="")
                    {
                       echo '<br/>';
                      $filenames=explode("$*_,_*$", $app->file_name);
                      
                      for($i=0;$i<count($filenames);$i++)
                      {
                          $link=base_url('employer/download/'.$filenames[$i]);
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='".$link."'>".lang('Attached file')." ".($i+1)."</a>"; 
                          if($i!=count($filenames)-1)
                            echo "<br/>";
                      }
                      if(count($filenames)==0)
                      {
                          $link=base_url('employer/download/'.$app->file_name);
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='./download/".$link."'>".lang('Attached file')."</a>";  
                      }
                    }
                    ?>

                  </div>
                  <div class="col-md-2"> <?php echo $app->comment;?></div>
                  <div class="col-md-2"><?php echo $app->rate;?></div>
                  <div class="col-md-2"><?php echo date_formats($app->applied_date, 'M d, Y');?></div>

              </li>

            <?php endforeach ?>  
          </ul>
        </div>
      </div>
    <?php endif ?>



    </div>
    <!--/Job Detail-->
    
    <?php $this->load->view('common/right_ads');?>
  </div>
</div>
<div class="modal fade" id="send_msg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Send a Message to')?> <?php echo $row->first_name;?></h4>
      </div>
      <form action="<?=base_url().'candidate/send_message/'.$IDCD?>" method="post">
        <div class="modal-body">
          <div id="emsg"></div>
          <div class="box-body">
            <div class="form-group">
              <label><?=lang('Message')?></label>
              <textarea required="required" id="message" name="message" required="required"  class="form-control" rows="12" placeholder=""><?php echo set_value('message');?></textarea>
              <?php echo form_error('message'); ?> </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="jsid" name="jsid" value="<?php echo $this->uri->segment(2);?>"/>
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
          <button type="button" name="msg_submit" id="msg_submit" class="btn btn-warning"><i class="fa fa-envelope"></i>&nbsp; <?=lang('Send Email')?></button>
          <?php
          if($chat_url!=""):
            ?>
          <button type="button" onclick="location.href='<?=$chat_url?>'" class="btn btn-primary"><?=lang('Open Chat')?></button><?php
          endif;
          ?>
          <button type="submit" id="sub_send" class="btn btn-success"><i class="fa fa-send"></i>&nbsp; <?=lang('Send')?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<script type="text/javascript">
function invite_job()
{
  $('#job').val();
  var msg="Hi , please take a look at this Job<br/><a target=\"_blank\" href=\"<?=base_url()?>jobs/"+$('#job').val()+"\"><i class=\"fa fa-link\"></i> "+$( "#job option:selected" ).text()+"</a>";

  $('#message').val(msg);
   $('#sub_send').click();
}
$("#sendcandidatemsg").click(function(){
		$('#send_msg').modal('show');
	});	
</script>
</body>
</html>
</html>