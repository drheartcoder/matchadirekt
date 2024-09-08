<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
/*$.ajax({
      type: "GET",
      url: "<?php //echo APPURL.'/seeker/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        console.log(data);
        //$("#main").html(data);
      }
    });*/
</script>
<?php 
    //myPrint($resData);exit;
    $countOfJob = count($resData);//exit;
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section class="vheight-100">
    <form action="#" method="POST">
        <div class="container tiles-header pb-3">
            <div class="row bg-grey py-2 justify-content-between">
                <div class="col-4">
                    <div class="dropdown show">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Eng</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 text-right">
                    <a href="<?php echo APPURL.'/login/logout'; ?>">
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
                        <li class="px-3 text-white w-100">
                            <?php 
                            $photoData  = $this->My_model->getSingleRowData('tbl_job_seekers',"photo","ID = ".$this->sessUserId);
                                $defaultUser = $staticUrl."/images/user.png";
                                $imgUrl = "";
                                $pht=$photoData->photo;
                                if($pht!="" && file_exists('public/uploads/candidate/'.$pht)) 
                                    $imgUrl = PUBLICURL.'/uploads/candidate/'.$pht;
                                else
                                    $imgUrl= $defaultUser; //'no_pic.jpg';
                                //echo $imgUrl;
                            ?>
                            <div class="user-profile-pic mb-2">
                                <img src="<?php echo  $imgUrl ; ?>" class="w-100 h-100">
                            </div>
                            <div class="media-body text-center">
                                <h5 class="font-med mb-0">
                                    <?php echo $this->sessFirstName; ?>
                                </h5>
                                <h6 class="mb-0">
                                    <?php  echo $this->sessUserEmail; //site.atempurl.com/jobsystemv2dev/public/uploads/candidate/sonali-BiXma-478.jpg ?>
                                </h6>
                            </div>
                        </li>
                    </ul>
                    <!-- manu profile -->
                    <ul class="second-nav py-4">
                        <li><a href="<?php echo APPURL; ?>/seeker/home"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/home.svg">Home</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/job/wishlist-jobs"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/wishlist.svg">Wishlist</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/my-account"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/user.svg">Manage Account</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/my-cv"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/file.svg">My CV</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/messenger"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/messenger.svg">Messenger</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/tutorials"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg">Tutorials</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/notification"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/bell.svg">Notification</a></li>
                    </ul>
                    <!-- nav ul list -->
                </nav>
                <!-- nav end -->
                <div class="col-5">
                    <h2 class="mb-0">Matchadirekt</h2>
                </div>
                <div class="col-5 text-right">
                    <ul class="mb-0 notification-list">
                          
                        <li class="d-inline-block mr-3"><a  class="notificatin-ic" href="<?php echo APPURL; ?>/seeker/notification"><img src="<?php echo  $staticUrl; ?>/images/bell-menu.svg" class="w-100"><?php 
                       $count = $this->seeker_library->get_notification_count();
                       if($count){
                        ?><span class="no-ic"><?php 
                       echo $count;
                        ?></span>
                        <?php
                       }
                       ?></a></li>
                        <li class="d-inline-block mr-3"><a  class="notificatin-ic"  href="<?php echo APPURL; ?>/seeker/messenger"><img src="<?php echo  $staticUrl; ?>/images/messenger-menu.svg" class="w-100">
                        <?php 
                       $count = $this->seeker_library->get_chat_count();
                       if($count){
                        ?><span class="no-ic"><?php 
                       echo $count;
                        ?></span>
                        <?php
                       }
                       ?></a></li>
                        <li class="d-inline-block"><a href="<?php echo APPURL; ?>/seeker/settings"><img src="<?php echo  $staticUrl; ?>/images/settings.svg" class="w-100"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <ul class="tiles-ul" id="main">
                        <?php 
                        if(isset($resData) && $resData!="" &&  $countOfJob > 0){
                            $i = $countOfJob;
                            foreach($resData as $job){
                                ?>
                                <li class="tiles-li-<?php echo $i; ?> tc-card">
                                    <div class="accept-reject-span"><span class="spnLeft text-danger" style="align-content: left; opacity: 0">Reject <input type="hidden" name="spnLeftId" id="spnLeftId" value="<?php echo $job->ID; ?>"></span> <span class="spnRight text-blue" style="align-content: right; opacity: 0">Accept <input type="hidden" name="spnRIghtId" id="spnRightId" value=<?php echo $job->ID; ?>></span></div>
                                    <a href="<?php echo APPURL.'/seeker/home/job-details/'.$job->ID; ?>">
                                        <div class="card tile py-3">
                                            <div class="card-body pt-0 pb-3 px-3">
                                                <h5 class="card-title mb-1"><?php echo $job->company_name; ?></h5>
                                                <h6 class="card-subtitle text-blue mb-2"><span class="text-d-grey">
                                                        <?php echo date('d M Y', strtotime($job->dated)); ?> </span>
                                                    <?php echo $job->job_title; ?>
                                                </h6>
                                                <ul class="list-unstyled mb-2">
                                                    <li class="media align-items-center mb-1">
                                                        <img class="mr-2" src="<?php echo $staticUrl; ?>/images/location.svg">
                                                        <div class="media-body">
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey">
                                                                <?php echo $job->city; ?>.</h6>
                                                        </div>
                                                    </li>
                                                    <li class="media align-items-center mb-1">
                                                        <img class="mr-2" src="<?php echo $staticUrl; ?>/images/currency.svg">
                                                        <div class="media-body">
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey">$
                                                                <?php echo $job->pay; ?>
                                                            </h6>
                                                        </div>
                                                    </li>
                                                    <li class="media align-items-center mb-1">
                                                        <img class="mr-2" src="<?php echo $staticUrl; ?>/images/certificate.svg">
                                                        <div class="media-body">
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey">
                                                                <?php echo $job->experience; ?> Years Experience</h6>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <h6 class="mb-2">Required Skills</h6>
                                                <ul class="skills-list list-inline mb-2">

                                                    <?php 
                                                    if($job->required_skills != ""){
                                                           $skillArray = explode(",",$job->required_skills);
                                                        if(isset($skillArray) && $skillArray != ""){
                                                            foreach($skillArray as $skill){
                                                                 echo '<li class="list-inline-item">'.$skill.'</li>'; 
                                                            }
                                                        }
                                                    } ?>
                                                </ul>
                                                <div class="about-summary">
                                                    <h6 class="mb-2">About Job</h6>
                                                    <p>
                                                        <?php echo $job->job_description; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                        <?php
                                $i--;
                            }
                        } else{
                            ?>
                              <li class="tiles-li-1 tc-card">
                                <div class="card tile py-3">
                                    <div class="card-body pt-0 pb-3 px-3">
                                        <h5 class="card-title mb-1">No Jobs available</h5>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <!-- col -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
        <div class="tiles-footer bg-l-grey">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-3 text-center"><a class="tiles-btn" onclick="funReject();"><img src="<?php echo  $staticUrl; ?>/images/skip.svg" alt=""></a></div>
                    <div class="col-3 text-center"><a class="tiles-btn" href="#" onclick=" funWishlist();"><img src="<?php echo  $staticUrl; ?>/images/wish-list.svg" alt=""></a></div>
                    <div class="col-3 text-center"><a class="tiles-btn" href="#" onclick="funAccept();"><img src="<?php echo  $staticUrl; ?>/images/apply.svg" alt=""></a></div>
                </div>
            </div>
        </div>
    </form>
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>
<script>
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
    } else {
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

$(document).ready(function() {
    $(function() {
        var count = <?php echo $countOfJob; ?>;
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
        var count = <?php echo $countOfJob; ?>;
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
});
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
        if (event.direction == "right") {
            //subkit application
            var jobId = $("#spnRightId").val();
            //alert(jobId);
            var myKeyVals = { "jobId": jobId };
            $.ajax({
                type: 'POST',
                url: "<?php echo APPURL.'/seeker/job/apply';?>",
                data: myKeyVals,
                dataType: "text",
                success: function(resultData) {
                    //alert(resultData);
                    //console.log(resultData);
                    if (resultData === "0") {
                        window.location.href = '<?php echo APPURL; ?>/seeker/my-account';
                    } else {
                        //alert("11");
                        window.location.reload();
                    }
                }
            });

            //window.location.reload();
        } else {
            //subkit application
            var jobId = $("#spnLeftId").val();
            //alert(jobId);
            var myKeyVals = { "jobId": jobId };
            $.ajax({
                type: 'POST',
                url: "<?php echo APPURL.'/seeker/job/reject';?>",
                data: myKeyVals,
                dataType: "text",
                success: function(resultData) {
                    /* if(resultData === "0") {
                         $("#alertCompleteProfileModal").addClass("show");
                         $("#alertCompleteProfileModal").css("display", "block");

                     } else {
                         alert("11");
                        
                     }*/
                    window.location.reload();
                }
            });
        }
        var className = jQuery(event.card[0]).attr('class').split(' ')[0];
    });
});

function funReject() {
    var jobId = $("#main :input").attr("value");
    // $(".spnLeft").show();
    $('.spnLeft').css('opacity', '1');
    var myKeyVals = { "jobId": jobId };
    $.ajax({
        type: 'POST',
        url: "<?php echo APPURL.'/seeker/job/reject';?>",
        data: myKeyVals,
        dataType: "text",
        success: function(resultData) {
            window.location.reload();
        }
    });
}

function funAccept() {
    var jobId = $("#main :input").attr("value");
    var myKeyVals = { "jobId": jobId };
    $.ajax({
        type: 'POST',
        url: "<?php echo APPURL.'/seeker/job/apply';?>",
        data: myKeyVals,
        dataType: "text",
        success: function(resultData) {
            if (resultData === "0") {
                window.location.href = '<?php echo APPURL; ?>/seeker/my-account';
            } else {
                window.location.reload();
            }
        }
    });
}

function funWishlist() {
    //tbl_favourite_companies
    var jobId = $("#main :input").attr("value");
    $(".spnRight").removeClass('text-blue');
    $(".spnRight").addClass('text-success');
    $(".spnRight").html('Wishlisted');
    $(".spnRight").css('opacity', '1');
    var myKeyVals = { "jobId": jobId };
    $.ajax({
        type: 'POST',
        url: "<?php echo APPURL.'/seeker/job/wishlist';?>",
        data: myKeyVals,
        dataType: "text",
        success: function(resultData) {
            if (resultData === "0") {
                window.location.href = '<?php echo APPURL; ?>/seeker/my-account';
            } else {
                window.location.reload();
            }
        }
    });
}
</script>