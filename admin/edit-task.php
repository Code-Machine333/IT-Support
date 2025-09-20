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
        $mysqltime = date('Y-m-d', strtotime($_POST['rawdate']));
        /* $mysqltime = date('Y-m-d H:i:s'($con,$_POST['date'])); */
        $created_by = $_SESSION['adid'];
        $tid = ($_GET['taskid']);



        $query = mysqli_query($con, "update tbltasks set project_id = '$project_id', employee_id='$employee_id', scope_id = '$scope_id', instructions ='$instructions', date ='$mysqltime' where id='$tid'");
        if ($query) {
			header( "refresh:5;url=view-task.php?projid=$ppid" );
			
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
                                    <?php $task_id = substr(base64_decode($_GET['taskid']), 0, -5); ?>
                                    <h4 class="m-t-0 header-title">Edit Task</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">

                                                <?php

                                                $tid = ($_GET['taskid']);


                                                $ret = mysqli_query($con, "select a.id, a.project_id, a.instructions, a.scope_id, a.date, d.id, d.customer_name, b.projectname, b.googlemap, b.location, c.scopename, e.id, e.fullname 
																		from tbltasks a, tblprojects b, tblscope c, customers d, tbluser e
																		where a.project_id = b.id and a.scope_id = c.id and b.customer_id = d.id
																		and a.employee_id = e.id and a.id = '$tid'");

                                                list($id, $project_id, $instructions, $scope_id, $assigned_date, $customer_id, $customer_name, $projectname, $googlemap, $location, $scopename, $employee_id, $fullname) = @mysqli_fetch_row($ret);

                                                ?>


                                                <p style="font-size:16px; color:red" align="center">
                                                    <?php if ($msg) {

                                                    }
                                                    ?>
                                                </p>
                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Project </label>
                                                            <select name='project_id' id="project_id" class="form-control" required="true">
                                                                <option value="">Select Project </option>
                                                                <?php
                                                                $ret = mysqli_query($con, "SELECT tblprojects.id, customers.customer_name, tblprojects.projectname 
																									FROM tblprojects, customers 
																									where tblprojects.customer_id = customers.id and tblprojects.active = 'yes' order by customer_name asc;");

                                                                while (list($pid, $cus_name, $proj_name) = mysqli_fetch_row($ret)) {
                                                                    echo "<option value=$pid";
                                                                    if ($pid == $project_id) {
                                                                        echo " selected";
                                                                    }
                                                                    echo ">$cus_name - $proj_name</option>";
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

                                                                while (list($emp_id, $emp_name) = mysqli_fetch_row($ret)) {
                                                                    echo "<option value=$emp_id";
                                                                    if ($emp_id == $employee_id) {
                                                                        echo " selected";
                                                                    }
                                                                    echo ">$emp_name</option>";
                                                                }
                                                                mysqli_free_result($ret);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Activity</label>
                                                            <select name='scope_id' id="scope_id" class="form-control">
                                                                <option value="">Select Scope</option>
                                                                <?php

                                                                $ret = mysqli_query($con, "SELECT id, scopename from tblscope where active = 'yes';");

                                                                while (list($scop_id, $scop_name) = mysqli_fetch_row($ret)) {
                                                                    echo "<option value=$scop_id";
                                                                    if ($scop_id == $scope_id) {
                                                                        echo " selected";
                                                                    }
                                                                    echo ">$scop_name</option>";
                                                                }
                                                                mysqli_free_result($ret);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Work Instructions</label>
                                                            <input type="text" id="instructions" name="instructions" class="form-control" value="<?php echo $instructions; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Assigned Date</label>
                                                            <input type="date" id="rawdate" name="rawdate" class="form-control" value="<?php echo $assigned_date; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Update Task</button></p>
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