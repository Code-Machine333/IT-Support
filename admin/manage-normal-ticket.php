<?php  
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid']==0)) {
  header('location:logout.php');
  } else{

?>

<!doctype html>
<html class="no-js" lang="en">

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
    
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <?php include_once('includes/sidebar.php');?>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
          <?php include_once('includes/header.php');?>
            <!-- header area end -->
            <!-- page title area start -->
            <?php include_once('includes/pagetitle.php');?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">View Detail of Tickets</h4>
                                <div class="data-tables">
									<table class="table text-center">
										<thead class="bg-light text-capitalize">
											<tr>
												<?php $today = date("Y/m/d"); ?>
												
												<th>Ticket ID</th>
												<th>Generating Ticket Date <?php echo $today; ?></th>
												<th>Employee ID</th>
												<th>Action</th>
											</tr>
										</thead>					
											<?php
												$today = date("Y/m/d");
												$ret=mysqli_query($con,"select * from tbltasks where date = '$today' order by employee_id desc");
												$cnt=1;
												while ($row=mysqli_fetch_array($ret)) {

											?>
										<tbody>
											<tr data-expanded="true">
												  
												<td><?php  echo $row['id'];?></td>
												<td><?php  echo $row['date'];?></td>
												<td><?php  echo $row['employee_id'];?></td>
												<td><a href="view-normal-ticket.php?viewid=<?php echo $row['ID'];?>">View</a>
											</tr>
											<?php 
												$cnt=$cnt+1;
											}?>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- data table end -->
                   
                    
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <?php include_once('includes/footer.php');?>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    
    
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
<?php }  ?>