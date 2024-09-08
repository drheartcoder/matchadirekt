<?php
$gets="?name_ref=".$this->input->get('name_ref')."&email=".$this->input->get('email')."&gender=".$this->input->get('gender')."&city=".$this->input->get('city');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
<style type="text/css">
  .ayBr{
    border-radius: 0px!important;
    
  }
</style>
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
    <?php echo $this->session->flashdata('msg');?>
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><b><?=lang('Job Applications Received')?></b></div>

            

          </div>
        </div>

        <!--Job Description-->
        <div class="companydescription">
          <div class="candidatesection" style="margin-bottom: -13px;">
            <form name="jsearch" id="jsearch ayBr" method="get" accept-charset="utf-8">
              <div class="col-md-4">
                    <input value="<?=$this->input->get('name_ref')?>" type="text" name="name_ref" id="name_ref" class="form-control ayBr" placeholder="<?=lang('Name or Reference or Job title or Skill')?>">                
              </div>
              <div class="col-md-3">
                    <input type="text" name="email" id="email" value="<?=$this->input->get('email')?>" class="form-control ayBr" placeholder="<?=lang('Email')?>">                
              </div>
              <div class="col-md-2">
                <select  class="form-control ayBr" name="gender" id="gender">
                  <option value="" selected="selected"><?=lang('Gender')?></option>
                  <option <?php if($this->input->get('gender')=="Male") echo "selected='selected'"?> value="Male"><?=lang('Male')?></option>
                  <option <?php if($this->input->get('gender')=="Female") echo "selected='selected'"?> value="Female"><?=lang('Female')?></option>
                  <option <?php if($this->input->get('gender')=="Other") echo "selected='selected'"?> value="Other"><?=lang('Other')?></option>
                      
                  </select>             
              </div>
              
              <div class="col-md-2">
                <select  class="form-control ayBr" name="city" id="city">
                  <option value="" selected="selected"><?=lang('City')?></option>
                      <?php if($cities_res): foreach($cities_res as $cities):?>
                        <option <?php if($this->input->get('city')==$cities->city_name) echo "selected='selected'"?> value="<?php echo $cities->city_name;?>"><?php echo $cities->city_name;?></option>
                      <?php endforeach; endif;?>
                  </select>
              </div>

              <div class="col-md-1">
                <input type="submit" class="btn ayBr" value="<?=lang('Search')?>">
                <center><small style="font-size: 12px;"><a href="<?=base_url().'export/applications'.$gets?>"><i class="fa fa-file-excel-o"></i> <?=lang('Export')?></a></small></center>
                <center><small style="font-size: 12px;"><a target="_blank" href="<?=base_url().'print/applications'.$gets?>"><i class="fa fa-print"></i> <?=lang('Print')?></a></small></center>
              </div>
          </form> 
              <div class="clear"></div>
            </div><hr/>
          <div class="row">
            <div class="col-md-12">
              <?php if($this->session->userdata('message')){ 
            $this->session->unset_userdata('message');
            ?><div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a> <strong><?=lang('Success')?>!</strong> <?=lang('Job application status updated successfully')?>. </div><?php } ?>
              <ul class="myjobList">
                <li class="row">
                  <div class="col-md-1"><strong><?=lang('Ref.')?></strong></div>
                  <div class="col-md-2"><strong><?=lang('Candidate Name')?></strong></div>
                  <div class="col-md-4"><strong><?=lang('Job Title')?></strong></div>
                  <div class="col-md-2"><strong><?=lang('Applied Date')?></strong></div>
                  <div class="col-md-2"><strong><?=lang('Actions')?></strong></div>
                  <div class="col-md-1"><strong></strong></div>
                </li>
                <?php if($result_applied_jobs): 
		  			foreach($result_applied_jobs as $row_applied_job):
		  ?>
           <?php 
             if($row_applied_job->withdraw==1) goto nd;
            ?>


                <li class="row">
                  <div class="col-md-1"><small><a style="font-size: 13px; color: #6b6b6b;" href="<?php echo base_url('candidate/'.$this->custom_encryption->encrypt_data($row_applied_job->job_seeker_ID));?>" target="_blank">#JS<?=str_repeat("0",5-strlen($row_applied_job->job_seeker_ID)).$row_applied_job->job_seeker_ID?></a></small></div>
                  <div class="col-md-2"><a href="<?php echo base_url('candidate/'.$this->custom_encryption->encrypt_data($row_applied_job->job_seeker_ID));?>"><?php echo $row_applied_job->first_name.' '.$row_applied_job->last_name;?></a></div>

                  <div class="col-md-4"><a href="<?php echo base_url('jobs/'.$row_applied_job->job_slug);?>"><?php echo $row_applied_job->job_title;?></a><br/><?php if($row_applied_job->answer!="") echo "<a style='color:green;font-size:15px;' href='#' onclick=\"$('#answers_$row_applied_job->ID').modal('show');\">Answers</a>";if( ($row_applied_job->skills_level!="" || $row_applied_job->file_name!="") && $row_applied_job->answer!="") echo '<br/>';?>
                    <?php if($row_applied_job->skills_level!="") echo "<a style='color:green;font-size:15px;' href='#' onclick=\"$('#skills_level_$row_applied_job->ID').modal('show');\">Skills Level</a>";if($row_applied_job->file_name!="" && $row_applied_job->skills_level!="") echo '<br/>';?>
                    <?php 
                    if($row_applied_job->file_name!="")
                    {
                      $filenames=explode("$*_,_*$", $row_applied_job->file_name);
                      for($i=0;$i<count($filenames);$i++)
                      {
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='./download/".$filenames[$i]."'>".lang('Attached file')." ".($i+1)."</a>"; 
                          if($i!=count($filenames)-1)
                            echo "<br/>";
                      }
                      if(count($filenames)==0)
                      {
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='./download/".$row_applied_job->file_name."'>".lang('Attached file')."</a>";  
                      }
                    }
                    ?>
                  </div>  
                  <div class="modal fade" id="skills_level_<?=$row_applied_job->ID?>">
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

                  <div class="modal fade" id="answers_<?=$row_applied_job->ID?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=$row_applied_job->first_name.' '.$row_applied_job->last_name.' - '.lang('Answers')?></h4>
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



                  <div class="col-md-2"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2"><a href="#" onclick="$('#add_calendar_<?=$row_applied_job->ID?>').modal('show')"><small><i class="fa fa-calendar"></i>&nbsp; <?=lang('Add')?></a></small> <a title="<?=lang('Edit job application status')?>" href="#" onclick="$('#edit_status_<?=$row_applied_job->ID?>').modal('show');" style="color: black;margin-left: 15px;"><i class="fa fa-edit"></i></a>
                    <br/><a href="#" onclick="$('#edit_status_<?=$row_applied_job->ID?>').modal('show');" style="color: red; cursor: pointer; font-size: 14px; font-weight: bold; margin-right: 15px!important;" ><?php if($row_applied_job->flag=="") echo lang("Primary"); else echo lang($row_applied_job->flag);?></a><a style="font-size: 16px;float: right;" title="<?=lang('See more details')?>" href="#" onclick="$('#job_details_<?=$row_applied_job->ID?>').modal('show');" style="color: #757575;"><i class="fa fa-eye"></i></a><br/>
                    <a href="<?= base_url('employer/application_attachments/'.$row_applied_job->ID)?>" target="_blank" style="color: blue; cursor: pointer; font-size: 14px;text-decoration: none; font-weight: bold; margin-right: 15px!important;" ><i class="fa fa-print"></i>&nbsp;Print all</a>
                    </div>
                    <div class="col-md-1">
                  <a href="<?= base_url('employer/job_applications/')?>delete/<?= $row_applied_job->ID ?>" style="color:red;cursor: pointer; font-size: 25px; font-weight: bold; " title="<?=lang('Delete')?>" onclick="return confirm('<?=lang('Are you sure you want to delete this item?')?>');" ><i class="fa fa-times"></i></a></div>
                  <?php
                  $rs=$this->db->query("SELECT * FROM calendar WHERE id_employer='".$id_employer_ID."' AND id_job_seeker='".$row_applied_job->seeker_ID."' ORDER BY id_calendar DESC LIMIT 1")->result();
                  if(count($rs)>0)
                  {
                    $rs=$rs['0'];
                    ?>
                  <div class="modal fade" id="add_calendar_<?=$row_applied_job->ID?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=lang('Add Event with this Candidate')?></h4>
                        </div>
                        <div class="modal-body">
                           <div class="col-md-12">
                             <div class="form-group">
                               <label><?=lang('Date')?></label> <input value="<?=date('Y-m-d',strtotime($rs->date))?>" type="date" id="date_<?=$rs->ID?>" required="required" class="form-control">
                             </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                <label><?=lang('Hour')?></label><input type="number" id="hour_<?=$rs->ID?>" required="required" value="<?php echo date('H',strtotime($rs->date));?>" class="form-control">
                              </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                              <label><?=lang('Minute')?></label> <input type="number" id="minute_<?=$rs->ID?>" required="required" value="<?php echo date('i',strtotime($rs->date));?>" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group" >
                              <label><?=lang('Notes')?></label> <textarea type="text" required="required" placeholder="<?=lang('Say something')?> ..." id="notes_<?=$rs->ID?>" class="form-control"><?=$rs->notes?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default"  data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                          <button type="button" class="btn btn-danger" onclick="showIt3(<?=$rs->id_calendar?>)"><?=lang('Delete')?></button>
                          <button type="button" name="submitter_af" id="submitter_af" onclick="showIt2('<?=$rs->id_calendar?>','<?=$row_applied_job->seeker_ID?>','<?=$id_employer_ID?>',$('#date_<?=$rs->ID?>').val(),$('#hour_<?=$rs->ID?>').val(),$('#minute_<?=$rs->ID?>').val(),$('#notes_<?=$rs->ID?>').val())" class="btn btn-success"><?=lang('Update')?></button>
                          <button type="button" name="submitter_af" id="submitter_af" onclick="showIt('<?=$row_applied_job->seeker_ID?>','<?=$id_employer_ID?>',$('#date_<?=$rs->ID?>').val(),$('#hour_<?=$rs->ID?>').val(),$('#minute_<?=$rs->ID?>').val(),$('#notes_<?=$rs->ID?>').val())" class="btn btn-warning"><?=lang('Add')?></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
                }
                  else
                  {
                    ?>
                    <div class="modal fade" id="add_calendar_<?=$row_applied_job->ID?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=lang('Add Event with this Candidate')?></h4>
                        </div>
                        <div class="modal-body">
                           <div class="col-md-12">
                             <div class="form-group">
                               <label><?=lang('Date')?></label> <input value="<?php echo date('Y-m-d');?>" type="date" required="required" id="date_<?=$row_applied_job->ID?>" class="form-control">
                             </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                <label><?=lang('Hour')?></label><input type="number" required="required" id="hour_<?=$row_applied_job->ID?>" value="10" class="form-control">
                              </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                              <label><?=lang('Minute')?></label> <input type="number" required="required" value="00" id="minute_<?=$row_applied_job->ID?>" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group" >
                              <label><?=lang('Notes')?></label> <textarea type="text" required="required" placeholder="<?=lang('Say something')?> ..." id="notes_<?=$row_applied_job->ID?>" class="form-control">Interview with <?php echo $row_applied_job->first_name.' '.$row_applied_job->last_name;?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" onclick="$('#add_calendar_<?=$row_applied_job->ID?>').modal('hide')"><?=lang('Close')?></button>
                          <button type="button" name="submitter_af" id="submitter_af" onclick="showIt('<?=$row_applied_job->seeker_ID?>','<?=$id_employer_ID?>',$('#date_<?=$row_applied_job->ID?>').val(),$('#hour_<?=$row_applied_job->ID?>').val(),$('#minute_<?=$row_applied_job->ID?>').val(),$('#notes_<?=$row_applied_job->ID?>').val())" class="btn btn-success"><?=lang('Add')?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                    <?php
                  }
                  ?>

                  <div class="modal fade" id="ifrm">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="title_link">Link</h4>
                        </div>
                        <div class="modal-body">
                           <iframe style="height: 500px;" class="form-control" id="iframe"></iframe> 
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" class="close" data-dismiss="modal"><?=lang('Go Back')?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="job_details_<?=$row_applied_job->ID?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=lang('Job Application Details')?></h4>
                        </div>
                        <form method="post" action="<?=base_url()?>employer/job_applications/update_details/<?=$row_applied_job->ID?>">
                        <div class="modal-body">
                            <div class="form-group" >
                            <label><?=lang('Cover leter')?></label> 
                            <textarea disabled="disabled" class="form-control"><?=$row_applied_job->cover_letter?></textarea>
                          </div>
                          <hr/>
                          <h4><?=lang('Personality test')?></h4><br/>
                          <div class="form-group" >
                            <label>Links</label> 
                            <select   name="links" id="links" class="form-control">
                              <option value=""><?=lang('Select a Link')?></option>
                              <option value="https://openpsychometrics.org/tests/IPIP-BFFM/"><?=lang('Big Five Personality Test')?></option>
                              <option value="https://openpsychometrics.org/tests/OEJTS/"><?=lang('Open Extended Jungian Type Scales')?></option>
                              <option value="https://openpsychometrics.org/tests/MGKT2/"><?=lang('Multifactor General Knowledge Test')?></option>
                            </select>
                          </div>
                          <button type="button" class="btn btn-primary" onclick="showMe('#job_details_<?=$row_applied_job->ID?>')"><?=lang('Open Link')?></button>
                          <button type="button" onclick="sendMe('<?=$row_applied_job->ID?>')" class="btn btn-success"><?=lang('Send')?></button>
                          <hr/>
                          <h4><?=lang('Update Rating/Comment')?></h4><br/>
                          <div class="form-group" >
                            <label>Rate</label> 
                            <select required="required" name="rate" class="form-control">
                              <option value=""><?=lang('Select a Rate')?></option>
                              <?php
                              for($i=1;$i<=10;$i++) {
                                $st="";
                                if($i==$row_applied_job->rate)
                                  $st="selected='selected'";
                                ?>
                                <option <?=$st?> value="<?=$i?>"><?=$i?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group" >
                            <label>Comment</label> 
                             <textarea required="required" name="comment" class="form-control"><?=$row_applied_job->comment?></textarea>
                          </div>
                          <hr>
                           <div class="form-group" >
                            <label><?=lang('Note')?></label> 
                            <textarea  name="Note" class="form-control"><?=$row_applied_job->note?></textarea>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" class="close" data-dismiss="modal"><?=lang('Close')?></button>
                          <button type="submit" class="btn btn-success"><?=lang('Update')?></button>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="edit_status_<?=$row_applied_job->ID?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=lang('Edit Status')?></h4>
                        </div>
                        <form method="post" action="<?=base_url()?>employer/job_applications/edit_status/<?=$row_applied_job->ID?>">
                        <div class="modal-body">
                            <div class="form-group" >
                            <label><?=lang('Status')?></label> 
                            <select name="status" class="form-control">
                              <option <?php if($row_applied_job->flag=="") echo "selected='selected'"; ?> value=""><?=lang('Primary')?></option>
                              <option <?php if($row_applied_job->flag=="Selection") echo "selected='selected'"; ?> value="Selection"><?=lang('Selection')?></option>
                              <option <?php if($row_applied_job->flag=="Interview") echo "selected='selected'"; ?>  value="Interview"><?=lang('Interview')?></option>
                              <option <?php if($row_applied_job->flag=="Success") echo "selected='selected'"; ?>  value="Success"><?=lang('Success')?></option>
                              <option <?php if($row_applied_job->flag=="Failure") echo "selected='selected'"; ?>  value="Failure"><?=lang('Failure')?></option>
                            </select>
                            <br/>
                            <h5>
                              <?=lang('NOTE : The job seeker will be notified once you change status of this application')?>
                            </h5>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" class="close" data-dismiss="modal"><?=lang('Close')?></button>
                          <button type="submit" class="btn btn-success"><?=lang('Update')?></button>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>

                </li>
                <?php 
                  nd:
                  if($row_applied_job->withdraw==0) goto lb;
                  ?>
                  <li class="row" id="aplied_<?php echo $row_applied_job->ID;?>">
                  <div class="col-md-1"><a href="<?= base_url('employer/job_applications/')?>delete/<?= $row_applied_job->ID ?>" onclick="return confirm('<?=lang('Are you sure you want to delete this item?')?>');" ><?=lang('Delete')?></a></div> 
                  <div class="col-md-1"><small>#JS<?=str_repeat("0",5-strlen($row_applied_job->job_seeker_ID)).$row_applied_job->job_seeker_ID?></small></div>
                  <div class="col-md-2"><span style="font-style: oblique;"><?php echo $row_applied_job->first_name.' '.$row_applied_job->last_name;?></span></div>
                   <div class="col-md-4"><span style="font-style: oblique;"><?php echo $row_applied_job->job_title;?></span>
                  </div>
                  <div class="col-md-2"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
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
      ntt=ntt.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'_');
      var dtl=new Date(dte);
      var newdtl=dtl.getUTCFullYear() + "-" + (dtl.getUTCMonth()+1) + "-" + dtl.getUTCDate() + " "+ hrs + ":" + tme + ":00";
      window.location="<?=base_url()?>employer/job_applications/add_Event/"+idj+"/"+ide+"/"+newdtl+"/"+ntt;
  }
  function showIt2(idc,idj,ide,dte,hrs,tme,ntt)
  {
      ntt=ntt.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,' ');
      var dtl=new Date(dte);
      var newdtl=dtl.getUTCFullYear() + "-" + (dtl.getUTCMonth()+1) + "-" + dtl.getUTCDate() + " "+ hrs + ":" + tme + ":00";
      window.location="<?=base_url()?>employer/job_applications/update_Event/"+idc+"/"+idj+"/"+ide+"/"+newdtl+"/"+ntt;
  }
  function showIt3(idc)
  {
    if(confirm("<?=lang('Do you really wanna delete this booking ?')?>"))
    {
      window.location="<?=base_url()?>employer/job_applications/delete_Event/"+idc;
    }
  }
  function showMe(md_id)
  {
    var lkn=$('#links').find(":selected").val();
    if(lkn!="")
    {
       $(md_id).modal('hide');
       $("#iframe").attr("src", lkn);
       $('#title_link').text($('#links').find(":selected").text());
       $('#ifrm').modal('show');
    }
  }
  function sendMe(jb_id)
  {
    var lkn=$('#links').find(":selected").val();
    if(lkn!="")
    {
      //https://openpsychometrics.org/tests/IPIP-BFFM/
      //https://openpsychometrics.org/tests/OEJTS/
      //https://openpsychometrics.org/tests/MGKT2/
       if(lkn=="https://openpsychometrics.org/tests/IPIP-BFFM/")
            lkn="1";
       else if(lkn=="https://openpsychometrics.org/tests/OEJTS/")
            lkn="2";
       else            
            lkn="3";
       window.location="<?=base_url()?>employer/job_applications/send_link/"+jb_id+"/"+$('#links').find(":selected").text()+"/"+lkn;
    }
    else
      alert("<?=lang('Choose a link !')?>");
  }
</script>
</body>
</html>