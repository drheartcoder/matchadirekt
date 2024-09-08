<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>
<section class="main-container vheight-100">
    <div class="container h-100">
         <div class="row">
       <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Messages')?></h2>
            </div>
        </div>
        <?php 
                    if(isset($convs) && $convs != "" ){ 
        ?>

        <div class="row">
            <div class="col-12">
                <ul class="messages-list p-3">
<?php //myPrint($convs);die; ?>

                     <?php    foreach($convs as $c){
                                //myPrint($c);exit;
                                $defaultUser = $staticUrl."/images/user.png";
                                $imgUrl = "";
                                $pht=$c->company_logo;
                                // $defaultUser = $staticUrl."/images/user.png";
                                $defaultUser =PUBLICURL."/uploads/candidate/thumb/no_pic.jpg";
                                $imgUrl = "";
                                if($pht!="" && file_exists('public/uploads/employer/'.$pht)) 
                                    $imgUrl = PUBLICURL.'/uploads/employer/'.$pht;
                                else
                                    $imgUrl= $defaultUser; 
                           ?>
                           <?php if($c->isNewForSeeker==1){ $colorMsg="bg-m-blue"; }else{$colorMsg="bg-l-grey"; } ?>
                           
                            <li class="py-2 align-items-center mb-1 <?php echo $colorMsg; ?>">
                                <a class="media" href="<?php echo WEBURL; ?>/seeker/messenger/chat-history/<?php echo $c->id_conversation; ?>">
                                    <div class="user-img mr-3">
                                        <?php //echo $imgUrl;die; ?>
                                        <img src="<?php echo  $imgUrl; ?>" class="w-100">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="card-title mb-0"><?php echo $c->company_name; ?></h5>
                                      <!--   <p class="last-msg mb-0">Last Login : <?php //echo date_formats($c->last_login_date,'M j, Y - h:i') ; ?></p> -->
                                        <!-- <p class="last-msg mb-0"><?php //echo $c->msg; ?></p> -->
                                    </div>
                                </a>
                            </li>
                            <?php
                        }
                    ?>   
                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>
    <?php } ?>
        <!-- row -->
    </div>
</div>
</div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>