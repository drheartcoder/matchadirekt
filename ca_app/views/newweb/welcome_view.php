<!DOCTYPE html>
<html lang="en">
<?php 
    if($this->session->userdata("sessUserId") > 0){
        if($this->session->userdata("sessIsJobSeeker") == 1)
            $staticUrl = STATICWEBSEEKERURL; 
        else // if($this->session->userdata("sessIsEmployer") == 1)
            $staticUrl = STATICWEBCOMPURL; 
          
    } else {
        $staticUrl = STATICWEBCOMPURL; 
    }

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Matchadirekt</title>
    <!-- font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <!-- main css -->
    <link href="<?php echo  $staticUrl; ?>/css/mobile-menu.css" rel="stylesheet">
    <?php  if( $staticUrl == STATICWEBCOMPURL){ ?>
  <!-- include summernote -->
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/summernote/dist/summernote-bs4.css">

     
    <?php
    } ?>
    


    <!-- calendar -->

    <!-- main css -->
    <link href="<?php echo  $staticUrl; ?>/css/main.css" rel="stylesheet">
    <link href="<?php echo  $staticUrl; ?>/css/responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- modernizr for cross browser -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <!-- font awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>
</head>

<body>
<section class="bg-blue justify-content-between">
    <div class="container">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white ">
          <div class="row  py-3 py-md-3 text-center">
            <div class="col-12">
            <a href="#" class="d-block text-center"><img class="" src="<?php echo $staticUrl; ?>/images/logo.jpeg"></a>
          </div>
          <div class="col-12 text-center">
            <div class="row">
              <div class="col-12">

            <div class="welcome-btn my-3">

              <ul class="wlc-ul justify-content-between text-center ">
                <li class="d-inline-block mx-2 my-2 m-md-0"><a href="<?php echo WEBURL; ?>/login" class="text-center"><?=lang('Login');?></a></li>
                <li class="d-inline-block mx-2 my-2 m-md-0"><a href="<?php echo WEBURL; ?>/registration" class="text-center"><?=lang('Register');?></a></li>
                <li class="d-inline-block mx-2 my-2 m-md-0"><a href="<?php echo WEBURL; ?>/login/forgot" class="text-center"><?=lang('Forgot Password');?>  </a></li>

                 <li class="d-inline-block mx-2 my-2 m-md-0">
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
              </li>
              </ul>
</div>
</div>
  <div class="col-12 text-center">
    <h2 class="wlc-title text-uppercase py-2 font-bold bg-l-grey ">Welcome To Matchadirekt</h2>
  </div>
            </div>
       
          </div>
        </div>

             
<div class="wlc-video text-center my-3 ">
 <iframe width="100%" height="300" src="https://www.youtube.com/embed/PfPC0WbX_co" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

 

<div class="tutorial-sect text-center">
<h3 class="tuto-title py-2 text-blue font-bold font-med text-center bg-l-grey"><?=lang('Tutorials');?></h3>
<ul>
  <?php if(isset($tutorialData) && $tutorialData !=''){ 
    foreach ($tutorialData as $tutor) {
       ?>
  <li class="border-bottom">
<h4 class="tuto-title2 mb-2 mt-1 my-md-3 text-black font-med"><?php echo $tutor->tutName; ?></h4>
<p class="tuto-decs text-black pb-2 pb-md-3"><?php echo $tutor->tutDescrip; ?></p>
</li>
<?php } 
} ?>
 </ul>
  </div>

           
            <!-- row -->
        </div>
        <!-- container -->
    </div>
</section>



<!-- -------------footer----------------- -->


<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
 <?php  if( $staticUrl == STATICWEBCOMPURL){ ?>
        <!-- editor -->
          <script type="text/javascript" src="<?php echo  $staticUrl; ?>/summernote/dist/summernote-bs4.js"></script>
          <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1//js/froala_editor.pkgd.min.js"></script>
      <script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/align.min.js"></script>
    <script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/code_beautifier.min.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/froala_editor.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/align.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/code_beautifier.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/code_view.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/colors.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/draggable.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/emoticons.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/font_size.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/font_family.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/image.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/file.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/image_manager.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/line_breaker.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/link.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/lists.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/paragraph_format.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/paragraph_style.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/video.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/table.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/url.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/entities.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/char_counter.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/inline_style.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/save.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/fullscreen.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/quote.min.js"></script>
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/quick_insert.min.js"></script> -->
<?php } ?>
<script src='<?php echo  $staticUrl; ?>/js/moment.min.js'></script>

<script src='<?php echo  $staticUrl; ?>/js/jquery-ui.min.js'></script>
<script src="<?php echo  $staticUrl; ?>/js/custom.js"></script>
</body>

</html>