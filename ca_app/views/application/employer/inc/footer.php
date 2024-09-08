<!-- </div> -->
<!-- jQuery -->
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
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="<?php echo  $staticUrl; ?>/js/mobile-menu.js"></script>
<script src="<?php echo  $staticUrl; ?>/js/hammer.min.js"></script>
<script src="<?php echo  $staticUrl; ?>/js/tindercards.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
 <?php  if( $staticUrl == STATICAPPCOMPURL){ ?>
        <!-- editor -->
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/froala_editor.min.js"></script>
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
<script type="text/javascript" src="<?php echo  $staticUrl; ?>/js/editor/quick_insert.min.js"></script>
<?php } ?>
<script src='<?php echo  $staticUrl; ?>/js/moment.min.js'></script>
<script src='<?php echo  $staticUrl; ?>/js/fullcalendar.min.js'></script>
<script src='<?php echo  $staticUrl; ?>/js/jquery-ui.min.js'></script>
<script src="<?php echo  $staticUrl; ?>/js/custom.js"></script>
</body>

</html>