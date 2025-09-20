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
                                    <h5 class="m-t-0 header-title">View Project
									<a href="add-note.php?projid=<?php echo $cid=($_GET['projid']);?>" class="btn btn-primary btn-sm float-right">Add Note</a></h5>
                                    <p class="text-muted m-b-30 font-14">
                                       
                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                              
											<p style="font-size:16px; color:red" align="center"> <?php if($msg){
												echo $msg;
											  }  ?> </p>


											<?php
												$rno=mt_rand(10000,99999); 
												$cid=substr(base64_decode($_GET['projid']),0,-5);
												/* $custid=($_GET['custid']); */
												$ret=mysqli_query($con,"SELECT tblprojects.id, tblprojects.project_number, tblprojects.projectname, tblprojects.active,
																		tblprojects.Project_StartDate, tblprojects.Project_EndDate, tblstatus.statusname, tbluser.FullName
																		FROM ((tblprojects
																		LEFT JOIN tblstatus ON tblprojects.status_id = tblstatus.id)
																		LEFT JOIN tbluser ON tblprojects.PM = tbluser.ID) where tblprojects.id = '$cid';");

												list($id, $project_number, $projectname, $active, $startdate, $enddate, $statusname, $FullName) = @mysqli_fetch_row($ret);

											?>
											
											

												<table border="1" class="table table-bordered mg-b-0">
													<tr>
														<th>Project Number</th>
															<td><?php  echo $project_number;?></a></td>
															
													</tr>
													<tr>
														<th>Project Name</th>
															<td><?php echo $projectname;?></td>
													</tr>
													<tr>
														<th>Project Status</th>
															<td><?php echo $statusname;?></td>
													</tr>
													<tr>
														<th>Project Manager</th>
															<td><?php echo $FullName;?></td>
													</tr>
													
													<tr>
														<th>Start Date</th>
															<td><?php echo $startdate;?></td>
													</tr>
													<tr>
														<th>End Date</th>
															<td><?php echo $enddate;?></td>
													</tr>
													
													<tr>
														<th>Active</th>
															<td><?php echo $active;?></td>
													</tr>
													
												</table>
												
												<br><br>
												<?php
												
												$ret=mysqli_query($con,"SELECT tblnotes.id, tblnotes.notes, tblnotes.date, tblnotes.proj_id, tbluser.FullName
																		FROM ((tblnotes
																		LEFT JOIN tbluser ON tbluser.id = tblnotes.created_by)
																		LEFT JOIN tblprojects ON tblprojects.id = tblnotes.proj_id) where tblprojects.id = '$cid';");

												list($id, $notes, $date, $proj_id, $FullName) = @mysqli_fetch_row($ret);

											?>
											
												<div class="list-group">
												  <button type="button" class="list-group-item list-group-item-action disabled">
													Project Notes
												  </button>
												  <button type="button" class="list-group-item list-group-item-action">2022-10-13 Updated owner on new plans - IT Support</button>
												</div>
												
  
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