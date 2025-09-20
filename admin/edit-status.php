<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $StatusName = mysqli_real_escape_string($con, $_POST['StatusName']);
        $active = mysqli_real_escape_string($con, $_POST['active']);
        $eid = substr(base64_decode($_GET['editid']), 0, -5);

        $query = mysqli_query($con, "update tblProjectStatus set StatusName = '$StatusName', IsActive = '$active' where id='$eid'");
        if ($query) {
			
			header("refresh:3;url=manage-status.php");
			
            $msg = "Status has been update. You'll be redirected in about 3 secs.";

        } else {
            echo "Error: " . $msg . "<br>" . $con->error;
        }
    }
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
                                    <h4 class="m-t-0 header-title">Update Status <?php echo $editid; ?></h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <?php

                                                $cid = substr(base64_decode($_GET['editid']), 0, -5);
                                                /* $ret=mysqli_query($con,"select * from tblProjectStatus where id='$cid'"); */

                                                $ret = mysqli_query($con, "select id, StatusName, IsActive from tblProjectStatus where id='$cid'");

                                                list($id, $StatusName, $active) = @mysqli_fetch_row($ret);

                                                ?>
                                                <p style="font-size:16px; color:red" align="center">

                                                    <?php if ($msg) {
                                                        echo $msg;
                                                    }  ?>
                                                </p>

                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Status Name</label>
                                                        <div class="col-10">
                                                            <input type="text" id="StatusName" name="StatusName" class="form-control" autofocus required="true" value="<?php echo $StatusName; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <div class="checkbox checkbox-custom">
                                                                <input id="admin" type="checkbox" name="active" value="1" <?php if ($active == "1") {
                                                                                                                                echo " CHECKED";
                                                                                                                            } ?>>
                                                                <label for="admin">
                                                                    Active </a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Update Status</button></p>
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