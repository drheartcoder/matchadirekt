<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
    <?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100 justify-content-between">
    <div class="container">
        <div class="col-11 col-lg-9 col-xl-9 mx-auto bg-white">
            <div class="row top-header bg-l-grey align-items-center">
                <div class="col-2">
                    <a href="web-my-jobs.php" class="d-block">
                        <img src="images/back-arrow.png" class="back-arrow">
                    </a>
                </div>
                <div class="col-8 text-center">
                    <h2 class="mb-0">Edit Job</h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12 px-4">
                    <div class="">
                        <form class="row mt-4" action="web-job-tiles.php">
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
                                <input type="text" class="form-control" placeholder="Job Title">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="text" class="form-control" placeholder="Diarienummer">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="number" class="form-control" placeholder="No.of Vacancies">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Experience Required</option>
                                    <option value="Less than 1">Less than 1 year</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="10+">10+</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Job Mode</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Home Based">Home Based</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Salary Offer(Pk Rs.)</option>
                                    <option value="Trainee Stipend">Trainee Stipend</option>
                                    <option value="5000-10000">5-10</option>
                                    <option value="11000-15000">11-15</option>
                                    <option value="16000-20000">16-20</option>
                                    <option value="21000-25000">21-25</option>
                                    <option value="26000-30000">26-30</option>
                                    <option value="31000-35000">31-35</option>
                                    <option value="36000-40000">36-40</option>
                                    <option value="41000-50000">41-50</option>
                                    <option value="51000-60000">51-60</option>
                                    <option value="61000-70000">61-70</option>
                                    <option value="71000-80000">71-80</option>
                                    <option value="81000-100000">81-100</option>
                                    <option value="100000-120000">101-120</option>
                                    <option value="120000-140000">121-140</option>
                                    <option value="140000-160000">141-160</option>
                                    <option value="160000-200000">161-200</option>
                                    <option value="200000-240000">201-240</option>
                                    <option value="240000-280000">241-280</option>
                                    <option value="281000-350000">281-350</option>
                                    <option value="350000-450000">351-450</option>
                                    <option value="450000 or above">450 or above</option>
                                    <option value="Discuss">Discuss</option>
                                    <option value="Depends">Depends</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <small class="text-d-grey">Apply Before</small>
                                <input type="date" class="form-control" placeholder="Apply Before">
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
                                    <option selected="" disabled="">Qualification</option>
                                    <option value="BA">BA</option>
                                    <option value="BE">BE</option>
                                    <option value="BS">BS</option>
                                    <option value="CA">CA</option>
                                    <option value="Certification">Certification</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="HSSC">HSSC</option>
                                    <option value="MA">MA</option>
                                    <option value="MBA">MBA</option>
                                    <option value="MS">MS</option>
                                    <option value="PhD">PhD</option>
                                    <option value="SSC">SSC</option>
                                    <option value="ACMA">ACMA</option>
                                    <option value="MCS">MCS</option>
                                    <option value="Does not matter">Does not matter</option>
                                    <option value="B.Tech">B.Tech</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="form-group col-12  mb-3">
                                <div id='edit'></div>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Select Quizze</option>
                                    <option>No Quizzes</option>
                                    <option>HTML</option>
                                    <option>CSS</option>
                                </select>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Choose a Job Analysis</option>
                                    <option value="8">test analysis</option>
                                    <option value="9">asdfasdf</option>
                                </select>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Choose a Employer Certificate</option>
                                    <option value="10">Web Designer</option>
                                </select>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Choose a Interview</option>
                                    <option value="13">Web Designer</option>
                                    <option value="14">asdfasdf</option>
                                </select>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <select class="form-control">
                                    <option selected="" disabled="">Job type</option>
                                    <option value="Internal">Internal</option>
                                    <option value="External">External</option>
                                    <option value="Local">Local</option>
                                    <option value="National">National</option>
                                    <option value="Social channels">Social channels</option>
                                    <option value="Newspapers">Newspapers</option>
                                </select>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <input type="password" class="form-control" placeholder="Password (* Internal only)">
                                <span></span>
                            </div>
                            <div class="form-group col-12 mb-3">
                                <textarea class="form-control" placeholder="Note" rows="2"></textarea>
                                <span></span>
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
                            <div class="form-group col-12  skill-block py-3 bg-l-grey">
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
                            <div class="col-12"></div>
                            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                                <div class="row">
                                    <div class="form-group col-6 mb-3">
                                        <button type="submit" class="btn btn-blue">Cancel</button>
                                    </div>
                                    <div class="form-group col-6 mb-3">
                                        <a href="web-login.php" class="btn btn-blue">Update</a>
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
        <!-- container -->
    </div>
</section>
<!-- section -->
<?php include 'footer.php'; ?>