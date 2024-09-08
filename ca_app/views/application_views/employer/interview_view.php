
<?php $this->load->view('application_views/common/header_emp'); ?>

<!--/Header-->

  
    <?php echo $this->session->flashdata('msg');?>
   
            <div style="padding-bottom:10px;"><a href="javascript:;" onclick="$('#add_interview').modal('show')" class="upload_cv" title="<?=lang('Add Interview')?>"><?=lang('Add Interview')?></a> <a href="javascript:;" class="upload_cv" title="<?=lang('Add Interview')?>"><i class="fa fa-plus-square">&nbsp;</i></a></div>
         
        <div class="modal fade" id="add_interview">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Add Interview')?></h4>
                </div>
                <form action="<?=base_url()?>app/employer/interview/add" method="post">
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
                       <input value="" type="text" name="pageSlug" id="pageSlug" required="required" class="form-control">
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

          <!--Job Row-->
          <?php 
          $i=0;
         if($results):?>
                      
                 <table class="table_list" cellsspacing="10"> 
              <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>        
           <?php foreach($results as $row):
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

          <tr>
           
              <td><a href="#" onclick="$('#ifrm_<?=$row->ID?>').modal('show')" class="jobtitle"><?php echo word_limiter(strip_tags($row->pageTitle),9);?></a></td>
              
              <td><?php echo date_formats($row->created_at, 'd M Y');?></td>
              <td><a style="" href="javascript:;" onclick="$('#update_interview_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Edit')?>"><span class="label label-primary"><?=lang('Edit')?></span></a>
              
              <a href="javascript:;" onclick="$('#delete_label_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Delete')?>"><span class="label label-danger"><?=lang('Delete')?></span></a> 
              </td>
              
              
        <div class="modal fade" id="update_interview_<?=$row->ID?>"> 
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Update Interview')?></h4>
                </div>
                <form action="<?=base_url()?>app/employer/interview/update/<?=$row->ID?>" method="post">
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
                  <button type="button" onclick="location.href='<?=base_url()?>app/employer/interview/delete/<?=$row->ID?>'" class="btn btn-danger"><?=lang('Delete')?></button>
                </div>
              </div>
            </div>
          </div>

                <div class="clear"> </div>
            
              <div class="clear"></div>
           
          </tr>
          <?php 
          endforeach;
         else:     
        ?>
          <div align="center" class="text-red"><?=lang('No Interview found')?>.</div>
        <?php endif;?>
       


    <!--/Job Detail-->
    
    <!--Pagination-->


<script src="http://vps537003.ovh.net/public/js/jquery-1.11.0.js" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/admin/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script>
<script type="text/javascript">     

  $("#pageSlug").keypress(function(e){
        var input =  $("#pageSlug").val();
        var regExp = "^[A-Z0-9a-z]*$";
        var match = input.match(regExp);
        if (!match){
            input=input.slice(0,-1);
            $("#pageSlug").val(input);
        }
  });
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
<?php $this->load->view('application_views/common/footer_app'); ?>