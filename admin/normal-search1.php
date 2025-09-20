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
									<form id="basic-form" method="post">
										<div class="form-group">
											<label>Search by Project Number or Project Name</label>
											<input id="searchdata" type="text" name="searchdata" required="true" class="form-control" autofocus placeholder="Project Number or Project Name">
										</div>

										<br>
										<button type="submit" class="btn-custom-primary" name="search" id="submit">Search</button>
									</form>

									<?php
									$rno = mt_rand(10000, 99999);
									$sid = substr(base64_decode($_GET['udid']), 0, -5);
									if (isset($_POST['search'])) {

										$sdata = $_POST['searchdata'];
									?>
										<h4 align="center">Result against "<?php echo $sdata; ?>" keyword </h4>
										<div class="data-tables">
											<table class="table text-center">
												<thead class="bg-light text-capitalize">
													<tr>
														<th>Search #</th>
														<th>Project Number</th>
														<th>Project Name</th>
													</tr>
												</thead>
												<?php
												$ret = mysqli_query($con, "select * from tblprojects where project_number like '%$sdata%' or projectname like '%$sdata%' ");
												$num = mysqli_num_rows($ret);
												if ($num > 0) {
													$cnt = 1;
													while ($row = mysqli_fetch_array($ret)) {

												?>
														<tbody>
															<tr data-expanded="true">
																<td><?php echo $cnt; ?></td>
																<td><a href="view-project.php?projid=<?php echo base64_encode($row['id'] . $rno); ?>"><?php echo $row['project_number']; ?></a></td>
																<td><?php echo $row['projectname']; ?></td>
															</tr>
														<?php
														$cnt = $cnt + 1;
													}
												} else { ?>
														<tr>
															<td colspan="8"> No record found against this search</td>
														</tr>
												<?php }
												$con->close();
											} ?>
														</tbody>
											</table>

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