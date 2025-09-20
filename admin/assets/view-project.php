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
										<h5 class="m-t-0 mb-0  header-title">Project Details
										</h5>
										<nav class="navbar navbar-expand-lg navbar-light">

											<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
												<span class="navbar-toggler-icon"></span>
											</button>
											
											<ul class="navbar-nav">
												<li class="nav-item">
													<a class="btn-custom-primary mr-2" href="add-milestone.php?projid=<?php echo $cid = ($_GET['projid']); ?>">Add Milestone</a>
												</li>
												<li class="nav-item">
													<a class="btn-custom-primary" href="view-projects-team.php?projid=<?php echo $cid = ($_GET['projid']); ?>">Project Team</a>
												</li>
											</ul>
										</nav>
									</div>

									<div class="row">
										<div class="col-12">
											<div class="p-20">

												<p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
																											echo $msg;
																										}  ?> </p>


												<?php
												$rno = mt_rand(10000, 99999);
												$cid = substr(base64_decode($_GET['projid']), 0, -5);
												/* $custid=($_GET['custid']); */
												$ret = mysqli_query($con, "SELECT tblprojects.id, tblprojects.project_number, tblprojects.projectname, tblprojects.active,
																		tblprojects.Project_StartDate, tblprojects.Project_EndDate, tblProjectStatus.statusname, tbluser.FullName
																		FROM ((tblprojects
																		LEFT JOIN tblProjectStatus ON tblprojects.status_id = tblProjectStatus.id)
																		LEFT JOIN tbluser ON tblprojects.PM = tbluser.ID) where tblprojects.id = '$cid';");

												list($id, $project_number, $projectname, $active, $startdate, $enddate, $statusname, $FullName) = @mysqli_fetch_row($ret);

												?>



												<table class="styled-table">
													<tr>
														<th>Project Number</th>
														<td><a href="edit-project.php?projid=<?php echo base64_encode($id . $rno); ?>"><?php echo $project_number; ?></a></td>

													</tr>
													<tr>
														<th>Project Name</th>
														<td><?php echo $projectname; ?></td>
													</tr>
													<tr>
														<th>Start Date</th>
														<td><?php echo $startdate; ?></td>
													</tr>
													<tr>
														<th>End Date</th>
														<td><?php echo $enddate; ?></td>
													</tr>

													<tr>
														<th>Project Status</th>
														<td><?php echo $statusname; ?></td>
													</tr>

												</table>
												<br><br>

												<!-- Project Milestone Table -->
												<h5 class="mt-4 mb-4  header-title">Project Milestones
												</h5>

												<table class="styled-table">
													<thead>
														<tr>
															<th>Milestone Name</th>
															<th>Milestone Start Date</th>
															<th>Milestone End Date</th>
															<th>Status</th>
															<!-- <th>Actions</th> -->
														</tr>
													</thead>

													<!-- query tblMilestone -->
													<?php
													/* $rno=mt_rand(10000,99999);  */
													$ret1 = mysqli_query($con, "SELECT tblmilestone.id, tblmilestone.MilestoneName, tblmilestone.start_date, tblmilestone.end_date, tblMilestoneStatus.StatusName 
																				from tblmilestone, tblMilestoneStatus 
																				where tblmilestone.status = tblMilestoneStatus.id and tblmilestone.project_id = '$cid';");

													$cnt = 1;
													while ($row = mysqli_fetch_array($ret1)) {

													?>
														<tr>
															<td>
																<a href="view-milestone.php?msid=<?php echo base64_encode($row['id'] . $rno); ?>" title="Milestone details"> <?php echo $row['MilestoneName']; ?></a>
															</td>
															<td><?php echo $row['start_date']; ?></td>
															<td><?php echo $row['end_date']; ?></td>
															<td><?php echo $row['StatusName']; ?></td>
															
															<!-- <td>
																<a class="mr-4" href="view-milestone.php?msid=<?php echo base64_encode($row['id'] . $rno); ?>"><img src="assets/images/view-svg.svg" alt="layers-img" width="25"></a>
																<a class="mr-4" href="view-milestone.php?msid=<?php echo base64_encode($row['id'] . $rno); ?>"><img src="assets/images/edit-svg.svg" alt="layers-img" width="25"></a>
																<a class="mr-4" href="view-milestone.php?msid=<?php echo base64_encode($row['id'] . $rno); ?>"><img src="assets/images/delete-svg.svg" alt="layers-img" width="25"></a>
															</td> -->

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

	</body>

	</html>
<?php }  ?>