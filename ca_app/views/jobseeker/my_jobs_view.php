<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header--> 
<!--Detail Info-->
<div class="container detailinfo">
  <div class="row">
  	<div class="col-md-3">
    	<div class="dashiconwrp">
    		<?php $this->load->view('jobseeker/common/jobseeker_menu'); ?>
  		</div>
    </div>
    <div class="col-md-9">
    <!--Job Detail-->
    
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><b><?=lang('My Job Applications')?></b></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <ul class="myjobList">
                <?php if($result_applied_jobs): 
		  			foreach($result_applied_jobs as $row_applied_job):
		  ?>
            <?php 
            if($row_applied_job->withdraw==1) goto nd;
            ?>
                <li class="row" id="aplied_<?php echo $row_applied_job->applied_id;?>">
                  <div class="col-md-4"><a href="<?php echo base_url('jobs/'.$row_applied_job->job_slug);?>"><?php echo $row_applied_job->job_title;?></a></div>
                   <div class="col-md-4"><a href="<?php echo base_url('jobs/'.$row_applied_job->job_slug);?>"><?php echo $row_applied_job->company_name;?></a><br/><?php if($row_applied_job->answer!="") echo "<a style='color:green;font-size:15px;' href='#' onclick=\"$('#answers_$row_applied_job->applied_id').modal('show');\">Answers</a>";if( ($row_applied_job->skills_level!="" || $row_applied_job->file_name!="") && $row_applied_job->answer!="") echo '<br/>';?>
                    <?php if($row_applied_job->skills_level!="") echo "<a style='color:green;font-size:15px;' href='#' onclick=\"$('#skills_level_$row_applied_job->applied_id').modal('show');\">Skills Level</a>";if($row_applied_job->file_name!="" && $row_applied_job->skills_level!="") echo '<br/>';?>
                    <?php 
                    if($row_applied_job->file_name!="")
                    {
                      $filenames=explode("$*_,_*$", $row_applied_job->file_name);
                      $j=0;
                      for($i=0;$i<count($filenames);$i++)
                      {
                          if($filenames[$i]!="")
                          { 
                            $j++;
                            echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a target='_blank'style='color:darkgreen!important;font-size: 13px!important;' href='./show/".$filenames[$i]."'>Attached file ".($j)."</a> <a title='".lang('Delete')."' href=\"".base_url('jobseeker/my_jobs/delete_file/').$filenames[$i]."/".$row_applied_job->applied_id."\"><i class='fa fa-times' style='color:red;'></i></a>";
                              echo "<br/>";
                          }
                      }
                      if(count($filenames)==0)
                      {
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a target='_blank' style='color:darkgreen!important;font-size: 13px!important;' href='./show/".$row_applied_job->file_name."'>".lang('Attached file')."</a> <a title='".lang('Delete')."' href=\"".base_url('jobseeker/my_jobs/delete_file/').$row_applied_job->file_name."/".$row_applied_job->applied_id."\"><i class='fa fa-times' style='color:red;'></i></a><br/>";  
                      }
                    }
                    echo "<i style='color:darkgreen!important;font-size: 15px!important;' class='fa fa-plus'></i> <a onclick=\"$('#add_files_$row_applied_job->applied_id').modal('show');\" style='color:darkgreen!important;font-size: 14px!important;' href=\"#\">".lang('Add Files')."</a>"; 
                    ?>
                  </div>
                  <div class="modal fade" id="add_files_<?=$row_applied_job->applied_id?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=$row_applied_job->job_title.' - '.lang('Add Files')?></h4>
                        </div>
                        <form enctype="multipart/form-data" method="post" action="<?=base_url('jobseeker/my_jobs/add_file/').$row_applied_job->applied_id?>">
                          <div class="modal-body">
                            <div class="form-group" id="attached_file_fm">
                              <br/>
                              <label><?=lang('Attach File')?> &nbsp;* <small>Only <b><?=lang('Documents')?>, <?=lang('Images')?></b> <?=lang('Type are Allowed')?></small></label>
                              <input type="File" name="attached_file[]" id="attached_file" class="form-control"/>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><?=lang('Submit')?></button>
                            <button type="button" class="btn btn-default"  data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="skills_level_<?=$row_applied_job->applied_id?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=$row_applied_job->job_title.' - '.lang('Skills Level')?></h4>
                        </div>
                        <div class="modal-body">
                          <div>
                            <?=$row_applied_job->skills_level?>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default"  data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="answers_<?=$row_applied_job->applied_id?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=$row_applied_job->job_title.' - '.lang('Answers')?></h4>
                        </div>
                        <div class="modal-body">
                          <div>
                            <?=$row_applied_job->answer?>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default"  data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2 text-right"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2 text-right"><a onclick="if(confirm('Do you really wanna withraw this Application ?')){window.location='<?=base_url()?>jobseeker/my_jobs/withdraw/<?php echo $row_applied_job->applied_id;?>';}" style="cursor:pointer;font-size: 12px;" ><?=lang('Withdraw')?></a>
                  &nbsp;&nbsp;&nbsp; <a href="javascript:;" onClick="del_applied_job(<?php echo $row_applied_job->applied_id;?>);" title="Delete" class="delete-ico"><i class="fa fa-times">&nbsp;</i></a>
                  <br/><span style="color: red; cursor: pointer; font-size: 14px; font-weight: bold; margin-right: 15px!important;" ><?php if($row_applied_job->flag=="") echo lang("Primary"); else echo $row_applied_job->flag;?></span></div>
                </li>
                <?php 
                  nd:
                  if($row_applied_job->withdraw==0) goto lb;
                  ?>
                  <li class="row" id="aplied_<?php echo $row_applied_job->applied_id;?>">
                  <div class="col-md-4"><a style="font-style: oblique;"><?php echo $row_applied_job->job_title;?></a></div>
                   <div class="col-md-4"><a style="font-style: oblique;"><?php echo $row_applied_job->company_name;?></a>
                  </div>
                  <div class="col-md-2 text-right"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2 text-right"><i style="color:gray;font-size: 12px;" ><?=lang('Withdrawn')?></i>&nbsp;&nbsp;&nbsp; <a href="javascript:;" onClick="del_applied_job(<?php echo $row_applied_job->applied_id;?>);" title="Delete" class="delete-ico"><i class="fa fa-times">&nbsp;</i></a></div>
                </li>
                  <?php
                  lb:
                 ?>
                <?php 	endforeach; 
		  		else:?>
                <?=lang('No record found')?>!
                <?php endif;?>
              </ul>
            </div>
            
            
            
            
          </div>
        </div>
      </div>
    </div>
    <!--/Job Detail--> 
    
    <!--Pagination-->
    <div class="paginationWrap"> <?php echo ($result_applied_jobs)?$links:'';?> </div>
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?>
</body>
</html>