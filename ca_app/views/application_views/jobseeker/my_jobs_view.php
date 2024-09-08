<?php $this->load->view('application_views/common/header'); ?>
           
              <ul class="myjobList">
                <?php if($result_applied_jobs): 
		  			foreach($result_applied_jobs as $row_applied_job):
		  ?>
            <?php 
            if($row_applied_job->withdraw==1) goto nd;
            ?>
                  
                  
                  
                <li class="full_row" id="aplied_<?php echo $row_applied_job->applied_id;?>" style="
                border: 0;margin:auto; border-bottom: 1px solid gray;    padding: 16px;
                box-shadow: 0 0 3px 1px;">
                    
                    
                <div class="full_row" style="padding: 3px;">
                       <a onclick="Confirm('Do you really wanna withraw this Application ?',function(result){if (result) {window.location='<?=base_url()?>app/jobseeker/my_jobs/withdraw/<?php echo $row_applied_job->applied_id;?>';}});" style="cursor:pointer;font-size: 12px;" class="icon_a" ><?=lang('Withdraw')?></a>
                  &nbsp;&nbsp;&nbsp; 
                    <span style="color: #5d6063; cursor: pointer; font-size: 14px; font-weight: bold; margin-right: 15px!important;" class="icon_a"><?php if($row_applied_job->flag=="") echo lang("Primary"); else echo $row_applied_job->flag;?></span><a href="javascript:;" onClick="del_applied_job(<?php echo $row_applied_job->applied_id;?>);" title="Delete" style="float:right" class="delete-ico icon_a"><i class="fa fa-times">&nbsp;</i> <small>delete</small></a><hr/>
                    </div>
                    
                    
                    <div class="full_row"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                    
                  <div class="full_row">
                      <div><h4><i class="fa fa-caret-right"></i> <?=lang('Job')?> </h4></div>
                      <a ><?php echo $row_applied_job->job_title;?></a></div>
                   <div class="full_row">
                       <div><h4><i class="fa fa-caret-right"></i> <?=lang('Company Infos')?> </h4></div>
                       <a><?php echo $row_applied_job->company_name;?></a>
                       <br/><?php if($row_applied_job->answer!="") echo "<a style='color: green;
                        font-size: 15px;
                        padding: 10px 0 10px 0;
                        display: block;
                        ' href='#' onclick=\"$('#answers_$row_applied_job->ID').show();\">".lang('Answers')."</a>";?>
                        <?php if($row_applied_job->skills_level!="") echo "<a style='color: darkblue;
                        font-size: 15px;
                        padding: 10px 0 10px 0;
                        display: block;
                        ' href='#' onclick=\"$('#skills_level_$row_applied_job->ID').modal('show');\">".lang('Skills Level')."</a>";
                        if($row_applied_job->skills_level!="") echo '<br/>';//$row_applied_job->file_name!="" && ?>
                    <?php 
                    // if($row_applied_job->file_name!="")
                    // {
                    //   $filenames=explode("$*_,_*$", $row_applied_job->file_name);
                    //   for($i=0;$i<count($filenames);$i++)
                    //   {
                    //       echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a  style='color:darkgreen!important;font-size: 13px!important;padding: 10px 0 10px 0;' href='./show/".$filenames[$i]."'>Attached file ".($i+1)."</a>"; 
                    //       if($i!=count($filenames)-1)
                    //         echo "<br/>";
                    //   }
                    //   if(count($filenames)==0)
                    //   {
                    //       echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a   style='color:darkgreen!important;font-size: 13px!important;' href='./show/".$row_applied_job->file_name."'>".lang('Attached file')."</a>";  
                    //   }
                    // }
                    ?>
                  </div>

                 <div class="model_app" id="answers_<?=$row_applied_job->ID?>">
                      <div class="top_header">
                  <center><div class="title_page"><?php echo lang('Answers');?></div></center>
                   <span type="button" class="close_app_model" data-dismiss="modal"><i class="fa fa-times"></i></span>
               </div>
                     
                    <div class="">
                      <div class="">
                        <div class="modal-header">
                         
                          <h4 class="modal-title"><?=$row_applied_job->job_title.' - '.lang('Answers')?></h4>
                        </div>
                        <div class="modal-body">
                          <div>
                            <?=$row_applied_job->answer?>
                          </div>
                        </div>
                        <div class="modal-footer">
                          
                        </div>
                      </div>
                    </div>
                  </div>

                <div class="model_app" id="skills_level_<?=$row_applied_job->ID?>">
                      <div class="top_header">
                  <center><div class="title_page"><?php echo lang('Skills Level');?></div></center>
                   <span type="button" class="close_app_model" data-dismiss="modal"><i class="fa fa-times"></i></span>
               </div>
                     
                    <div class="">
                      <div class="">
                        <div class="modal-header">
                         
                          <h4 class="modal-title"><?=$row_applied_job->job_title.' - '.lang('Skills Level')?></h4>
                        </div>
                        <div class="modal-body">
                          <div>
                            <?=$row_applied_job->skills_level?>
                          </div>
                        </div>
                        <div class="modal-footer">
                          
                        </div>
                      </div>
                    </div>
                  </div>
               
                </li>
                  <br/>
                <?php 
                  nd:
                  if($row_applied_job->withdraw==0) goto lb;
                  ?>
                  <li class="row" id="aplied_<?php echo $row_applied_job->applied_id;?>">
                  <div class="col-md-4"><a style="font-style: oblique;"><?php echo $row_applied_job->job_title;?></a></div>
                   <div class="col-md-4"><a style="font-style: oblique;"><?php echo $row_applied_job->company_name;?></a>
                  </div>
                  <div class="col-md-2 text-right"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2 text-right"><i style="color:gray;font-size: 12px;" ><?=lang('Withdrawn')?></i>&nbsp;&nbsp;&nbsp; <a href="javascript:;" onClick="del_applied_job(<?php echo $row_applied_job->applied_id;?>);" title="Delete" class="delete-ico"><i class="fa fa-times">&nbsp;</i></a></div>
                </li>
                  <?php
                  lb:
                 ?>
                <?php 	endforeach; 
		  		else:?>
                <?=lang('No record found')?>!
                <?php endif;?>
              </ul>
           
            
            
            
            
         
      
  
    <!--/Job Detail--> 
    
    <!--Pagination-->
    <div class="paginationWrap"> <?php echo ($result_applied_jobs)?$links:'';?> </div>

<script src="<?php echo base_url('public/js/jquery-1.11.0.js');?>" type="text/javascript"></script> 
<script type="text/javascript">
    $(".close_app_model").click(function(){
    $('.model_app').hide();
        }); 
</script>
 
<?php $this->load->view('application_views/common/footer_app'); ?>