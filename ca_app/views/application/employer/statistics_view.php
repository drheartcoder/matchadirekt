<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/settings" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Statistic</h2>
            </div>
        </div>
    </div>
    <!-- container -->
    <div class="container">
        <div class="row">
            <div class="col-12 py-4 text-center">
                <h5 class="font-semi mb-0">Total Job Applicants : <?=$count_jobs?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-4 text-center">
                <div class="statistic-block">
                    <h5 class="mb-0">Males</h5>
                    <h6 class="text-d-grey mb-0"><?=$count_males?>%</h6>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="statistic-block">
                    <h5 class="mb-0">Females</h5>
                    <h6 class="text-d-grey mb-0"><?=$count_females?>%</h6>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="statistic-block">
                    <h5 class="mb-0">Others</h5>
                    <h6 class="text-d-grey mb-0"><?=$count_others?>%</h6>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="statistic-tile p-3 mb-4 h-auto">
                    <label class="text-d-grey">Primary - <?=round($count_Primary,2)?>%</label>
                    <div class="progress mb-3">
                        <div class="progress-bar"  style="width:<?=round($count_Primary)?>%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <label class="text-d-grey">Success - <?=round($count_Success,2)?>%</label>
                    <div class="progress mb-3">
                        <div class="progress-bar"  style="width:<?=round($count_Success)?>%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <label class="text-d-grey">Interview - <?=round($count_Interview,2)?>%</label>
                    <div class="progress">
                        <div class="progress-bar"  style="width:<?=round($count_Interview)?>%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
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
</section>
<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>