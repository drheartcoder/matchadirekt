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
            <div class="col-md-8"><b><?=lang('All Quizzes')?></b></div>
            <div class="col-md-4 text-right"><a href="javascript:;" onclick="$('#add_quizz').modal('show')" class="upload_cv" title="<?=lang('Add Quizz')?>"><?=lang('Add Quizz')?></a> <a href="javascript:;" class="upload_cv" title="<?=lang('Add Quizz')?>"><i class="fa fa-plus-square">&nbsp;</i></a></div>
          </div>
        </div>
        <div class="modal fade" id="add_quizz">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Add Quizz')?></h4>
                </div>
                <form action="<?=base_url()?>employer/quizzes" method="post">
              <div class="modal-body" style="min-height: 240px;">
                   <div>
                     <label class="input-group-addon"><?=lang('Title')?></label>
                      <input name="title" class="form-control" placeholder="<?=lang('Title')?>" required="required"/><hr/>
                     <label class="input-group-addon"><?=lang('Quizz Text')?></label>
                      <textarea name="quizz" class="form-control" cols="60" rows="5" required="required" ></textarea>
                      <input name="answer1" type="text" class="form-control" required="required" placeholder="<?=lang('Answer')?> 1" id="answer_1" value="">
                      <input name="answer2" type="text" class="form-control" required="required" placeholder="<?=lang('Answer')?> 2" id="answer_2" value="">
                      <input name="answer3" type="text" class="form-control" required="required" placeholder="<?=lang('Answer')?> 3" id="answer_3" value="">
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
                <div class="col-md-8"><?php echo word_limiter(strip_tags($row->title),9);?>
                </div>
                <div class="col-md-4">
                
                  <div class="col-md-2 pull-right text-left"> 
                  <a style="margin-left: 10px;" href="javascript:;" onclick="$('#update_quizz_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Edit')?>"><span class="label label-primary"><?=lang('Edit')?></span></a> </div>
                  <div class="col-md-2 pull-right text-right"> 
                  <a href="javascript:;" onclick="$('#delete_quizz_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Delete')?>"><span class="label label-danger"><?=lang('Delete')?></span></a> 
                  </div>
                  
        <div class="modal fade" id="update_quizz_<?=$row->ID?>"> 
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Update Quizz')?></h4>
                </div>
                <form action="<?=base_url()?>employer/quizzes/update/<?=$row->ID?>" method="post">
                <div class="modal-body" style="min-height: 240px;">
                   <div>
                     <label class="input-group-addon"><?=lang('Title')?></label>
                      <input value="<?=$row->title?>" name="title" class="form-control" placeholder="<?=lang('Title')?>" required="required"/><hr/>
                     <label class="input-group-addon"><?=lang('Quizz Text')?></label>
                      <textarea name="quizz" class="form-control" cols="60" rows="5" required="required" ><?=$row->quizz?></textarea>
                      <input name="answer1" type="text" class="form-control" required="required" placeholder="<?=lang('Answer')?> 1" id="answer_1" value="<?=$row->answer1?>">
                      <input name="answer2" type="text" class="form-control" required="required" placeholder="<?=lang('Answer')?> 2" id="answer_2" value="<?=$row->answer2?>">
                      <input name="answer3" type="text" class="form-control" required="required" placeholder="<?=lang('Answer')?> 3" id="answer_3" value="<?=$row->answer3?>">
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
        <div class="modal fade" id="delete_quizz_<?=$row->ID?>">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Delete Quizz')?></h4>
                </div>
                <div class="modal-body" style="min-height: 70px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <h3><?=lang('Do you wanna really delete this Quizz')?> <b>'<?=$row->title?>'</b> ?</h3>
                     </div>
                   </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                  <button type="button" onclick="location.href='<?=base_url()?>employer/quizzes/delete/<?=$row->ID?>'" class="btn btn-danger"><?=lang('Delete')?></button>
                </div>
              </div>
            </div>
          </div>

                  <div class="col-md-8">
                    <div class="date"><?php echo date_formats($row->created_at, 'd M Y');?></div>
                  </div>
                </div>
                <div class="clear"> </div>
                <br/>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          <?php 
          endforeach;
         else:     
        ?>
          <div align="center" class="text-red"><?=lang('No Quizz found')?>.</div>
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