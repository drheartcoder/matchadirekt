<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php $staticUrl = STATICWEBCOMPURL; ?>

<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/archives" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?php echo ucfirst($rowLabel->label); ?> Archives</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php
                            if($results){
                                foreach($results as $row){ 
                                  //  myPrint($row);
                                    $posted_job = $this->posted_jobs_model->get_active_posted_job_by_id($row->fk_id);
                                    $title=$posted_job->job_title;
                                   // myPrint($posted_job);
                                    //$type=lang("job");
                                    //$url=base_url().'jobs/'.$posted_job->job_slug;
                                    if($posted_job->ID > 0){

                            ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="edit-block">
                                    <ul>
                                         <?php if($row->fk_type=="post_jobs" && $posted_job->sts=="archive") { ?>
                                         <li><a href="<?php echo WEBURL; ?>/employer/archives/restore/<?php echo $posted_job->ID; ?>/<?php echo $row->label_id; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/trash-restore.svg" class="w-100"></a></li>
                                        <?php } ?>
                                        <li><a href="<?php echo WEBURL; ?>/employer/archives/delete-detail-archive-job/<?php echo $row->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <a class="media" href="#view-job">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-0"><a href="<?php echo WEBURL; ?>/employer/job/view-job/<?php echo $posted_job->ID; ?>/2/<?php echo $row->label_id; ?>"><?php echo  $title; ?></a></div>
                                            <p class="col-6 text-d-grey mb-0"><?php echo date_formats($row->created_at, 'd M Y'); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php        
                                    }
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
    </div>
    </div>
    <!-- container -->
</section>
<!-- section -->

<?php $this->load->view('newweb/inc/footer'); ?>