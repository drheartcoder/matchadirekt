<?php $this->load->view('newweb/inc/header'); ?>

<?php 
    $staticUrl = STATICWEBCOMPURL; 
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<section class="bg-blue vheight-100 justify-content-between">
    <div class="container">
        <div class="col-11 col-lg-9 col-xl-6 mx-auto bg-white vh-center pb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-10 text-center mx-auto py-2 py-md-3">
                <!-- <div class="flash-screen px-4">
                    <img src="<?php //echo  $staticUrl; ?>/images/flash-screen.png" class="img-fluid">
                </div> -->
                <h2 class="text-blue font-bold py-4">MATCHADIREKT</h2>
                <form action="" method="POST" >
                            <?php if($msg):?>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="alert alert-danger">
                                            <?php echo $msg;?></div>
                                    </div>
                                </div>
                            <?php endif;?>
                        
                    <div class="row mt-4">
                        <div class="form-group col-12">
                            <input type="email" class="form-control" name="email" placeholder="<?=lang('Your Email Address')?>">
                        </div>
                        <div class="form-group col-12">
                            <input type="password" class="form-control" name="pass" placeholder="<?=lang('Password')?>">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-blue" name="btnLogin"><?=lang('Login'); ?></button>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 text-center text-sm-left">
                        <div class="font-med text-blue">
                            <?=lang('New user?')?> <a href="<?php echo WEBURL; ?>/registration" class="text-blue text-underline"><?=lang('Sign up!')?></a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 text-center text-sm-Right d-inline-block">
                         <div class="font-med text-blue d-inline-block mr-2">
                            <a href="<?php echo WEBURL; ?>/login/forgot" class="text-blue text-underline"><?=lang('Forgot Password!')?></a>
                        </div>
                <div class="dropdown show d-inline-block">
                    <a class="dropdown-toggle font-med text-blue" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lang</a>
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
                        <!-- <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a> -->
                    </div>
                </div>
            </div>
                </div>
                <div class="row text-center d-inline-block my-2">
                    <a href="#" class="bg-l-grey socil-icon d-inline-block" data-toggle="modal" data-target="#loginWithFacebook">
                    <i class="fab fa-facebook-f text-blue"></i></a>
                    <a href="#" class="bg-l-grey socil-icon d-inline-block" data-toggle="modal" data-target="#loginWithGoogle">
                     <i class="fab fa-google-plus-g text-blue"></i></a>

                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    </div>
    <!-- container -->
</section>

<!-- Modal -->
<div class="modal fade" id="loginWithFacebook" tabindex="-1" role="dialog" aria-labelledby="loginWithFacebookTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered p-3" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="d-inline-block w-100  font-med text-uppercase login-pop text-center text-blue" id="exampleModalLongTitle">Login As</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body px-3 px-lg-4">
        <form>
            <div class="col-12 ">
            <div class="row">
            <div class=" col-12 col-sm-6 custom-control custom-radio font-med mb-3">
            <input type="radio" class="custom-control-input" id="customRadio" name="role" value="1" checked="checked">
            <label class="custom-control-label" for="customRadio">Login As Seeker</label>
            </div>

            <div class="col-12 col-sm-6 custom-control custom-radio font-med mb-3">
            <input type="radio" class="custom-control-input" id="customRadio2" name="role" value="2">
            <label class="custom-control-label" for="customRadio2">Login As Employer</label>
            </div>
            </div></div>

            <div class="text-center">
                <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"  login_text=" FaceBook " size="xlarge">Facebook</fb:login-button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="loginWithGoogle" tabindex="-1" role="dialog" aria-labelledby="loginWithGoogleTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered p-3" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="d-inline-block w-100  font-med text-uppercase login-pop text-center text-blue" id="exampleModalLongTitle">Login As</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body px-3 px-lg-4">
        <form>
            <div class="col-12 ">
            <div class="row">
            <div class=" col-12 col-sm-6 custom-control custom-radio font-med mb-3">
            <input type="radio" class="custom-control-input" id="customRadioG" name="roleG" value="1" checked="checked">
            <label class="custom-control-label" for="customRadioG">Login As Seeker</label>
            </div>

            <div class="col-12 col-sm-6 custom-control custom-radio font-med mb-3">
            <input type="radio" class="custom-control-input" id="customRadioG2" name="roleG" value="2">
            <label class="custom-control-label" for="customRadioG2">Login As Employer</label>
            </div>
            </div></div>

            <div class="text-center">
                <!-- <div  id="customBtn"  class="g-signin2" data-onsuccess="onSignIn" data-theme="dark">Google</div> -->
                <div class="g-signin2" data-onsuccess="onSignIn"></div>

            </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="390760846084-50cs8d0m4t0lvi854ic7e8og33bo99mu.apps.googleusercontent.com" >
<script type="text/javascript">
  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    var radioVal =  $("input[name='role']:checked").val();
    //alert(radioVal);
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response,radioVal);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '925429134506565',
      cookie     : true,  // enable cookies to allow the server to access
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.2' // The Graph API version to use for the call
    });

    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.
    /*var radioVal =  $("input[name='role']:checked").val();
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response,radioVal);
    });*/

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function statusChangeCallback(response,radioVal) {
    FB.api('/me?fields=name,first_name,last_name,email,link,gender,locale,birthday,cover,picture.type(large)', function(result) {
            if(result.name != ""){
                console.log(result);
                console.log(result.picture);
                console.log(result.picture);
                console.log(result.picture.data.url);
                $.ajax({        // "" http://graph.facebook.com/169157487607051/picture?type=square
                    type: "POST",//<img src="//graph.facebook.com/169157487607051/picture" />
                    url: '<?php echo WEBURL; ?>/registration/social-reg',
                    data: {name: result.name,email: result.email,gender: result.gender,link: result.link,birthday: result.birthday,image: result.picture.data.url,loginfrom: 'facebook',facebook: result.id,google: '',radioVal: radioVal},
                    success: function(data){
                        console.log(data);
                        if(data == "0"){
                           alert('something went wrong');
                        } else {
                             window.location.href = data;
                        }
                    }
                });
           }
     });
  }
 


</script>

<script type="text/javascript">

    function onSignIn(googleUser) {
      var profile = googleUser.getBasicProfile();
      console.log(profile); // Do not send to your backend! Use an ID token instead.
      /*$.ajax({
            type: "POST",
            url: 'submission.php',
            data: {name: profile.ig,email: profile.U3,image: profile.Paa,loginfrom: 'google',facebook: '',google:  profile.Eea},
            success: function(data){
               //alert(data);
              console.log(data);
              // window.location.href = 'index.php';
            }
        });*/
      /*console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
      console.log('Name: ' + profile.getName());
      console.log('Image URL: ' + profile.getImageUrl());
      console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        Here is your client ID
        390760846084-50cs8d0m4t0lvi854ic7e8og33bo99mu.apps.googleusercontent.com
        
        Here is your client secret
        YGmdY86N-06V6N0TnJfMgZnW

      */
    }
</script>
<!-- <meta name="google-site-verification" content="AIzaSyAdFbQRZgCd8RH7Ie14AaIjzDdNP1TZWOU" /> -->

