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
									<div class="d-flex align-items-center justify-content-between">
									
									<!-- sql statement to get the project name and project number -->
									<?php
										$rno = mt_rand(10000, 99999);
										$sid = substr(base64_decode($_GET['projid']), 0, -5);
										$ret1 = mysqli_query($con, "SELECT tblprojects.id, tblprojects.project_number, tblprojects.projectname
											FROM  tblprojects where tblprojects.id = '$sid';");

										list($id, $project_number, $projectname) = @mysqli_fetch_row($ret1);
										
										/*-- create session variables --*/
										$_SESSION['Projectname'] = $projectname;
										$_SESSION['ProjectID'] = $id;
                                    ?>
									
									
                                    <h5 class="m-t-0 mb-0  header-title">Project Team for <?php echo $projectname; ?> - <a href="view-project.php?projid=<?php echo $cid = ($_GET['projid']); ?>"> <?php echo $project_number; ?></a>

                                    </h5>
                                    <nav class="navbar navbar-expand-lg navbar-light">

                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>

                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="btn-custom-primary mr-2" href="add-employee.php?projid=<?php echo $cid = ($_GET['projid']); ?>">Add Team Member</a>
                                            </li>
                                        </ul>
                                    </nav>
									</div>

                                    <br>


                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <table class="styled-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Team Member</th>
                                                            <th>Project Discipline</th>
                                                        </tr>
                                                    </thead>
													
													<!-- create lookup for POC and PM here - need two new rows -- if PM is blank read not assigned -->
													
													<?php 
													
													$ret1 = mysqli_query($con, "SELECT tbluser.FullName
																				FROM tblProjectTeam
																				LEFT JOIN tbluser ON tblProjectTeam.employee_id = tbluser.ID
																				WHERE tblProjectTeam.project_id = '$sid' AND tblProjectTeam.proj_disc = 100;");
													
													$cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret1)) {
													?>
														
														<tr>
                                                            <td>
															<?php echo $row['FullName']; ?></td>
															
                                                            <td><?php echo " Principal in Charge "; ?></td>
                                                        </tr>
														
													<?php
                                                        $cnt = $cnt + 1;
                                                    } ?>
													
													
													<!-- create lookup for POC and PM here - need two new rows -- if PM is blank read not assigned -->
													
													<?php 
													
													$ret2 = mysqli_query($con, "SELECT tbluser.FullName
																				FROM tblProjectTeam
																				LEFT JOIN tbluser ON tblProjectTeam.employee_id = tbluser.ID
																				WHERE tblProjectTeam.project_id = '$sid' AND tblProjectTeam.proj_disc = 101;");
													
													$cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret2)) {
													?>
														
														<tr>
                                                            <td>
															<?php echo $row['FullName']; ?></td>
															
                                                            <td><?php echo " Project Manager "; ?></td>
                                                        </tr>
														
													<?php
                                                        $cnt = $cnt + 1;
                                                    } ?>
													
													
													<!-- display the name of the assigned team members -->
													
                                                    <?php
                                                    $rno = mt_rand(10000, 99999);

                                                    /*  pass session userid 
															$managed_by=$_SESSION['adid'];*/
                                                    $ret = mysqli_query($con, "SELECT tbluser.FullName, tbldiscipline.DisciplineName, tblProjectTeam.project_id, tbluser.ID
																				FROM (((tblProjectTeam
																				LEFT JOIN tbluser ON tblProjectTeam.employee_id = tbluser.id)
																				LEFT JOIN tblprojects ON tblProjectTeam.project_id = tblprojects.id)
																				LEFT JOIN tbldiscipline On tbluser.fk_discipline = tbldiscipline.id)
																				where tblProjectTeam.project_id = '$sid' and tblProjectTeam.Deleted = '1';");

                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret)) {

                                                    ?>



                                                        <tr>
                                                            <td>
															<a href="edit-project-team.php?udid=<?php echo base64_encode($row['ID'] . $rno);?>"> <?php echo $row['FullName']; ?></a></td>
															
                                                            <td><?php echo " $row[DisciplineName] "; ?></td>
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