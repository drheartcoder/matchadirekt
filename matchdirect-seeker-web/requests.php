<?php include 'header.php'; ?>
<div class="web-sidebar bg-white vheight-100">
<?php include 'web-sidebar.php'; ?>
</div>
<section class="main-container vheight-100">
    <div class="container h-100">
        <div class="col-11col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="settings.php" class="d-block">
                    <img src="images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Notification</h2>
            </div>
            <div class="col-2 text-right">
                <ul class="mb-0">
                    <li class="d-inline-block"><a href="inbox.php"><img src="images/delete.svg" class="img-fluid"></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <ul class="messages-list">
                    <li class="py-2 align-items-center px-3 bdr-btm">
                        <a class="media" href="request-view.php">
                            <div class="media-body">
                                <div class="row">
                                    <h5 class="col-6 card-title mb-0">Company Name Inc.</h5>
                                    <span class="col-6 text-right text-d-grey"><small>YESTERDAY, 2:30 PM</small></span>
                                </div>
                                <p class="last-msg mb-0">Request for job interview</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-2 align-items-center px-3 bdr-btm">
                        <a class="media" href="request-view.php">
                            <div class="media-body">
                                <div class="row">
                                    <h5 class="col-6 card-title mb-0">Company Name Inc.</h5>
                                    <span class="col-6 text-right text-d-grey"><small>YESTERDAY, 2:30 PM</small></span>
                                </div>
                                <p class="last-msg mb-0">Request for job interview</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-2 align-items-center px-3">
                        <a class="media" href="request-view.php">
                            <div class="media-body">
                                <div class="row">
                                    <h5 class="col-6 card-title mb-0">Company Name Inc.</h5>
                                    <span class="col-6 text-right text-d-grey"><small>YESTERDAY, 2:30 PM</small></span>
                                </div>
                                <p class="last-msg mb-0">Request for job interview</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php include 'footer.php'; ?>