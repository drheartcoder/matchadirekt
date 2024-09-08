<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100">
    <div class="container">
        <div class="col-10 col-lg-8 col-xl-8 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="manage-account.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">My Cv</h2>
            </div>
        </div>
        <form class="row" action="manage-account.php">
            <div class="form-group  col-12 px-0 user-img text-center">
                <img src="images/user.png" class="w-100">
                <div class="wrap-custom-file w-100">
                    <input type="file" name="image5" id="image5" accept=".gif, .jpg, .png" / required="">
                    <label class="mb-0 py-3" for="image5">
                        <i class="fas fa-plus-circle"></i>
                        <span class="text-black font-med">Tap To Select</span>
                    </label>
                </div>
            </div>
            <div class="form-group col-12 mb-3 text-center">
                <button type="submit" class="btn-comm btn btn-blue">Update</button>
            </div>
        </form>
        <!-- col -->
        <!-- row -->
    </div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php include 'footer.php'; ?>