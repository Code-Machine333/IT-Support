<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
    if (strlen($_SESSION['sid']==0)) {
  header('location:logout.php');
  } else{

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

          <?php include_once('includes/sidebar.php');?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                 <?php include_once('includes/header.php');?>

                <!-- Start Page content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">View Task 
									<a href="start-task.php" class="btn btn-primary btn-sm float-right">Start Task</a></h4>
                                    <p class="text-muted m-b-30 font-14">
                                       
                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                              
											<p style="font-size:16px; color:red" align="center"> <?php if($msg){
												echo $msg;
											  }  ?> </p>


											<?php
												$sid=$_SESSION['sid'];
												$rno=mt_rand(10000,99999);
												$cid=($_GET['projid']);
												$ret=mysqli_query($con,"select a.id, a.instructions, a.active, a.date, a.employee_id, b.projectname, b.googlemap, b.location, c.scopename, d.customer_name, e.fullname
																	from tbltasks a, tblprojects b, tblscope c, customers d, tbluser e 
																	where a.employee_id = '$sid' and a.project_id = '$cid';");

												 list($id, $instructions, $active, $task_date, $employee_id, $projectname, $googlemap, $location, $scopename, $customer_name, $fullname) = @mysqli_fetch_row($ret); 
												 
												/*$row = mysqli_fetch_row($ret); */
												/*$cnt=1;
												while ($row=mysqli_fetch_array($ret)) {*/
											?>
											
												<table border="1" class="table table-bordered mg-b-0">
													<tr>
														<th>Task Number (<?php echo $cid; ?>)</th>
															<td><?php echo $id; ?> </td>
															
													</tr>
													<tr>
														<th>Customer Name</th>
															<td><?php echo $customer_name; ?> </td>
													</tr>
													
													<tr>
														<th>Project Name</th>
															<td><?php echo $projectname; ?> </td>
													</tr>

													<tr>
														<th>Google Map</th>
															<td><a href="<?php echo $googlemap;?>"><?php  echo $googlemap;?></a></td>
													</tr>
													<tr>
														<th>Address</th>
															<td><?php echo $location; ?> </td>
													</tr>
												 
													<tr>
														<th>Activity</th>
															<td><?php echo $scopename; ?> </td>
													</tr>
													
													<tr>
														<th>Task Date</th>
															<td><?php echo $task_date; ?> </td>
													</tr>
												  
													<tr>
														<th>Work Instructions</th>
															<td><?php echo $instructions; ?> </td>
													</tr>
													<tr>
														<th>Assigned To</th>
														
																<td> <?php  
																if ($employee_id ==0)
																{
																	echo "Not Assigned";
																  
																} else {
																	
																	echo $fullname;
																} ?>
															</td>
														
															
													</tr>
													<tr>
														<th>Active</th>
															<td><?php echo $active; ?> </td>
													</tr>
													
												</table>

												 <?php /* }  */ ?>
  
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

             <?php include_once('includes/footer.php');?>
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