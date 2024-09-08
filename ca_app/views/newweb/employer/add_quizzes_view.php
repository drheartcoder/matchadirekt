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

<form class="main-container vheight-100 justify-content-between" method="POST" action="#">
    <div class="container">
        <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/quizzes" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Add Quizzes')?></h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                   <!--  <form class="row mt-4" action="job-tiles.php"> -->
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="Title" name="title" id="title">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea class="form-control" name="quizz" id="quizz"  placeholder="Quizz Text" rows="2"></textarea>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text"  name="answer1" id="answer1" class="form-control" placeholder="answer 1">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text"   name="answer2" id="answer2" class="form-control" placeholder="answer 2">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text"  name="answer3" id="answer3" class="form-control" placeholder="answer 3">
                            <span></span>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
        <div class="col-12 text-center mx-auto mb-3">
                             
                    <button type="submit" class="btn btn-comm btn-blue" name="btnAddQuizz" id="btnAddQuizz"><?=lang('Add')?></button>
     
                    <!--  <a href="<?php// echo WEBURL; ?>/employer/quizzes" class="btn btn-blue" name="btnAddQuizz">Add</a> -->
            </div>
    </div>
    <!-- container -->
   
    </div>
    <!-- container -->
</form>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>