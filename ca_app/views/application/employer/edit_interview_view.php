<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo APPURL.'/employer/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;

?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
               <a href="<?php echo APPURL; ?>/employer/interview" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Edit Interview</h2>
            </div>
        </div>
        <?php if(isset($results) && $results !=''){
          // myPrint($results);die; 
         ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <?php //myPrint($results);die; ?>
                    <form class="row mt-4" action="#" method="POST">
                        <div class="form-group col-12 mb-3">
                            <input  class="form-control" placeholder="Title" value="<?=$results->pageTitle?>" type="text" name="pageTitle">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input  type="text" name="pageSlug" class="form-control" placeholder="Slug" value="<?=$results->pageSlug?>">
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
                        <a href="<?php echo APPURL; ?>/employer/interview" class="btn btn-blue">Cancel</a>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <button type="submit" class="btn btn-blue" name="txtBtnUpdate" id="txtBtnUpdate">Update</button>
                            
                        </div>
                </div>
            </div>
            <!-- col -->
        </div>
      <?php } ?>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<!-- section -->



<?php $this->load->view('application/inc/footer'); ?>

<script type="text/javascript">
 
 $(document).ready(function(){
    $('#hiddeninput').hide();
  });
  $(document).ready(function(){
      $('#hiddeninput').hide();
      var str = '<?php echo $results->pageContent; ?>';
      var str1 =str.replace(";","");
     $('.fr-element').html(str1);
  });   

    $(function(){
      $('#txtBtnUpdate').click(function () {
        var chk = $('.fr-element').children().html();
        $('#hiddeninput').val(chk);
      });
  });

</script>