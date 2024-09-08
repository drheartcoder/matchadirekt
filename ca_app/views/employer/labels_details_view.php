<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
<style type="text/css"> .formwraper p{font-size:13px;}</style>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header-->
<div class="container detailinfo">
  <div class="row">
  <div class="col-md-3">
  <div class="dashiconwrp">
    <?php $this->load->view('employer/common/employer_menu');?>
  </div>
  </div>
  
    <div class="col-md-9"> 
    <?php echo $this->session->flashdata('msg');?>
      <!--Job Application-->
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-8"><b><?=$rowLabel->label?></b></div>
            <div class="col-md-4 text-right"><a href="javascript:;" class="upload_cv" title="<?=lang('Go Back')?>"><i class="fa fa-angle-double-left">&nbsp;</i></a>&nbsp;<a href="<?=base_url()?>employer/labels" class="upload_cv" title="<?=lang('Go Back')?>"><?=lang('Go Back')?></a> </div>
          </div>
        </div>
        <!--Job Description-->
        <div class="row searchlist"> 
          <br/>
          <!--Job Row-->
          <?php 
          $i=0;
          if($un=="true")
            goto ena;
         if($results):
          foreach($results as $row):
          $title="";$url="";$type=lang("seeker");
          if($row->fk_type=="job_seekers")
          {
              //$decrypted_id = $this->custom_encryption->decrypt_data($id);
              $jobseeker = $this->job_seekers_model->get_job_seeker_by_id($row->fk_id);
              if(!$jobseeker)
                goto endddd;
              $title=$jobseeker->first_name." ".$jobseeker->last_name;
              $url=base_url().'candidate/'.$this->custom_encryption->encrypt_data($row->fk_id);
          }
          else if($row->fk_type=="post_jobs")
          {
              $posted_job = $this->posted_jobs_model->get_active_posted_job_by_id($row->fk_id);
              if(!$posted_job)
                goto endddd;
              $title=$posted_job->job_title;$type=lang("job");
              $url=base_url().'jobs/'.$posted_job->job_slug;
          }
          ?>
          <div class="col-md-12">
            <div class="intlist">
              <div class="col-md-12">
                <div class="col-md-5"> <a href="<?=$url?>" class="jobtitle"><?php echo word_limiter(strip_tags($title),9);?> &nbsp;<small style="font-size: 12px;">(<?=$type?>)</small></a>
                </div>
                  <div class="col-md-3">
                    <div class="date"><?php echo date_formats($row->created_at, 'd M Y');?></div>
                  </div>
              <div class="col-md-4 pull-right text-right">
               <?php if($row->fk_type=="post_jobs" && $posted_job->sts=="archive") { ?>
                <div class="col-md-2 pull-right text-right">
                  <a href="javascript:;" onclick="showMe('<?php echo $posted_job->ID;?>')" style="text-decoration:none;" title="<?=lang('Restore')?>"><span class="label label-success"><?=lang('Restore')?></span></a> 
                </div>
                <?php } ?>
                <div class="col-md-2 pull-right text-right">
                  <a href="javascript:;" onclick="$('#delete_label_<?=$row->ID?>').modal('show')" style="text-decoration:none;margin-left: -20px;" title="<?=lang('Delete')?>"><span class="label label-danger"><?=lang('Delete')?></span></a> 
                </div>
              </div>
                    <div class="modal fade" id="delete_label_<?=$row->ID?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title"><?=lang('Delete')?></h4>
                            </div>
                            <div class="modal-body" style="min-height: 70px;">
                               <div class="col-md-12">
                                 <div class="form-group">
                                   <h3><?=lang('Do you wanna really delete this item')?> ?</h3>
                                 </div>
                               </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                              <button type="button" onclick="location.href='<?=base_url()?>employer/labels/label_details_del/<?=$row->ID?>'" class="btn btn-danger"><?=lang('Delete')?></button>
                            </div>
                          </div>
                        </div>
                      </div>

                <div class="clear"> </div>
                  <br/>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          <?php 
          endddd:
          endforeach;
         else:     
        ?>
          <div align="center" class="text-red"><?=lang('No item found')?>.</div>
        <?php endif;
          ena:
          if($un=="true")
          {
            foreach ($results as $row) {
              $title=$row->job_title;$type=lang("job");
              $url=base_url().'jobs/'.$row->job_slug;
          ?>
           <div class="col-md-12">
            <div class="intlist">
              <div class="col-md-12">
                <div class="col-md-5"> <a href="<?=$url?>" class="jobtitle"><?php echo word_limiter(strip_tags($title),9);?> &nbsp;<small style="font-size: 12px;">(<?=$type?>)</small></a>
                </div>
                  <div class="col-md-3">
                    <div class="date"><?php echo date_formats($row->dated, 'd M Y');?></div>
                  </div>
                  <div class="col-md-4 pull-right text-right">
                    <div class="col-md-2 pull-right text-right">
                      <a href="javascript:;" onclick="showMe('<?php echo $row->ID;?>')" style="text-decoration:none;" title="<?=lang('Restore')?>"><span class="label label-success"><?=lang('Restore')?></span></a> 
                    </div>
                    <div class="col-md-2 pull-right text-right">
                      <a href="javascript:;" onclick="$('#add_archive_<?php echo $row->ID;?>').modal('show')" style="text-decoration:none;margin-left: -20px;" title="<?=lang('Add')?>"><span class="label label-primary"><?=lang('Add')?></span></a> 
                    </div>
                  </div>
                  <div class="modal fade" id="add_archive_<?php echo $row->ID;?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?=lang('Choose Label')?></h4>
                        </div>
                        <form action="<?=base_url()?>employer/labels/label_details_add/<?=$row->ID?>/post_jobs" method="post">
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
                      </div>

                <div class="clear"> </div>
                  <br/>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          <?php
            }
          }
          ?>
        </div>
        <br/>
      </div>
    </div>
    <!--/Job Detail-->
    
    <!--Pagination-->
    
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<!-- Profile Popups -->
<?php $this->load->view('employer/common/employers_popup_forms'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script>
<script type="text/javascript">
  function showMe(idc)
  {
    if(confirm("<?=lang('Do you really wanna restore this job')?> ?"))
    {
       window.location="<?=base_url()?>employer/my_posted_jobs/archive_job/"+idc+"/POO/active";
    }
  }
</script>
</body>
</html>