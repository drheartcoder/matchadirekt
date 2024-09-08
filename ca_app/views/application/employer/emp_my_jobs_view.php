<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php $staticUrl = STATICAPPCOMPURL; ?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/settings" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">My Jobs</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php 
                            if(isset($jobList) && $jobList != ""){
                                foreach($jobList as $job){
                                  //myPrint($job);exit;
                                    ?>
                                    <li class="py-3 align-items-center px-3 bdr-btm">
                                        <div class="edit-block">
                                            <ul>
                                                <li><a href="#"  onclick="$('#add_archive_<?php echo $job->ID;?>').modal('show')"  class="bg-d-blue"><img src="<?php echo  $staticUrl; ?>/images/archive-white.svg" class="w-100"></a></li>
                                                <li><a href="<?php echo APPURL; ?>/employer/job/delete-job/<?php echo $job->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                                <li><a href="<?php echo APPURL; ?>/employer/job/edit/<?php echo $job->ID; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                                <?php
                                                  if($job->sts == "inactive")  {
                                                    ?>
                                                    <li><a href="<?php echo APPURL; ?>/employer/job/change-status/<?php echo $job->ID; ?>" class="bg-success" title="active"><img src="<?php echo  $staticUrl; ?>/images/active.svg" class="w-100"></a></li>
                                                    <?php
                                                  }
                                                ?>
                                                <?php
                                                  if($job->sts == "active"){
                                                    ?>
                                                    <li><a href="<?php echo APPURL; ?>/employer/job/change-status/<?php echo $job->ID; ?>" class="bg-warning" title="draft"><img src="<?php echo  $staticUrl; ?>/images/draft.svg" class="w-100"></a></li>
                                                    <?php
                                                  }                                                  
                                                ?>

                                            </ul>
                                        </div>
                                        <a class="media" href="<?php echo APPURL; ?>/employer/job/view-job/<?php echo $job->ID; ?>">
                                            <div class="media-body">
                                                <div class="row align-items-center">
                                                    <div class="col-6 card-title mb-0"><?php echo $job->job_title; ?>
                                                        <p class="last-msg mb-0"><?php echo $job->company_name; ?></p>
                                                        <p class="text-d-grey mb-0"><?php echo date('d M Y',strtotime($job->dated)); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="modal fade" id="add_archive_<?php echo $job->ID;?>">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h4 class="modal-title"><?=('Choose Label')?></h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <form action="<?=APPURL?>/employer/labels/label-details-add/<?=$job->ID?>/post_jobs" method="post">
                                              <div class="modal-body" style="min-height: 100px;">
                                                   <div class="col-md-12">
                                                     <div class="form-group">
                                                       <label><?=('Label')?></label> 
                                                       <select class="form-control" name="label" required="required">
                                                         <option value=""><?=('Choose Label')?></option>
                                                         <?php
                                                         $result_labels=$this->db->query("SELECT * FROM tbl_labels WHERE company_id=".$this->sessUserId." AND deleted='0'")->result();
                                                         foreach ($result_labels as $row2) {
                                                           ?><option value="<?=$row2->ID?>"><?=$row2->label?></option><?php
                                                         }
                                                         ?>
                                                       </select>
                                                     </div>
                                                   </div>
                                              </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=('Close')?></button>
                                                  <button type="submit" class="btn btn-success"><?=('Add')?></button>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                    </li>

                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<?php $this->load->view('application/inc/footer'); ?>