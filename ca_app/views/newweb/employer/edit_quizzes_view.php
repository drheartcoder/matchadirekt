<?php $this->load->view('newweb/inc/header'); ?>
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
                <h2 class="mb-0"><?=lang('Edit Quiz')?></h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <?php //myPrint($results);die;?>
                   <!--  <form class="row mt-4" action="job-tiles.php"> -->
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control"  value="<?=$results->title?>" name="title">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea name="quizz" class="form-control" placeholder="Quizz Text" rows="2" name="quizz" ><?=$results->quizz ;?></textarea>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input name="answer1" type="text" class="form-control" id="answer1" value="<?=$results->answer1 ;?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input name="answer2" type="text" class="form-control" id="answer2" value="<?=$results->answer2 ;?>">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input name="answer3" type="text" class="form-control" id="answer3" value="<?=$results->answer3 ;?>">
                            <span></span>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
             <div class="col-12 text-center mx-auto mb-3">
                <button type="submit" class="btn btn-comm btn-blue" name="btnUpdateQuizz" id="btnUpdateQuizz"><?=lang('Submit')?></button>
                <!-- <button type="submit" class="btn btn-blue">Update</button> -->
            </div>
    </div>

    <!-- container -->
    <!-- <div class="container">
   
        </div> -->
    </div>
    </div>
    <!-- container -->
</form>
<!-- section -->

<?php $this->load->view('newweb/inc/footer'); ?>