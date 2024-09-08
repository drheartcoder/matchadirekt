<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100">
    <div class="container">
       <div class="col-10 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="my-cv.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Add Document</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <form class="row mt-4" action="job-tiles.php">
                    <div class="form-group col-12 skill-block py-3 bg-l-grey">
                        <ul>
                            <li class="bdr-btm py-3 position-relative">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="#" class=""><img src="images/close-white2.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <h6><img src="images/file.svg" class="mr-2">File N:1</h6>
                                <a href="javascript:void(0)">Certificate.docx</a>
                            </li>
                            <li class="bdr-btm py-3 position-relative">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="#" class=""><img src="images/close-white2.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <h6><img src="images/file.svg" class="mr-2">File N:1</h6>
                                <a href="javascript:void(0)">Certificate.docx</a>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group col-12 mb-3">
                        <div class="input-group justify-content-center">
                            <div class="wrap-custom-file w-100">
                                <input type="file" name="image5" id="image5" required="">
                                <label for="image5">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Company Logo</span>
                                </label>
                            </div>
                            <div class="input-group-append ml-0 mt-3">
                                <button class="btn btn-blue add-btn rounded-0" type="button">
                                    <img src="images/plus-white.svg" class="w-100">
                                </button>
                            </div>
                        </div>
                        <span></span>
                    </div>
                     <div class="col-12 col-lg-9 col-xl-8 mx-auto my-3">
                        <div class="row">
                    <div class="form-group col-6 mb-3">
                        <button type="submit" class="btn btn-blue">Update</button>
                    </div>
                    <div class="form-group col-6 mb-3">
                        <a href="my-cv.php" class="btn btn-blue">Cancel</a>
                    </div>
                </div>
            </div>
                </form>
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