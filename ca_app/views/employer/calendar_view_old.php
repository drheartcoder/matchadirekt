<!DOCTYPE html>

<html lang="en">

<head>

<?php $this->load->view('common/meta_tags'); ?>

<title><?php echo $title;?></title>


  <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/calendar/libs/css/smoothness/jquery-ui-1.8.11.custom.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/calendar/jquery.weekcalendar.css'); ?>" />
  <script type="text/javascript" src="<?php echo base_url('public/calendar/libs/jquery-1.4.4.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/calendar/libs/jquery-ui-1.8.11.custom.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/calendar/libs/date.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/calendar/jquery.weekcalendar.js'); ?>"></script>



  <script type='text/javascript'>
  var year = new Date().getFullYear();
  var month = new Date().getMonth();
  var day = new Date().getDate();
  var eventData = {
    events : [
      <?php
      $i=1;
      foreach($results as $row)
      {
      ?>
    {'id':'<?=$i?>', 'start': new Date('<?php echo date('Y-m-d H:i',strtotime($row->date))?>'), 'end': new Date('<?php echo date('Y-m-d H:i',strtotime('+2 hour +30 minute +0 second',strtotime($row->date)));?>'),
    'title':'<?=$row->notes?> (<?=$row->first_name.' '.$row->last_name?>)'},
      <?php
        $i++;
      }
      ?>
    ]
  };

  $(document).ready(function() {
    $('#calendar').weekCalendar({
      timeslotsPerHour: 3,
      timeslotHeigh: 30,
      hourLine: true,
      data: eventData,
      height: function($calendar) {
        return $(window).height() - $('h4').outerHeight(true);
      },
      eventRender : function(calEvent, $event) {
        if (calEvent.end.getTime() < new Date().getTime()) {
          $event.css('backgroundColor', '#aaa');
          $event.find('.time').css({'backgroundColor': '#999', 'border':'1px solid #888'});
        }
      },
      eventDrop: function(calEvent, $event) {
      },
      eventResize: function(calEvent, $event) {
      },
      eventClick: function(calEvent, $event) {
      }
    });

    $('<div id="message" class="ui-corner-all"></div>').prependTo($('body'));
  });

</script>

<?php $this->load->view('common/before_head_close'); ?>

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

  

    <div class="col-md-9"> <?php echo $this->session->flashdata('msg');?> 
    <div class="formwraper">
    <div class="titlehead"><?=lang('Calendar')?></div>
    <div class="row" style="overflow: hidden!important;">
      

          <div class="container clearfix">
             <div class="col-md-9">
             <div id="calendar"></div></div>

          </div>

    </div>
    </div>
   </div>

  </div>
</div>

<?php $this->load->view('common/bottom_ads');?>

<!--Footer-->

<?php $this->load->view('common/footer'); ?>




<script type="text/javascript"> var cy = '<?php echo $country;?>'; </script> 
<script type="text/javascript">
  $(document).ready(function() {
  $(".wc-time-slots").css("pointer-events","none");
});
</script>
</body>

</html>