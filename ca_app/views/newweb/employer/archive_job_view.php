<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>
<section class="main-container vheight-100 justify-content-between">
  <div class="container">
        <div class="col-11 col-lg-9 col-xl-9 mx-auto bg-white">
            <form method="POST" action="#">
    
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="archive.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Add Archive')?></h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <div class="row mt-4" action="job-tiles.php">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="Label">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" value="Description">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
   
    <!-- container -->
    <div class="container">
        <div class="col-11 col-lg-9 col-xl-9 mx-auto bg-white">
                 <a href="archive.php" class="btn btn-blue"><?=lang('Add')?></a>
        </div>
      </div>
    <!-- container -->
    </form>
</div>
</div>
  
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>