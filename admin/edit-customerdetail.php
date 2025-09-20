<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $customer_id = $_POST['customer_id'];
        $customer_phone = $_POST['customer_phone'];
        $customer_name = $_POST['customer_name'];
        $comments = $_POST['comments'];
        $active = $_POST['active'];
        if ($active == 'on') {
            $actvie_value = 1;
        } else {
            $actvie_value = 0;
        }
        $customerid = substr(base64_decode($_GET['custidid']), 0, -5);

        $query = mysqli_query($con, "update customers set customer_name= '$customer_name', customer_phone='$customer_phone', comments='$comments', active='$actvie_value' where id =$customer_id");
        if ($query) {
            $msg = "Customer detail has been update.";
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
                                    <h4 class="m-t-0 header-title">Update Customer Details


                                        <a href="add-project1.php?custid=<?php echo $cid = ($_GET['custid']); ?>" class="btn btn-primary btn-sm float-right">Add Project</a>
                                    </h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <?php
                                                $rno = mt_rand(10000, 99999);
                                                $customerid = substr(base64_decode($_GET['custid']), 0, -5);
                                                $ret = mysqli_query($con, "select id, customer_name, customer_phone, comments, active from customers where id ='$customerid'");
                                                list($id, $customer_name, $customer_phone, $comments, $active) = @mysqli_fetch_row($ret);

                                                ?>

                                                <p style="font-size:16px; color:red" align="center">
                                                    <?php if ($msg) {
                                                        echo $msg;

                                                        header("refresh:5;url=manage-customers.php");
                                                        echo 'You\'ll be redirected in about 5 secs. If not, click <a href="manage-customers.php">here</a>.';
                                                    }
                                                    ?>
                                                </p>

                                                <form class="form-horizontal" role="form" method="post" name="submit">
                                                    <input type="hidden" name="customer_id" value="<?php echo $id; ?>">
                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Client Name</label>
                                                            <input class="form-control" type="text" id="customer_name" name="customer_name" required="true" value="<?php echo $customer_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Customer Phone</label>
                                                            <input type="text" id="customer_phone" name="customer_phone" class="form-control" required="true" value="<?php echo $customer_phone; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Comments</label>
                                                            <input type="text" id="comments" name="comments" class="form-control" value="<?php echo $comments; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Active</label>
                                                            <input name="active" type="checkbox" value="on" <?php if ($active == "1") {
                                                                                                                echo " CHECKED";
                                                                                                            } ?>>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Update</button></p>
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