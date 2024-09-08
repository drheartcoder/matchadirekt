<?php $this->load->view('application/inc/header'); ?>
<?php 
    $staticUrl = STATICAPPSEEKERURL; 
?>
<section>
    <div class="container h-100">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                 <?php
                if($redirectTo == 1){
                    $returnUrl = APPURL."/seeker/notification";
                } else {
                    $returnUrl = APPURL."/seeker/settings";
                }
                ?>
                <a href="<?php echo $returnUrl; ?>" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">Calendar</h2>
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
                            <?php if(isset($data) && $data != ""){
                                foreach($data as $d){
                                    $empId = $d->id_employer;
                                    $empData = $this->My_model->getSingleRowData("tbl_employers","tbl_employers.*,(select company_name from tbl_companies where ID = tbl_employers.company_ID) compName","ID= ".$empId)
                                    ?>
                                    <li class="py-3 align-items-center px-3 bdr-btm">
                                        <a class="media" href="view-candidates-details.php">
                                            <div class="media-body">
                                                <div class="row align-items-center">
                                                    <div class="col-12 card-title mb-0">Call From: <?php echo $empData->first_name; ?></div>
                                                    <p class="col-12 text-d-grey mb-0">Company: <?php echo $empData->compName; ?></p>
                                                    <p class="col-12 text-d-grey mb-0"><?=$d->date?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                }

                            } ?>
                            <!-- <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="view-candidates-details.php">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-0">Web Designer</div>
                                            <p class="col-12 text-d-grey mb-0">Web Designer</p>
                                            <p class="col-12 text-d-grey mb-0">Tue 6 Nov, 09:30 - 10:00 GMT</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3 bdr-btm">
                                <a class="media" href="view-candidates-details.php">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-0">Web Designer</div>
                                            <p class="col-12 text-d-grey mb-0">Web Designer</p>
                                            <p class="col-12 text-d-grey mb-0">Tue 6 Nov, 09:30 - 10:00 GMT</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="py-3 align-items-center px-3">
                                <a class="media" href="view-candidates-details.php">
                                    <div class="media-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 card-title mb-0">Web Designer</div>
                                            <p class="col-12 text-d-grey mb-0">Web Designer</p>
                                            <p class="col-12 text-d-grey mb-0">Tue 6 Nov, 09:30 - 10:00 GMT</p>
                                        </div>
                                    </div>
                                </a>
                            </li> -->
                        </ul>
                        <!-- nav ul list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<!-- section -->

<!-- section -->
<?php $this->load->view('application/inc/footer'); ?>
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