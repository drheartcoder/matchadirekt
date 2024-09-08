<?php $this->load->view('newweb/inc/header'); ?>
<!-- Include external CSS. -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1/css/froala_style.min.css" rel="stylesheet" type="text/css" /><?php $staticUrl = STATICWEBCOMPURL; ?>
<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/job-analysis" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Edit Analysis')?></h2>
            </div>
        </div>
        <?php if(isset($results) && $results !=''){ ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="POST">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="<?=$results->pageTitle?>" name="pageTitle" id="pageTitle">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="<?=$results->pageSlug?>" name="pageSlug" id="pageSlug">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div id='edit'>
                            </div>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"><?php echo $results->pageContent; ?></textarea> 
                        </div>

                        
  <div class="col-12 col-lg-9 mx-auto">
                          <div class="row">
                        <div class="form-group col-12 col-sm-6 mb-3">
                            <a href="<?php echo WEBURL; ?>/employer/job-analysis" class="btn btn-blue"><?=lang('Cancel')?></a>
                        </div>
                        <div class="form-group col-12 col-sm-6 mb-3">
                            <button type="submit" class="btn btn-blue" name="btnJobAnalysis" id="btnJobAnalysis"><?=lang('Update')?></button>
                        </div>
                    </div>
                </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
         <?php  } ?>
         <!-- row -->
    </div>
</div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
  <!-- Include external JS libs. -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
  <!-- Include Editor JS files. -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1//js/froala_editor.pkgd.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $('#hiddeninput').hide();
  var contents = '<?php echo $results->pageContent; ?>';
  $('#edit').froalaEditor({
  });
  $('#edit').froalaEditor('html.set', contents);
});
$(function(){
  $('#btnUpdateTut').click(function () {
    var chk = $('.fr-element').html();
    $('#hiddeninput').val(chk);
  });
});

</script>
<!-- Initialize the editor. -->
<script type="text/javascript">
    $(function() {
      $('#edit').froalaEditor({
        // Set the file upload URL.
        imageUploadURL: '<?php echo BASEURL; ?>/editorFiles/uploadimgJobAnalysis.php',
        imageUploadParams: {
          id: 'my_editor'
        }
      })
    });
</script>

<!-- 
<script type="text/javascript">
 
 $(document).ready(function(){
    $('#hiddeninput').hide();
  });
  $(document).ready(function(){
      $('#hiddeninput').hide();
      var str = '<?php echo $results->pageContent; ?>';
     $('.fr-element').html(str);
  });   

    $(function(){
      $('#btnJobAnalysis').click(function () {
        var chk = $('.fr-element').html();
        $('#hiddeninput').val(chk);
      });
  });

</script> -->