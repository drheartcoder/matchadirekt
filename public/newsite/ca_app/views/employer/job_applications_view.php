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
    <?php $this->load->view('employer/common/employer_menu');?>
  </div>
  </div>
  
    <div class="col-md-9"><!--Job Detail-->
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><b><?=lang('Job Applications Received')?></b></div>
          </div>
        </div>
        <!--Job Description-->

        <a href="http://egogym.test/export/applications">Download</a>

        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <ul class="myjobList">
                <li class="row">
                  <div class="col-md-3"><strong><?=lang('Candidate Name')?></strong></div>
                  <div class="col-md-4"><strong><?=lang('Job Title')?></strong></div>
                  <div class="col-md-3"><strong><?=lang('Applied Date')?></strong></div>
                  <div class="col-md-2"><strong><?=lang('Actions')?></strong></div>
                </li>
                <?php if($result_applied_jobs): 
		  			foreach($result_applied_jobs as $row_applied_job):
		  ?>
           <?php 
             if($row_applied_job->withdraw==1) goto nd;
            ?>
                <li class="row">
                  <div class="col-md-3"><a href="<?php echo base_url('candidate/'.$this->custom_encryption->encrypt_data($row_applied_job->job_seeker_ID));?>"><?php echo $row_applied_job->first_name.' '.$row_applied_job->last_name;?></a></div>

                  <div class="col-md-4"><a href="<?php echo base_url('jobs/'.$row_applied_job->job_slug);?>"><?php echo $row_applied_job->job_title;?></a><br/><?php if($row_applied_job->answer!="") echo'His answer : ('.$row_applied_job->answer.')';if($row_applied_job->file_name!="" && $row_applied_job->answer!="") echo '<br/>';?>
                    <?php 
                    if($row_applied_job->file_name!="")
                    {
                      $filenames=explode("$*_,_*$", $row_applied_job->file_name);
                      for($i=0;$i<count($filenames);$i++)
                      {
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='./download/".$filenames[$i]."'>Attached file ".($i+1)."</a>"; 
                          if($i!=count($filenames)-1)
                            echo "<br/>";
                      }
                      if(count($filenames)==0)
                      {
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='./download/".$row_applied_job->file_name."'>Attached file</a>";  
                      }
                    }
                    ?>
                  </div>  
                  <div class="col-md-3"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2"><a href="#" onclick="$('#add_calendar_<?=$row_applied_job->ID?>').modal('show')"><small><i class="fa fa-calendar"></i>&nbsp; <?=lang('Add')?></a></small></div>
                  <div class="modal fade" id="add_calendar_<?=$row_applied_job->ID?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=lang('Add Event with this Candidate')?></h4>
                        </div>
                        <div class="modal-body">
                           <div class="form-group col-md-12" >
                             <label><?=lang('Date')?></label> <input type="date" required="required" id="date_<?=$row_applied_job->ID?>" class="form-control">
                           </div>
                            <div class="form-group col-md-6" >
                              <label><?=lang('Hour')?></label><input type="number" required="required" id="hour_<?=$row_applied_job->ID?>" value="10" class="form-control">
                            </div>
                            <div class="form-group col-md-6" >
                            <label><?=lang('Minute')?></label> <input type="number" required="required" value="00" id="minute_<?=$row_applied_job->ID?>" class="form-control">
                          </div>
                            <div class="form-group col-md-12" >
                            <label><?=lang('Notes')?></label> <textarea type="text" required="required" placeholder="<?=lang('Say something')?> ..." id="notes_<?=$row_applied_job->ID?>" class="form-control">Interview with <?php echo $row_applied_job->first_name.' '.$row_applied_job->last_name;?></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" onclick="$('#add_calendar_<?=$row_applied_job->ID?>').modal('hide')"><?=lang('Close')?></button>
                          <button type="button" name="submitter_af" id="submitter_af" onclick="showIt('<?=$row_applied_job->seeker_ID?>','<?=$id_employer_ID?>',$('#date_<?=$row_applied_job->ID?>').val(),$('#hour_<?=$row_applied_job->ID?>').val(),$('#minute_<?=$row_applied_job->ID?>').val(),$('#notes_<?=$row_applied_job->ID?>').val())" class="btn btn-success"><?=lang('Add')?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <?php 
                  nd:
                  if($row_applied_job->withdraw==0) goto lb;
                  ?>
                  <li class="row" id="aplied_<?php echo $row_applied_job->applied_id;?>">
                  <div class="col-md-3"><a style="font-style: oblique;"><?php echo $row_applied_job->first_name.' '.$row_applied_job->last_name;?></a></div>
                   <div class="col-md-4"><a style="font-style: oblique;"><?php echo $row_applied_job->job_title;?></a>
                  </div>
                  <div class="col-md-3"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2"><i style="color:gray;font-size: 12px;" ><?=lang('Withdrawn')?></i></div>
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
<script type="text/javascript">
  function showIt(idj,ide,dte,hrs,tme,ntt)
  {
      var dtl=new Date(dte);
      var newdtl=dtl.getUTCFullYear() + "-" + (dtl.getUTCMonth()+1) + "-" + dtl.getUTCDate() + " "+ hrs + ":" + tme + ":00";
      window.location="<?=base_url()?>employer/job_applications/add_Event/"+idj+"/"+ide+"/"+newdtl+"/"+ntt;
  }
</script>
</body>
</html>