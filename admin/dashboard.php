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
			<title>CE ERP || Admin Dashboard</title>
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
				
				
				<!-- ========== Left Sidebar Start ========== -->
				
				
				<!-- User box -->
				
				
				<!--- Sidemenu -->
				
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
										<h4 class="header-title mb-4">Clark & Enersen Overview</h4>
										
										<div class="row">
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														<p class="text-muted mb-0 mr-5"><a href="manage-all-projects.php">All Projects</a></p>
													</div>
													<div>
														<?php														
															$query1 = mysqli_query($con, "Select DISTINCT * from tblprojects");
															$project_count = mysqli_num_rows($query1);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#ff0000" value="<?php echo $project_count; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														<p class="text-muted mb-0 mr-5"><a href="manage-active-projects.php">Active Projects</a></p>
													</div>
													<div>
														<?php
															$query2 = mysqli_query($con, "Select * from tblprojects where status_id = '1'");
															$activeprojects = mysqli_num_rows($query2);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#b5cc2d" value="<?php echo $activeprojects; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														
														<p class="text-muted mb-0 mr-5"><a href="manage-onhold-projects.php">On Hold Projects</a></p>
														
													</div>
													<div>
														<?php
															$query = mysqli_query($con, "Select * from tblprojects where status_id = '5'");
															$onholdprojects = mysqli_num_rows($query);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#ff6535" value="<?php echo $onholdprojects; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														
														<p class="text-muted mb-0 mr-5"><a href="manage-archived-projects.php">Archived Projects</a></p>
														
													</div>
													<div>
														<?php
															$query3 = mysqli_query($con, "Select * from tblprojects where status_id = '2'");
															$ArchivedProjects = mysqli_num_rows($query3);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#ff9c00" value="<?php echo $ArchivedProjects; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
													
														<p class="text-muted mb-0 mr-5"><a href="view-projects-user.php">Your Projects</a></p>
														
													</div>
													<div>
														<?php
														
															/* pass session userid */
															$managed_by = $_SESSION['adid'];
															
															$query4 = mysqli_query($con, "SELECT DISTINCT tbluser.FullName, tblprojects.id, tblprojects.project_number, tblprojects.projectname, tblprojects.status_id, tblProjectStatus.StatusName
																			FROM (((tblProjectTeam
																			LEFT JOIN tbluser ON tblProjectTeam.employee_id = tbluser.id)
																			LEFT JOIN tblprojects ON tblProjectTeam.project_id = tblprojects.id)
																			LEFT JOIN tblProjectStatus On tblProjectStatus.id = tblprojects.status_id)
																			where tblProjectTeam.employee_id = '$managed_by' and tblProjectStatus.id != 2");
															$myProjects = mysqli_num_rows($query4);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#ff0000" value="<?php echo $myProjects; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														
														<p class="text-muted mb-0 mr-5"><a href="view-managers-team.php">Managers Team</a></p>
														
													</div>
													<div>
														<?php
															$team_query = mysqli_query($con, "Select distinct id from tbluser where fk_reports  = '$managed_by'");
															$TeamProjects = mysqli_num_rows($team_query);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#b5cc2d" value="<?php echo $TeamProjects; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
											<!-- <div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														
														<p class="text-muted mb-0 mr-5"><a href="view-projects-bydiscipline.php">Discipline Projects</a></p>
														
													</div>
													<div>
														<?php
															$user_query = mysqli_query($con, "SELECT DISTINCT tblprojects.id, tblprojects.projectname
																							from (((tblProjectTeam
																							LEFT JOIN tblprojects on tblProjectTeam.project_id = tblprojects.id)
																							LEFT JOIN tbluser on tblProjectTeam.employee_id = '$managed_by')
																							LEFT JOIN tbldiscipline on tbluser.fk_discipline = tblProjectTeam.proj_disc)
																							where tblprojects.status_id = '1' order by tblProjectTeam.project_id ASC");
															$ProjectDiscipline = mysqli_num_rows($user_query);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#ff6535" value="<?php echo $ProjectDiscipline; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div> -->
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														
														<p class="text-muted mb-0 mr-5"><a href="view-marketsector.php">Market Sector</a></p>
														
													</div>
													<div>
														<?php
															$user_query = mysqli_query($con, "Select distinct id from tblMarketSector where active = '1'");
															$MarketSector = mysqli_num_rows($user_query);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#ff6535" value="<?php echo $MarketSector; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
											<div class="col-sm-6 col-lg-6 col-xl-3">
												<div class="card-box mb-0 widget-chart-two d-flex align-items-center justify-content-center">
													<div class="widget-chart-two-content">
														
														<p class="text-muted mb-0 mr-5"><a href="view-projectdisc.php">Discipline Projects</a></p>
														
													</div>
													<div>
														<?php
															$user_query = mysqli_query($con, "Select distinct id from tbldiscipline where active = 'yes'");
															$ProjectDisc = mysqli_num_rows($user_query);
														?>
														<input data-plugin="knob" data-min="0" data-max="<?php echo $project_count; ?>" data-width="80" data-height="80" data-linecap=round data-fgColor="#ff6535" value="<?php echo $ProjectDisc; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
													</div>
													
												</div>
											</div>
											
										</div>
										<!-- end row -->
										
									</div>
								</div>
							</div>
							
							<!-- end row -->
							
							
							
							
							<!-- start secondary display - Milestones -->
							
							<div class="row">
								<div class="col-12">
									<div class="card-box shadow">

										<!-- get username -->
										
										<?php
											
											$username = $_SESSION['adid'];
											$rno = mt_rand(10000, 99999);
											$query = mysqli_query($con, "Select FullName from tbluser where ID = '$username' ");
											list($FullName) = @mysqli_fetch_row($query);
											
										?>
										<div class="d-flex align-items-center justify-content-between">
											
											<h4 class="header-title px-4 pt-4">Upcoming Milestones for <?php echo $FullName; ?>:</h4>
											
											<nav class="navbar navbar-expand-lg navbar-light">
												
												<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
													<span class="navbar-toggler-icon"></span>
												</button>
												
												<ul class="navbar-nav">
													<li class="nav-item">
														<a class="btn-custom-primary mr-2" href="view-all-milestones.php?milestnid=<?php echo base64_encode($row['username'] . $rno) ; ?>">All Milestones</a>
													</li>
													
												</ul>
											</nav>
										</div>
										
										
										<div class="row p-4">
											
											<table class="styled-table" >
												<thead>
													<tr>
														<th>Project Number:</th>
														<th>Project Name:</th>
														<th>Milestone Name:</th>
														<th>Milestone End Date:</th>
													</tr>
												</thead>
												
												<!-- query tblMilestone -->
												<?php
												
													/*$ret1 = mysqli_query($con, "select tblprojects.id, tblprojects.project_number, tblprojects.projectname, tblmilestone.MilestoneName, tblmilestone.end_date 
													from ((tblProjectTeam
													INNER JOIN tblprojects ON tblProjectTeam.project_id = tblprojects.id)
													INNER JOIN tblmilestone ON tblProjectTeam.project_id = tblmilestone.project_id)
													where tblProjectTeam.employee_id = '$username' and tblmilestone.end_date > NOW() and tblProjectTeam.Deleted = '1' order by tblmilestone.end_date ASC LIMIT 10;");*/
													
													/*$ret1 = mysqli_query($con, "SELECT a.MilestoneName AS amilestonename, a.end_date AS aend_date, b.project_number AS bproject_number, b.projectname AS bprojectname
																		FROM tblmilestone a
																		JOIN tblProjectTeam c ON a.project_id = c.project_id
																		JOIN tblprojects b ON b.id = a.project_id
																		WHERE c.employee_id = 22;"); */
																	
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
																				tblProjectTeam.employee_id = '$username' and tblmilestone.status = '1'
																			order by tblmilestone.end_date ASC LIMIT 10
																			;");					
													
													while ($row = mysqli_fetch_array($ret1)) {
														
													?>
													<tr>
														<td>
															<a href="view-project.php?projid=<?php echo base64_encode($row['id'] . $rno); ?>"> <?php echo $row['project_number']; ?></a>
														</td>
														<td><?php echo $row['projectname']; ?></td>
														<td><?php echo $row['MilestoneName']; ?></td>
														<? $end_date = date('Y-m-d', strtotime($row['end_date'])); ?>
														<td><?php echo $end_date; ?></td>
														
													</tr>
													<?php
														$cnt = $cnt + 1;
													} ?>
													
													
													
											</table>
											
											
											
										</div>
										<!-- close database connection -->
										<?php
											$con->close();
										?>
										
										<!-- end row -->
										
									</div>
								</div>
							</div>						
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
			
			<!-- Flot chart -->
			<script src="../plugins/flot-chart/jquery.flot.min.js"></script>
			<script src="../plugins/flot-chart/jquery.flot.time.js"></script>
			<script src="../plugins/flot-chart/jquery.flot.tooltip.min.js"></script>
			<script src="../plugins/flot-chart/jquery.flot.resize.js"></script>
			<script src="../plugins/flot-chart/jquery.flot.pie.js"></script>
			<script src="../plugins/flot-chart/jquery.flot.crosshair.js"></script>
			<script src="../plugins/flot-chart/curvedLines.js"></script>
		<script src="../plugins/flot-chart/jquery.flot.axislabels.js"></script>
		
		<!-- KNOB JS -->
		<!--[if IE]>
		<script type="text/javascript" src="../plugins/jquery-knob/excanvas.js"></script>
		<![endif]-->
		<script src="../plugins/jquery-knob/jquery.knob.js"></script>
		
		<!-- Dashboard Init -->
		<script src="assets/pages/jquery.dashboard.init.js"></script>
		
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
		<?php } ?>												