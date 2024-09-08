<?php 
     if($this->session->userdata("sessIsJobSeeker") == 1)
            $staticUrl = STATICWEBSEEKERURL; 
           $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div class="d-none d-md-block web-sidebar bg-white vheight-100">

    <div class="d-flex bg-blue text-white py-2 px-3">
         <?php 
         $data=array();
        $data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);
        //myPrint($data);die;
                        $defaultUser = $staticUrl."/images/user.png";
                        $imgUrl = "";
                        $pht=$data->photo;
                       /* if($pht=="") $pht='no_pic.jpg';
                             $imgUrl = base_url('public/uploads/candidate/'.$pht);*/
                            $defaultUser = $staticUrl."/images/user.png";
                            $imgUrl = "";
                            //$pht=$photoData->photo;
                            if($pht!="" && file_exists('public/uploads/candidate/'.$pht)) 
                                $imgUrl = PUBLICURL.'/uploads/candidate/'.$pht;
                            else
                                $imgUrl= $defaultUser; 
                    ?>
    <div class="profile-pic d-flex align-items-center mr-auto">
        <div class="profile-div  mr-3"><img src="<?php echo $imgUrl; ?>" alt="img"></div><span class="align-middle font-med pro-name">My Profile</span>
       <!--  <div class="profile-div  mr-3"><img src="<?php //echo $staticUrl; ?>/images/photo.png alt="img"></div><span class="align-middle font-med pro-name">My Profile</span>" -->
    </div>
    <div class="ml-auto d-flex align-items-center"><a href="#" class="py-0" onclick="openNav()"><img src="<?php echo $staticUrl; ?>/images/setting.svg" class=""></a></div>
    </div>
    <ul class="second-nav web-nav">
              <li><a href="<?php echo WEBURL; ?>/seeker/home"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/home2.svg"><?=lang('Home')?></a></li>
    <li><a href="<?php echo WEBURL; ?>/seeker/search"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/search.svg"><?=lang('Search')?></a></li>
    <li><a href="<?php echo WEBURL; ?>/seeker/job/wishlist-jobs"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/wish-list2.svg"><?=lang('Wishlist')?></a></li>
    <li><a href="<?php echo WEBURL; ?>/seeker/my-account"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/user21.svg"><?=lang('Manage Account')?></a></li>
    <li><a href="<?php echo WEBURL; ?>/seeker/my-cv"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/cv.svg"><?=lang('My CV')?></a></li>
     <?php 
                       $chatCount = $this->seeker_library->get_chat_count();
                     
                       ?>
    <li><a href="<?php echo WEBURL; ?>/seeker/messenger"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/messenger21.svg"><?=lang('Messenger')?> <?php if($chatCount){ ?>(<?php echo $chatCount; ?>)<?php } ?></a></li>
    <li><a href="<?php echo WEBURL; ?>/seeker/tutorials"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/tutorial2.svg"><?=lang('Employer Showcase')?></a></li>
    <li><a href="<?php echo WEBURL; ?>/tutorialadmin"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial2.svg"><?=lang('Tutorials')?></a></li>
    <!--   <li><a href="web-my-company.php"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/cv.svg">My Company</a></li> -->
    <?php 
        $notfCount = $this->seeker_library->get_notification_count();
     ?>

    <li><a href="<?php echo WEBURL; ?>/seeker/notification"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/bell2.svg"><?=lang('Notification')?><?php if($notfCount){?>(<?php echo $notfCount;?>)<?php } ?></a></li>
    <li><a href="<?php echo WEBURL; ?>/login/logout"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/lock2.svg"><?=lang('Logout')?></a></li>
    </ul>
    <div id="mySidenav" class="sidenav vheight-100 box-shadow">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="dropdown show px-3">
        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">lang</a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <?php
            $rows_ln=$this->db->query("SELECT * FROM tbl_lang")->result();
          
            foreach($rows_ln as $row_ln)
            {
            ?>
               <a  class="dropdown-item" style="font-size: 14px;text-decoration: none;" href="<?=WEBURL?>/lang/<?=$row_ln->Abbreviation?>?url=<?=$actual_link?>"><?=$row_ln->Name?></a>
            <?php
            }
            ?>
            <a  class="dropdown-item" style="font-size: 14px;text-decoration: none;" href="<?=WEBURL?>/lang/en?url=<?=$actual_link?>">English</a>
        </div>
    </div>
    <ul class="setting-nav py-3 px-3">
        <li><a href="<?php echo WEBURL; ?>/seeker/settings/show-applications"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/Applications.svg"><?=lang('Applications')?></a></li>
        <!-- <li><a href="pins.php"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/pins.svg">Pins</a></li> -->
        <li><a href="<?php echo WEBURL; ?>/seeker/my-cv/add-skills"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/skills.svg"><?=lang('Skills')?></a></li>
        <li><a href="<?php echo WEBURL; ?>/seeker/request"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/saved-Candidates.svg"><?=lang('Requests')?></a></li>
        <li><a href="<?php echo WEBURL; ?>/seeker/calender"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/Calendar.svg"><?=lang('Calendar')?></a></li>
        <li><a href="<?php echo WEBURL; ?>/seeker/setpassword/change-password"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/pwd.svg"><?=lang('Change Password')?></a></li>
    </ul>
    </div>
</div>

