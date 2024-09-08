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
            <div class="col-md-8"><b><?=lang('All Labels')?></b></div>
            <div class="col-md-4 text-right"><a href="javascript:;" onclick="$('#add_label').modal('show')" class="upload_cv" title="<?=lang('Add Label')?>"><?=lang('Add Label')?></a> <a href="javascript:;" class="upload_cv" title="<?=lang('Add Label')?>"><i class="fa fa-plus-square">&nbsp;</i></a></div>
          </div>
        </div>
        <div class="modal fade" id="add_label">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Add Label')?></h4>
                </div>
                <form action="<?=base_url()?>employer/labels/add" method="post">
              <div class="modal-body" style="min-height: 180px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Label')?></label> 
                       <input value="" type="text" name="label" required="required" class="form-control">
                     </div>
                     <div class="form-group">
                       <label><?=lang('Description')?></label> 
                       <textarea type="text" name="description" class="form-control"></textarea>
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
          <div class="col-md-12">
            <div class="intlist">
              <div class="col-md-12">
                <div class="col-md-8"> <a href="<?php echo base_url('employer/label_details/'.$row->ID);?>" class="jobtitle"><?php echo word_limiter(strip_tags($row->label),9);?></a>
                </div>
                <?php if($row->ID==0) goto prv; ?>
                <div class="col-md-4">
                
                  <div class="col-md-2 pull-right text-left"> 
                  <a style="margin-left: 10px;" href="javascript:;" onclick="$('#update_label_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Edit')?>"><span class="label label-primary"><?=lang('Edit')?></span></a> </div>
                  <div class="col-md-2 pull-right text-right"> 
                  <a href="javascript:;" onclick="$('#delete_label_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Delete')?>"><span class="label label-danger"><?=lang('Delete')?></span></a> 
                  </div>
                  
        <div class="modal fade" id="update_label_<?=$row->ID?>"> 
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Update Label')?></h4>
                </div>
                <form action="<?=base_url()?>employer/labels/update/<?=$row->ID?>" method="post">
                <div class="modal-body" style="min-height: 180px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Label')?></label> 
                       <input value="<?=$row->label?>" type="text" name="label" required="required" class="form-control">
                     </div>
                     <div class="form-group">
                       <label><?=lang('Description')?></label> 
                       <textarea type="text" name="description" class="form-control"><?=$row->description?></textarea>
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
                  <h4 class="modal-title"><?=lang('Delete Label')?></h4>
                </div>
                <div class="modal-body" style="min-height: 70px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <h3><?=lang('Do you wanna really delete this Label')?> <b>'<?=$row->label?>'</b> ?</h3>
                     </div>
                   </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                  <button type="button" onclick="location.href='<?=base_url()?>employer/labels/delete/<?=$row->ID?>'" class="btn btn-danger"><?=lang('Delete')?></button>
                </div>
              </div>
            </div>
          </div>

                  <div class="col-md-8">
                    <div class="date"><?php echo date_formats($row->created_at, 'd M Y');?></div>
                  </div>
                </div>
                <?php prv: ?>
                <div class="clear"> </div>
                  <?php if($row->ID==0) echo"<hr style='margin-top: 10px; margin-bottom: 10px;'/>"; else echo "<br/>"; ?>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          <?php 
          endforeach;
         else:     
        ?>
          <div align="center" class="text-red"><?=lang('No Label found')?>.</div>
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
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script>
</body>
</html>