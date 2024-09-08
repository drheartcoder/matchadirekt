<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPCOMPURL; 
?>

<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/home" class="d-block">
                    <img src="<?php echo  $staticUrl;?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Messages</h2>
            </div>
        </div>
        <?php if(isset($convs) && $convs !=''){ ?>
        <div class="row">
            <div class="col-12">
                <ul class="messages-list">
                    <?php foreach ($convs as $conv) { 

                     ?>
                    <li class="py-2 align-items-center">
                        <a class="media" href="<?php echo APPURL; ?>/employer/messenger/chat/<?php echo $conv->id_conversation ; ?>">
                            <div class="user-img mr-3">
                              <?php 

                                     //myPrint($c);exit;
                                // $defaultUser = $staticUrl."/images/user.png";
                                // $imgUrl = "";
                                // $pht=$c->company_logo;
                                // $defaultUser =PUBLICURL."/uploads/candidate/thumb/no_pic.jpg";
                                // $imgUrl = "";
                                // if($pht!="" && file_exists('public/uploads/employer/'.$pht)) 
                                //     $imgUrl = PUBLICURL.'/uploads/employer/'.$pht;
                                // else
                                //     $imgUrl= $defaultUser; 

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

                                <img src="<?php echo  $imgUrl; ?>" class="w-100">
                            </div>
                            <div class="media-body">
                                <h5 class="card-title mb-0"><?php echo $conv->first_name ; ?></h5>
                                <p class="last-msg mb-0">Last Login : <?php echo date_formats($conv->last_login_date,'M j, Y - h:i') ; ?></p>
                            </div>
                        </a>
                    </li>
                <?php  } ?>
                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>

       <?php } ?>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>