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
                <h2 class="mb-0">View Tutorial</h2>
            </div>
        </div>
        <?php if(isset($tutorialData) && $tutorialData!=0){
            //myPrint($tutorialData);die;
         ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $tutorialData->tutorial_name;?></h5>
                  <!--   <h6 class="card-subtitle mb-2">Web Designer</h6> -->
                   <!--  <p>Demo NOTE: You can edit this default content on admin CMS page </p> -->
                    <ul>
                        <li>Industry Name: <span><?php echo $tutorialData->industry_name;?></span></li>
                       <!--  <li>Job Title: <span>Lorem Ipsum</span></li>
                        <li>Classification: <span>Lorem Ipsum</span></li>
                        <li>Department/Division: <span>Lorem Ipsum</span></li>
                        <li>Location: <span>Lorem Ipsum</span></li>
                        <li>Pay Grade: <span>Lorem Ipsum</span></li> -->
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2">About Summary</h6>
                        <p><?php echo $tutorialData->tutorial_description;?></p>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php } ?>
        <!-- row -->
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="<?php echo APPURL; ?>/employer/tutorials" class="btn btn-blue">Back</a>
            </div>
        </div>
    </div>
</section>
<!-- section -->

<?php $this->load->view('application/inc/footer'); ?>