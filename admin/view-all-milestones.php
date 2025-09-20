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
									<div class="d-flex align-items-center justify-content-between">
										<h5 class="m-t-0 mb-0  header-title">All Milestones
										</h5>
										
									</div>

									<div class="row">
										<div class="col-12">
											<div class="p-20">

												<p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
																											echo $msg;
																										}  ?> </p>


												



												<table class="styled-table" id="dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Project Number</th>
                                                            <th>Project Name</th>
															<th>Milestone</th>
															<th>End Date</th>
															<!-- <th>ID</th> -->
                                                        </tr>
                                                    </thead>
                                                    <?php
													
													
													
													$username = $_SESSION['adid'];
                                                    $rno = mt_rand(10000, 99999);
												/*$cid = substr(base64_decode($_GET['milestnid']), 0, -5);
												 $custid=($_GET['custid']); 
												 $cid = ($_GET['milestnid']);*/
												/* $ret = mysqli_query($con, "select tblprojects.id, tblprojects.project_number, tblprojects.projectname, tblmilestone.MilestoneName, tblmilestone.end_date 
																					from ((tblProjectTeam
																					LEFT JOIN tblprojects ON tblProjectTeam.project_id = tblprojects.id)
																					LEFT JOIN tblmilestone ON tblProjectTeam.project_id = tblmilestone.project_id)
																					where tblProjectTeam.employee_id = '$cid' and tblmilestone.end_date is NOT NULL and tblProjectTeam.Deleted = '1' order by tblmilestone.end_date;"); */
													
													/*$ret = mysqli_query($con, "SELECT b.id as bid, a.milestoneName as aMilestoneName, a.end_date as aend_date, b.project_number as bproject_number, b.projectname as bprojectname
																				FROM tblmilestone a
																				JOIN tblprojects b ON b.Id = a.project_id 
																				WHERE a.createdby = 22 order by a.end_date;");*/
																				
																				$ret1 = mysqli_query($con, "SELECT DISTINCT
																				tblmilestone.MilestoneName, 
																				tblmilestone.end_date,
																				tblprojects.id,
																				tblprojects.project_number, 
																				tblprojects.projectname, 
																				tblProjectTeam.employee_id
																			FROM 
																				tblmilestone
																			INNER JOIN 
																				tblprojects 
																			ON
																				tblmilestone.project_id  = tblprojects.id
																			INNER JOIN
																				tblProjectTeam
																			ON
																				tblProjectTeam.project_id = tblprojects.id
																			WHERE
																				tblProjectTeam.employee_id = '$username'
																			;");
																					
																					
                                                    $cnt = 1;
                                                    while ($row = mysqli_fetch_array($ret1)) {

                                                    ?>

                                                        <tr>
                                                            <td><a href="view-project.php?projid=<?php echo base64_encode($row['id'] . $rno); ?>"><?php echo $row['project_number']; ?></a></td>
                                                            <td><?php echo " $row[projectname] "; ?></td>
															<td><?php echo " $row[MilestoneName] "; ?></td>
															<? $end_date = date('m-d-Y', strtotime($row['end_date'])); ?>
															<td><?php echo $end_date; ?></td>
                                                        </tr>

                                                    <?php
                                                        $cnt = $cnt + 1;
                                                    } ?>



                                                </table>
												<br><br>

												

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