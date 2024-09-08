<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBCOMPURL;
?>
<section class="main-container  vheight-100 justify-content-between">
    <div class="container h-100">
        <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
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
                    <h2 class="mb-0"><?=lang('Calendar')?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-0">
                    <div id='calendar'></div>
                </div>
                <!-- col -->
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card border-0 mt-1 details-block">
                        <div class="card-body px-0 py-2">
                            <ul class="messages-list mb-0">
                                <?php 
                                if(isset($data) && $data != ""){
                                    foreach($data as $d){
                                        $seekerData = $this->My_model->getSingleRowData("tbl_job_seekers","","ID = ".$d->id_job_seeker);
                                        if($seekerData->first_name != ""){

                                        ?>
                                        <li class="py-3 align-items-center px-3 bdr-btm">
                                            <a class="media" href="<?php echo WEBURL; ?>/employer/candidate/candidate-full-post/<?php echo $this->custom_encryption->encrypt_data( $d->id_job_seeker); ?>">
                                                <div class="media-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 card-title mb-0"><?php echo $seekerData->first_name; ?></div>
                                                        <p class="col-12 text-d-grey mb-0"><?php echo $d->date; ?></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                            <!-- nav ul list -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
<script type="text/javascript">
    $(document).ready(function() {
    /*$('#external-events .fc-event').each(function() {

        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim($(this).text()), // use the element's text as the event title
            stick: true // maintain when user navigates (see docs on the renderEvent method)
        });

    });*/
    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'prev title next',
            right: 'month,agendaWeek,agendaDay'
        },
        aspectRatio: 1.15,
        defaultDate: '<?php echo date("Y-m-d");  ?>',
        fixedWeekCount: false,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        droppable: true,
        events: [
            <?php if(isset($data) && $data != ""){
                foreach($data as $data){
                    $title = $data->notes;
                    $startDate = explode(" ", $data->date)[0];
                    $strt = date("Y-m-d",strtotime($startDate));
                    ?>
                    {
                        title: '<?php echo $title; ?>',
                        start: '<?php echo $strt; ?>'
                    },
                    <?php
                }
            } ?>
        ]
    });

});
</script>