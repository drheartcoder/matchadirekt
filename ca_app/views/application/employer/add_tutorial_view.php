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
                <a href="<?php echo APPURL; ?>/employer/tutorials" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">New Tutorial</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="post">
                        <div class="form-group col-12 mb-3">
                            <!-- <input type="text" name="txtTitle" id="txtTitle" class="form-control" value="course" placeholder="Title">
 -->                         <select class="form-control" name="selCompIndustry" id="selCompIndustry">
                                    <option value="" selected="" disabled=""><?=('Industry')?></option>
                                    <option value="" selected><?=('Select Industry')?></option>
                                      <?php foreach($result_industries as $row_industry):
                                                    $selected = (set_value('selCompIndustry')==$row_industry->ID)?'selected="selected"':'';
                                          ?>
                                      <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
                                      <?php endforeach;?>
                                </select>
                                <span></span>
                                <!--  <?php //echo (form_error('selCompIndustry')); ?> 
                                  <small id="errselCompIndustry" class="form-text text-muted">This Field is required</small> -->
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" name="txtTutorialName" id="txtTutorialName" class="form-control" value="Tutorial Name" placeholder="Tutorial Name">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                           
                            <div id='edit' name="txtEdit"></div>
                            <span></span>
                            <?php //echo form_error('hiddeninput'); ?>
                            <small id="errhiddeninput" class="form-text text-muted">This Field is required</small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"></textarea> 
                        </div>

                        <div class="form-group col-6 mb-3">
                        	<a href="<?php echo APPURL; ?>/employer/tutorials" class="btn btn-blue" >Cancel</a>   
                        </div>
                        <div class="form-group col-6 mb-3">
                         
                            <button type="submit" class="btn btn-blue" name="btnSubmitTut" id="btnSubmitTut">Submit</button>
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

$(function(){
      $('#btnSubmitTut').click(function () {
        var chk = $('.fr-element').html();
        $('#hiddeninput').val(chk);
      });
  });
</script>
<script type="text/javascript">
    new FroalaEditor('div#edit', {
    videoResponsive: true,
    toolbarButtons: ['insertVideo']
  })
</script>