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
								
									<!-- sql statement to get the project name and project number -->
									
									<?php
										$rno = mt_rand(10000, 99999);
										$sid = substr(base64_decode($_GET['notesid']), 0, -5);
										$ret1 = mysqli_query($con, "SELECT tblprojects.id, tblprojects.project_number, tblprojects.projectname
											FROM  tblprojects, tblProjectNotes where tblprojects.id = tblProjectNotes.ProjectID and tblProjectNotes.id = '$sid';");

										list($id, $project_number, $projectname) = @mysqli_fetch_row($ret1);
										
										/*-- create session variables --*/
										$_SESSION['Projectname'] = $projectname;
										$_SESSION['ProjectID'] = $id;
										
										$rno = mt_rand(10000, 99999);
					
										$pid = base64_encode($id . $rno);
                                    ?>
									
									<div class="d-flex align-items-center justify-content-between">
									
											
									
										<h5 class="m-t-0 mb-0  header-title">Project Notes for <?php echo $projectname; ?> - <a href="view-project.php?projid=<?php echo $pid; ?>"> <?php echo $project_number; ?></a>
										</h5>
										<nav class="navbar navbar-expand-lg navbar-light">

											<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
												<span class="navbar-toggler-icon"></span>
											</button>
											<!-- create an if then to edit the note -->
											
											<ul class="navbar-nav">
												<li class="nav-item">
													<!-- check to see if logged in user is who created note, if so, display the edit button -->
													<?
													$rno = mt_rand(10000, 99999);
														$cid = substr(base64_decode($_GET['notesid']), 0, -5);
														$ret = mysqli_query($con, "SELECT tblProjectNotes.id, tblProjectNotes.Note, tblProjectNotes.CreateDate, tblprojects.id, tblprojects.project_number, tblprojects.projectname, tbluser.id, tbluser.FullName
																				FROM ((tblProjectNotes
																				LEFT JOIN tblprojects ON tblProjectNotes.ProjectID = tblprojects.id)
																				LEFT JOIN tbluser ON tblProjectNotes.CreatedBy = tbluser.ID) where tblProjectNotes.id = '$cid';");

														list($id, $ProjectNote, $CreateDate, $ProjectID, $ProjectNumber, $ProjectName, $user, $FullName) = @mysqli_fetch_row($ret);
														
														
													
													
													if ($user_id = $user){ ?>
													
													<a class="btn-custom-primary mr-2" href="edit-project-note.php?notesid=<?php echo $cid = ($_GET['notesid']); ?>">Edit Note</a> <?
													
													}
													
													else {
													
													}
													?>
													
													
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
												
														

												?>
												



												<table class="styled-table">
													<tr>
													<th>Project Note</th>
														<td><?php echo $ProjectNote; ?></td>
													</tr>
												
														<th>Created By</th>
														<td><?php echo $FullName; ?> on <?php echo date('m-d-Y', strtotime($CreateDate)); ?></td>
													</tr>
													
													
													

												</table>
												<br><br>

												

												
												<br><br>
												
												

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