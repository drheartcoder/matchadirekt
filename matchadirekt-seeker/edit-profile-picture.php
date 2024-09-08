<?php include 'header.php'; ?>
<section>
    <div class="container">
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
            <div class="form-group user-img">
                <img src="images/user.png" class="w-100">
                <div class="wrap-custom-file w-100">
                    <input type="file" name="image5" id="image5" accept=".gif, .jpg, .png" / required="">
                    <label class="mb-0 py-3" for="image5">
                        <i class="fas fa-plus-circle"></i>
                        <span class="text-black font-med">Tap To Select</span>
                    </label>
                </div>
            </div>
            <div class="form-group col-12 mb-3">
                <button type="submit" class="btn btn-blue">Update</button>
            </div>
        </form>
        <!-- col -->
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php include 'footer.php'; ?>