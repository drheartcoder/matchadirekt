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
        <div class="row align-items-center">
            <div class="col-12">
                <h6 class="font-reg mt-3">Company Information</h6>
                <div class="">
                    <form class="row mt-4" action="job-tiles.php">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Your Name">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Company Name">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Select Industry</option>
                                <option value="3">Accounts</option>
                                <option value="5">Advertising</option>
                                <option value="7">Banking</option>
                                <option value="10">Customer Service</option>
                                <option value="42">Domstolsverket</option>
                                <option value="16">Graphic / Web Design</option>
                                <option value="18">HR / Industrial Relations</option>
                                <option value="40">IT - Hardware</option>
                                <option value="22">IT - Software</option>
                                <option value="35">Teaching / Education</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">Org. Type</option>
                                <option value="Private">Private</option>
                                <option value="Public">Public</option>
                                <option value="Government">Government</option>
                                <option value="Semi-Government">Semi-Government</option>
                                <option value="NGO">NGO</option>
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
                            <input type="number" class="form-control" placeholder="Mobile Phone">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Home Phone">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Company Website">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control">
                                <option selected="" disabled="">No. of Employees</option>
                                <option value="1-10">1-10</option>
                                <option value="11-50">11-50</option>
                                <option value="51-100">51-100</option>
                                <option value="101-300">101-300</option>
                                <option value="301-600">301-600</option>
                                <option value="601-1000">601-1000</option>
                                <option value="1001-1500">1001-1500</option>
                                <option value="1501-2000">1501-2000</option>
                                <option value="More than 2000">More than 2000</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                                <textarea class="form-control" placeholder="Company Description" rows="2"></textarea>
                                <span></span>
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