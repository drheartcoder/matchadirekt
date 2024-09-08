<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;?>

<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/certificate" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Edit Certificate</h2>
            </div>
        </div>
        <?php if(isset($results) && $results !=''){ ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="POST">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="<?=$results->pageTitle?>" name="pageTitle">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="<?=$results->pageSlug?>" name="pageSlug">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div id='edit'>
                            </div>
                        </div>

                         <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"><?php echo $results->pageContent; ?></textarea> 
                        </div>
                        <div class="form-group col-6 mb-3">
                             <a href="<?php echo APPURL; ?>/employer/certificate" class="btn btn-blue">Cancel</a>
                            
                        </div>
                        <div class="form-group col-6 mb-3">
                           <button type="submit" class="btn btn-blue" name="btnUpdateCer" id="btnUpdateCer">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php } ?>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<?php $this->load->view('application/inc/footer'); ?>

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
      $('#btnUpdateCer').click(function () {
        var chk = $('.fr-element').html();
        $('#hiddeninput').val(chk);
      });
  });

</script>