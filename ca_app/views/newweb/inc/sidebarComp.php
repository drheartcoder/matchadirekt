<?php 
     if($this->session->userdata("sessIsJobSeeker") == 1){
            $staticUrl = STATICWEBSEEKERURL; 
     }
        else // if($this->session->userdata("sessIsEmployer") == 1)
           { $staticUrl = STATICWEBCOMPURL;}

        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<div class="d-none d-md-block web-sidebar bg-white vheight-100">

    <div class=" d-flex bg-blue text-white py-2 px-3">

        <?php 
         $data=array();
        $data = $this->employers_model->get_employer_by_id($this->sessUserId);
       // $data = $this->My_model->getSingleRowData('tbl_job_seekers',"","ID = ".$this->sessUserId);
        //myPrint($data);die;
                        $defaultUser = $staticUrl."/images/user.svg";
                        $imgUrl = "";
                        $pht=$data->company_logo;
                       /* if($pht=="") $pht='no_pic.jpg';
                             $imgUrl = base_url('public/uploads/candidate/'.$pht);*/
                            $defaultUser = $staticUrl."/images/user.svg";
                            $imgUrl = "";
                            //$pht=$photoData->photo;
                            if($pht!="" && file_exists('public/uploads/employer/'.$pht)) 
                                $imgUrl = PUBLICURL.'/uploads/employer/'.$pht;
                            else
                                $imgUrl= $defaultUser; 
                    ?>
        <div class="profile-pic d-flex align-items-center mr-auto">
        <div class="profile-div  mr-3"><img src="<?php echo  $imgUrl; ?>" alt="img"></div><span class="align-middle font-med pro-name"><?=lang('My Profile')?></span>
    </div>
        <div class="ml-auto d-flex align-items-center"><a href="#" class="py-0" onclick="openNav()"><img src="<?php echo  $staticUrl; ?>/images/setting.svg"  class=""></a></div>
    </div>
    <ul class="second-nav web-nav">
        <li><a href="<?php echo WEBURL; ?>/employer/home"><img class="mr-3" src="<?php echo $staticUrl; ?>/images/home.svg"><?=lang('Home')?></a></li>
        <li><a href="<?php echo WEBURL; ?>/employer/search"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/search.svg"><?=lang('Search')?></a></li>
        <li><a href="<?php echo WEBURL; ?>/employer/my-account"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/user21.svg"><?=lang('Manage Account')?></a></li>
        <li><a href="<?php echo WEBURL; ?>/employer/company"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/cv.svg"><?=lang('My Company')?></a></li>
          <?php  $notfCount = $this->employer_library->get_notification_count(); ?>
        <li><a href="<?php echo WEBURL; ?>/employer/notification"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/bell2.svg"><?=lang('Notification')?><?php 
                    if($notfCount){  ?>(<?php echo $notfCount; ?>)<?php } ?></a></li>
        <?php  $msgcount = $this->employer_library->get_chat_count(); ?>
        <li><a href="<?php echo WEBURL; ?>/employer/messenger"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/messenger21.svg"><?=lang('Messenger')?><?php if($msgcount){  ?>(<?php echo $msgcount; ?>)<?php } ?></a></li>
      <!--   <li><a href="web-job-tiles.php"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/wish-list2.svg">Wishlist</a></li> -->
        <!--   <li><a href="my-company.php"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/company.svg">My Company</a></li> -->
        <li><a href="<?php echo WEBURL; ?>/tutorialadmin"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial2.svg"><?=lang('Tutorials')?></a></li>
        <li><a href="<?php echo WEBURL; ?>/login/logout"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/lock2.svg"><?=lang('Logout')?></a></li>
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
                        <li><a href="<?php echo WEBURL; ?>/employer/job/add-new-job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('New Job')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('My Jobs')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/application"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('Applications')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/candidate/wishlisted-candidates"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/saved-Candidates.svg"><?=lang('Saved Candidates')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/tutorials"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg"><?=lang('Employer Showcase')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/invitations"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Invitations.svg"><?=lang('Invitations')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/quizzes"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Quizzes.svg"><?=lang('Quizzes')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/interview"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Interview.svg"><?=lang('Interview')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/job-analysis"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Job-Analysis.svg"><?=lang('Job Analysis')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/certificate"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('Employer Certificate')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/calendar"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Calendar.svg"><?=lang('Calendar')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/archives"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Archive.svg"><?=lang('Archive')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/statistics"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Statistics.svg"><?=lang('Statistics')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/setpassword/change-password"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/pwd.svg"><?=lang('Change Password')?></a></li>
                    </ul>
                  

    </div>
</div>

<!-- <script type="text/javascript">
// $(document).ready(function(){
//     setColor();
//     $('#dropdownMenuLink .dropdown-menu a.dropdown-item').change(function(){
//          setColor();       
//     });
//  });

// function setColor()
// {
//    var color =  $('#dropdownMenuLink .dropdown-menu').find('a.dropdown-item').attr('value');
//    $('a.dropdown-item').css('background', color); 
// }

$(document).ready(function() {
   $('#dropdownMenuLink .dropdown-menu a.dropdown-item').css('color','gray');
   $('#dropdownMenuLink .dropdown-menu a.dropdown-item').change(function() {
      var current = $('#dropdownMenuLink .dropdown-menu a.dropdown-item').val();
      if (current != 'null') {
          $('#dropdownMenuLink .dropdown-menu a.dropdown-item').css('color','black');
      } else {
          $('#dropdownMenuLink .dropdown-menu a.dropdown-item').css('color','gray');
      }
   }); 
});

</script> -->
