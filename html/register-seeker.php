<?php include 'header.php'; ?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="login.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Register here</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <h6 class="font-reg mt-3">Register as</h6>
                <ul class="nav nav-pills row" id="pills-tab" role="tablist">
                    <li class="col-6 nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills-home" role="tab" aria-selected="true">Seeker</a>
                    </li>
                    <li class="col-6 nav-item">
                        <a class="nav-link" data-toggle="pill" href="#pills-profile" role="tab" aria-selected="false">Company</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                        <form class="row mt-4" action="login-with-phone.php">
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Full Name">
                                <span></span>
                            </div>
                            <div class="form-group col-5 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-7 mb-3"></div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Day</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Month</option>
                                    <option>test1</option>
                                    <option>test2</option>
                                    <option>test3</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-4 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Year</option>
                                    <option>1990</option>
                                    <option>1991</option>
                                    <option>1992</option>
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
                                <select class="form-control">
                                    <option selected="" disabled="">Channel</option>
                                    <option>Channel1</option>
                                    <option>Channel2</option>
                                    <option>Channel3</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <button type="submit" class="btn btn-blue">Continue</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                        <form class="row mt-4" action="login-with-phone.php">
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Full Name">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Company Name">
                                <span></span>
                            </div>
                            <div class="form-group col-6 mb-3">
                                <select class="form-control">
                                    <option value="" selected="" disabled="">Select Industry</option>
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
                            <div class="form-group col-6 mb-3">
                                <select class="form-control">
                                    <option value="Private" selected="" disabled="">Org. Type</option>
                                    <option value="Private">Private</option>
                                    <option value="Public">Public</option>
                                    <option value="Government">Government</option>
                                    <option value="Semi-Government">Semi-Government</option>
                                    <option value="NGO">NGO</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <textarea class="form-control" placeholder="Address" rows="2"></textarea>
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
                                <input type="number" class="form-control" placeholder="Landline Phone">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="Cell Phone">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Company Website">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option value="1-10">No. of Employees</option>
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
                                <select class="form-control">
                                    <option>Channel</option>
                                    <option>Channel1</option>
                                    <option>Channel2</option>
                                    <option>Channel3</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <div class="wrap-custom-file">
                                    <input type="file" name="image5" id="image5" accept=".gif, .jpg, .png" / required="">
                                    <label for="image5">
                                        <i class="fas fa-plus-circle"></i>
                                        <span>Company Logo</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <button type="submit" class="btn btn-blue">Continue</button>
                            </div>
                        </form>
                    </div>
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