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
									
									<?php
                                    $rno = mt_rand(10000, 99999);
									
									/*  pass variable from previous page */
									$discid = substr(base64_decode($_GET['discid']), 0, -5);
                                    $ret1 = mysqli_query($con, "SELECT id, DisciplineName from tbldiscipline where id = '$discid';");

                                    list($disc_id, $disc_name) = @mysqli_fetch_row($ret1);
									

                                    ?>
								
								
                                    <h4 class="m-t-0 header-title">Projects by Discipline - <?php echo $disc_name; ?>
                                    </h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <table class="styled-table" id="dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Project Number</th>
                                                            <th>Project Name</th>
															<th>Member</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $rno = mt_rand(10000, 99999);
                                                    
                                                    /*  pass session userid */
                                                    $managed_by = $_SESSION['adid'];
                                                    $ret = mysqli_query($con, "SELECT DISTINCT tblprojects.id, tblprojects.project_number, tblprojects.projectname
																				from (((tblProjectTeam
																				LEFT JOIN tblprojects on tblProjectTeam.project_id = tblprojects.id)
																				LEFT JOIN tbluser on tblProjectTeam.employee_id = '$managed_by')
																				LEFT JOIN tbldiscipline on tbluser.fk_discipline = tblProjectTeam.proj_disc)
																				where tblprojects.status_id = '1' order by tblProjectTeam.project_id ASC
																		; ");
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {

                                                    ?>

                                                        <tr>
                                                            <td><a href="view-project.php?projid=<?php echo base64_encode($row['id'] . $rno); ?>"><?php echo $row['project_number']; ?></a></td>
                                                            <td><?php echo " $row[projectname] "; ?></td>
															<td><?php echo " $row[Deleted] "; ?></td>
                                                        </tr>

                                                    <?php
                                                        $cnt = $cnt + 1;
                                                    }

                                                    $con->close();

                                                    ?>



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