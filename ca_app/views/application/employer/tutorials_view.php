<?php $this->load->view('application/inc/header'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
    //myPrint($_SESSION);exit;

?>

<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/settings" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Tutorials</h2>
            </div>
            <div class="col-2 pr-0 text-right">
                <a href="<?php echo APPURL; ?>/employer/tutorials/add-tutorial" class="btn btn-blue add-btn rounded-0">
                    <img src="<?php echo  $staticUrl;?>/images/plus-white.svg" class="w-100">
                </a>
            </div>
        </div>
<?php
//myPrint($tutorialData);die;  
if(isset($tutorialData) && $tutorialData !=''){


?>
        <div class="row">
            <div class="col-12 p-0">
                <div class="card border-0 mt-1 details-block">
                    <div class="card-body px-0 py-2">
                        <ul class="messages-list mb-0">
                            <?php foreach ($tutorialData as $tdata){ {
                                # code...
                            } ?>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <div class="edit-block">
                                    <ul>
                                        <li><a href="<?php echo APPURL; ?>/employer/tutorials/remove-tutorial/<?php echo $tdata->ID;?>" class="bg-red"><img src="<?php echo  $staticUrl;?>/images/close-white.svg" class="w-100"></a></li>
                                        <li><a href="<?php echo APPURL; ?>/employer/tutorials/edit-tutorial/<?php echo $tdata->ID;?>" class="bg-blue"><img src="<?php echo  $staticUrl;?>/images/edit-pen.svg" class="w-100"></a></li>
                                    </ul>
                                </div>
                                <a class="media" href="<?php echo APPURL; ?>/employer/tutorials/tutorial-details/<?php echo $tdata->ID;?>">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 card-title mb-0"><?php echo $tdata->tutorial_name;?>
                                                <p class="text-d-grey mb-0"><?php echo date_format($tdata->dated, 'j,M,Y');?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
<?php }?>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>