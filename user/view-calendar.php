    
    


<?php  
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid']==0)) {
  header('location:logout.php');
  } else{
?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>CE ERP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>
        
        <script src="assets/js/jquery.min.js"></script>
      
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

          <?php include_once('includes/sidebar.php');?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                 <?php include_once('includes/header.php');?>

                <!-- Start Page content -->
                <div class="content">
                    <?php

                        $schedules = $con->query("SELECT * FROM `events`");
                        $sched_res = [];

                        foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
                            $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
                            $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
                            $sched_res[$row['id']] = $row;
                        }

                        if(isset($conn)) $conn->close();
                    ?>

                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient" id="topNavBar">
                        <div class="container d-flex justify-content-center">
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="navbar-brand title" href="#">This is heading of event page</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="container py-5 px-2" id="page-container">
                        <div class="row">
                            <div class="col-md-9">
                                <div id="calendar"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="cardt rounded-0 shadow">
                                    <div class="card-header bg-gradient bg-primary text-light">
                                        <h5 class="card-title">Schedule Form</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <form action="event_save.php" method="post" id="schedule-form">
                                                <input type="hidden" name="id" value="">
                                                <div class="form-group mb-2">
                                                    <label for="title" class="control-label">Title</label>
                                                    <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="description" class="control-label">Description</label>
                                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="start_datetime" class="control-label">Start</label>
                                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="end_datetime" class="control-label">End</label>
                                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Event Details Modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-0">
                                <div class="modal-header rounded-0">
                                    <h5 class="modal-title">Schedule Details</h5>
                                </div>
                                <div class="modal-body rounded-0">
                                    <div class="container-fluid">
                                        <dl>
                                            <dt class="text-muted">Title</dt>
                                            <dd id="title" class="fw-bold fs-4"></dd>
                                            <dt class="text-muted">Description</dt>
                                            <dd id="description" class=""></dd>
                                            <dt class="text-muted">Start</dt>
                                            <dd id="start" class=""></dd>
                                            <dt class="text-muted">End</dt>
                                            <dd id="end" class=""></dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="modal-footer rounded-0">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal" data-toggle="modal" data-target="#event-details-modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- content -->

             <?php include_once('includes/footer.php');?>
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->



        <!-- jQuery  -->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script src="assets/js/fullcalendar.min.js"></script>
        <script>
            var calendar;
            var Calendar = FullCalendar.Calendar;
            var events = [];

            $(function() {

                if (!!scheds) {
                    Object.keys(scheds).map(k => {
                        var row = scheds[k]
                        events.push({ id: row.id, title: row.title, start: row.start_datetime, end: row.end_datetime });
                    });
                }
                
                var date = new Date()
                var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear(),

                calendar = new Calendar(document.getElementById('calendar'), {
                    headerToolbar: {
                        left: 'prev,next today',
                        right: 'dayGridMonth,dayGridWeek,list',
                        center: 'title',
                    },
                    selectable: true,
                    themeSystem: 'bootstrap',
                    events: events,
                    eventClick: function(info) {
                        var details = $('#event-details-modal');
                        var id = info.event.id;

                        if (!!scheds[id]) {
                            details.find('#title').text(scheds[id].title);
                            details.find('#description').text(scheds[id].description);
                            details.find('#start').text(scheds[id].sdate);
                            details.find('#end').text(scheds[id].edate);
                            details.find('#edit,#delete').attr('data-id', id);
                            details.modal('show');
                        } else {
                            alert("Event is undefined");
                        }
                    },
                    eventDidMount: function(info) {
                        // Do Something after events mounted
                    },
                    editable: true
                });

                calendar.render();

                // Form reset listener
                $('#schedule-form').on('reset', function() {
                    $(this).find('input:hidden').val('');
                    $(this).find('input:visible').first().focus();
                });

                // Edit Button
                $('#edit').click(function() {
                    var id = $(this).attr('data-id');

                    if (!!scheds[id]) {
                        var form = $('#schedule-form');

                        console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"));
                        form.find('[name="id"]').val(id);
                        form.find('[name="title"]').val(scheds[id].title);
                        form.find('[name="description"]').val(scheds[id].description);
                        form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"));
                        form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"));
                        $('#event-details-modal').modal('hide');
                        form.find('[name="title"]').focus();
                    } else {
                        alert("Event is undefined");
                    }
                });

                // Delete Button / Deleting an Event
                $('#delete').click(function() {
                    var id = $(this).attr('data-id');
                    if (!!scheds[id]) {
                        var _conf = confirm("Are you sure to delete this scheduled event?");
                        if (_conf === true) {
                            location.href = "./event_delete.php?id=" + id;
                        }
                    } else {
                        alert("Event is undefined");
                    }
                });
            });
        </script>
        <script>
            var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
        </script>
    </body>
</html>
<?php }  ?>