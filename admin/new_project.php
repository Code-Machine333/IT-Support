<?php 

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=1){
    header('Location: login.php');
    exit();
}

//pass username
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Vogt Dashboard</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top" OnLoad="document.customer.customer_name.focus();">
  	<!-- Navigation-->
		<?php include 'nav_menu.php';?>  
	<!-- End of Nav -->
  <div class="content-wrapper">
		<div class="container-fluid">
		  <!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
				  <a href="index.php">Dashboard</a>
				</li>
				<li class="breadcrumb-item active">Customer</li>
			</ol>
					<div class="row">					
						<!-- form layout location -->
						<div class="col-sm-8">
						<!-- start of form  -->
							<div class="card">
								<div class="card-header">
									<h4 class="mb-0">New Customer</h4>
								</div>
									<div class="card-body">
										<form  class="form" name=equipment method="post" action="add_customer.php">
											
											<input type="hidden" name="username" id="username" value="<?php echo $username; ?>"/>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label form-control-label">Customer Name</label>
												<div class="col-lg-9">
													<input class="form-control" type="text" name="customer_name">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label form-control-label">Customer Phone</label>
												<div class="col-lg-9">
													<input class="form-control" type="text" name="customer_phone">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label form-control-label">Comments</label>
												<div class="col-lg-9">
													<textarea class="form-control" rows="6" name="comments"></textarea>
												</div>
											</div>											
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label form-control-label"></label>
												<div class="col-lg-9">
													<button type="submit" class="btn btn-primary" name="reg_p">Submit</button>
												</div>
											</div>
										</form>
									</div>
							</div> 
						</div>
					</div>
		</div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Vogt Excavating 2019</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
  </div>
</body>

</html>
