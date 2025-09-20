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
        <title>Vogt ERP</title>
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
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box shadow">
                                    <h4 class="m-t-0 header-title">Manage Active Tasks
                                        <a href="add-task.php" class="btn btn-primary btn-sm float-right">Add Task</a>
                                    </h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Project</th>
                                                            <th>Task Name</th>
                                                            <th>Assigned to</th>
                                                            <th>Est. Time</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    /* $rno=mt_rand(10000,99999);   */
                                                    $ret = mysqli_query($con, "select a.id, a.project_id, a.scope_id, a.employee_id, a.estimated_time, a.active, b.projectname, c.scopename, d.FullName, e.customer_name
																from tbltasks a left join tblprojects b on b.id = a.project_id
																LEFT JOIN customers e on e.id = b.customer_id
																left join tblscope c on a.scope_id=c.id
																left join tbluser d on d.id = a.employee_id
																where a.active = 'yes';");

                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {

                                                    ?>

                                                        <tr>
                                                            <td><a href="view-task.php?custid=<?php echo $row['id']; ?>"><?php echo " $row[id] - $row[customer_name] - $row[projectname] "; ?></a></td>
                                                            <td><?php echo $row['scopename']; ?></td>
                                                            <td><?php if ($row['employee_id'] == 0) {
                                                                    echo "Not Assigned";
                                                                } else {
                                                                    echo $row['FullName'];
                                                                } ?>
                                                            </td>
                                                            <td><?php echo $row['estimated_time']; ?></td>
                                                        </tr>

                                                    <?php
                                                        $cnt = $cnt + 1;
                                                    } ?>



                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-box -->
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->






                        <!-- end row -->





                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include_once('includes/footer.php'); ?>
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->



        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>

    </html>
<?php }  ?>