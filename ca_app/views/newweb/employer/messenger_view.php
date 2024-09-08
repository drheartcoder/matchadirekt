<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>
<style type="text/css">
    .bg-m-blue {
    background-color: #cde8f5 !important;
}
</style>
   <section class="main-container vheight-100 justify-content-between">
     <div class="container">
        <div class="row">
           <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/home" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Messages')?></h2>
            </div>
        </div>
        <?php //myPrint($convs);die; ?>
           <?php if(isset($convs) && $convs !=''){
           //myPrint($convs);die; ?>
        <div class="row">
            <div class="col-12 px-3 px-lg-4">
                <ul class="messages-list mt-3">
                    <?php foreach ($convs as $conv) { 

                     ?>
                     <?php if($conv->isNewForEmployer==1){ $colorMsg="bg-m-blue"; }else{$colorMsg="bg-l-grey"; } ?>
                    <li class="py-3 align-items-center mb-1 <?php echo $colorMsg; ?>">
                        <a class="media" href="<?php echo WEBURL; ?>/employer/messenger/chat/<?php echo $conv->id_conversation ; ?>">
                            <div class="user-img mr-3">
                                 <?php 
                                 
                                    $defaultUser = $staticUrl."/images/user.png";
                                    $imgUrl = "";
                                     $pht=$conv->photo;
                                     /* if($pht=="") $pht='no_pic.jpg';
                                     $imgUrl = base_url('public/uploads/candidate/'.$pht);*/
                                    $defaultUser = PUBLICURL."/uploads/candidate/thumb/no_pic.jpg";;
                                    $imgUrl = "";
                                    //$pht=$photoData->photo;
                                    if($pht!="" && file_exists('public/uploads/candidate/'.$pht)) 
                                        $imgUrl = PUBLICURL.'/uploads/candidate/'.$pht;
                                    else
                                        $imgUrl= $defaultUser; 
                                ?>
                                <img src="<?php echo  $imgUrl ; ?>" class="w-100">
                            </div>
                            
                            <div class="media-body">
                                <h5 class="card-title mb-0"><?php echo $conv->first_name ; ?></h5>
                               <?php if($conv->last_login_date!=""){ ?>
                                <p class="last-msg mb-0">Last Seen : <?php echo date_formats($conv->last_login_date,'M j, Y - h:i') ; ?></p>
                            <?php } ?>
                            </div>
                        </a>
                    </li>
                     <?php  } ?>
                   <!--  <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-2.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-3.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-4.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-5.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-6.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-1.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-2.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-3.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-4.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li> -->
                    <!-- <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-5.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li>
                    <li class="py-3 align-items-center">
                        <a class="media" href="web-chat-view.php">
                            <div class="user-img mr-3">
                                <img src="<?php echo  $staticUrl;?>/images/avatar-6.png" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0">Marie Winter</h5>
                                <p class="last-msg mb-0">Happiness is not something readymade. It comes from your own actions.</p>
                            </div>
                        </a>
                    </li> -->
                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    <?php } ?>
    </div>
</div>
    <!-- container -->
        
</section>
   
<?php $this->load->view('newweb/inc/footer'); ?>