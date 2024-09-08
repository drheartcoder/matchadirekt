<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo APPURL.'/seeker/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php 
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
                        <li class="px-3 text-white">
                            <h5 class="font-med mb-0"><?php echo $this->sessFirstName; ?></h5>
                            <h6 class="mb-0"><?php  echo $this->sessUserEmail; ?> </h6>
                        </li>
                    </ul>
                    <!-- manu profile -->
                    <ul class="second-nav py-4">
                        <li><a href="<?php echo APPURL; ?>/seeker/home"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/home.svg">Home</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/job/wishlist-jobs"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/wishlist.svg">Wishlist</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/my-account"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/user.svg">Manage Account</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/my-cv"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/file.svg">My CV</a></li>
                        <li><a href="inbox.php"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/messenger.svg">Messenger</a></li>
                        <li><a href="<?php echo APPURL; ?>/seeker/tutorials"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/tutorial.svg">Tutorials</a></li>
                        <li class="notificatin-ic" style="position:relative;"><a href="<?php echo APPURL; ?>/seeker/notification"><img class="mr-3" src="<?php echo  $staticUrl; ?>/images/bell.svg">Notification<span class="no-ic" style="position: absolute;top:0px; right:0px;background-color: #000; color:#fff; height: 20px; width: 20px; border-radius: 50%">1</span></a></li>
                    </ul>
                    <!-- nav ul list -->
                </nav>
                <!-- nav end -->
                <div class="col-5">
                    <h2 class="mb-0">Matchadirekt</h2>
                </div>
                <div class="col-5 text-right">
                    <ul class="mb-0 notification-list">
                        <li class="d-inline-block mr-3"><a href="<?php echo APPURL; ?>/seeker/notification"><img src="<?php echo  $staticUrl; ?>/images/bell-menu.svg" class="w-100"></a></li>
                        <li class="d-inline-block mr-3"><a href="<?php echo APPURL; ?>/seeker/settings/inbox"><img src="<?php echo  $staticUrl; ?>/images/messenger-menu.svg" class="w-100"></a></li>
                        <li class="d-inline-block"><a href="<?php echo APPURL; ?>/seeker/settings"><img src="<?php echo  $staticUrl; ?>/images/settings.svg" class="w-100"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <ul class="tiles-ul" id="main">
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
                    <div class="col-3 text-center"><a class="tiles-btn" onclick="funReject();"><img src="<?php echo  $staticUrl; ?>/images/skip.svg" alt=""></a></div>
                    <div class="col-3 text-center"><a class="tiles-btn" href="#" onclick=" funWishlist();"><img src="<?php echo  $staticUrl; ?>/images/wish-list.svg" alt=""></a></div>
                    <div class="col-3 text-center"><a class="tiles-btn" href="#"  onclick="funAccept();"><img src="<?php echo  $staticUrl; ?>/images/apply.svg" alt=""></a></div>
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
   /* $(function() {
        var count = <?php //echo $countOfJob; ?>;
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
    });*/
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
            var jobId = $("#spnRightId").val();
            //alert(jobId);
            var myKeyVals = { "jobId" : jobId};
            $.ajax({
                  type: 'POST',
                  url: "<?php echo APPURL.'/seeker/job/apply';?>",
                  data: myKeyVals,
                  dataType: "text",
                  success: function(resultData) { 
                        if(resultData === "0") {
                            window.location.href ='<?php echo APPURL; ?>/seeker/my-account'; 
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
            var myKeyVals = { "jobId" : jobId};
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
function funReject(){
    var jobId = $("#main :input").attr("value");
    // $(".spnLeft").show();
    $('.spnLeft').css( 'opacity', '1' );
    var myKeyVals = { "jobId" : jobId};
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

function funAccept(){
    var jobId = $("#main :input").attr("value");
    var myKeyVals = { "jobId" : jobId};
    $.ajax({
      type: 'POST',
      url: "<?php echo APPURL.'/seeker/job/wishlist';?>",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 
            if(resultData === "0") {
                window.location.href ='<?php echo APPURL; ?>/seeker/my-account'; 
            } else {
                window.location.reload();
            }
        }
    });
}


function funWishlist(){
    //tbl_favourite_companies
    var jobId = $("#main :input").attr("value");
     $(".spnRight").css( 'opacity', '1' );
    var myKeyVals = { "jobId" : jobId};
    $.ajax({
      type: 'POST',
      url: "<?php echo APPURL.'/seeker/job/wishlist';?>",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 
            if(resultData === "0") {
                window.location.href ='<?php echo APPURL; ?>/seeker/my-account'; 
            } else {
                window.location.reload();
            }
        }
    });
}
</script>