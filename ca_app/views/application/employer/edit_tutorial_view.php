<?php $this->load->view('application/inc/header'); ?>

<?php 
    $staticUrl = STATICAPPCOMPURL; 
?>

<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/tutorials" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Edit Tutorial</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="post">
                        <div class="form-group col-12 mb-3">
                            <!-- <input type="text" class="form-control" value="Lorem Ipsum" placeholder="Title"> -->
                            <select class="form-control" name="selCompIndustry" id="selCompIndustry">
                                <option selected="" disabled="">Select Industry</option>
                                 <?php foreach($result_industries as $row_industry):
                                      $selected = ($tutorialData->industry_ID==$row_industry->ID)?'selected="selected"':'';
                                ?>
                                    <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
                                    <?php endforeach;?>
                                   
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="<?php echo ($tutorialData->tutorial_name); ?>" placeholder="Tutorial Name" name="txtTutorialName" id="txtTutorialName">
                            <span></span> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div id='edit'>
                            </div>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"><?php echo $tutorialData->tutorial_description; ?></textarea> 
                        </div>
                        <div class="form-group col-6 mb-3">
                       <a href="<?php echo APPURL; ?>/employer/tutorials" class="btn btn-blue" >Cancel</a> 
                        </div>
                        <div class="form-group col-6 mb-3">
                       
                            <button type="submit" class="btn btn-blue" name="btnUpdateTut" id="btnUpdateTut">Update</button>
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
<script type="text/javascript">
 
 $(document).ready(function(){
    $('#hiddeninput').hide();
  });
  $(document).ready(function(){
      $('#hiddeninput').hide();
      var str = '<?php echo $tutorialData->tutorial_description; ?>';
      var str1 =str.replace(";","");
     $('.fr-element').html(str1);
  });   

    $(function(){
      $('#btnUpdateTut').click(function () {
        var chk = $('.fr-element').children().html();
        $('#hiddeninput').val(chk);
      });
  });

</script>