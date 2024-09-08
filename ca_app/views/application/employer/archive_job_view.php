<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
?>
<section class="vheight-100 justify-content-between">
  <form method="POST" action="#">
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="archive.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Add Archive</h2>
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
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                 <a href="archive.php" class="btn btn-blue">Add</a>
            </div>
        </div>
    </div>
    <!-- container -->
    </form>
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>