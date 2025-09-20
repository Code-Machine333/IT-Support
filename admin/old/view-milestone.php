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
		
		<link rel="shortcut icon" href="assets/images/favicon.ico">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.css" rel="stylesheet" type="text/css" />

		<script src="assets/js/modernizr.min.js"></script>

	</head>


	<body>

		<div id="wrapper">

			<?php include_once('includes/sidebar.php'); ?>

			<div class="content-page">

				<?php include_once('includes/header.php'); ?>

				<div class="content">
					<div class="container-fluid">

						<div class="row">
							<div class="col-12">
								<div class="card-box shadow">
									<div class="d-flex align-items-center justify-content-between">
									
										<?php
												$rno = mt_rand(10000, 99999);
												
												$cid = substr(base64_decode($_GET['msid']), 0, -5);
												$ret = mysqli_query($con, "Select tblmilestone.id, tblmilestone.MilestoneName, tblmilestone.project_id, tblmilestone.status, tblmilestone.start_date, tblmilestone.end_date, tblmilestone.description,
																			tblprojects.project_number, tblprojects.projectname, tbluser.FullName, tblMilestoneStatus.StatusName
																	FROM (((tblmilestone
																	Left join tblprojects on tblmilestone.project_id = tblprojects.id)
																	Left join tblMilestoneStatus on tblmilestone.status = tblMilestoneStatus.id)
																	left join tbluser on tblmilestone.createdby = tbluser.id) where tblmilestone.id ='$cid';");

												list($id, $MilestoneName, $project_id, $status, $startdate, $enddate, $description, $project_number, $projectname, $FullName, $StatusName) = @mysqli_fetch_row($ret);

										?>
										
										<h5 class="m-t-0 mb-0  header-title">Milestone Details for <a href="view-project.php?projid=<?php echo base64_encode($project_id . $rno); ?>"><?php echo $project_number; ?>
										</h5>
										<nav class="navbar navbar-expand-lg navbar-light">

											<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
												<span class="navbar-toggler-icon"></span>
											</button>
											
											<ul class="navbar-nav">
												<li class="nav-item">
													<a class="btn-custom-primary mr-2" href="add-milestone.php?projid=<?php echo $cid = ($_GET['projid']); ?>">Add Milestone</a>
												</li>
											</ul>
										</nav>
									</div>

									<div class="row">
										<div class="col-12">
											<div class="p-20">

												<?php if (isset($msg) && $msg): ?>
												<p style="font-size:16px; color:red" align="center"><?php echo htmlspecialchars($msg); ?></p>
												<?php endif; ?>

												<?php 
													$user_id = $_SESSION['adid'];
													$ret = mysqli_query($con, "SELECT tz.timezone
														FROM tblTimezone AS tz
														JOIN tbluser AS u ON tz.id = u.timezone
														WHERE u.ID = '$user_id';");

													list($timezone) = @mysqli_fetch_row($ret);
												?>
												
												<table class="styled-table">
													<tr>
														<th>Project Name</th>
														<td><?php echo $projectname; ?></td>
													</tr>
													<tr>
														<th>Milestone Name</th>
														<td><a href="edit-milestone.php?msid=<?php echo base64_encode($id . $rno); ?>"><?php echo $MilestoneName; ?></td>
													</tr>
													<tr>
														<th>Milestone Description</th>
														<td><?php echo $description; ?></td>
													</tr>
													<tr>
														<th>Milestone Status</th>
														<td><?php echo $StatusName; ?></td>
													</tr>
													<tr>
														<th>Start Date</th>
														<td><?php echo date('m-d-Y', strtotime($startdate)); ?></td>
													</tr>
													<tr>
														<th>End Date</th>
														<td><?php echo date('m-d-Y', strtotime($enddate)); ?></td>
													</tr>

													<tr>
														<th>Assigned By</th>
														<td><?php echo $FullName; ?></td>
													</tr>
													<tr>
														<th>Timezone</th>
														<td><?php echo $timezone; ?></td>
													</tr>
													<tr>
														<th>ICS file</th>
														<td>
															<a href="download_ics.php?date_start=<?php echo urlencode($startdate); ?>&date_end=<?php echo urlencode($enddate); ?>&projectname=<?php echo urlencode($projectname); ?>&milestone=<?php echo urlencode($MilestoneName); ?>&description=<?php echo urlencode($description); ?>&timezone=<?php echo urlencode($timezone); ?>" class="btn-custom-primary">Download ICS</a>
														</td>
													</tr>

												</table>
												<br><br>

												

												<br><br>

											</div>
										</div>

									</div>

								</div> 
							</div>
						</div>
	
					</div> 

				</div> 

				<?php include_once('includes/footer.php'); ?>
			</div>
		</div>
	
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/metisMenu.min.js"></script>
		<script src="assets/js/waves.js"></script>
		<script src="assets/js/jquery.slimscroll.js"></script>
		<script src="assets/js/jquery.core.js"></script>
		<script src="assets/js/jquery.app.js"></script>

	</body>

	</html>
<?php }  ?>