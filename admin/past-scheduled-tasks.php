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
                                    <?php $display_date = date("m/d/Y"); ?>
                                    <h4 class="m-t-0 header-title">Scheduled Tasks for <?php echo $display_date; ?>
                                        <a href="add-task.php" class="btn btn-primary btn-sm float-right">Add Task</a>
                                    </h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Employee</th>
                                                        </tr>
                                                    </thead>
                                                    <?php

                                                    $ret = mysqli_query($con, "select DISTINCT a.id, a.fullname, b.employee_id from tbluser a, tbltasks b where a.id = b.employee_id order by a.fullname;");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        $employee_id = $row[employee_id];
                                                    ?>

                                                        <table class="table mb-0 table-hover">
                                                            <tr>
                                                                <td><?php echo $row[fullname]; ?></td>
                                                                <td>

                                                                    <ul class="list-group list-group-flush ml-10">

                                                                        <?php
                                                                        $rno = mt_rand(10000, 99999);
                                                                        $today = date('Y-m-d');

                                                                        $retb = mysqli_query($con, "select a.id, a.project_id, a.employee_id, a.scope_id, a.estimated_time, b.project_number, b.projectname, c.scopename, d.FullName from tbltasks a left join tblprojects b on b.id = a.project_id left join tblscope c on a.scope_id=c.id left join tbluser d on d.id = a.employee_id 
																	where date < now() - interval 1 day and employee_id = '$employee_id'");
                                                                        $cntb = 1;
                                                                        while ($data = mysqli_fetch_array($retb)) {
                                                                        ?>

                                                                            <li class="list-group-item"><a href="view-task.php?custid=<?php echo base64_encode($data['id'] . $rno); ?>"><?php echo $data['project_number'] . " - " . $data['projectname'] . " - " . $data['estimated_time']; ?></a></li>




                                                                        <?php $cntb++;
                                                                        } ?>

                                                                    </ul>
                                                                </td>
                                                            </tr>

                                                        <?php $cnta++;
                                                    } ?>


                                                        </table>
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