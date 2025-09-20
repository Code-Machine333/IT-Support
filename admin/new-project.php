<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $macname = $_POST['macname'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];
        $address = $_POST['macadd'];

        $query = mysqli_query($con, "insert into  tblmechanics(FullName,MobileNumber,Email,Address) value('$macname','$mobno','$email','$address')");
        if ($query) {
            $msg = "Mechanic Details has been added.";
        } else {
            $msg = "Something Went Wrong. Please try again";
        }
    }
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Vehicle Service Managment System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
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
                                    <h4 class="m-t-0 header-title">Add New Project</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
                                                                                                            echo $msg;
                                                                                                        }  ?> </p>
                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Project Name</label>
                                                        <div class="col-10">
                                                            <input type="text" id="macname" name="macname" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Scope</label>
                                                        <div class="col-10">
                                                            <input type="text" id="scope" name="scope" class="form-control" maxlength="10" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Google Map</label>
                                                        <div class="col-10">
                                                            <input type="map" id="map" name="email" class="form-control" required="true">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Location</label>
                                                        <div class="col-10">
                                                            <input type="text" id="location" name="location" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Status</label>
                                                        <div class="col-10">
                                                            <input type="text" id="status" name="status" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Updated</label>
                                                        <div class="col-10">
                                                            <input type="text" id="updated" name="updated" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">In Quickbooks</label>
                                                        <div class="col-10">
                                                            <input type="text" id="quckbooks" name="quickbooks" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">In ExactTime</label>
                                                        <div class="col-10">
                                                            <input type="text" id="exacttime" name="exacttime" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Mapped (Billable)</label>
                                                        <div class="col-10">
                                                            <input type="text" id="mapped" name="mapped" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">811 Clear Date</label>
                                                        <div class="col-10">
                                                            <input type="text" id="811" name="811" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Last Refresh</label>
                                                        <div class="col-10">
                                                            <input type="text" id="refresh" name="refresh" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Ticket Number </label>
                                                        <div class="col-10">
                                                            <input type="text" id="ticket" name="ticket" class="form-control" required="true">
                                                        </div>
                                                    </div>








                                                    <div class="form-group row">

                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Add</button></p>
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