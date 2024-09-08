<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>

<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/seeker/home" class="d-block">
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
                    <li><a href="<?php echo WEBURL; ?>/seeker/settings/show-applications"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('Applications')?></a></li>
                    <!-- <li><a href="pins.php"><img class="mr-3" src="<?php //echo  $staticUrl; ?>/images/pins.svg">Pins</a></li> -->
                    <li><a href="<?php echo WEBURL; ?>/seeker/my-cv/add-skills"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/skills.svg"><?=lang('Skills')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/seeker/request"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/saved-Candidates.svg"><?=lang('Requests')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/seeker/calender"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Calendar.svg"><?=lang('Calendar')?></a></li>
                     <li><a href="<?php echo WEBURL; ?>/seeker/setpassword/change-password"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/pwd.svg"><?=lang('Change Password')?></a></li>
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
<?php $this->load->view('newweb/inc/footer'); ?>