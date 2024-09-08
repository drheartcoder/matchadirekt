<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo WEBURL.'/employer/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
    //myPrint($_SESSION);exit;

?>

<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/tutorialadmin" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('View Tutorial')?></h2>
            </div>
        </div>
        <?php if(isset($tutorialData) && $tutorialData!=0){
            //myPrint($tutorialData);die;
         ?>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1"><?php echo $tutorialData->tutName;?></h5>
                  <!--   <h6 class="card-subtitle mb-2">Web Designer</h6> -->
                   <!--  <p>Demo NOTE: You can edit this default content on admin CMS page </p> -->
                    <ul>
                       <!--  <li><?=lang('Industry Name')?>: <span><?php echo $tutorialData->industry_name;?></span></li> -->
                       <!--  <li>Job Title: <span>Lorem Ipsum</span></li>
                        <li>Classification: <span>Lorem Ipsum</span></li>
                        <li>Department/Division: <span>Lorem Ipsum</span></li>
                        <li>Location: <span>Lorem Ipsum</span></li>
                        <li>Pay Grade: <span>Lorem Ipsum</span></li> -->
                    </ul>
                    <div class="about-summary">
                        <h6 class="mb-2"><?=lang('About Summary')?></h6>
                        <p><?php echo $tutorialData->tutDescrip;?></p>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php } ?>
        <!-- row -->
          <div class="col-12 mb-3 text-center px-0">
                <a href="<?php echo WEBURL; ?>/tutorialadmin" class="btn btn-comm btn-blue"><?=lang('Back')?></a>
            </div>
    </div>

</div>
    <!-- container -->
  <!--   <div class="container">
        <div class="row">
            
        </div>
    </div> -->
    </div>
</section>
<!-- section -->

<?php $this->load->view('newweb/inc/footer'); ?>