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
        $estimated_time = mysqli_real_escape_string($con, $_POST['estimated_time']);
        $mysqltime = date('Y-m-d', strtotime($_POST['rawdate']));
        /* $mysqltime = date('Y-m-d H:i:s'($con,$_POST['date'])); 
	<? echo fixDate($posted); ?>
	*/
        $created_by = $_SESSION['adid'];
        $tid = ($_GET['projid']);


        $query = mysqli_query($con, "insert into tbltasks(project_id, employee_id, scope_id, instructions, created_by, date, estimated_time, active)
	value ('$project_id','$employee_id','$scope_id', '$instructions','$created_by', '$mysqltime', '$estimated_time', 'yes')");
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
                                <div class="card-box shadow"><?php $cid = substr(base64_decode($_GET['projid']), 0, -5); ?>
                                    <h4 class="m-t-0 header-title">Add Project Task</h4>


                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">

                                                <p style="font-size:16px; color:red" align="center">
                                                    <?php if ($msg) {

                                                        header("refresh:5;url=manage-tasks.php");
                                                        echo 'You\'ll be redirected in about 5 secs. If not, click <a href="manage-tasks.php">here</a>.';
                                                    }
                                                    ?>
                                                </p>
                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Project</label>
                                                            <select name='project_id' id="project_id" class="form-control" required="true">
                                                                <option value="">Select Project</option>

                                                                <?php

                                                                $ret = mysqli_query($con, "select a.id, a.project_number, a.projectname, b.customer_name
																								from tblprojects a, customers b where a.id='$cid' and a.customer_id = b.id");

                                                                while (list($pid, $project_number, $proj_name, $cus_name) = mysqli_fetch_row($ret)) {
                                                                    echo "<option value=$pid";
                                                                    if ($pid == $cid) {
                                                                        echo " selected";
                                                                    }
                                                                    echo ">$project_number - $cus_name - $proj_name</option>";
                                                                }

                                                                mysqli_free_result($ret);

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Employee</label>
                                                            <select name='employee_id' id="employee_id" class="form-control">
                                                                <option value="">Select Employee</option>
                                                                <?php

                                                                $ret = mysqli_query($con, "SELECT id, fullname from tbluser where active = 'on';");

                                                                while ($row = mysqli_fetch_array($ret)) {
                                                                    echo "<option value='" . $row['id'] . "'>" . $row['fullname'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret);
                                                                ?>



                                                                mysqli_free_result($ret);?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Activity</label>
                                                            <select name='scope_id' id="scope_id" class="form-control" required="true">
                                                                <option value="">Select Activity</option>
                                                                <?php $query = mysqli_query($con, "select * from tblscope where active = 'yes'");
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['scopename']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="instructions">Work Instructions</label>
                                                            <input type="text" id="instructions" name="instructions" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="rawdate">Assigned Date</label>
                                                            <input type="date" id="rawdate" name="rawdate" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="estimated_time">Estimated Time</label>
                                                            <input type="text" id="estimated_time" name="estimated_time" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Add Task</button></p>
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