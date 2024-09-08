<?php include 'header.php'; ?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="certificate.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">New Certificate</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="job-tiles.php">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="Lorem Ipsum">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="Lorem Ipsum">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div id='edit'></div>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <button type="submit" class="btn btn-blue">Cancel</button>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <a href="login.php" class="btn btn-blue">Add</a>
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
<?php include 'footer.php'; ?>