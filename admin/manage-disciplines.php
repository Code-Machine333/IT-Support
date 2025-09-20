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
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                                    <h4 class="mt-4 header-title d-flex align-items-center justify-content-between">
                                        <span>Disciplines</span>
                                        <a href="add-discipline.php" class="btn-custom-primary">Add Discipline</a>
                                    </h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <table class="styled-table" id="dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Discipline</th>
                                                            <th>Active</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $rno = mt_rand(10000, 99999);
                                                    $ret = mysqli_query($con, "select * from tbldiscipline");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {

                                                    ?>

                                                        <tr>
                                                            <td><?php echo $row['DisciplineName']; ?></td>

                                                            <td><?php if ($row['active'] == "yes") {
                                                                    echo "Active";
                                                                } else {
                                                                    echo "Not Active";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><a href="edit-discipline.php?editid=<?php echo base64_encode($row['id'] . $rno); ?>"> Edit Discipline</a></td>
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
		
		<!-- Page level plugins -->
        <script src="assets/js/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatables/dataTables.bootstrap4.min.js"></script>
        <script>
            $('#dataTable').dataTable({
                "pageLength": 50,
            });
        </script>

    </body>

    </html>
<?php }  ?>