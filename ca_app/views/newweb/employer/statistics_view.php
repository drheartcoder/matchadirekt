<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>
<section class="main-container vheight-100 justify-content-between">
     <div class="col-12 col-lg-9 col-xl-8 mx-auto bg-white px-0">
        <div class="row">

   <div class="container">
   <div class="col-12">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <?php 
                $this->load->library('Mobile_Detect');
                $detect = new Mobile_Detect();
                if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
                    $redirectUrl =WEBURL."/employer/settings";
                } else {
                    $redirectUrl = WEBURL."/employer/home";
                }
                ?>
                <a href="<?php echo  $redirectUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Statistic')?></h2>
            </div>
        </div>
    </div>
</div>
    <!-- container -->
    <div class="container">
        <div class="col-12">
        <div class="row">
            <div class="col-12 py-4  px-4 text-center">
                <h5 class="font-semi mb-0"><?=lang('Total Job Applicants :')?> <?=$count_jobs?></h5>
            </div>
        </div>
        <div class="row px-2">
            <div class="col-4 text-center">
                <div class="statistic-block">
                    <h5 class="mb-0"><?=lang('Males')?></h5>
                    <h6 class="text-d-grey mb-0"><?=$count_males?>%</h6>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="statistic-block">
                    <h5 class="mb-0"><?=lang('Females')?></h5>
                    <h6 class="text-d-grey mb-0"><?=$count_females?>%</h6>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="statistic-block">
                    <h5 class="mb-0"><?=lang('Others')?></h5>
                    <h6 class="text-d-grey mb-0"><?=$count_others?>%</h6>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- container -->
    <div class="container mt-4">
        <div class="col-12">
        <div class="row">
            <div class="col-12 px-2">
                <div class="statistic-tile p-3 mb-4 h-auto">
                    <label class="text-d-grey"><?=lang('Primary -')?> <?=round($count_Primary,2)?>%</label>
                    <div class="progress mb-3">
                        <div class="progress-bar w-0" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"style="width:<?=round($count_Primary)?>%" ></div>
                    </div>
                    <label class="text-d-grey"><?=lang('Success -')?> <?=round($count_Success,2)?>%</label>
                    <div class="progress mb-3">
                        <div class="progress-bar w-100" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?=round($count_Success)?>%" ></div>
                    </div>
                    <label class="text-d-grey"><?=lang('Interview -')?> <?=round($count_Interview,2)?>%</label>
                    <div class="progress">
                        <div class="progress-bar w-0" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?=round($count_Interview)?>%"></div>
                    </div>
                </div>
                <div class="statistic-tile p-3 mb-4 h-auto">
                     <?php
                    if(isset($Professions) && $Professions != ""){
                        $proCount = count($Professions);
                        $totalValue = 0;
                        foreach($Professions as $name => $value){
                            $totalValue = $totalValue + $value;
                        }
                        foreach($Professions as $name => $value){
                           $new_width = ( ($value *100)/ $totalValue );
                           ?>
                            <label class="text-d-grey"><?php echo $name; ?> - <?php echo round($new_width,2); ?>%</label>
                            <div class="progress mb-3">
                                <div class="progress-bar " style="width:<?=round($new_width)?>%"  role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                           <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
  
 </div>
</div>
        
</section>
   
     
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>