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
		<link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
									
										<?php 
										
											$cid = substr(base64_decode($_GET['projid']), 0, -5);
											
										?>
									
										<h5 class="m-t-0 mb-0  header-title">Project Details <?php echo $cid ?>
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
													<a class="btn-custom-primary mr-2" href="add-project-note.php?projid=<?php echo $cid = ($_GET['projid']); ?>">Add Note</a>
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
												$ret = mysqli_query($con, "SELECT tblprojects.id, tblprojects.project_number, tblprojects.projectname, 
																		tblprojects.Project_StartDate, tblprojects.Project_EndDate, tblprojects.EstimatedCost, tblProjectStatus.statusname, tblMarketSector.name
																		FROM (((tblprojects
																		LEFT JOIN tblProjectStatus ON tblprojects.status_id = tblProjectStatus.id)
																		LEFT JOIN tblMarketSector ON tblprojects.ProjectMarket = tblMarketSector.id)
																		LEFT JOIN tbluser ON tblprojects.PM = tbluser.ID) where tblprojects.id = '$cid';");

												list($id, $project_number, $projectname, $startdate, $enddate, $EstimatedCost, $statusname, $projectmarket) = @mysqli_fetch_row($ret);

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
														<th>Estimated Cost</th>
														<td>$<?php echo number_format($EstimatedCost, 2, '.', ',');	?></td>
													</tr>
													<tr>
														<th>Market Sector</th>
														<td><?php echo $projectmarket; ?></td>
													</tr>
													<tr>
														<th>Start Date</th>
														<!-- add logic for no date listed - echo date or TBD -->
														<?
															if ($startdate === "0000-00-00"){ ?>
															
															<td> TBD </td>
															
															<?
															
															} else { ?>
															
															<td> <? echo date('m-d-Y', strtotime($startdate));?> </td> 
															
															<?
																														
															}
														
														?>
														
													</tr>
													<tr>
														<th>End Date</th>									
														<!-- add logic for no date listed - echo date or TBD -->
														<?
															if ($enddate === "0000-00-00"){ ?>
															
															<td> TBD </td>
															
															<?
															
															} else { ?>
															
															<td> <? echo date('m-d-Y', strtotime($enddate));?> </td> 
															
															<?
																														
															}
														
														?>
														
													</tr>

													<tr>
														<th>Project Status</th>
														<td><?php echo $statusname; ?></td>
													</tr>

												</table>
												<br><br>

												<!-- Project Milestone Table -->
												<div class="d-flex align-items-center justify-content-between">
												<h5 class="mt-4 mb-4  header-title">Project Milestones
												</h5>
												
													
												</div>

												<table class="styled-table" id="dataTable">
													<thead>
														<tr>
															<th>Milestone Name</th>
															<th>Milestone Start Date</th>
															<th>Milestone End Date</th>
															<th>Status</th>
														</tr>
													</thead>

													<!-- query tblMilestone -->
													<?php
													
													$ret1 = mysqli_query($con, "SELECT tblmilestone.id, tblmilestone.MilestoneName, tblmilestone.start_date, tblmilestone.end_date, tblMilestoneStatus.StatusName 
																				from tblmilestone, tblMilestoneStatus 
																				where tblmilestone.status = tblMilestoneStatus.id and tblmilestone.project_id = '$cid' order by tblmilestone.end_date ASC;");

													$cnt = 1;
													while ($row = mysqli_fetch_array($ret1)) {

													?>
														<tr>
															<td>
																<a href="view-milestone.php?msid=<?php echo base64_encode($row['id'] . $rno); ?>" title="Milestone details"> <?php echo $row['MilestoneName']; ?></a>
															</td>
															<td><?php 
																if ($row['start_date'] && $row['start_date'] != '0000-00-00 00:00:00' && $row['start_date'] != '0000-00-00') {
																	echo date('m-d-Y', strtotime($row['start_date']));
																} else {
																	echo 'TBD';
																}
															?></td>
															<td><?php 
																if ($row['end_date'] && $row['end_date'] != '0000-00-00 00:00:00' && $row['end_date'] != '0000-00-00') {
																	echo date('m-d-Y', strtotime($row['end_date']));
																} else {
																	echo 'TBD';
																}
															?></td>
															
															<td><?php echo $row['StatusName']; ?></td>
														</tr>
													<?php
														$cnt = $cnt + 1;
													} ?>
													
												</table>
												<br><br>
												
												<!-- Project Notes Table -->
												<div class="d-flex align-items-center justify-content-between">
												<h5 class="mt-4 mb-4  header-title">Project Notes
												</h5>
												
													
												</div>

												<table class="styled-table" id="dataTable">
													<thead>
														<tr>
															<th style="width: 60%">Note</th>
															<th style="width: 20%">Date</th>
															<th style="width: 20%">By</th>
														</tr>
													</thead>

													<!-- query tblNotes  -->
													
													<?php
													
													$ret2 = mysqli_query($con, "SELECT tblProjectNotes.id, tblProjectNotes.Note, tblProjectNotes.CreateDate, tbluser.FullName, tblprojects.project_number
																					from ((tblProjectNotes
																					LEFT JOIN tbluser ON tblProjectNotes.CreatedBy = tbluser.ID)
																					LEFT JOIN tblprojects ON tblProjectNotes.ProjectID = tblprojects.id)
																					where tblProjectNotes.ProjectID = '$cid' order by tblProjectNotes.CreateDate desc;");

													$cnt = 1;
													while ($row = mysqli_fetch_array($ret2)) {

													?>
														<tr>
															
															<td style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display:block;"><a href="view-project-notes.php?notesid=<?php echo base64_encode($row['id'] . $rno); ?>" title="Note"> <?php echo $row['Note']; ?></a></td>
															<? $CreateDate = date('m-d-Y', strtotime($row['CreateDate']));?> 
															<td><?php echo $CreateDate; ?></td>
															<td><?php echo $row['FullName']; ?></td>
														</tr>
													<?php
														$cnt = $cnt + 1;
													} 
													
													 $con->close();
													
													?>
													
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