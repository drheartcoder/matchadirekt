<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    $recordCount= count($data);
?>
<section class="vheight-100">
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
                    <li class="px-3 text-white">
                        <h5 class="font-med mb-0"><?php echo $companyData->company_name; ?></h5>
                        <h6 class="mb-0"><?php echo $companyData->industry; ?></h6>
                    </li>
                </ul>
                <!-- manu profile -->
                <ul class="second-nav py-4">
                    <li><a href="<?php echo APPURL; ?>/employer/home"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/home.svg">Home</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/my-account"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/user.svg">Manage Account</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/company"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/company.svg">My Company</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/messenger"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/messenger.svg">Messenger</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/tutorials"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg">Tutorials</a></li>
                    <li><a href="<?php echo APPURL; ?>/employer/notification"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/bell.svg">Notification</a></li>
                    <li><a href="<?php echo APPURL.'/login/logout'; ?>"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/lock.svg">Logout</a></li>
                </ul>
                <!-- nav ul list -->
            </nav>
            <!-- nav end -->
            <div class="col-5">
                <h2 class="mb-0">Matchadirekt</h2>
            </div>
            <div class="col-5 text-right">
                <ul class="mb-0 notification-list">
                    <li class="d-inline-block mr-3"><a   class="notificatin-ic" href="<?php echo APPURL; ?>/employer/notification"><img src="<?php echo  $staticUrl; ?>/images/bell-menu.svg" class="w-100"><?php  $count = $this->employer_library->get_notification_count(); if($count){  ?><span class="no-ic"><?php echo $count; ?></span><?php } ?></a></li>
                    <li class="d-inline-block mr-3">
                        <a href="<?php echo APPURL; ?>/employer/messenger" class="notificatin-ic">
                            <img src="<?php echo  $staticUrl; ?>/images/messenger-menu.svg" class="w-100"><?php  $msgcount = $this->employer_library->get_chat_count(); if($msgcount){  ?><span class="no-ic"><?php echo $msgcount; ?></span><?php } ?>
                        </a>
                    </li>
                    <li class="d-inline-block"><a href="<?php echo APPURL; ?>/employer/settings"><img src="<?php echo  $staticUrl; ?>/images/settings.svg" class="w-100"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <ul class="tiles-ul" id="main">
                    <?php if(isset($data) && $data != ""){
                        $i = $recordCount;
                            foreach($data as $row){
                                ?>
                                <li class="tiles-li-<?php echo $i; ?> tc-card">
                                    <div class="accept-reject-span"><span class="spnLeft text-danger" style="align-content: left; opacity: 0">Reject <input type="hidden" name="spnLeftId" id="spnLeftId" value="<?php echo $row->ID; ?>"></span> <span class="spnRight text-blue" style="align-content: right; opacity: 0">Accept <input type="hidden" name="spnRIghtId" id="spnRightId" value="<?php echo $row->ID; ?>"></span></div>
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
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey">$ <?php echo $row->expected_salary; ?></h6>
                                                        </div>
                                                    </li>
                                                    <li class="media align-items-center mb-1">
                                                        <img class="mr-2" src="<?php echo  $staticUrl; ?>/images/certificate.svg">
                                                        <div class="media-body">
                                                            <h6 class="mt-0 mb-0 font-reg text-d-grey"><?php echo $row->experience; ?></h6>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <h6 class="mb-2">Skills</h6>
                                                <ul class="skills-list list-inline mb-2">
                                                    <?php 
                                                        if(isset($row->skills) && $row->skills !=""){
                                                            foreach ($row->skills as $skill) {
                                                                echo '<li class="list-inline-item">'.$skill.'</li>';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                                <div class="about-summary">
                                                    <h6 class="mb-2">About Summary</h6>
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
                            <li class="tiles-li-1 tc-card">
                                <div class="card tile py-3">
                                    <div class="card-body pt-0 pb-3 px-3">
                                        <h5 class="card-title mb-1">No Candidates exist</h5>
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
    <div class="tiles-footer fixed-bottom py-2 bg-l-grey">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-3 text-center"><a class="tiles-btn" href="#" onclick="funReject();"><img src="<?php echo  $staticUrl; ?>/images/skip.svg" alt=""></a></div>
            <div class="col-3 text-center"><a class="tiles-btn" href="#" onclick="funWishlist();"><img src="<?php echo  $staticUrl; ?>/images/wish-list.svg" alt=""></a></div>
            <div class="col-3 text-center"><a class="tiles-btn" href="#" onclick="funAccept();"><img src="<?php echo  $staticUrl; ?>/images/apply.svg" alt=""></a></div>
        </div>
    </div>
    </div>
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
        if(event.direction == "right"){
            //subkit application
            var seeker_ID = $("#spnRightId").val();
            //alert(seeker_ID);
            var myKeyVals = { "seeker_ID" : seeker_ID};
            $.ajax({
                  type: 'POST',
                  url: "<?php echo APPURL.'/employer/candidate/invite';?>",
                  data: myKeyVals,
                  dataType: "text",
                  success: function(resultData) { 
                        window.location.reload();
                }
            });

            //window.location.reload();
        } else {
            //subkit application
            var seeker_ID = $("#spnLeftId").val();
            //alert(seeker_ID);
            var myKeyVals = { "seeker_ID" : seeker_ID};
            $.ajax({
                  type: 'POST',
                  url: "<?php echo APPURL.'/employer/candidate/reject';?>",
                  data: myKeyVals,
                  dataType: "text",
                  success: function(resultData) {
                             window.location.reload();
                        }
            });
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
          url: "<?php echo APPURL.'/employer/candidate/reject';?>",
          data: myKeyVals,
          dataType: "text",
          success: function(resultData) {
                    window.location.reload();
                }
    });
}

function funAccept(){
    var seeker_ID = $("#main :input").attr("value");
    var myKeyVals = { "seeker_ID" : seeker_ID};
    $.ajax({
      type: 'POST',
      url: "<?php echo APPURL.'/employer/candidate/invite';?>",
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
      url: "<?php echo APPURL.'/employer/candidate/wishlist';?>",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 
            window.location.reload();
        }
    });
}
</script>