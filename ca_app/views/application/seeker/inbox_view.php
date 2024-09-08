<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/seeker/home" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Messages</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="messages-list">
                    <?php
                    if(isset($convs) && $convs != "" ){
                        foreach($convs as $c){
                                //myPrint($c);exit;
                                $defaultUser = $staticUrl."/images/user.png";
                                $imgUrl = "";
                                $pht=$c->company_logo;
                                $defaultUser =PUBLICURL."/uploads/candidate/thumb/no_pic.jpg";
                                $imgUrl = "";
                                if($pht!="" && file_exists('public/uploads/employer/'.$pht)) 
                                    $imgUrl = PUBLICURL.'/uploads/employer/'.$pht;
                                else
                                    $imgUrl= $defaultUser; 
                           ?>

                            <li class="py-2 align-items-center">
                                <a class="media" href="<?php echo APPURL; ?>/seeker/messenger/chat-history/<?php echo $c->id_conversation; ?>">
                                    <div class="user-img mr-3">
                                        <img src="<?php echo  $imgUrl; ?>" class="w-100">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="card-title mb-0"><?php echo $c->first_name; ?></h5>
                                        <p class="last-msg mb-0">Last Login : <?php echo date_formats($c->last_login_date,'M j, Y - h:i') ; ?></p>
                                        <!-- <p class="last-msg mb-0"><?php //echo $c->msg; ?></p> -->
                                    </div>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <!-- nav ul list -->
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>