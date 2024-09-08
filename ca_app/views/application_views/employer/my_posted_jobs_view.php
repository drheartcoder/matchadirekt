
<?php $this->load->view('application_views/common/header_emp'); ?>
  
    <?php echo $this->session->flashdata('msg');?>
    <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
      <!--Job Application-->
        <!--Job Description-->
        <ul class="myjobList">
          <!--Job Row-->
            <?php $rest=''; ?>
          <?php 
         if($result_posted_jobs):
          foreach($result_posted_jobs as $row_jobs):
            if($row_jobs->sts=="archive")
              goto enddd;
          ?>
          <li class="full_row" id="pj_<?php echo $row_jobs->ID;?>" style="
                border: 0;margin:auto; border-bottom: 1px solid gray;    padding: 16px;
                box-shadow: 0 0 3px 1px;">
              <div class="option_div" style="
                width: 100%;
                margin-top: -10px;
                margin-bottom: 15px;
                float: right;
                text-align: right;">
                  
                  <a href="#" onclick="$('#add_archive_<?php echo $row_jobs->ID;?>').modal('show')" title="<?php echo lang('Add to Archive');?>" style="margin-right: 12px;"><span class="label label-primary"><?=lang('archive')?></span></a>
                  
                  <a href="<?php echo base_url('app/employer/edit_posted_job/index/'.$row_jobs->ID);?>" title="<?=lang('Edit')?>" class="" style="border: 1px solid;
                    border-radius: 5px;
                    position: absolute;
                    padding: 3px 8px;
                    background-color: white;
                    right: 25px;">
                      <i class="fa fa-pencil"></i></a>
                  
                  <?php if($row_jobs->sts=='pending'):?>
                    <span class="label label-warning" style="float: left;
                                margin-left: -16px;
                                margin-top: -6px;
                border-radius: 0 0 5px 0;"><?=lang('Pending Review')?></span>
                  <?php else:?>
                              <a href="javascript:;" style="text-decoration:none;margin-left: 10px;" id="sts_<?php echo $row_jobs->ID;?>" onClick="update_posted_job_status_employer(<?php echo $row_jobs->ID;?>);" title="<?php echo ($row_jobs->sts=='active')?lang('Set This Job as Draft'):lang('Post This Job');?>"><span class="label label-<?php echo ($row_jobs->sts=='active')?'success':'danger';?>" style="float: left;
                                margin-left: -16px;
                                margin-top: -6px;
                border-radius: 0 0 5px 0;"><?php echo $row_jobs->sts=='inactive'?lang('draft'): lang($row_jobs->sts);?></span></a>
                  <?php endif;?>  
               </div>
              
              <div class="full_row"><?php echo date_formats($row_jobs->dated, 'd M Y');?></div>
                
              <div class="full_row">
                  <div><h4><i class="fa fa-caret-right"></i> <?=lang('Job')?> </h4></div>
                <a href="<?php echo base_url('app/job_details/index/'.$row_jobs->job_slug);?>" class="jobtitle"><?php echo word_limiter(strip_tags($row_jobs->job_title),9);?></a>
              </div>
                
               <div class="full_row">
                   <div><h4><i class="fa fa-caret-right"></i> <?=lang('Location')?> </h4></div>
                 <a href="<?php echo base_url('app/company/index/'.$row->company_slug);?>"><?php echo $row->company_name;?></a> &nbsp;-&nbsp; <?php echo $row_jobs->city;?>
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

                   
                  
              
              <?php if(strlen($row_jobs->job_description)>20) {
                                  $rest = substr($row_jobs->job_description, 0, 20).' ...';
                       }
                     else{
                         $rest = $row_jobs->job_description;
                     }
                     ?>
                <div class="clear"> </div>
               <div class="full_row" style="margin-bottom: 15px;">
                   <div><h4><i class="fa fa-caret-right"></i> <?=lang('Description')?> </h4></div>
                <p><?=$rest?></p>
              </div>
              
              
              <div class="clear"></div>
            
          </li>
              <br/>       
          <?php 
            enddd:
          endforeach;
         else:          
        ?>
          <div align="center" class="text-red"><?=lang('No job posted')?>.</div>
          <?php endif;?>
        </ul>
      <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
    <!--/Job Detail-->
    
    <!--Pagination-->
    
<?php $this->load->view('application_views/common/footer_app'); ?>