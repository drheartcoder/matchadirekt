<?php include 'header.php'; ?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="job-tiles.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Manage Account</h2>
            </div>
        </div>
        <div class="row">
            <div class="user-img">
                <img src="images/user.png" class="w-100">
                <div class="edit-block">
                    <ul>
                        <li><a href="edit-profile-picture.php" class="bg-blue"><img src="images/edit-pen.svg" class="w-100"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="job-tiles.php">
                        <div class="form-group col-12 mb-3">
                            <input type="email" class="form-control" placeholder="Email">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Full Name">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-4 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Day</option>
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-4 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Month</option>
                                <option>Jan</option>
                                <option>Feb</option>
                                <option>Mar</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-4 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Year</option>
                                <option>1980</option>
                                <option>1981</option>
                                <option>1982</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Current Address">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Location</option>
                                <option>test1</option>
                                <option>test2</option>
                                <option>test3</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Landmark">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Nationality</option>
                                <option>test1</option>
                                <option>test2</option>
                                <option>test3</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Mobile Phone">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Home Phone">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                <label class="custom-control-label text-d-grey" for="customControlAutosizing">Informations Privacy</label>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <button type="submit" class="btn btn-blue">Update</button>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <a href="login.php" class="btn btn-blue">Delete Account</a>
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