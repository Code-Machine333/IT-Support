<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
	header('location:logout.php');
} else {
	if (isset($_POST['submit'])) {
		$catname = $_POST['catename'];
		$eid = substr(base64_decode($_GET['editid']), 0, -5);

		$query = mysqli_query($con, "update tblcategory set VehicleCat = '$catname' where ID=$eid");
		if ($query) {
			$msg = "Category has been update.";
		} else {
			$msg = "Something Went Wrong. Please try again";
		}
	}
?>


	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<title>Vogt ERP</title>
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
									<h4 class="m-t-0 header-title">Update Vehicle</h4>
									<p class="text-muted m-b-30 font-14">

									</p>

									<div class="row">
										<div class="col-12">
											<div class="p-20">
												<?php

												$cid = substr(base64_decode($_GET['editid']), 0, -5);
												$ret = mysqli_query($con, "select * from fleet where ID='$cid'");
												$cnt = 1;
												while ($row = mysqli_fetch_array($ret)) {

												?>
													<p style="font-size:16px; color:red" align="center">

														<?php if ($msg) {
															echo $msg;
														}  ?>
													</p>

													<form class="form-horizontal" role="form" method="post" name="submit">

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Tag ID</label>
																<input type="text" id="unit_number" name="unit_number" class="form-control" placeholder="Unit Number" required="true" value="<?php echo $row['unit_number']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Year</label>
																<input type="text" id="year" name="year" class="form-control" required="true" value="<?php echo $row['year']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Make</label>
																<input type="text" id="make" name="make" class="form-control" required="true" value="<?php echo $row['make']; ?>">
															</div>
														</div>


														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Model</label>
																<input type="text" id="model" name="model" class="form-control" required="true" value="<?php echo $row['model']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Gross Vehicle Weight</label>
																<input type="text" id="gvwr" name="gvwr" class="form-control" required="true" value="<?php echo $row['gvwr']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">License Number</label>
																<input type="text" id="license_number" name="license_number" class="form-control" required="true" value="<?php echo $row['license_number']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">City</label>
																<input type="text" id="city" name="city" class="form-control" required="true" value="<?php echo $row['city']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">State</label>
																<input type="text" id="state" name="state" class="form-control" required="true" value="<?php echo $row['state']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Cost New</label>
																<input type="text" id="cost_new" name="cost_new" class="form-control" required="true" value="<?php echo $row['cost_new']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Value</label>
																<input type="text" id="value" name="value" class="form-control" required="true" value="<?php echo $row['value']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Class</label>
																<input type="text" id="class" name="class" class="form-control" required="true" value="<?php echo $row['class']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Comp</label>
																<input type="text" id="comp" name="comp" class="form-control" required="true" value="<?php echo $row['comp']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Coll</label>
																<input type="text" id="coll" name="coll" class="form-control" required="true" value="<?php echo $row['coll']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Steers</label>
																<input type="text" id="steers" name="steers" class="form-control" required="true" value="<?php echo $row['steers']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Pushers</label>
																<input type="text" id="pusher" name="pusher" class="form-control" required="true" value="<?php echo $row['pusher']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Drives</label>
																<input type="text" id="drives" name="drives" class="form-control" required="true" value="<?php echo $row['drives']; ?>">
															</div>
														</div>

														<div class="form-group row m-b-20">
															<div class="col-12">
																<label for="example-email">Active</label>
																<input type="text" id="drives" name="drives" class="form-control" required="true" value="<?php echo $row['drives']; ?>">
															</div>
														</div>


													<?php } ?>

													<div class="form-group row">
														<div class="col-12">
															<p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Update</button></p>
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