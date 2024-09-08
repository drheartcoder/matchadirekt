<!DOCTYPE html>
<html lang="en">
<?php 
    if($this->session->userdata("sessUserId") > 0){
        if($this->session->userdata("sessIsJobSeeker") == 1)
            $staticUrl = STATICAPPSEEKERURL; 
        else // if($this->session->userdata("sessIsEmployer") == 1)
            $staticUrl = STATICAPPCOMPURL; 
          
    } else {
        $staticUrl = STATICAPPCOMPURL; 
    }
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
    <?php  if( $staticUrl == STATICAPPCOMPURL){ ?>
        <!-- editor -->
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/froala_editor.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/froala_style.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/code_view.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/colors.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/draggable.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/emoticons.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/image_manager.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/image.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/line_breaker.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/table.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/char_counter.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/video.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/fullscreen.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/file.css">
        <link rel="stylesheet" href="<?php echo  $staticUrl; ?>/css/editor/quick_insert.css"> 
    <?php
    } ?>
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
    <!-- calendar -->
    <link href='<?php echo  $staticUrl; ?>/css/fullcalendar.min.css' rel='stylesheet' />
    <link href='<?php echo  $staticUrl; ?>/css/fullcalendar.print.css' rel='stylesheet' media='print' />
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
    <!-- <div class="wrapper"> -->