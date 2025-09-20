<?php
	session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $milename = mysqli_real_escape_string($con, $_POST['milename']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $milestart_date = $_POST['milestart_date'];
        $mileend_date = $_POST['mileend_date'];
		$milestone_id = mysqli_real_escape_string($con, $_POST['milestone_id']);
        $proj_id = $_REQUEST['projid'];
		$created_by = $_SESSION['adid'];
        $prjid = substr(base64_decode($_GET['projid']), 0, -5);
		if ($prjid == '') {
			$message = "There is no project number";
            echo "<script type='text/javascript'>alert('$message');</script>";
		} else {
        if ($mileend_date < $milestart_date) {
            $message = "The end date is not correct";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $query = mysqli_query($con, "INSERT INTO tblmilestone (MilestoneName, createdby, start_date, end_date, status, description, project_id) 
										VALUES ('$milename', '$created_by', '$milestart_date', '$mileend_date', '$milestone_id', '$description', '$prjid')");
            if ($query) {
				
				$rno1 = mt_rand(10000, 99999);
				
				$pid  = base64_encode($prjid . $rno1);
				
                header( "refresh:3;url=view-project.php?projid=$pid" );
					
					$msg = "Milestone has been added. You'll be redirected in about 3 secs..";
					
				} else {
					
					$msg = "Something Went Wrong. Please try again";
				}
			}	
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
                                    <h4 class="m-t-0 header-title">Add Milestone</h4>
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
                                                            
                                                            <label for="example-email">Milestone Name </label>
                                                            <input type="text" id="milename" name="milename" class="form-control" required="true" autofocus>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Milestone Description</label>
                                                            <input type="text" id="description" name="description" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    
                                            </div>
											
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Start Date</label>
                                                    <input type="date" id="milestart_date" name="milestart_date" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">End Date</label>
                                                    <input type="date" id="mileend_date" name="mileend_date" class="form-control">
                                                </div>
                                            </div>
											
											<div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Milestone Status</label>
                                                            <select name='milestone_id' id="milestone_id" class="form-control" required="true">
                                                                <option value="">Select Status</option>
                                                                <?php $query = mysqli_query($con, "select * from tblMilestoneStatus where active = '1'");
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['StatusName']; ?></option>
                                                                <?php }
                                                                mysqli_free_result($query);
                                                                ?>
                                                            </select>
                                                </div>
                                            </div>


                                            <div class="form-group row mt-5">

                                                <div class="col-12">
                                                    <p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Add Milestone</button></p>
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