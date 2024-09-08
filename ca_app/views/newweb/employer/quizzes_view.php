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

//myPrint($candidateDetails);die;?>
<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                $this->load->library('Mobile_Detect');
                $detect = new Mobile_Detect();
                if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
                    $redirectUrl =WEBURL."/employer/settings";
                } else {
                    $redirectUrl = WEBURL."/employer/home";
                }
                ?>
                <a href="<?php echo  $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('All Quizzes')?></h2>
            </div>
            <div class="col-2 pr-0 text-right">
                <a href="<?php echo WEBURL; ?>/employer/quizzes/add-quizzes" class="btn btn-blue add-btn rounded-0">
                    <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                </a>
            </div>
        </div>
<?php // myPrint($results);die; 
 if(isset($results) && $results !=''){ ?>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                                  <?php //myPrint($results);die;
                                 foreach($results as $quizz) {
                                 ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="<?php echo WEBURL; ?>/employer/quizzes/delete/<?php echo $quizz->ID; ?>" class="bg-red"><img src="<?php echo  $staticUrl; ?>/images/close-white.svg" class="w-100"></a></li>
                                        <li><a href="<?php echo WEBURL; ?>/employer/quizzes/edit-quizzes/<?php echo $quizz->ID; ?>" class="bg-blue"><img src="<?php echo  $staticUrl; ?>/images/edit-pen.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <div class="media-body">
                                    <div class="row align-items-center">
                                        <div class="col-6 card-title mb-0"><?php echo $quizz->title;?></div>
                                        <p class="col-6 text-d-grey mb-0"><?php echo date_format($quizz->created_at,'M j,Y');?></p>
                                    </div>
                                </div>
                            </li>
                        <?php }?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>