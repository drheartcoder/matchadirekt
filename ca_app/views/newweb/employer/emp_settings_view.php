<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo WEBURL.'/employer/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
    //myPrint($_SESSION);exit;

//myPrint($candidateDetails);die;?>
<section>
    <div class="main-container vheight-100 h-100">
        <div class="col-12 col-md-11 col-lg-8 mx-auto">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Settings')?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
              <ul class="setting-nav py-3">
                    <li><a href="<?php echo WEBURL; ?>/employer/job/add-new-job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('New Job')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('My Jobs')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/application"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('Applications')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/candidate/wishlisted-candidates"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/saved-Candidates.svg"><?=lang('Saved Candidates')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/tutorials"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg"><?=lang('Employer showcase')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/invitations"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Invitations.svg"><?=lang('Invitations')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/quizzes"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Quizzes.svg"><?=lang('Quizzes')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/interview"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Interview.svg">Interview</a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/job-analysis"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Job-Analysis.svg"><?=lang('Job Analysis')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/certificate"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('Employer Certificate')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/calendar"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Calendar.svg"><?=lang('Calendar')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/archives"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Archive.svg"><?=lang('Archive')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/statistics"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Statistics.svg"><?=lang('Statistics')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/setpassword/change_password"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/pwd.svg"><?=lang('Change Password')?></a></li>
                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>