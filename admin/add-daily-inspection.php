<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $project_id = mysqli_real_escape_string($con, $_POST['project_id']);
        $employee_id = mysqli_real_escape_string($con, $_POST['employee_id']);
        $scope_id = mysqli_real_escape_string($con, $_POST['scope_id']);
        $instructions = mysqli_real_escape_string($con, $_POST['instructions']);
        $mysqltime = date('Y-m-d', strtotime($con, $_POST['rawdate']));
        /* $mysqltime = date('Y-m-d H:i:s'($con,$_POST['date'])); */
        $created_by = $_SESSION['adid'];



        $query = mysqli_query($con, "insert into tbltasks(project_id, employee_id, scope_id, instructions, created_by, date)
	value ('$project_id','$employee_id','$scope_id', '$instructions','$created_by', '$mysqltime')");
        if ($query) {
            $msg = "Project Task has been added.";
        } else {
            $msg = "Something Went Wrong. Please try again";
        }
    }
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
                                    <h4 class="m-t-0 header-title">Daily Inspection Report</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">

                                                <p style="font-size:16px; color:red" align="center">
                                                    <?php if ($msg) {
                                                        echo $mysqltime;

                                                        header("refresh:5;url=manage-tasks.php");
                                                        echo 'You\'ll be redirected in about 5 secs. If not, click <a href="manage-tasks.php">here</a>.';
                                                    }
                                                    ?>
                                                </p>
                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Vehicle</label>
                                                            <select name='project_id' id="project_id" class="form-control" required="true">
                                                                <option value="">Select Vehicle</option>

                                                                <?php

                                                                $ret = mysqli_query($con, "select id, unit_number, year, make, model from fleet where active = 'yes';");

                                                                while ($row = mysqli_fetch_array($ret)) {
                                                                    echo "<option value='" . $row['id'] . "'>" . $row['unit_number'] . " - " . $row['year'] . " - " . $row['make'] . " - " . $row['model'] . "</option>";
                                                                }

                                                                mysqli_free_result($ret);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Odometer / Hours Reading</label>
                                                            <input type="text" id="instructions" name="instructions" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Issue</label>
                                                            <select name='issue1' id="issue1" class="form-control">
                                                                <option value="">Report Issue</option>
                                                                <?php

                                                                $ret = mysqli_query($con, "SELECT id, defect_name from tbldefect where active = 'yes';");

                                                                while ($row = mysqli_fetch_array($ret)) {
                                                                    echo "<option value='" . $row['id'] . "'>" . $row['defect_name'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Issue Remarks</label>
                                                            <input type="text" id="issue_remark" name="issue_remark" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Add Daily Inspection</button></p>
                                                        </div>
                                                    </div>

                                                </form>
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