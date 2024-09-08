<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>

   <section class="main-container vheight-100 justify-content-between">
       <div class="container ">
           <div class="col-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="web-job-analysis.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">New Certificate</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 px-2">
                <div class="">
                    <form class="row mt-4" action="web-job-tiles.php">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Title">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Slug">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div id='edit'></div>
                        </div>
                       
<div class="col-12 col-lg-10 col-xl-8 mx-auto">
                            <div class="row">
                        <div class="form-group col-6 mb-2">
                            <button type="submit" class="btn btn-blue">Cancel</button>
                        </div>
                        <div class="form-group col-6 mb-2">
                            <a href="web-login.php" class="btn btn-blue">Add</a>
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
