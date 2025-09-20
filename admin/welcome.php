<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
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
                                <h4 class="header-title mb-4">Account Overview</h4>

                                <div class="row">
                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#0acf97" value="" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <?php $query = mysqli_query($con, "Select * from tbluser");
                                                $usercount = mysqli_num_rows($query);
                                                ?>
                                                <p class="text-muted mb-0 mt-2">Total Registered User</p>
                                                <h3 class=""><?php echo $usercount; ?></h3>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#f9bc0b" value="" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <?php $query1 = mysqli_query($con, "Select * from tblenquiry");
                                                $enqcount = mysqli_num_rows($query1);
                                                ?>
                                                <p class="text-muted mb-0 mt-2">Total Enquiry</p>
                                                <h3 class=""><?php echo $enqcount; ?></h3>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#f1556c" value="14" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <?php $query2 = mysqli_query($con, "Select * from tblmechanics");
                                                $meccount = mysqli_num_rows($query2);
                                                ?>
                                                <p class="text-muted mb-0 mt-2">Total Enquiry</p>
                                                <h3 class=""><?php echo $meccount; ?></h3>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6 col-xl-3">
                                        <div class="card-box mb-0 widget-chart-two">
                                            <div class="float-right">
                                                <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#2d7bf4" value="60" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                                            </div>
                                            <div class="widget-chart-two-content">
                                                <p class="text-muted mb-0 mt-2">Total Revenue</p>
                                                <h3 class="">$32,540</h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
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