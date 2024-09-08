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
    <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
      <!--Job Application-->
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><b><?=lang('All Posted Jobs')?></b></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="row searchlist"> 
          <br/>
          <!--Job Row-->
          <?php 
         if($result_posted_jobs):
          foreach($result_posted_jobs as $row_jobs):
            if($row_jobs->sts=="archive")
              goto enddd;
          ?>
          <div class="col-md-12" id="pj_<?php echo $row_jobs->ID;?>">
            <div class="intlist">
              <div class="col-md-12">
                <div class="col-md-7"> <a href="<?php echo base_url('jobs/'.$row_jobs->job_slug);?>" class="jobtitle"><?php echo word_limiter(strip_tags($row_jobs->job_title),9);?></a>
                  <div class="location"><a href="<?php echo base_url('company/'.$row->company_slug);?>"><?php echo $row->company_name;?></a> &nbsp;-&nbsp; <?php echo $row_jobs->city;?></div>
                </div>
                <div class="col-md-2">
                  <div class="date"><?php echo date_formats($row_jobs->dated, 'd M Y');?></div>
                </div>
                <div class="col-md-3">                
                  <div class="col-md-1 pull-right text-right">  
                  <a href="<?php echo base_url('employer/edit_posted_job/'.$row_jobs->ID);?>" title="<?=lang('Edit')?>" class="edit-ico"><i class="fa fa-pencil">&nbsp;</i></a>
                </div>
                  <div class="col-md-1 pull-right text-right">  
                  <a href="#" onclick="$('#add_archive_<?php echo $row_jobs->ID;?>').modal('show')" style="text-decoration:none;float: right;margin-right: 21px;" title="<?php echo lang('Add to Archive');?>"><span class="label label-primary"><?=lang('archive')?></span></a>
                  </div>
<div class="modal fade" id="add_archive_<?php echo $row_jobs->ID;?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?=lang('Choose Label')?></h4>
        </div>
        <form action="<?=base_url()?>employer/labels/label_details_add/<?=$row_jobs->ID?>/post_jobs" method="post">
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

                  <div class="col-md-1 pull-right text-right">  
                  <?php if($row_jobs->sts=='pending'):?>
                    <span class="label label-warning"><?=lang('Pending Review')?></span>
                  <?php else:?>
                  <a href="javascript:;" style="text-decoration:none;margin-left: 10px;" id="sts_<?php echo $row_jobs->ID;?>" onClick="update_posted_job_status_employer(<?php echo $row_jobs->ID;?>);" title="<?php echo ($row_jobs->sts=='active')?lang('Set This Job as Draft'):lang('Post This Job');?>"><span class="label label-<?php echo ($row_jobs->sts=='active')?'success':'danger';?>"><?php echo $row_jobs->sts=='inactive'?lang('draft'): lang($row_jobs->sts);?></span></a>
                  <?php endif;?>                  
                  </div>
                  
                </div>
                <div class="clear"> </div>
                <p><?php echo word_limiter(strip_tags($row_jobs->job_description),20);?></p>
              </div><br/>
              <div class="clear"></div>
            </div>
          </div>
          <?php 
            enddd:
          endforeach;
         else:          
        ?>
          <div align="center" class="text-red"><?=lang('No job posted')?>.</div>
          <?php endif;?>
        </div><br/>
      </div>
      <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
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
  function showIt(idc)
  {
    if(confirm("<?=lang('Do you really wanna archive this job ?')?>"))
    {
      window.location="<?=base_url()?>employer/my_posted_jobs/archive_job/"+idc;
    }
  }
</script>
</body>
</html>