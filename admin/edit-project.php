<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
	header('location:logout.php');
} else {
	if (isset($_POST['submit'])) {
		$project_number = mysqli_real_escape_string($con, $_POST['project_number']);
		$projectname = mysqli_real_escape_string($con, $_POST['projectname']);
		$active = mysqli_real_escape_string($con, $_POST['active']);
		$pic = mysqli_real_escape_string($con, $_POST['pic']);
		$PM = mysqli_real_escape_string($con, $_POST['pm']);
		$ProjectStart = mysqli_real_escape_string($con, $_POST['ProjectStart']);
        $ProjectEnd = mysqli_real_escape_string($con, $_POST['ProjectEnd']);
		$status_id = mysqli_real_escape_string($con, $_POST['status_id']);
		$sector_id = mysqli_real_escape_string($con, $_POST['sector_id']);
		$estimatedcost = mysqli_real_escape_string($con, $_POST['estimatedcost']);
		$eid = substr(base64_decode($_GET['projid']), 0, -5);
		$ppid = ($_GET['projid']);
		
		/* update tblprojects */

		$query = mysqli_query($con, "update tblprojects set project_number = '$project_number', projectname = '$projectname',
								Project_StartDate = '$ProjectStart', Project_EndDate = '$ProjectEnd', status_id = '$status_id', EstimatedCost = '$estimatedcost', ProjectMarket = '$sector_id'
								where id='$eid'");
		
		
		/* check to see if PIC has been assigned to ProjectTeam - PIC = 100 in the proj_disc column */
		
		$ret3 = mysqli_query($con, "select a.id, a.employee_id from tblProjectTeam a where a.project_id='$eid' and a.proj_disc = 100");

					list($special_id, $pic_id) = @mysqli_fetch_row($ret3);
								
					if (isset($pic_id ))  {
						
							$ret = mysqli_query($con, "update tblProjectTeam set employee_id = '$pic' where id = '$special_id'");	
							/*
							var_dump ("return", $ret3);
							var_dump ("XPM", $pm_id);
							var_dump ("special", $special_id);
							var_dump ("PM", $pic_id);
							var_dump ("EID", $eid);
							die();
							
							  */
						} else {
						
							$ret = mysqli_query($con, "insert into tblProjectTeam(project_id, employee_id, proj_disc) value ('$eid', '$pic', '100')");
						}	
		
						
						
						
		/* check to see if PM has been assigned to Project Team - PM = 101 in the proj_disc column */
		
		$ret4 = mysqli_query($con, "select a.id, a.employee_id from tblProjectTeam a where a.project_id='$eid' and a.proj_disc = 101");

					list($spec_id, $pm_id) = @mysqli_fetch_row($ret4);
						
					if (isset($pm_id )) {
					
							$ret = mysqli_query($con, "update tblProjectTeam set employee_id = '$PM' where id = '$spec_id'");
					
							
							
						} else {
						
							$ret = mysqli_query($con, "insert into tblProjectTeam(project_id, employee_id, proj_disc) value ('$eid', '$PM', '101')");
					
							
						}
		
		if ($query) {
					
					
					$rno = mt_rand(10000, 99999);
					
					$pid = base64_encode($eid . $rno);
					
					/*
					header( "refresh:3;url=view-project.php?projid=$pid" );
					$msg = "Project has been added. You'll be redirected in about 3s secs..";
					*/
					
				}
		
	
		if ($query) {
			
			header( "refresh:3;url=view-project.php?projid=$ppid" );
			
			$msg = "Project has been update. You'll be redirected in about 3 secs.";
		} else {
			echo "Error: " . $msg . "<br>" . $con->error;
		}
	}
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
									<h4 class="m-t-0 header-title">Update Project </h4>
									
										<p class="text-muted m-b-30 font-14">
										
										</p>
										
										<div class="row">
											<div class="col-12">
												<div class="p-20">
													<?php

													$cid = substr(base64_decode($_GET['projid']), 0, -5);

													$ret = mysqli_query($con, "select a.id, a.project_number, a.projectname, a.Project_StartDate, a.Project_EndDate, a.status_id, a.EstimatedCost, a.ProjectMarket
																			from tblprojects a where a.id='$cid'");

													list($id, $project_number, $projectname, $start_date, $end_date, $status_id, $estimatedcost, $ProjectMarket) = @mysqli_fetch_row($ret);

													?>
													<p style="font-size:16px; color:red" align="center">

														<?php if ($msg) {
															
															echo $msg;
														}
														?>
													</p>

													<form class="form-horizontal" role="form" method="post" name="submit">
													
														<div class="form-group row">
															<label class="col-2 col-form-label" for="example-email">Project Name</label>
															<div class="col-10">
																
																<input type="text" id="project_number" name="project_number" class="form-control" autofocus required="true" value="<?php echo $project_number; ?>">
															</div>
														</div>

														<div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Project Name</label>
                                                        <div class="col-10">
																
																<input type="text" id="projectname" name="projectname" class="form-control" required="true" value="<?php echo $projectname; ?>">
															</div>
														</div>
														
														<!-- get the POC of the project -->
														<?php
															
															$ret1 = mysqli_query($con, "select a.employee_id from tblProjectTeam a where a.project_id='$cid' and a.proj_disc = 100");

															list($poc_id) = @mysqli_fetch_row($ret1);

														?>
														
														
														
														<div class="form-group row">
                                                        <label class="col-2 col-form-label">PIC</label>
															<div class="col-10">
																<select name='pic' id="pic" class="form-control">
																	<option value="">Select PIC</option>
																	<?php

																	$ret2 = mysqli_query($con, "select * from tbluser where active = '1' and board = '1' order by FullName");

																	while (list($emp_id, $FullName) = mysqli_fetch_row($ret2)) {
																		echo "<option value=$emp_id";
																		if ($emp_id == $poc_id) {
																			echo " selected";
																		}
																		echo ">$FullName</option>";
																	}
																	
																	?>

																</select>
															</div>
														</div>
														
														<!-- get the PM of the project -->
														
														<?php
															
															$ret3 = mysqli_query($con, "select a.employee_id from tblProjectTeam a where a.project_id='$cid' and a.proj_disc = 101");

															list($pm_id) = @mysqli_fetch_row($ret3);

														?>
														
														
														<div class="form-group row">
                                                        <label class="col-2 col-form-label">PM</label>
															<div class="col-10">
																<select name='pm' id="pm" class="form-control">
																	<option value="">Select PM</option>
																	<?php

																	$ret4 = mysqli_query($con, "select * from tbluser where active = '1' order by FullName");

																	while (list($PJMR_id, $FullName) = mysqli_fetch_row($ret4)) {
																		echo "<option value=$PJMR_id";
																		if ($PJMR_id == $pm_id) {
																			echo " selected";
																		}
																		echo ">$FullName</option>";
																	}
																	
																	?>

																</select>
															</div>
														</div>
														
														
														<div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Est. Constr. Cost</label>
                                                        <div class="col-10">
																<input type="text" id="estimatedcost" name="estimatedcost" class="form-control" value="<?php echo $estimatedcost; ?>">
															</div>
														</div>
														
														<div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Start Date</label>
															<div class="col-10">
																
																<input type="date" id="ProjectStart" name="ProjectStart" class="form-control" required="true" value="<?php echo substr($start_date, 0, 10); ?>">
															
															</div>
														</div>
													
														<div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">End Date</label>
															<div class="col-10">
																	
																	<input type="date" id="ProjectEnd" name="ProjectEnd" class="form-control" required="true" value="<?php echo substr($end_date, 0, 10); ?>">
																	
															</div>
														</div>
														
														<div class="form-group row">
                                                        <label class="col-2 col-form-label">Project Market Sector</label>
															<div class="col-10">
																<select name='sector_id' id="sector_id" class="form-control">
																	<option value="">Select Market Sector</option>
																	<?php

																	$ret = mysqli_query($con, "select id, name from tblMarketSector order by name asc");

																	while (list($sector_id, $sectorname) = mysqli_fetch_row($ret)) {
																		echo "<option value=$sector_id";
																		if ($sector_id == $ProjectMarket) {
																			echo " selected";
																		}
																		echo ">$sectorname</option>";
																	}
																	
																	?>

																</select>
															</div>
														</div>

														<div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Project Status</label>
															<div class="col-10">
																<select name='status_id' id="status_id" class="form-control">
																	<option value="">Select Status</option>
																	<?php

																	$ret = mysqli_query($con, "select id, statusname from tblProjectStatus order by statusname asc");

																	while (list($stat_id, $statusname) = mysqli_fetch_row($ret)) {
																		echo "<option value=$stat_id";
																		if ($stat_id == $status_id) {
																			echo " selected";
																		}
																		echo ">$statusname</option>";
																	}
																	mysqli_free_result($ret);
																	?>

																</select>
															</div>
														</div>

														<div class="form-group row">
															<div class="col-12">
																<p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Update Project</button></p>
															</div>
														</div>

													</form>

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