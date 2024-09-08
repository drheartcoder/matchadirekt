<?php $this->load->view('application_views/common/header_emp');?>
<!--/Header-->
   
    <?php echo $this->session->flashdata('msg');?>
      <!--Job Application-->
            <div class=""><a href="javascript:;" onclick="$('#add_quizz').modal('show')" class="upload_cv" title="<?=lang('Add Quizz')?>"><?=lang('Add Quizz')?></a> <a href="javascript:;" class="upload_cv" title="<?=lang('Add Quizz')?>"><i class="fa fa-plus-square">&nbsp;</i></a></div>

        <div class="modal fade" id="add_quizz">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Add Quizz')?></h4>
                </div>
                <form action="<?=base_url()?>app/employer/quizzes/add" method="post">
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
        
          <!--Job Row-->
          <?php 
          $i=0;
          $rest='';
         if($results):?>
             <table class="table_list" cellsspacing="10"> 
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>                                              
         <?php foreach($results as $row):
          ?>
              <tr>
                   <?php if(strlen($row->title)>9) {
                                  $rest = substr($row->title, 0, 9).' ...';
                       }
                     else{
                         $rest = $row->title;
                     }
                     ?>
                <td><?= $rest ?></td>
                <td><?php echo date_formats($row->created_at, 'd M Y');?></td>
                <td> <a style="margin-left: 10px;" href="javascript:;" onclick="$('#update_quizz_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Edit')?>"><span class="label label-primary"><?=lang('Edit')?></span></a>
                   <a href="javascript:;" onclick="$('#delete_quizz_<?=$row->ID?>').modal('show')" style="text-decoration:none;" title="<?=lang('Delete')?>"><span class="label label-danger"><?=lang('Delete')?></span></a>
                  </td>
            </tr>
           
        <div class="modal fade" id="update_quizz_<?=$row->ID?>"> 
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Update Quizz')?></h4>
                </div>
                <form action="<?=base_url()?>app/employer/quizzes/update/<?=$row->ID?>" method="post">
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
                  <button type="button" onclick="location.href='<?=base_url()?>app/employer/quizzes/delete/<?=$row->ID?>'" class="btn btn-danger"><?=lang('Delete')?></button>
                </div>
              </div>
            </div>
           </div>

                <div class="clear"> </div>
                <br/>
           
              <div class="clear"></div>
        
          <?php 
          endforeach;?>
            </table>
         <?php else:     
        ?>
          <div align="center" style="margin-top:50px;" class="text-red"><?=lang('No Quizz found')?>.</div>
        <?php endif;?>
        
        <br/>

    
    <!--/Job Detail-->
    
    <!--Pagination-->

<?php $this->load->view('application_views/common/footer_app');?>
