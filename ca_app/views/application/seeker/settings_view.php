<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>

<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/home" class="d-block">
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
                    <li><a href="<?php echo APPURL; ?>/seeker/settings/show-applications"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg">Applications</a></li>
                    <!-- <li><a href="pins.php"><img class="mr-3" src="<?php //echo  $staticUrl; ?>/images/pins.svg">Pins</a></li> -->
                    <li><a href="<?php echo APPURL; ?>/seeker/my-cv/add-skills"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/skills.svg">Skills</a></li>
                    <li><a href="<?php echo APPURL; ?>/seeker/request"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/saved-Candidates.svg">Requests</a></li>
                    <li><a href="<?php echo APPURL; ?>/seeker/calender"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Calendar.svg">Calendar</a></li>
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