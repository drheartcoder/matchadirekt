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
            <div class="col-md-8"><b><?=lang('Interview')?></b></div>
            <div class="col-md-4 text-right"><a href="javascript:;" onclick="$('#add_interview').modal('show')" class="upload_cv" title="<?=lang('Add Interview')?>"><?=lang('Add Interview')?></a> <a href="javascript:;" class="upload_cv" title="<?=lang('Add Interview')?>"><i class="fa fa-plus-square">&nbsp;</i></a></div>
          </div>
        </div>
        <div class="modal fade" id="add_interview">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Add Interview')?></h4>
                </div>
                <form action="<?=base_url()?>employer/interview/add" method="post">
              <div class="modal-body" style="min-height: 180px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Title')?></label> 
                       <input value="" type="text" name="pageTitle" required="required" class="form-control">
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Slug')?></label> 
                       <input value="" type="text" name="pageSlug" required="required" class="form-control">
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Content')?></label> 
                       <textarea type="text" id="editor0" name="pageContent" required="required" class="form-control"><?php echo file_get_contents(base_url().'qcsh/default_interview.html');?></textarea>
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
        <!--Job Description-->
        <div class="row searchlist"> 
          <br/>
          <!--Job Row-->
          <?php 
          $i=0;
         if($results):
          foreach($results as $row):
          ?>

    <div class="modal fade" id="ifrm_<?=$row->ID?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="title_link"><?=$row->pageTitle?></h4>
          </div>
          <div class="modal-body">
             <iframe src="<?=base_url().'/ja_in/'.$row->pageSlug?>" style="height: 500px;" class="form-control">
             </iframe> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" class="close" data-dismiss="modal"><?=lang('Close')?></button>
          </div>
        </div>
      </div>
    </div>

          <div class="col-md-12">
            <div class="intlist">
              <div class="col-md-12">
                <div class="col-md-8"> <a href="#" onclick="$('#ifrm_<?=$row->ID?>').modal('show')" class="jobtitle"><?php echo word_limiter(strip_tags($row->pageTitle),9);?></a>
                </div>
                <div class="col-md-4">
                
                  <div class="col-md-2 pull-right text-left"> 
                  <a style="margin-left: 10px;" href="javascript:;" onclick="$('#update_interview_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Edit')?>"><span class="label label-primary"><?=lang('Edit')?></span></a> </div>
                  <div class="col-md-2 pull-right text-right"> 
                  <a href="javascript:;" onclick="$('#delete_label_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Delete')?>"><span class="label label-danger"><?=lang('Delete')?></span></a> 
                  </div>
                  
        <div class="modal fade" id="update_interview_<?=$row->ID?>"> 
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Update Interview')?></h4>
                </div>
                <form action="<?=base_url()?>employer/interview/update/<?=$row->ID?>" method="post">
                <div class="modal-body" style="min-height: 180px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Title')?></label> 
                       <input value="<?=$row->pageTitle?>" type="text" name="pageTitle" required="required" class="form-control">
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Slug')?></label> 
                       <input value="<?=$row->pageSlug?>" type="text" name="pageSlug" required="required" class="form-control">
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Content')?></label> 
                       <textarea type="text" id="editor<?=$row->ID?>" name="pageContent" required="required" class="form-control"><?=$row->pageContent?></textarea>
                     </div>
                   </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                  <button type="submit" class="btn btn-success"><?=lang('Update')?></button>
                </div>
                </form>
              </div>
            </div>
          </div>
        <div class="modal fade" id="delete_label_<?=$row->ID?>">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Delete Interview')?></h4>
                </div>
                <div class="modal-body" style="min-height: 70px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <h3><?=lang('Do you wanna really delete this interview')?> <b>'<?=$row->pageTitle?>'</b> ?</h3>
                     </div>
                   </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                  <button type="button" onclick="location.href='<?=base_url()?>employer/interview/delete/<?=$row->ID?>'" class="btn btn-danger"><?=lang('Delete')?></button>
                </div>
              </div>
            </div>
          </div>

                  <div class="col-md-8">
                    <div class="date"><?php echo date_formats($row->created_at, 'd M Y');?></div>
                  </div>
                </div>
                <div class="clear"> </div>
              </div>
              <div class="clear"></div>
            </div><br/>
          </div>
          <?php 
          endforeach;
         else:     
        ?>
          <div align="center" class="text-red"><?=lang('No Interview found')?>.</div>
        <?php endif;?>
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
<script src="<?php echo base_url('public/js/admin/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script>
<script type="text/javascript">     
  
  $(function() {
   var editor = CKEDITOR.replace('editor0');
    });

  <?php
  foreach($results as $row):
  ?>  
  $(function() {
   var editor = CKEDITOR.replace('editor<?=$row->ID?>');
    });
  <?php
  endforeach;
  ?>
  </script>
</body>
</html>