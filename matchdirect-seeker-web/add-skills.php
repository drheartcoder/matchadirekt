<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100">
    <div class="container">
        <div class="col-11 col-lg-9 col-xl-8 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="my-cv.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Add Skills</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="job-tiles.php">
                        <div class="form-group col-12 skill-block py-3 bg-l-grey">
                            <ul class="skill-group mb-0">
                                <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                                    <button type="button" class="close">
                                        <img src="images/skill-close.svg" class="w-100 svg">
                                    </button>
                                    HTML
                                </li>
                                <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                                    <button type="button" class="close">
                                        <img src="images/skill-close.svg" class="w-100 svg">
                                    </button>
                                    HTML
                                </li>
                                <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2">
                                    <button type="button" class="close">
                                        <img src="images/skill-close.svg" class="w-100 svg">
                                    </button>
                                    HTML
                                </li>
                            </ul>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Add Skills">
                                <div class="input-group-append ml-0">
                                    <button class="btn btn-blue add-btn rounded-0" type="button">
                                        <img src="images/plus-white.svg" class="w-100">
                                    </button>
                                </div>
                            </div>
                            <span></span>
                        </div>
                         <div class="col-12 col-lg-9 col-xl-8 mx-auto mb-3">
                            <div class="row">
                        <div class="form-group col-6 mb-3">
                            <button type="submit" class="btn btn-blue">Update</button>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <a href="my-cv.php.php" class="btn btn-blue">Cancel</a>
                        </div>
                    </div>
                </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php include 'footer.php'; ?>