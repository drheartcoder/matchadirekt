<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;

//myPrint($candidateDetails);die;?>
<form class="vheight-100 justify-content-between" method="POST" action="#">
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/quizzes" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Edit Archive</h2>
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
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
            <button type="submit" class="btn btn-blue" name="btnUpdateQuizz" id="btnUpdateQuizz">Submit</button>
                <!-- <button type="submit" class="btn btn-blue">Update</button> -->
            </div>
        </div>
    </div>
    <!-- container -->
</form>
<!-- section -->

<?php $this->load->view('application/inc/footer'); ?>