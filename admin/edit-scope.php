<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $scopename = mysqli_real_escape_string($con, $_POST['scopename']);
        $active = mysqli_real_escape_string($con, $_POST['active']);
        $eid = substr(base64_decode($_GET['editid']), 0, -5);

        $query = mysqli_query($con, "update tblscope set scopename = '$scopename', active = '$active' where id='$eid'");
        if ($query) {
            $msg = "Status has been update.";
        } else {
            echo "Error: " . $msg . "<br>" . $con->error;
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
                                    <h4 class="m-t-0 header-title">Update Activity <?php echo $editid; ?></h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <?php

                                                $cid = substr(base64_decode($_GET['editid']), 0, -5);

                                                $ret = mysqli_query($con, "select id, scopename, active from tblscope where id='$cid'");

                                                list($id, $scopename, $active) = @mysqli_fetch_row($ret);

                                                ?>
                                                <p style="font-size:16px; color:red" align="center">

                                                    <?php if ($msg) {
                                                        echo $msg;

                                                        header("refresh:5;url=manage-scope.php");
                                                        echo 'You\'ll be redirected in about 5 secs. If not, click <a href="manage-scope.php">here</a>.';
                                                    }
                                                    ?>
                                                </p>

                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Activity Name</label>
                                                        <div class="col-10">
                                                            <input type="text" id="scopename" name="scopename" class="form-control" required="true" value="<?php echo $scopename; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Active</label>
                                                            <input name="active" type="checkbox" value="yes" <?php if ($active == "yes") {
                                                                                                                    echo " CHECKED";
                                                                                                                } ?>>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Update Activity</button></p>
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