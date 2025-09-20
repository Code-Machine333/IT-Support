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
        <title>CE ERP</title>
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
                                    <h4 class="m-t-0 header-title">Register Users
                                        <a href="add-user.php" class="fa fa-plus-square-o float-right"></a>
                                    </h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Full Name</th>
                                                            <th>Mobile Number</th>
                                                            <th>Email</th>
                                                            <th>Admin</th>
                                                            <th>Active</th>
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $rno = mt_rand(10000, 99999);
                                                    $ret = mysqli_query($con, "select * from tbluser");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {

                                                    ?>

                                                        <tr>
                                                            <td>
                                                                <a href="edit-user.php?udid=<?php echo base64_encode($row['ID'] . $rno); ?>" title="Edit user details"> <?php echo $row['FullName']; ?></a>
                                                            </td>
                                                            <td><?php echo $row['MobileNo']; ?></td>
                                                            <td><?php echo $row['Email']; ?></td>
                                                            <td><?php if ($row['admin'] == "on") {
                                                                    echo "Yes";
                                                                } else {
                                                                    echo "No";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php if ($row['active'] == "on") {
                                                                    echo "Active";
                                                                } else {
                                                                    echo "Not Active";
                                                                }
                                                                ?>
                                                            </td>
                                                            <!-- <td><a href="edit-user.php?udid=<?php // echo base64_encode($row['ID'].$rno);
                                                                                                    ?>" title="Edit user details"> Edit Details</a></td> -->
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