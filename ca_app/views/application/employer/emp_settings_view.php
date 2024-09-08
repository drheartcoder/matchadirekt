<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo APPURL.'/employer/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;

//myPrint($candidateDetails);die;?>
<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Settings</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
              <ul class="setting-nav py-3">
                    <li><a href="<?php echo APPURL; ?>/employer/job/add-new-job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg">New Job</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg">My Jobs</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/application"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg">Applications</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/candidate/wishlisted-candidates"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/saved-Candidates.svg">Saved Candidates</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/tutorials"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg">Tutorials</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/invitations"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Invitations.svg">Invitations</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/quizzes"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Quizzes.svg">Quizzes</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/interview"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Interview.svg">Interview</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/job-analysis"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Job-Analysis.svg">Job Analysis</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/certificate"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg">Employer Certificate</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/calendar"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Calendar.svg">Calendar</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/archives"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Archive.svg">Archive</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/statistics"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Statistics.svg">Statistics</a></li>
                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>