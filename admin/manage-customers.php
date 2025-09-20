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
                                    <h4 class="m-t-0 header-title">Manage Customers
                                        <a href="add-customer.php" class="btn btn-primary btn-sm float-right">Add Customer</a>
                                    </h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Customer Name</th>
                                                            <th>Customer Phone</th>
                                                            <th>Status</th>
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $rno = mt_rand(10000, 99999);
                                                    $ret = mysqli_query($con, "select * from customers order by customer_name");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {

                                                    ?>

                                                        <tr>
                                                            <td>
                                                                <a href="edit-customerdetail.php?custid=<?php echo base64_encode($row['id'] . $rno); ?>"><?php echo $row['customer_name']; ?></a>
                                                            </td>
                                                            <td><?php echo $row['customer_phone']; ?></td>
                                                            <td>
                                                                <?php if ($row['active'] == "1") {
                                                                    echo "Active";
                                                                } else {
                                                                    echo "Not Active";
                                                                }
                                                                ?>
                                                            </td>
                                                            <!-- <td><a href="edit-customerdetail.php?custid=<?php // echo base64_encode($row['id'].$rno);
                                                                                                                ?>">Edit Details</a></td> -->
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