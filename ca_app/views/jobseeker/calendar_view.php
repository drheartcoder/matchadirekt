<!DOCTYPE html>

<html lang="en">

<head>

<?php $this->load->view('common/meta_tags'); ?>

<title><?php echo $title;?></title>

<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/calendar/libs/css/smoothness/jquery-ui-1.8.11.custom.css'); ?>" />
<!--   <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/calendar/jquery.weekcalendar.css'); ?>" />
 -->  <script type="text/javascript" src="<?php echo base_url('public/calendar/libs/jquery-1.4.4.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/calendar/libs/jquery-ui-1.8.11.custom.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('public/calendar/libs/date.js'); ?>"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url('public/calendar/jquery.weekcalendar.js'); ?>"></script> -->


<!-- <script type='text/javascript'>
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
      'title':'<?=$row->notes?> ( <?=$row->first_name.' '.$row->last_name?> )'},
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
        }
      });

      function displayMessage(message) {
        $('#message').html(message).fadeIn();
      }

      $('<div id="message" class="ui-corner-all"></div>').prependTo($('body'));
    });

</script>
 -->
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

    <?php $this->load->view('jobseeker/common/jobseeker_menu');?>

  </div>

  </div>

  

    <div class="col-md-9"> <?php echo $this->session->flashdata('msg');?> 
    <!-- <div class="formwraper">
    <div class="titlehead"><?=lang('Calendar')?></div>
    <div class="row" style="overflow: hidden!important;">
          <div class="container clearfix calender_app">
             <div class="col-md-9">
             <div id="calendar"></div></div>

          </div>
    </div>
    </div> -->
    <div id='wrap'>

    <div id='calendar'></div>

    <div style='clear:both'></div>
    </div>
   </div>

  </div>
</div>

<?php $this->load->view('common/bottom_ads');?>

<!--Footer-->

<?php $this->load->view('common/footer'); ?>

<!-- <script type="text/javascript"> var cy = '<?php echo $country;?>'; </script>  -->
<script type="text/javascript" src="<?php echo base_url('public/newCalender/calender.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('public/newCalender/calender.css'); ?>">
<script type="text/javascript">
    $(document).ready(function(){
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
       var calendar =  $('#calendar').fullCalendar({
        header: {
          left: 'title',
          center: 'agendaDay,agendaWeek,month',
          right: 'prev,next today'
        },
        editable: true,
        firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
        selectable: true,
        defaultView: 'basicWeek',
        
        axisFormat: 'h:mm',
        columnFormat: {
                  month: 'ddd',    // Mon
                  week: 'ddd d', // Mon 7
                  day: 'dddd M/d',  // Monday 9/7
                  agendaDay: 'dddd d'
              },
              titleFormat: {
                  month: 'MMMM yyyy', // September 2009
                  week: "MMMM yyyy", // September 2009
                  day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
              },
        allDaySlot: false,
        selectHelper: true,
        select: function(start, end, allDay) {
          var title = prompt('Event Title:');
          if (title) {
            calendar.fullCalendar('renderEvent',
              {
                title: title,
                start: start,
                end: end,
                allDay: allDay
              },
              true // make the event "stick"
            );
          }
          calendar.fullCalendar('unselect');
        },
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function(date, allDay) { // this function is called when something is dropped
        
          // retrieve the dropped element's stored Event Object
          var originalEventObject = $(this).data('eventObject');
          
          // we need to copy it, so that multiple events don't have a reference to the same object
          var copiedEventObject = $.extend({}, originalEventObject);
          
          // assign it the date that was reported
          copiedEventObject.start = date;
          copiedEventObject.allDay = allDay;
          
          // render the event on the calendar
          // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
          $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
          
          // is the "remove after drop" checkbox checked?
          if ($('#drop-remove').is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
          }
          
        },
        
        events: [
          {
            title: 'All Day Event',
            start: new Date(y, m, 1)
          },
          {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d-3, 16, 0),
            allDay: false,
            className: 'info'
          },
          {
            id: 999,
            title: 'Repeating Event',
            start: new Date(y, m, d+4, 16, 0),
            allDay: false,
            className: 'info'
          },
          {
            title: 'Meeting',
            start: new Date(y, m, d, 10, 30),
            allDay: false,
            className: 'important'
          },
          {
            title: 'Lunch',
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            className: 'important'
          },
          {
            title: 'Birthday Party',
            start: new Date(y, m, d+1, 19, 0),
            end: new Date(y, m, d+1, 22, 30),
            allDay: false,
          },
          {
            title: 'Click for Google',
            start: new Date(y, m, 28),
            end: new Date(y, m, 29),
            url: 'https://ccp.cloudaccess.net/aff.php?aff=5188',
            className: 'success'
          }
        ],      
      });
      
     });

</script>
<!-- <script type="text/javascript">
  $(document).ready(function() {
  $(".wc-time-slots").css("pointer-events","none");
      
       $(window).scroll(function()            
     {
         var sd = $(window).scrollTop();
      
       if(sd>=50){

                 $('#div_nav').addClass('fix_me');
                $('#back_arrow').css({
                              'top':'50px',
                            
                          });

       }else
           {
                $('#div_nav').removeClass('fix_me');
                $('#back_arrow').css({
                              'top':'90px',
                          });
           }
           
      });
      
      
      $('#back_arrow').click(function(){
                 $('.dashboard_div').slideDown('slow');
         $('#back_arrow').css({
                              'display':'none',
                          });
          $('#close_menu').css({
                              'display':'block',
                          });
        
  });
    $('#close_menu').click(function(){
                  $('.dashboard_div').slideUp('slow');
         $('#back_arrow').css({
             'display':'block',
                          });
          $('#close_menu').css({
                              'display':'none',
                          });
  });
      
      
});
</script> -->

</body>

</html>