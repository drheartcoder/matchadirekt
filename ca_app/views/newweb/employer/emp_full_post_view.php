<?php $this->load->view('newweb/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
    $.ajax({
      type: "GET",
      url: "<?php echo WEBURL.'/employer/home/get_list_of_matching_jobs';?>", 
      success: function(data) {
        $("#main").html(data);
      }
    });
</script>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
    //myPrint($_SESSION);exit;
?>

<section class="main-container vheight-100 justify-content-between">
  <div class="container">
        <div class="col-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/company" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Full Post')?></h2>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-12">
                <div class="py-3">
                    <h5 class="card-title mb-1"><?=lang('Marie Winter')?></h5>
                    <h6 class="card-subtitle mb-2"><?=lang('Designer')?></h6>
                    <ul class="list-unstyled mb-0">
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg">test@test.com</h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg">8805699566</h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg">06 May 1991</h6>
                            </div>
                        </li>
                        <li class="media align-items-center mb-1">
                            <div class="media-body">
                                <h6 class="mt-0 mb-0 font-reg">Kungsgatan 22, 651 08 Karlstad, Sweden</h6>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">Document</h6>
                    </div>
                    <div class="card-body px-3">
                        <ul>
                            <li>
                                <h6><img src="<?php echo  $staticUrl; ?>/images/file.svg" class="mr-2">File N:1</h6>
                                <a href="javascript:void(0)">Certificate.docx</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">About Marie</h6>
                    </div>
                    <div class="card-body px-3">
                        <p class="mb-0">We are looking for a UI/UX Designer to turn our software into easy-to-use products for our clients. If you have a portfolio of professional design projects that includes work with web/mobile applications, we’d like to meet you. Should be able to create creative UI for mobile application and website as per requirements. Should be able to create creative UI for mobile application and website as per requirements.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">References</h6>
                    </div>
                    <div class="card-body px-3">
                        <h5 class="card-title mb-2">test test</h5>
                        <h6 class="card-subtitle mb-2">Title: <span>Test</span></h6>
                        <h6 class="card-subtitle mb-2">Phone: <span>7965423640</span></h6>
                        <h6 class="card-subtitle mb-2">Email: <span>test@test.com</span></h6>
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">Experience</h6>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0">
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">Web Designer</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">Crystal Web Techs</p>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                            <span class="col-12 text-d-grey">Apr 2018 to Present</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">Web Designer</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">Crystal Web Techs</p>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                            <span class="col-12 text-d-grey">Apr 2018 to Present</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">Web Designer</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">Crystal Web Techs</p>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                            <span class="col-12 text-d-grey">Apr 2018 to Present</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">Education</h6>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0">
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">BE</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">CMCS</p>
                                            <span class="col-12 text-d-grey">2015</span>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">BE</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">CMCS</p>
                                            <span class="col-12 text-d-grey">2015</span>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3">
                                <a class="media" href="javascript:void(0)">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-2">BE</div>
                                            <p class="col-12 h6 last-msg mb-2 text-blue">CMCS</p>
                                            <span class="col-12 text-d-grey">2015</span>
                                            <span class="col-12 text-d-grey">Nashik, , India</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="card border-0 details-block">
                    <div class="card-header py-2 px-3 bg-blue border-0">
                        <h6 class="text-white mb-0">Applications</h6>
                    </div>
                    <div class="card-body px-0 py-0">
                        <ul class="messages-list mb-0">
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <h5 class="card-title mb-2">Web Designer</h5>
                                <h6 class="card-subtitle mb-2">Ref. <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">status <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">Comment <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">Rate <span>0</span></h6>
                                <h6 class="card-subtitle mb-0">Date <span>Dec 31, 1969</span></h6>
                            </li>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <h5 class="card-title mb-2">Web Designer</h5>
                                <h6 class="card-subtitle mb-2">Ref. <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">status <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">Comment <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">Rate <span>0</span></h6>
                                <h6 class="card-subtitle mb-0">Date <span>Dec 31, 1969</span></h6>
                            </li>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <h5 class="card-title mb-2">Web Designer</h5>
                                <h6 class="card-subtitle mb-2">Ref. <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">status <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">Comment <span>Test</span></h6>
                                <h6 class="card-subtitle mb-2">Rate <span>0</span></h6>
                                <h6 class="card-subtitle mb-0">Date <span>Dec 31, 1969</span></h6>
                            </li>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>