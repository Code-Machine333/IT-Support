<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

if(isset($_POST['submit']))
  {
	$pid = $_POST['EmpID'];
	
	$project_id=substr(base64_decode($_GET['projid']),0,-5);
    
	$employee_id=mysqli_real_escape_string($con,$_POST['emp_id']);
	
	$proj_disc=mysqli_real_escape_string($con,$_POST['project_disc']);
	
	
	$note = mysqli_real_escape_string($con, $_POST['note']);
	
    $proj_id = $_REQUEST['projid'];
	
	$created_by = $_SESSION['adid'];
	
    $prjid = substr(base64_decode($_GET['projid']), 0, -5);
	
	$query = mysqli_query($con, "insert into tblProjectNotes (Note, ProjectID, CreatedBy) 
										value('$note', '$prjid', '$created_by')");
	
	if ($query) {
		
				$rno1 = mt_rand(10000, 99999);
				
				$pid  = base64_encode($prjid . $rno1);
				
                header( "refresh:3;url=view-project.php?projid=$pid" );
	
	$msg = "Project has been added. You'll be redirected in about 3 secs..";
	
  }
  else
    {
      $msg="Something Went Wrong. Please try again";
	 
	  
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
                                    <h4 class="m-t-0 header-title">Add Project Note</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <p style="font-size:16px; color:red" align="center">

														<?php if ($msg) {
															
															echo $msg;
														}
														?>
												</p>
                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            
                                                            <textarea id="note" name="note" class="form-control" required="true"autofocus rows="8"></textarea>
                                                        </div>
                                                    </div>

                                                    
                                            </div>
											
                                            <div class="form-group row mt-5">

                                                <div class="col-12">
                                                    <p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Add Project Note</button></p>
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