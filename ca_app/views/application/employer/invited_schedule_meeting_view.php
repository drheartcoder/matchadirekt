<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                    $redirectUrl =  APPURL."/employer/invitations";
                ?>

                <a href="<?php echo $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">View Candidates</h2>
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
                                        <a href="<?php echo APPURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($candidateDetails->ID); ?>/5/0/<?php echo $employer_id;?>/<?php echo $jobseeker_id;?>">

                                            <?php echo $candidateDetails->first_name;?></a>
                                        </div>

                                         <?php if(isset($latest_job_title) && $latest_job_title !=''){ ?>
                                        <div class="col-12 card-title mb-3"><?php echo $latest_job_title->job_title; ?></div>
                                        <?php } ?>
                                        <?php 
                                        $rs=$this->db->query("SELECT * FROM calendar WHERE id_employer='".$this->sessUserId."' AND id_job_seeker='".$candidateDetails->ID."' ORDER BY id_calendar DESC LIMIT 1")->result();

                                        if(isset($rs) && $rs != "" && isset($rs[0]) && $rs[0] != ""){
                                            ?>
                                            <form action="<?php echo APPURL; ?>/employer/invitations/update-event" class="col-12" method="POST">
                                                <div class="row">
                                                    <div class="col-12 card-title mb-0">Update Event with  <?php echo $candidateDetails->first_name;?></div>
                                                    <div class="form-group col-12 mb-3">
                                                        <input type="date" class="form-control" placeholder="Date" name="txtDate" id="txtDate" value="<?php echo explode(" ", $rs[0]->date)[0]; ?>">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <input type="time" class="form-control" placeholder="Time" name="txtTime" id="txtTime" value="<?php echo explode(" ", $rs[0]->date)[1]; ?>"> 
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <input type="text" class="form-control" placeholder="Notes" name="txtNote" id="txtNote" value="<?php echo $rs[0]->notes; ?>">
                                                        <input type="hidden" name="calId" id="calId" value="<?php echo $rs[0]->id_calendar; ?>">
                                                        <input type="hidden" name="calId" id="calId" value="<?php echo $rs[0]->id_calendar; ?>">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <button type="submit" class="btn btn-blue" name="txtBtnSubmit" id="txtBtnSubmit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                             <form action="<?php echo APPURL; ?>/employer/invitations/add-event/<?php echo $candidateDetails->ID; ?>" class="col-12" method="POST">
                                                <div class="row">
                                                    <div class="col-12 card-title mb-0">Add Event with  <?php echo $candidateDetails->first_name;?></div>
                                                    <div class="form-group col-12 mb-3">
                                                        <input type="date" class="form-control" placeholder="Date" name="txtDate" id="txtDate">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <input type="time" class="form-control" placeholder="Time" name="txtTime" id="txtTime">
                                                        <span></span>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
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
                                    </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="<?php echo APPURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data($candidateDetails->ID); ?>/5/0/<?php echo $employer_id;?>/<?php echo $jobseeker_id;?>" class="btn btn-blue">Candidate Details</a> 
                                            </div>
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
    <!-- container -->
</section>
<!-- section -->

<?php $this->load->view('application/inc/footer'); ?>

<script type="text/javascript">
    /*function changeStatus(){
        var status = $("#status").val();
        var myKeyVals = { "status" : status,  };
        $.ajax({
              type: 'POST',
              url: "<?php // echo APPURL.'/employer/candidate/change-status/'.$candidateDetails->ID.'/'.$jobData->ID; ?>",
              data: myKeyVals,
              dataType: "text",
              success: function(resultData) { 
                console.log(resultData);
                   // window.location.reload();
            }
        });
    } */  

</script>