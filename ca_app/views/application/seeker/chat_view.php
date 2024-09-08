<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section class="vheight-100">
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/messenger" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?php echo $conversationData->employerName;  ?></h2>
            </div>
            <div class="col-2 text-right">
                <ul class="mb-0">
                  <!--   <li class="d-inline-block"><a href="<?php //echo APPURL; ?>/seeker/settings/inbox"><img src="<?php //echo  $staticUrl; ?>/images/delete.svg" class="img-fluid"></a></li> -->
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card conversation-block border-0">
                    <div class="card-body scroll px-0" id="chatBox">
                        <?php
                        foreach ($messages as $msg) {
                            if($msg->type_sender!="employers"){
                                $class = "send";
                            } else {
                                 $class = "received";
                             }
                                ?>
                                <div class="main-msg-block mb-3">
                                    <div class="msg-block">
                                        <div class="msg-container <?php echo $class; ?>">
                                            <span class="msg-text"><?php echo $msg->message; ?></span>
                                        </div>
                                    </div>
                                </div>
                            
                            <?php
                        }
                            ?>
                    </div>
                    <form enctype="multipart/form-data" method="post" action="<?=APPURL.'/seeker/messenger/send-message/'.$this->custom_encryption->encrypt_data($conversationData->id_employer)?>">
                        <div class="card-footer border-0 rounded-0">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control shadow" name="message" id="message">
                                <div class="input-group-append">
                                     <button href="javascript:;" onclick="$('#upload_file').click();return false;" title="<?=lang('Upload File')?>" class="btn send-bgn"><i class="fa fa-file">&nbsp;</i></button>
                                    <input type="file" name="upload_file" id="upload_file" style="display:none;"/>
                                    <button type="submit" class="btn send-bgn d-flex"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>
<script>
$(document).ready(function(){           
    $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
    $('#message').focus();
});

$("#upload_file").change(function(){
    ext_array = ['doc','docx','pdf','rtf','png','jpg','jpeg'];  
    var ext = $('#upload_file').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ext_array) == -1) {
      alert("<?=lang('Invalid file provided')?>!");
      return false;
    }
   this.form.submit();
  });
</script>