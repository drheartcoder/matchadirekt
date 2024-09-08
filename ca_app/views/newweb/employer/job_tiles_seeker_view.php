<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
    if(isset($data) && $data != ''){
    $recordCount= count($data);
    }else{
        $recordCount = 0;
    }
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   // myPrint($recordCount);exit;
?>
<!-- <?php //include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php //include 'web-sidebar.php'; ?>
</div> -->

<div class="d-block d-md-none container tiles-header pb-1">
        <div class="row bg-grey py-2 justify-content-between">
            <div class="col-4">
                <div class="dropdown show">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=lang('Eng')?></a>
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

                        <!-- <a class="dropdown-item" href="#"><?php // echo lang('Action')?></a>
                        <a class="dropdown-item" href="#"><?php // echo lang('Another action')?></a>
                        <a class="dropdown-item" href="#"><?php // echo lang('Something else here')?></a> -->
                    </div>
                </div>
            </div>
            <div class="col-4 text-right">
                <a href="<?php echo WEBURL.'/login/logout'; ?>">
                    <img src="<?php echo  $staticUrl; ?>/images/signout.svg" class="img-fluid">
                </a>
            </div>
        </div>
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a class="toggle d-block py-3">
                    <img src="<?php echo  $staticUrl; ?>/images/menu-bars.svg" class="menu-bar">
                </a>
            </div>
            <nav id="main-nav">

                <ul class="first-nav pb-3">
                    <li class="px-3 text-whit w-100">
                          <div class="user-profile-pic mb-2">
                     
                               <?php   $imgData=array();

       
                     $imgData = $this->employers_model->get_employer_by_id($this->sessUserId);
      
                        $defaultUser = $staticUrl."/images/user.svg";
                        $imgUrl = "";
                        $pht=$imgData->company_logo;
                       /* if($pht=="") $pht='no_pic.jpg';
                             $imgUrl = base_url('public/uploads/candidate/'.$pht);*/
                            $defaultUser = $staticUrl."/images/user.svg";
                            $imgUrl = "";
                            //$pht=$photoimgData->photo;
                            if($pht!="" && file_exists('public/uploads/employer/'.$pht)) 
                                $imgUrl = PUBLICURL.'/uploads/employer/'.$pht;
                            else
                                $imgUrl= $defaultUser;  ?>
                                <img src="<?php echo $imgUrl; ?>" class="w-100 h-100">
                            </div>
                         <div class="media-body text-center">   
                        <h5 class="font-med mb-0"><?php echo $companyData->company_name; ?></h5>
                        <h6 class="mb-0"><?php echo $companyData->industry; ?></h6>
                    </div>
                    </li>
                </ul>
                <!-- manu profile -->
                <ul class="second-nav py-4">
                    <li><a href="<?php echo WEBURL; ?>/employer/home"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/home.svg"><?=lang('
')?>Home<?=lang('
')?></a></li>
                                 <li><a href="<?php echo WEBURL; ?>/employer/search"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/search2.svg"><?=lang('Search')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/my-account"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/user.svg"><?=lang('Manage Account')?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/employer/company"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/company.svg"><?=lang('My Company')?></a></li>
                    <?php  $msgcount = $this->employer_library->get_chat_count();   ?>

                    <li><a href="<?php echo WEBURL; ?>/employer/messenger"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/messenger.svg"><?=lang('Messenger')?><?php if($msgcount){  ?>(<?php echo $msgcount; ?>)<?php } ?></a></li>
                    <li><a href="<?php echo WEBURL; ?>/tutorialadmin"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg"><?=lang('Tutorials')?></a></li>

                    <?php  $notfCount = $this->employer_library->get_notification_count(); ?> 

                    <li><a href="<?php echo WEBURL; ?>/employer/notification"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/bell.svg"><?=lang('Notification')?><?php 
                    if($notfCount){  ?>(<?php echo $notfCount; ?>)<?php } ?></a></li>
                    <li><a href="<?php echo WEBURL.'/login/logout'; ?>"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/lock.svg"><?=lang('Logout')?></a></li>
                </ul>
                <!-- nav ul list -->
            </nav>
            <!-- nav end -->
            <div class="col-5">
                <h2 class="mb-0"><?=lang('Matchadirekt')?></h2>
            </div>
            <div class="col-5 text-right">
                <ul class="mb-0 notification-list">
                    <li class="d-inline-block mr-3"><a   class="notificatin-ic" href="<?php echo WEBURL; ?>/employer/notification"><img src="<?php echo  $staticUrl; ?>/images/bell-menu.svg" class="w-100"><?php  $count = $this->employer_library->get_notification_count(); if($count){  ?><span class="no-ic"><?php echo $count; ?></span><?php } ?></a></li>
                    <li class="d-inline-block mr-3">
                        <a href="<?php echo WEBURL; ?>/employer/messenger" class="notificatin-ic">
                            <img src="<?php echo  $staticUrl; ?>/images/messenger-menu.svg" class="w-100"><?php  $msgcount = $this->employer_library->get_chat_count();
                             if($msgcount){  ?><span class="no-ic"><?php echo $msgcount; ?></span><?php } ?>
                        </a>
                    </li>
                    <li class="d-inline-block"><a href="#" onclick="openNavmob()"><img src="<?php echo  $staticUrl; ?>/images/settings.svg" class="w-100"></a></li>

<!-- setting sidebar mobile -->

    <div id="mySidenavmob" class="sidenav vheight-100 box-shadow">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNavmob()">&times;</a>
            <ul class="setting-nav py-3 px-3">
                        <li><a href="<?php echo WEBURL; ?>/employer/job/add-new-job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('New Job')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/job"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('My Jobs')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/application"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/Applications.svg"><?=lang('Applications')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/candidate/wishlisted-candidates"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/saved-Candidates.svg"><?=lang('Saved Candidates')?></a></li>
                        <li><a href="<?php echo WEBURL; ?>/employer/tutorials"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg"><?=lang('Employer showcase')?></a></li>
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

<!--  -->






                </ul>
            </div>
        </div>
    </div>


<div class="main-container py-2 py-md-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-sm-10 col-md-11 col-lg-8 col-xl-7 mx-auto">
                <div class="tiles-arrow">
                    <div class="d-none d-md-block left-arrow2 left-arr"><a href="#" onclick="funReject();"><i class="fas fa-caret-square-left text-d-grey"></i></a></div>
                    <div class="d-none d-md-block left-arrow2 right-arr"><a href="#" onclick="funAccept();"><i class="fas fa-caret-square-right text-d-grey"></i></a></div>
             
                <ul class="tiles-ul mb-0" id="main">

                    
                   <?php if(isset($data) && $data != "" &&  $recordCount > 0){
                        $i = $recordCount;
                            foreach($data as $row){
                                ?>
                                <li class="tiles-li-<?php echo $i; ?> tc-card">
                                    <div class="accept-reject-span"><span class="spnLeft text-danger" style="align-content: left; opacity: 0"><?=lang('Reject')?> <input type="hidden" name="spnLeftId" id="spnLeftId" value="<?php echo $row->ID; ?>"></span> <span class="spnRight text-blue" style="align-content: right; opacity: 0"><?=lang('Accept')?><?=lang('
')?> <input type="hidden" name="spnRIghtId" id="spnRightId" value="<?php echo $row->ID; ?>"></span></div>
                                    <a href="Javascript:void(0)">
                                        <div class="card tile py-3">
                                            <div class="card-body pt-0 pb-3 px-3">
                                                <h5 class="card-title mb-1"><?php echo $row->first_name; ?></h5>
                                                <h6 class="card-subtitle mb-2"><?php echo $row->lastest_job_title; ?></h6>
                                                <ul class="list-unstyled mb-2">
                                                    <li class="media align-items-center mb-1">
                                                        <img class="mr-2" src="<?php echo  $staticUrl; ?>/images/location.svg">
                                                        <div class="media-body">
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey"><?php echo $row->city; ?>, <?php echo $row->country; ?>.</h6>
                                                        </div>
                                                    </li>
                                                    <li class="media align-items-center mb-1">
                                                        <img class="mr-2" src="<?php echo  $staticUrl; ?>/images/currency.svg">
                                                        <div class="media-body">
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey"> <?php echo $row->expected_salary; ?></h6>
                                                        </div>
                                                    </li>
                                                    <li class="media align-items-center mb-1">
                                                        <img class="mr-2" src="<?php echo  $staticUrl; ?>/images/certificate.svg">
                                                        <div class="media-body">
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey"><?php echo $row->experience; ?></h6>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <h6 class="mb-2"><?=lang('Skills')?></h6>
                                                <ul class="skills-list list-inline mb-2">
                                                    <?php 
                                                    //myPrint($row->skills);
                                                        if(isset($row->skills) && $row->skills !=""){
                                                            foreach ($row->skills as $skill) {
                                                                echo '<li class="list-inline-item">'.$skill.'</li>';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                                <div class="about-summary">
                                                    <h6 class="mb-2"><?=lang('About Summary')?></h6>
                                                    <p>
                                                        <?php echo $row->about; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php 
                            $i--;
                            }
                        } else { ?>
                            <li class="tiles-li-0 tc-card">
                                <div class="card tile py-3">
                                    <div class="card-body pt-0 pb-3 px-3">
                                        <h5 class="card-title mb-1"><?=lang('No candidates to show')?></h5>
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                      
                </ul>
            </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
    <div class="tiles-footer fixed-bottom  py-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="d-block d-md-none col-3 col-md-2 col-lg-1 text-center"><a class="tiles-btn" href="tel:9198675654" id="telclick" onclick="contactInfo();"><img src="<?php echo STATICWEBCOMPURL; ?>/images/cellphone.svg" alt=""></a></div>
                  <div class="d-none d-md-block col-3 col-md-2 col-lg-1 text-center" data-toggle="modal" data-target="#exampleModalCenter3"><a class="tiles-btn" href="#" onclick="contactInfoDesk();"><img src="<?php echo STATICWEBCOMPURL; ?>/images/cellphone.svg" alt=""></a></div>
                <div class="col-3 col-md-2 col-lg-1 text-center"><a class="tiles-btn" href="#" onclick="funWishlist();"><img src="<?php echo STATICWEBCOMPURL; ?>/images/wish-list.svg" alt=""></a></div>
            <!--     <div class="col-3 col-md-2 col-lg-1 text-center"><a class="tiles-btn" href="#" onclick="funAccept();"><img src="<?php echo STATICWEBCOMPURL; ?>/images/apply.svg" alt=""></a></div> -->

            </div>

       </div>
    </div>


    <!-- ------------------call modal--------------------- -->
<div class="modal callmodal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue text-white text-center py-2">
        <h5 class="modal-title w-100 text-uppercase font-med text-center" id="exampleModalLongTitle">Call Us At</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times-circle text-white"></i></span>
        </button>
      </div>
      <div class="modal-body p-4">
       <p id="contDeskModal">68790800</p>
      </div>
    
    </div>
  </div>
</div>
    <!-- --------------------modal end-------------------- -->



</div>
<?php $this->load->view('newweb/inc/footer'); ?>
<script>
$(document).ready(function() {
        var innerHeight = window.innerHeight
        var tilesHeader = $('.tiles-header').height();
        var tilesFooter = $('.tiles-footer').height();
        var totalHeight = tilesHeader + tilesFooter + 10;
        var passHeight = innerHeight - tilesFooter - 96;
        $('.tiles-ul').css({
            "height": passHeight
        });
     
});

/*
$(document).ready(function() {
      $(function() {
        var count = <?php echo $recordCount; ?>;
        var displayCount = (count - 3);
        for (var i = count; i > 0; i--) {
            if (i <= displayCount) {
                $('.tiles-li-' + i).css("display", "none")
            } else {
                $('.tiles-li-' + i).css("display", "block")
            }

        }
    });
});
$(document).ready(function() {
    $(function() {
        var count = <?php echo $recordCount; ?>;
        var zIndex = 0
        var transforms = 0.85;
        var j = 1;
        for (var i = 1; i <= count; i++) {

            zIndex++;
            transforms = transforms + 0.05;
            $('.tiles-li-' + i).css({
                'z-index': zIndex,
            });

        }
    });
});*/
$(document).ready(function() {
    var opac = 0;

    $(".spnLeft").css({ 'opacity': opac });
    $(".spnRight").css({ 'opacity': opac });
    // Define cards
    var cards = [
        new Tindercardsjs.card(0)
    ];
    // Render cards
    Tindercardsjs.render(cards, $('#main'), function(event) {
        console.log('Swiped ' + event.direction + ', cardid is ' + event.cardid + ' and target is:');
        console.log(event.card);
        //event.direction
        if(event.direction == "right"){
            //subkit application
            var seeker_ID = $("#spnRightId").val();
            //alert(seeker_ID);
            if(seeker_ID){ 
                var myKeyVals = { "seeker_ID" : seeker_ID};
                $.ajax({
                      type: 'POST',
                      url: "<?php echo WEBURL.'/employer/candidate/invite';?>",
                      data: myKeyVals,
                      dataType: "text",
                      success: function(resultData) { 
                            window.location.reload();
                    }
                });
            }

            //window.location.reload();
        } else {
            //subkit application
            var seeker_ID = $("#spnLeftId").val();
            //alert(seeker_ID);
            var myKeyVals = { "seeker_ID" : seeker_ID};
            if(seeker_ID){  
                $.ajax({
                      type: 'POST',
                      url: "<?php echo WEBURL.'/employer/candidate/reject';?>",
                      data: myKeyVals,
                      dataType: "text",
                      success: function(resultData) {
                                 window.location.reload();
                            }
                });
            }
        }
        var className = jQuery(event.card[0]).attr('class').split(' ')[0];
    });
});
function funReject(){
    var seeker_ID = $("#main :input").attr("value");
    // $(".spnLeft").show();
    $('.spnLeft').css( 'opacity', '1' );
    var myKeyVals = { "seeker_ID" : seeker_ID};
    $.ajax({
          type: 'POST',
          url: "<?php echo WEBURL.'/employer/candidate/reject';?>",
          data: myKeyVals,
          dataType: "text",
          success: function(resultData) {
                 //   window.location.reload();
                }
    });
}
function funAccept(){
    var seeker_ID = $("#main :input").attr("value");
    var myKeyVals = { "seeker_ID" : seeker_ID};
    $.ajax({
      type: 'POST',
      url: "<?php echo WEBURL.'/employer/candidate/invite';?>",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 
           window.location.reload();
        }
    });
}
function funWishlist(){
    //tbl_favourite_companies
    var seeker_ID = $("#main :input").attr("value");
     $(".spnRight").removeClass('text-blue');
    $(".spnRight").addClass('text-success');
    $(".spnRight").html('Wishlisted');
     $(".spnRight").css( 'opacity', '1' );
    var myKeyVals = { "seeker_ID" : seeker_ID};
    $.ajax({
      type: 'POST',
      url: "<?php echo WEBURL.'/employer/candidate/wishlist';?>",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 
            window.location.reload();
        }
    });
}
</script>

<script type="text/javascript">
    function contactInfo(){
    //tbl_favourite_companies
    var seeker_ID = $("#main :input").attr("value");
     
    var myKeyVals = {"seeker_ID" : seeker_ID};
    $.ajax({
      type: 'POST',
      url: "<?php echo WEBURL.'/employer/candidate/callinfo';?>",
      data: myKeyVals,
      dataType: "html",
      success: function(resultData) { 
        //html(resultData).show();
            $("#telclick").attr("href", "tel:"+resultData);
           // alert(resultData);
           // window.location.reload();
        }
    });
}

</script>

<script type="text/javascript">
    function contactInfoDesk(){
    //tbl_favourite_companies
    var seeker_ID = $("#main :input").attr("value");
     
    var myKeyVals = {"seeker_ID" : seeker_ID};
    $.ajax({
      type: 'POST',
      url: "<?php echo WEBURL.'/employer/candidate/callinfo';?>",
      data: myKeyVals,
      dataType: "html",
      success: function(resultData) { 
        //html(resultData).show();
            $("#contDeskModal").html(resultData);
         //   alert(resultData);
           // window.location.reload();
        }
    });
}

</script>


<!-- <script>
$(document).ready(function() {
    if (window.innerWidth <= 576) {

        var innerHeight = window.innerHeight
        var tilesHeader = $('.tiles-header').height();
        var tilesFooter = $('.tiles-footer').height();
        var totalHeight = tilesHeader + tilesFooter + 10;
        var passHeight = innerHeight - totalHeight;
        $('.tiles-ul').css({
            "height": passHeight
        });
    }
    else {
        var innerHeight = window.innerHeight
        var tilesHeader = $('.tiles-header').height();
        var tilesFooter = $('.tiles-footer').height();
        var totalHeight = tilesHeader + tilesFooter;
        var passHeight = innerHeight + totalHeight;
        $('.tiles-ul').css({
            'height': passHeight,
            'margin-bottom': tilesFooter
        });
    }
});
</script> -->



