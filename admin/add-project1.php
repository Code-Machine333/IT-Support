<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $project_number = mysqli_real_escape_string($con, $_POST['project_number']);
        $projectname = mysqli_real_escape_string($con, $_POST['projectname']);
        $scope = mysqli_real_escape_string($con, $_POST['scope']);
        $googlemap = mysqli_real_escape_string($con, $_POST['googlemap']);
        $location = mysqli_real_escape_string($con, $_POST['location']);
        $updated = mysqli_real_escape_string($con, $_POST['updated']);
        $quick = mysqli_real_escape_string($con, $_POST['quick']);
        $exact = mysqli_real_escape_string($con, $_POST['exact']);
        $mapped = mysqli_real_escape_string($con, $_POST['mapped']);
        $eightoneone = mysqli_real_escape_string($con, $_POST['eightoneone']);
        $refresh = mysqli_real_escape_string($con, $_POST['refresh']);
        $ticketno = mysqli_real_escape_string($con, $_POST['ticketno']);
        $customer_id = mysqli_real_escape_string($con, $_POST['customer_id']);
        $status_id = mysqli_real_escape_string($con, $_POST['status_id']);


        // Align with current schema: tblprojects has columns (id, project_number, projectname, status_id, Project_StartDate, Project_EndDate, EstimatedCost, ProjectMarket, PM, active, customer_id, CreatedAt)
        // The extra fields (scope, googlemap, location, etc.) are not present in the minimal schema. We'll store the basics and status/customer.
        $query = mysqli_query($con, "INSERT INTO tblprojects (project_number, projectname, status_id, customer_id, active) VALUES ('$project_number', '$projectname', '$status_id', '$customer_id', 'yes')");
        if ($query) {
            $msg = "Project has been added.";
        } else {
            $msg = "Something Went Wrong. Please try again.\n" . mysqli_error($con);
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
                                <div class="card-box shadow"><?php $cust_id = substr(base64_decode($_GET['custid']), 0, -5); ?>
                                    <h4 class="m-t-0 header-title">Add New Project</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <p style="font-size:16px; color:red" align="center">
                                                    <?php if ($msg) {
                                                        echo $msg;

                                                        header("refresh:5;url=dashboard.php");
                                                        echo 'You\'ll be redirected in about 5 secs. If not, click <a href="dashboard.php">here</a>.';
                                                    }
                                                    ?>
                                                </p>
                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label>Customer</label>
                                                            <select name='customer_id' id="customer_id" class="form-control" required="true">
                                                                <option value="">Select Customer</option>

                                                                <?php

                                                                $query = mysqli_query($con, "select id, customer_name from customers where id='$cust_id'");

                                                                while (list($pid, $customer_name) = mysqli_fetch_row($query)) {
                                                                    echo "<option value=$pid";
                                                                    if ($pid == $cust_id) {
                                                                        echo " selected";
                                                                    }
                                                                    echo ">$customer_name</option>";
                                                                }
                                                                mysqli_free_result($query);
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Project Number</label>
                                                            <input type="text" id="project_number" name="project_number" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Project Name</label>
                                                            <input type="text" id="projectname" name="projectname" class="form-control" required="true">
                                                        </div>
                                                    </div>



                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Google Map</label>
                                                            <input type="text" id="map" name="googlemap" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Location</label>
                                                            <input type="text" id="location" name="location" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="status">Status</label>
                                                            <select name='status_id' id="status_id" class="form-control">
                                                                <option value="">Select Status</option>
                                                                <?php

                                                                $ret = mysqli_query($con, "select * from tblstatus where active = 'yes'");

                                                                while ($row = mysqli_fetch_array($ret)) {
                                                                    echo "<option value='" . $row['id'] . "'>" . $row['statusname'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret);
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Updated</label>
                                                    <input type="date" id="updated" name="updated" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">In Quickbooks</label>
                                                    <select name="quick" id="quick" class="form-control">
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">In ExactTime</label>
                                                    <select name="exact" id="exact" class="form-control">
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label cor="example-email">Mapped (Billable)</label>
                                                    <select name="mapped" id="mapped" class="form-control">
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">811 Clear Date</label>
                                                    <input type="date" id="eightoneone" name="eightoneone" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Last Refresh</label>
                                                    <input type="date" id="refresh" name="refresh" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Ticket Number</label>
                                                    <input type="text" id="ticketno" name="ticketno" class="form-control">
                                                </div>
                                            </div>


                                            <div class="form-group row">

                                                <div class="col-12">
                                                    <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Add Project</button></p>
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