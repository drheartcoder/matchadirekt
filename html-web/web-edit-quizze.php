<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>

   <section class="main-container vheight-100 justify-content-between">

  <div class="container">
       <div class="col-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="web-quizzes.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Edit Archive</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 p-0 bg-white">
                <div class="text-center">
                    <form class="mt-4" action="web-job-tiles.php">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="Title">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea class="form-control" placeholder="Quizz Text" rows="2"></textarea>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="answer 1">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="answer 2">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="answer 3">
                            <span></span>
                        </div>
                          <a href="web-archive.php" class="btn-comm btn-blue mx-3 my-2">Update</a>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
   
</div>
</section>
   
     


<!-- section -->
<?php include 'footer.php'; ?>
