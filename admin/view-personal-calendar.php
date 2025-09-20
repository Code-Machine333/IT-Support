    <?php
    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');
    if (strlen($_SESSION['adid'] == 0)) {
        header('location:logout.php');
    } else {
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
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
            <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

            <script src="assets/js/modernizr.min.js"></script>
            <script src="assets/js/moment.min.js"></script>

            <script src="assets/js/jquery.min.js"></script>

        </head>

        <body>

            <!-- Begin page -->
            <div id="wrapper">

                <?php include_once('includes/sidebar.php'); ?>

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->

                <div class="content-page">

                    <?php include_once('includes/header.php'); ?>

                    <!-- Start Page content -->
                    <div class="content">
                        <?php
                        
                        $projectsTmp = $con->query("SELECT project_id FROM tblprojectteam WHERE employee_id = " . $_SESSION['adid']);
                        $projects = [];
                        while ($row = $projectsTmp->fetch_assoc()) {
                            array_push($projects, $row['project_id']);
                        }

                        $schedules = $con->query("SELECT * FROM `tblmilestone`");
                        $sched_res = [];
                        $sched_res1 = [];
                        $x = 0;
                        
                        while ($row = $schedules->fetch_assoc()) {
                            if (in_array($row['project_id'], $projects)) {
                                $sched_res[$row['id']] = $row;
                                $tmp = $row['project_id'];
                                $schedules1 = $con->query("SELECT * FROM `tblprojects` where `id`=$tmp");
                                while ($subRow = $schedules1->fetch_assoc()) {
                                    $sched_res1[$row['id']] = $subRow;
                                }
                                $x++;
                            }
                        }
                        
                        if (isset($con)) $con->close();
                        ?>

                        <div class="container pb-5 px-2" id="page-container">
                            <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient mb-5" id="topNavBar">
                                <div class="container d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="navbar-brand title" href="#">Milestone Calendar</a>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                            <div class="row">
                                <div class="col-12">
                                    <div id="calendar"></div>
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
                                                <dt class="text-muted">Job Number</dt>
                                                <dd id="jobNumber" class=""></dd>
                                                <dt class="text-muted">Job Name</dt>
                                                <dd id="jobName" class=""></dd>
                                                <dt class="text-muted">Start</dt>
                                                <dd id="start" class=""></dd>
                                                <dt class="text-muted">End</dt>
                                                <dd id="end" class=""></dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="modal-footer rounded-0">
                                        <div class="text-end">
                                            <!-- <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button> -->
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal" data-toggle="modal" data-target="#event-details-modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- content -->

                    <?php include_once('includes/footer.php'); ?>
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

            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
            <script>                
                var scheds = <?php echo json_encode($sched_res, JSON_INVALID_UTF8_IGNORE); ?>;
                var scheds1 = <?php echo json_encode($sched_res1, JSON_INVALID_UTF8_IGNORE); ?>;
                var calendar;
                var Calendar = FullCalendar.Calendar;
                var events = [];

                $(function() {

                    if (!!scheds) {
                        Object.keys(scheds).map(k => {
                            var row = scheds[k]

                            var previous = new Date(row.end_date);
                            previous.setDate(previous.getDate());
                            
                            events.push({
                                id: row.id,
                                title: row.MilestoneName,
                                start: previous,
                                end: row.end_date
                            });
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
                                    details.find('#title').text(scheds[id].MilestoneName);
                                    details.find('#description').text(scheds[id].description);
                                    details.find('#jobNumber').text(scheds1[id].project_number);
                                    details.find('#jobName').text(scheds1[id].projectname);
                                    details.find('#start').text(new Date(scheds[id].start_date).toLocaleDateString());
                                    details.find('#end').text(new Date(scheds[id].end_date).toLocaleDateString());
                                    details.find('#edit,#delete').attr('data-id', id);
                                    details.modal('show');
                                } else {
                                    alert("Event is undefined");
                                }
                            },
                            editable: false
                        });
                    calendar.render();
                    // Form reset listener
                    $('#schedule-form').on('reset', function() {
                        $(this).find('input:hidden').val('');
                        $(this).find('input:visible').first().focus();
                    });
                    $('#edit').click(function() {
                        var id = $(this).attr('data-id');
                        window.location.href = 'edit-milestone.php?id=' + id;
                    });
                });
            </script>
        </body>

        </html>
    <?php }  ?>