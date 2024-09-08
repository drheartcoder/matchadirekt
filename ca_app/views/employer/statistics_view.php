<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
<style type="text/css"> .formwraper p{font-size:13px;}</style>
<link rel="stylesheet" href="<?php echo base_url('public/chart/chartist.min.css');?>">
<style type="text/css">
  .ct-label{
    fill: white;
    font-size: 15px;
  }
</style>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header-->
<div class="container detailinfo">
  <div class="row">
  <div class="col-md-3">
  <div class="dashiconwrp">
    <?php $this->load->view('employer/common/employer_menu');?>
  </div>
  </div>
  
    <div class="col-md-9"> 
    <?php echo $this->session->flashdata('msg');?>
    <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
      <!--Job Application-->
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><b><?=lang('Statistics')?></b></div>
          </div>
        </div>
        <div class="row searchlist"> 
          <div class="col-md-12"><h3 style="margin-top: 15px;text-align: center;"><?=lang('Total Job Applicants')?> : <?=$count_jobs?></h3><hr/></div>
          <div class="col-md-1"></div>
          <div class="col-md-3" style="margin-top: 50px;margin-left: 40px;font-size: 16px;">
            Males : <?=$count_males?>%<hr/>
            Females : <?=$count_females?>%<hr/>
            Others : <?=$count_others?>%
          </div>
          <div class="col-md-5">
            <br/>
            <div class="ct-chart ct-golden-section" id="chart1"></div>
            <br/>
            
          </div>
        </div>
        <hr/>
        <div class="row searchlist">
          <div class="col-md-1"></div>
           
          <div class="col-md-8">
            <br/>
            <div class="ct-chart ct-golden-section" id="chart2"></div>
            <br/>
          </div>
        </div>
        <hr/>
        <div class="row searchlist">
          <div class="col-md-1"></div>
          <div class="col-md-3" style="margin-top: 30px;margin-left: 40px;font-size: 16px;">
            Primary : <?=$count_Primary?>%<hr/>
            Success : <?=$count_Success?>%<hr/>
            Interview : <?=$count_Interview?>%
          </div>
          <div class="col-md-5">
            <br/>
            <div class="ct-chart ct-golden-section" id="chart3"></div>
            <br/>
          </div>
        </div>

        <div class="row searchlist">

          <div class="col-md-1"></div>
           
          <div class="col-md-8">
            <br/>
            <div class="ct-chart ct-golden-section" id="chart4"></div>
            <br/>
          </div>
          <div class="col-md-12"><h3 style="margin-top: 15px;text-align: center;"><?=lang('Number of jobs per profession')?></h3><hr/></div>
        </div>


      </div>
      <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
    </div>
    <!--/Job Detail-->
    
    <!--Pagination-->
    
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<!-- Profile Popups -->
<?php $this->load->view('employer/common/employers_popup_forms'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('public/chart/chartist.min.js');?>"></script>
<script>
 var data = {
  series: [<?=$sexe_series?>]
};

var sum = function(a, b) { return a + b };

new Chartist.Pie('.ct-chart', data, {
  labelInterpolationFnc: function(value) {
    return Math.round(value / data.series.reduce(sum) * 100) + '%';
  }
});


var chart1=new Chartist.Bar('#chart2', {
  labels: [
  <?php 
  foreach ($Ages as $age => $count) {
    echo $age .',';
  }

  ?>

  ],
  series: [

<?php 
  foreach ($Ages as $age => $count) {
    echo $count .',';
  }
  ?>

  ]
}, {
  distributeSeries: true,
  axisY: {
    onlyInteger: true
  }
});

new Chartist.Bar('#chart3', {
  labels: ['Primary', 'Success', 'Interview'],
  series: [ [<?=$count_Primary?> , <?=$count_Success?> , <?=$count_Interview?>]]
}, {
  seriesBarDistance: 10,
  reverseData: true,
  horizontalBars: true,
  axisY: {
    offset: 70
  }
});



new Chartist.Bar('#chart4', {
  labels: [
  <?php 
  foreach ($Professions as $Profession => $nbr) {
    echo "'".$Profession."'" .',';
  }

  ?>

  ],
  series: [

<?php 
  foreach ($Professions as $Profession => $nbr) {
    echo $nbr .',';
  }
  ?>

  ]
}, {
  distributeSeries: true,
  axisY: {
    onlyInteger: true
  }
});



function exportXLS1(){

  chart1.export.toXLSX({}, function(data) {
    this.download(data, this.defaults.formats.XLSX.mimeType, "amCharts.xlsx");
  });
}


</script>
</body>
</html>