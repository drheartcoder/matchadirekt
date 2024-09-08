<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>

<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/seeker/settings/notification" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Company Name Inc.</h2>
            </div>
            <div class="col-2 text-right">
                <ul class="mb-0">
                    <li class="d-inline-block"><a href="<?php echo WEBURL; ?>/seeker/settings/inbox"><img src="<?php echo  $staticUrl; ?>/images/delete.svg" class="img-fluid"></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card conversation-block border-0">
                    <div class="card-body scroll px-0">
                        <div class="main-msg-block mb-3">
                            <div class="msg-block">
                                <div class="msg-container received">
                                    <span class="msg-text">The person who says it cannot be done should not interrupt the person who is doing it.</span>
                                </div>
                            </div>
                        </div>
                        <!-- msg -->
                    </div>
                    <div class="card-footer border-0 rounded-0">
                        <div class="input-group mb-0">
                            <input type="text" class="form-control shadow">
                            <div class="input-group-append">
                                <button type="button" class="btn send-bgn d-flex"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
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
<?php $this->load->view('newweb/inc/footer'); ?>