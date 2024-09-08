<?php include 'header.php'; ?>
<section class="vheight-100 justify-content-between">
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="quizzes.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Edit Archive</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="job-tiles.php">
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
                    </form>
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
                 <a href="archive.php" class="btn btn-blue">Update</a>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php include 'footer.php'; ?>