
<?php  
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid']==0)) {
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
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/jquery.min.js"></script>
        <!-- Include fusioncharts core library -->
		<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
		<!-- Include fusion theme -->
		<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
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
                        $schedules = $con->query("SELECT tblmilestone.*, tblprojects.project_number FROM `tblmilestone` INNER JOIN tblprojects ON tblmilestone.project_id = tblprojects.id");
                        
                        $sched_res = [];
                        foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
                            array_push($sched_res, $row);
                        }
                        if(isset($con)) $con->close();
                    ?>

                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient" id="topNavBar">
                        <div class="container d-flex justify-content-center">
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="navbar-brand title" href="#">Milestone Gnatt Calendar</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="d-flex my-3 align-items-center">
                        <div class="btn-group">
                            <button type="button" title="Previous month" aria-pressed="false" class="fc-prev-button btn btn-primary" onClick="get_np_data(-1)">
                                <span class="fa fa-chevron-left"></span>
                            </button>
                            <button type="button" title="Next month" aria-pressed="false" class="fc-next-button btn btn-primary" onClick="get_np_data(1)">
                                <span class="fa fa-chevron-right"></span>
                            </button>
                            <button type="button" title="This month" aria-pressed="false" class="fc-today-button btn btn-primary ml-2" disabled onClick="setToday()">Today</button>
                        </div>
                        <h2 class="fc-toolbar-title mx-auto" id="fc-dom-1">Milestones</h2>
                        <div class="btn-group type-btn-group">
                            <button type="button" title="week view" aria-pressed="false" class="btn btn-primary active" onClick="changeType(0)">week</button>
                            <button type="button" title="month view" aria-pressed="true" class="btn btn-primary" onClick="changeType(1)">Month</button>
                            <button type="button" title="list view" aria-pressed="false" class="btn btn-primary" onClick="changeType(2)">3 Month</button>
                        </div>
                    </div>
                    <div id="chart-container"></div>
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
        <script>
            var status = 0;
            // Variables
            var scheds = <?php echo json_encode($sched_res, JSON_INVALID_UTF8_IGNORE); ?>;

            console.log('scheds', scheds);
            var colors = ['#F2726F', '#5D62B5', '#62B58F', '29C3BE', '#67CDF2', '#FFC533'];
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var weeks = ["Su", "Mo", "Tu", "We", "Tr", "Fr", "Sa"];

            var today = new Date();
            var first_week, last_week;
            var first_month = new Date(today.getFullYear(), today.getMonth(), 1);
            var first_3month = new Date(today.getFullYear(), today.getMonth(), 1), last_3month;

            var dataSource;
            // Variable for the Chart
            var main_source = [ '','','' ];
            // Variable for the main_source
            var main_data = { 
                week:{ text:[], projectID:[], task: [], categories: []}, 
                month:{ text:[], projectID:[], task: [], categories: []}, 
                _3month:{ text:[], projectID:[], task: [], categories: []} 
            };
            function get_first_last_week(d) {
                d = new Date(d);
                var day = d.getDay(),
                    diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
                    first_week = new Date(d.setDate(diff));
                    last_week = new Date(d.setDate(diff + 6));
            }

            // Get Data 
            function get_week_data() {
                // Get the first and last date of the week
                var num = 1;     
                scheds.forEach(element => {
                    // Change the date format
                    var mile_first = new Date(element.start_date);
                    var mile_last = new Date(element.end_date);
                    var mile_first_format = (mile_first.getMonth() + 1) + '/' + mile_first.getDate() + '/' + mile_first.getFullYear() + ' 00:00:00';
                    var mile_last_format = (mile_last.getMonth() + 1) + '/' + (mile_last.getDate()) + '/' + mile_last.getFullYear() + ' 23:59:59';
                    // Compare
                    if (first_week < mile_last && mile_last < last_week ) {
                        add_data(0, element, mile_first_format, mile_last_format, num);
                        num++;
                    } else if (mile_first < last_week && first_week < mile_last ) {
                        add_data(0, element, mile_first_format, mile_last_format, num);
                        num++;
                    } else if (first_week < mile_first && mile_last < last_week) {
                        add_data(0, element, mile_first_format, mile_last_format, num);
                        num++;
                    }        
                });
                // Get category
                // First Category
                main_data.week.categories.push({
                    start: (first_week.getMonth() + 1) + '/' + first_week.getDate() + '/' + first_week.getFullYear() + ' 00:00:00',
                    end: (last_week.getMonth() + 1) + '/' + last_week.getDate() + '/' + last_week.getFullYear() + ' 23:59:59',
                    label: 'Project Milestones (' + (first_week.getMonth() + 1) + '/' + first_week.getDate() + '/' + first_week.getFullYear() + ' - ' + (last_week.getMonth() + 1) + '/' + last_week.getDate() + '/' + last_week.getFullYear() + ')'
                })
                // Second catgory
                tmp = [];
                for (let index = 0; index < 7; index++) {
                    var day = new Date(first_week);
                    var date = new Date(day);
                    date.setDate(day.getDate() + index);   
                    tmp.push({
                        start: (date.getMonth() + 1) + '/' + date.getDate() + '/' + (date.getFullYear()) + ' 00:00:00',
                        end: (date.getMonth() + 1) + '/' + date.getDate() + '/' + (date.getFullYear()) + ' 23:59:59',
                        label: weeks[date.getDay()] + ('(' + date.getDate() + ')')
                    })
                }
                main_data.week.categories.push(tmp);
                main_source[0] = {
                    chart: {
                        dateformat: "mm/dd/yyyy",
                        theme: "fusion",
                        useverticalscrolling: "50",
                        rowHeight: "40" // Set the height of each row
                    },
                    datatable: {
                        headervalign: "bottom",
                        datacolumn: [
                        {
                            headertext: "Milestone Name",
                            headervalign: "center",
                            headeralign: "center",
                            align: "center",
                            text: main_data.week.text,
                            heightPercentage: "100"
                        }
                        ]
                    },
                    tasks: {
                        task:main_data.week.task
                    },
                    processes: {
                        align: "center",
                        headertext: "Project Number",
                        headervalign: "middle",
                        headeralign: "center",
                        process: main_data.week.projectID,
                        heightPercentage: "100"
                    },
                    categories: [
                        {
                            category: [
                                main_data.week.categories[0]
                            ]
                        },
                        {
                            category: main_data.week.categories[1]
                        }
                    ]
                };
            }
            function get_month_data() {
                // Get the first and last date of the month
                var num = 1;
                var last_month = new Date(first_month.getFullYear(), first_month.getMonth() + 1, 0);   
                var currentMonth = first_month.getMonth();
                var currentYear = first_month.getFullYear();
                scheds.forEach(element => {
                    // Change the date format
                    var mile_first = new Date(element.start_date);
                    var mile_last = new Date(element.end_date);
                    var mile_first_format = (mile_first.getMonth() + 1) + '/' + mile_first.getDate() + '/' + mile_first.getFullYear() + ' 00:00:00';
                    var mile_last_format = (mile_last.getMonth() + 1) + '/' + (mile_last.getDate()) + '/' + mile_last.getFullYear() + ' 23:59:59';
                    // Compare
                    if (first_month < mile_last && mile_last < last_month ) {
                        add_data(1, element, mile_first_format, mile_last_format, num);
                        num++;
                    } else if (mile_first < last_month && first_month < mile_last ) {
                        add_data(1, element, mile_first_format, mile_last_format, num);
                        num++;
                    } else if (first_month < mile_first && mile_last < last_month) {
                        add_data(1, element, mile_first_format, mile_last_format, num);
                        num++;
                    }        
                });
                // Get category
                // First Category
                main_data.month.categories.push({
                    start: (currentMonth + 1) + '/' + '1' + '/' + currentYear + ' 00:00:00',
                    end: (currentMonth + 1) + '/' + last_month.getDate() + '/' + currentYear + ' 23:59:59',
                    label: 'Project Milestones (' + (currentMonth + 1) + '/' + '1' + '/' + currentYear + ' - ' + (currentMonth + 1) + '/' + last_month.getDate() + '/' + currentYear + ')'
                })

                // Second catgory
                tmp = [];
                for (let index = 0; index < (last_month.getDate() - first_month.getDate()) + 1; index++) {   
                    tmp.push({
                        start: (currentMonth + 1) + '/' + (index + 1) + '/' + (currentYear) + ' 00:00:00',
                        end: (currentMonth + 1) + '/' + (index + 1) + '/' + (currentYear) + ' 23:59:59',
                        label: (index + 1).toString()
                    })
                }
                main_data.month.categories.push(tmp);
                main_source[1] = {
                    chart: {
                        dateformat: "mm/dd/yyyy",
                        theme: "fusion",
                        useverticalscrolling: "50",
                        rowHeight: "40" // Set the height of each row
                    },
                    datatable: {
                        headervalign: "bottom",
                        datacolumn: [
                        {
                            headertext: "Milestone Name",
                            headervalign: "center",
                            headeralign: "center",
                            align: "center",
                            text: main_data.month.text
                        }
                        ]
                    },
                    tasks: {
                        task:main_data.month.task
                    },
                    processes: {
                        align: "center",
                        headertext: "ProjectID",
                        headervalign: "middle",
                        headeralign: "center",
                        process: main_data.month.projectID
                    },
                    categories: [
                        {
                            category: [
                                main_data.month.categories[0]
                            ]
                        },
                        {
                            category: main_data.month.categories[1]
                        }
                    ]
                };
            }
            function get_3months_data() {
                // Get the first and last date of the week
                var num=1;
                if(first_3month.getMonth() > 8) 
                    last_3month = new Date(first_3month.getFullYear() + 1 , (first_3month.getMonth() + 2) % 11, 0);
                else
                    last_3month = new Date(first_3month.getFullYear(), (first_3month.getMonth() + 3) % 11, 0);
                scheds.forEach(element => {
                    // Change the date format
                    var mile_first = new Date(element.start_date);
                    var mile_last = new Date(element.end_date);
                    var mile_first_format = (mile_first.getMonth() + 1) + '/' + mile_first.getDate() + '/' + mile_first.getFullYear() + ' 00:00:00';
                    var mile_last_format = (mile_last.getMonth() + 1) + '/' + (mile_last.getDate()) + '/' + mile_last.getFullYear() + ' 23:59:59';
                    
                    // Compare
                    if (first_3month < mile_last && mile_last < last_3month ) {
                        add_data(2, element, mile_first_format, mile_last_format, num);
                        num++;
                    } else if (mile_first < last_3month && first_3month < mile_last ) {
                        add_data(2, element, mile_first_format, mile_last_format, num);
                        num++;
                    } else if (first_3month < mile_first && mile_last < last_3month) {
                        add_data(2, element, mile_first_format, mile_last_format, num);
                        num++;
                    }     
                });
                // Get category
                // First Category
                main_data._3month.categories.push({
                    start: (first_3month.getMonth() + 1) + '/' + first_3month.getDate() + '/' + first_3month.getFullYear(),
                    end: (last_3month.getMonth() + 1) + '/' + last_3month.getDate() + '/' + last_3month.getFullYear(),
                    label: 'Project Milestones (' + (first_3month.getMonth() + 1) + '/' + first_3month.getDate() + '/' + first_3month.getFullYear() + ' - ' + (last_3month.getMonth() + 1) + '/' + last_3month.getDate() + '/' + last_3month.getFullYear() + ')'
                })

                // Second catgory
                tmp = [];
                for (let index = 0; index < 3; index++) {
                    var start_date, last_date;
                    if(first_3month.getMonth() + index > 11) {
                        start_date = new Date((first_3month.getFullYear() + 1), (first_3month.getMonth() + index) % 12, 1);
                        last_date = new Date((first_3month.getFullYear() + 1), (first_3month.getMonth() + index + 1) % 12, 0);
                    }
                    else {
                        start_date = new Date((first_3month.getFullYear()), first_3month.getMonth() + index, 1);
                        last_date = new Date((first_3month.getFullYear()), first_3month.getMonth() + index + 1, 0);
                    }
                    tmp.push({
                        start: (start_date.getMonth() + 1) + '/' + start_date.getDate() + '/' + (start_date.getFullYear()),
                        end: (last_date.getMonth() + 1) + '/' + last_date.getDate() + '/' + (last_date.getFullYear()),
                        label: months[start_date.getMonth()]
                    })
                }
                main_data._3month.categories.push(tmp);
                main_source[2] = {
                    chart: {
                        dateformat: "mm/dd/yyyy",
                        theme: "fusion",
                        useverticalscrolling: "50",
                        rowHeight: "40" // Set the height of each row
                    },
                    datatable: {
                        headervalign: "bottom",
                        datacolumn: [
                        {
                            headertext: "Milestone Name",
                            headervalign: "middle",
                            headeralign: "center",
                            align: "center",
                            text: main_data._3month.text
                        }
                        ]
                    },
                    tasks: {
                        task: main_data._3month.task
                    },
                    processes: {
                        align: "left",
                        headertext: "ProjectID",
                        headervalign: "middle",
                        headeralign: "center",
                        process: main_data._3month.projectID
                    },
                    categories: [
                        {
                        category: [
                            main_data._3month.categories[0]
                        ]
                        },
                        {
                        category: [
                            main_data._3month.categories[1][0],
                            main_data._3month.categories[1][1],
                            main_data._3month.categories[1][2],
                        ]
                        }
                    ]
                };
            }

            function add_data(index, element, mile_first, mile_last, num) {
                if(index == 1) {
                    main_data.month.text.push({label:element.MilestoneName});
                    main_data.month.projectID.push({label:element.project_number});
                    main_data.month.task.push({
                        id: num,
                        start: mile_first,
                        end: mile_last,
                        color: colors[num%6]
                    });
                }
                else if(index == 0) {
                    main_data.week.text.push({label:element.MilestoneName});
                    main_data.week.projectID.push({label:element.project_number});
                    main_data.week.task.push({
                        id: num,
                        start: mile_first,
                        end: mile_last,
                        color: colors[num%6]
                    });
                }
                else if(index == 2) {
                    main_data._3month.text.push({label:element.MilestoneName});
                    main_data._3month.projectID.push({label:element.project_number});
                    main_data._3month.task.push({
                        id: num,
                        start: mile_first,
                        end: mile_last,
                        color: colors[num%6]
                    });
                }
            }
            
            // Init the FusionChart
            function displayChart(dataSource) {
                var myChart = new FusionCharts({
                    type: "gantt",
                    renderAt: "chart-container",
                    width: "100%",
                    height: "100%",
                    dataFormat: "json",
                    dataSource,
                    events: {
                        "beforeRender": function(evt, args) {
                            var chartContainer = document.getElementById("chart-container");
                            var chartHeight = chartContainer.offsetHeight;
                            var rowHeight = args.dataSource.chart.rowHeight;
                            var numRows = args.dataSource.processes.process.length;
                            var totalRowHeight = numRows * rowHeight;

                            if (totalRowHeight > chartHeight) {
                                chartContainer.style.overflowY = "auto";
                            } else {
                                chartContainer.style.overflowY = "hidden";
                            }
                        }
                    }
                }).render();
            }
            function changeType(index) {
                status = index;         
                displayChart(main_source[status])
                for (let i = 0; i < 3; i++) {
                    document.querySelector('.type-btn-group').children[i].classList.remove('active');
                }
                document.querySelector('.type-btn-group').children[index].classList.add('active');
            }
            function setToday() {
                main_data = { 
                    week:{ text:[], projectID:[], task: [], categories: []}, 
                    month:{ text:[], projectID:[], task: [], categories: []}, 
                    _3month:{ text:[], projectID:[], task: [], categories: []} 
                };
                today = new Date();
                get_first_last_week(today);
                first_month = new Date(today.getFullYear(), today.getMonth(), 1);
                first_3month = new Date(today.getFullYear(), today.getMonth(), 1);
                get_week_data();
                get_month_data();
                get_3months_data();
                document.querySelector('.fc-today-button').setAttribute("disabled", true);
                displayChart(main_source[status]);
            }
            function todayCheck() {
                today = new Date();
                if(status == 0) {   
                    if( first_week < today && today < last_week ) 
                        document.querySelector('.fc-today-button').setAttribute("disabled", true);
                    else
                        document.querySelector('.fc-today-button').removeAttribute("disabled");
                }
                else if(status == 1) {
                    if( first_month.getMonth() == today.getMonth() && first_month.getFullYear() == today.getFullYear() ) 
                        document.querySelector('.fc-today-button').setAttribute("disabled", true);
                    else
                        document.querySelector('.fc-today-button').removeAttribute("disabled");
                }
                else if(status == 2) {
                    if( first_3month < today && today < last_3month ) 
                        document.querySelector('.fc-today-button').setAttribute("disabled", true);
                    else
                        document.querySelector('.fc-today-button').removeAttribute("disabled");
                }
            }
            function get_np_data(index) {
                // if index == -1 previous 
                // if index == 1 next
                if(status == 0) {
                    main_data.week = { text:[], projectID:[], task: [], categories: []};           
                    var day = new Date(first_week);
                    var nextDay = new Date(day);
                    if( index == -1)
                        nextDay.setDate(day.getDate() - 7);
                    else
                        nextDay.setDate(day.getDate() + 7);
                    get_first_last_week( nextDay );
                    get_week_data();
                }
                if(status == 1) {
                    main_data.month = { text:[], projectID:[], task: [], categories: []};          
                    if( index == 1) {
                        if(first_month.getMonth() == 11) {
                            first_month = new Date(first_month.getFullYear() + 1, 0, 1);
                        }
                        else {
                            first_month = new Date(first_month.getFullYear(), first_month.getMonth() + 1, 1);
                        }
                    }
                    else if( index == -1) {
                        if(first_month.getMonth() == 0) {
                            first_month = new Date(first_month.getFullYear() - 1, 11, 1);
                        }
                        else {
                            first_month = new Date(first_month.getFullYear(), first_month.getMonth() - 1, 1);
                        }
                    }
                    get_month_data();
                }
                if(status == 2) {
                    main_data._3month = { text:[], projectID:[], task: [], categories: []};           
                    if( index == 1) {
                        if(first_3month.getMonth() > 9) {
                            first_3month = new Date(first_3month.getFullYear() + 1, (first_3month.getMonth() + 3) % 12, 1);
                        }
                        else {
                            first_3month = new Date(first_3month.getFullYear(), first_3month.getMonth() + 3, 1);
                        }
                    }
                    else if( index == -1) {
                        if(first_3month.getMonth() < 3) {
                            first_3month = new Date(first_3month.getFullYear() - 1, (first_3month.getMonth() + 9) % 12, 1);
                        }
                        else {
                            first_3month = new Date(first_3month.getFullYear(), first_3month.getMonth() - 3, 1);
                        }
                    }
                    get_3months_data();
                }
                todayCheck();
                displayChart(main_source[status]);
            }
            
            // Get data
            get_first_last_week(today);
            get_week_data();
            get_month_data();
            get_3months_data();
            todayCheck();

            displayChart(main_source[0]);
        </script>
    </body>
</html>
<?php }  ?>
