<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>

<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                if($returnTo ==1){
                    $redirectUrl =  WEBURL."/employer/application";
                } else if($returnTo ==2){
                    $redirectUrl =  WEBURL."/employer/invitations";
                } else {
                    $redirectUrl = WEBURL."/employer/candidate/wishlisted-candidates";
                }
                ?>

                <a href="<?php echo $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('View Candidates')?></h2>
            </div>
        </div>
        <?php if(isset($candidateDetails) && $candidateDetails !=''){
    //myPrint($candidateDetails);exit;
            ?>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="media-body">
                                    <div class="row align-items-center">
                                     <div class="col-12 card-title mb-0">
                                        <a href="<?php echo WEBURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($candidateDetails->ID); ?>/4/<?php echo $jobData->ID;?>">

                                            <?php echo $candidateDetails->first_name;?></a>
                                        </div>

                                         <?php if(isset($latest_job_title) && $latest_job_title !=''){
                                                   // myPrint($jobData);exit; 
                                            ?>
                                        <div class="col-12 card-title mb-3"><a href="<?php echo WEBURL; ?>/employer/job/view-job/<?php echo $jobData->ID;?>/3/0/<?php echo $candidateDetails->ID; ?>"><?php echo $jobData->job_title; ?></a></div>
                                    <?php } ?>
                                        <div class="col-12 mb-2">
                                            <ul>
                                                <li class="h6">Ref. : <span>#JS<?=str_repeat("0",5-strlen($candidateDetails->ID)).$candidateDetails->ID?></span></li>
                                                <?php 
                                                if($applied_job_title != ""){
                                                    ?>
                                                    <li class="h6"><?=lang('Apply Date:')?> <span><?php echo date_formats($applied_job_title->dated, 'M d, Y') ; ?></span></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>

                                        <?php 
                                        $rs=$this->db->query("SELECT * FROM calendar WHERE id_employer='".$this->sessUserId."' AND id_job_seeker='".$candidateDetails->ID."' ORDER BY id_calendar DESC LIMIT 1")->result();

                                        if(isset($rs) && $rs != "" && isset($rs[0]) && $rs[0] != ""){
                                            ?>
                                            <form action="<?php echo WEBURL; ?>/employer/candidate/update-event/<?php echo $candidateDetails->ID; ?>/<?php echo $jobData->ID; ?>/<?php echo $applicationId; ?>" class="col-12" method="POST">
                                                <div class="row">
                                                    <div class="col-12 card-title mb-0 mb-1"><?=lang('Update Event with ')?> <?php echo $candidateDetails->first_name;?></div>
                                                    <div class="form-group col-12 mb-3">
                                                        <label for="txtDate">Event Date</label>
                                                        <input type="date" class="form-control" placeholder="Date" name="txtDate" id="txtDate" value="<?php echo explode(" ", $rs[0]->date)[0]; ?>">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <label for="txtTime">Event Time</label>
                                                        <input type="time" class="form-control" placeholder="Time" name="txtTime" id="txtTime" value="<?php echo explode(" ", $rs[0]->date)[1]; ?>"> 
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <label for="txtNote">Event Note</label>
                                                        <input type="text" class="form-control" placeholder="Notes" name="txtNote" id="txtNote" value="<?php echo $rs[0]->notes; ?>">
                                                        <input type="hidden" name="calId" id="calId" value="<?php echo $rs[0]->id_calendar; ?>">
                                                        <input type="hidden" name="calId" id="calId" value="<?php echo $rs[0]->id_calendar; ?>">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <button type="submit" class="btn btn-blue" name="txtBtnSubmit" id="txtBtnSubmit"><?=lang('Update')?></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <?php //echo $candidateDetails->ID; echo $jobData->ID; echo $applicationId;exit; ?>
                                             <form action="<?php echo WEBURL; ?>/employer/candidate/add-event/<?php echo $candidateDetails->ID; ?>/<?php echo $jobData->ID; ?>/<?php echo $applicationId; ?>" class="col-12" method="POST">
                                                <div class="row">
                                                    <div class="col-12 card-title mb-0"><?=lang('Add Event with ')?> <?php echo $candidateDetails->first_name;?></div>
                                                    <div class="form-group col-12 mb-3">
                                                        <label for="txtDate">Event Date</label>
                                                        <input type="date" class="form-control" placeholder="Date" name="txtDate" id="txtDate">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <label for="txtTime">Event Time</label>
                                                        <input type="time" class="form-control" placeholder="Time" name="txtTime" id="txtTime">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                         <label for="txtNote">Event Note</label>
                                                        <input type="text" class="form-control" placeholder="Notes" name="txtNote" id="txtNote">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <button type="submit" class="btn btn-blue" name="txtBtnAdd" id="txtBtnAdd">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-12 card-title mb-0"><a href=""><?=lang('Edit Status')?></a></div>
                                        <div class="form-group col-12 mb-3">
                                            <select class="form-control" onchange="changeStatus();" name="status" id="status">
                                                <option value="Primary" <?php if(isset($applied_job_title) && $applied_job_title != "" && $applied_job_title->flag == "Primary")echo "selected"; ?> >Primary</option>
                                                <option value="Selection" <?php if(isset($applied_job_title) && $applied_job_title != "" && $applied_job_title->flag == "Selection")echo "selected"; ?> >Selection</option>
                                                <option value="Interview" <?php if(isset($applied_job_title) && $applied_job_title != "" && $applied_job_title->flag == "Interview")echo "selected"; ?> >Interview</option>
                                                <option value="Success" <?php if(isset($applied_job_title) && $applied_job_title != "" && $applied_job_title->flag == "Success")echo "selected"; ?> >Success</option>
                                                <option value="Failure" <?php if(isset($applied_job_title) && $applied_job_title != "" && $applied_job_title->flag == "Failure")echo "selected"; ?> >Failure</option>
                                            </select>
                                            <span></span>
                                        </div>
                                        <div class="col-12">
                                            <p><?=lang('NOTE: The job seeker will be notified once you change status of this application')?></p>
                                        <div class="form-group col-12 mb-3">
                                        </div>
                                           <!--  <a href="<?php //echo WEBURL; ?>/employer/job/view-job" class="btn btn-blue">Application Details</a> -->
                                            <a href="<?php echo WEBURL; ?>/employer/job/view-job/<?php echo $jobData->ID;?>/3/0/<?php echo $candidateDetails->ID; ?>" class="btn btn-blue"><?=lang('Application Details')?></a> 
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    </div>
</div>
    </div>
    <!-- container -->
</section>
<!-- section -->

<?php $this->load->view('newweb/inc/footer'); ?>

<script type="text/javascript">
    function changeStatus(){
        var status = $("#status").val();
        var myKeyVals = { "status" : status  };
        $.ajax({
              type: 'POST',
              url: "<?php echo WEBURL.'/employer/candidate/change-status/'.$candidateDetails->ID.'/'.$jobData->ID; ?>",
              data: myKeyVals,
              dataType: "text",
              success: function(resultData) { 
                console.log(resultData);
                   // window.location.reload();
            }
        });
    }   

</script>