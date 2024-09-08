<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>

   <section class="main-container vheight-100 justify-content-between">
   <div class="container">

 <div class="col-11 col-lg-9 col-xl-9 vheight-100  mx-auto">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="web-save-candidates.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">View Candidates</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list view-candi mb-0">
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="media-body">
                                    <div class="row align-items-center">
                                        <div class="col-12 card-title mb-0"><a href="web-full-post.php">Candidate Name</a></div>
                                        <div class="col-12 card-title mb-3"><a href="web-view-job.php">Web Designer</a></div>
                                        <div class="col-12 mb-2">
                                            <ul>
                                                <li class="h6">Ref. : <span>#JB00158</span></li>
                                                <li class="h6">Apply Date: <span>Jan 12, 2020</span></li>
                                            </ul>
                                        </div>
                                        <div class="col-12 card-title mb-0">Add Event with this Candidate</div>
                                        <div class="form-group col-12 mb-3 mt-3">
                                            <input type="date" class="form-control" placeholder="Date">
                                            <span></span>
                                        </div>
                                        <div class="form-group col-12 mb-3">
                                            <input type="time" class="form-control" placeholder="Time">
                                            <span></span>
                                        </div>
                                        <div class="form-group col-12 mb-3">
                                            <input type="text" class="form-control" placeholder="Notes">
                                            <span></span>
                                        </div>
                                        <div class="form-group col-12 text-center mx-auto mb-3">
                                            <button type="submit" class="btn-comm btn-blue">Add</button>
                                        </div>
                                        <div class="col-12 card-title mb-0"><a href="web-full-post.php">Edit Status</a></div>
                                        <div class="form-group col-12 mb-3 mt-3">
                                            <select class="form-control">
                                                <option selected="selected" value="">Primary</option>
                                                <option value="Selection">Selection</option>
                                                <option value="Interview">Interview</option>
                                                <option value="Success">Success</option>
                                                <option value="Failure">Failure</option>
                                            </select>
                                            <span></span>
                                        </div>
                                        <div class="col-12">
                                            <p>NOTE: The job seeker will be notified once you change status of this application</p>
                                        </div>
                                        <div class="form-group col-12 text-center mx-auto mb-3">
                                            <a href="web-view-job.php" class="btn-comm btn-blue">Application Details</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</div>
   
 
        
</section>
   
     


<!-- section -->
<?php include 'footer.php'; ?>
