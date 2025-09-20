<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
	
	if (isset($_POST['delete'])) {
		
		$eid = substr(base64_decode($_GET['msid']), 0, -5);
		$rno = mt_rand(10000, 99999);
		$project_id = ($_POST['project_id']);
		$pid  = base64_encode($project_id . $rno);
		
		$query = mysqli_query($con, "delete from tblmilestone where id='$eid'");
		if ($query) {
				header("refresh:3;url=view-project.php?projid=$pid");
                $msg = "Milestone has been deleted. You'll be redirected in about 3 secs.";
            } else {
                echo "Error: " . $msg . "<br>" . $con->error;
            } 
	
    } elseif (isset($_POST['submit'])) {
		$eid = substr(base64_decode($_GET['msid']), 0, -5);
        $milename = mysqli_real_escape_string($con, $_POST['milename']);
        $miledesc = mysqli_real_escape_string($con, $_POST['miledesc']);
        $milestart_date = mysqli_real_escape_string($con, $_POST['milestart_date']);
        $mileend_date = mysqli_real_escape_string($con, $_POST['mileend_date']);
		$status_id = mysqli_real_escape_string($con, $_POST['status_id']);
        if ($mileend_date < $milestart_date) {
            $message = "The end date is not correct";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            
			
			$ppid = ($_GET['msid']);
            $query1 = mysqli_query($con, "update tblmilestone set MilestoneName = '$milename', status = '$status_id', description = '$miledesc', start_date = '$milestart_date', end_date = '$mileend_date' where id='$eid'");
            if ($query1) {
				header("refresh:3;url=view-milestone.php?msid=$ppid");
                $msg = "Milestone has been update. You'll be redirected in about 3 secs.";
            } else {
                echo "Error: " . $msg . "<br>" . $con->error;
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
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <script src="assets/js/modernizr.min.js"></script>
		<script>
		  $( function() {
			$( "#datepicker" ).datepicker();
		  } );
		</script>

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
                                    <h4 class="m-t-0 header-title">Update Milestone</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <?php

                                                $cid=substr(base64_decode($_GET['msid']),0,-5);
                                               

                                                $ret = mysqli_query($con, "select id, MilestoneName, status, start_date, end_date, description, project_id from tblmilestone where id='$cid'");
                                                list($id, $milename, $status, $start_date, $end_date, $description, $project_id) = @mysqli_fetch_row($ret);
                                                

                                                ?>
                                                <p style="font-size:16px; color:red" align="center">

                                                    <?php if ($msg) {
														
                                                        echo $msg;
                                                    }
                                                    ?>
                                                </p>

                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Milestone Name</label>
                                                        <div class="col-10">
                                                            <input type="text" id="milename" name="milename" class="form-control" required="true" value="<?php echo $milename; ?>" autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Milestone Description</label>
                                                        <div class="col-10">
                                                            <textarea id="miledesc" name="miledesc" class="form-control" required="true"><?php echo $description; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        
                                                            <label class="col-2 col-form-label" for="example-email">Start Date</label>
															<div class="col-10">
                                                            <input type="date" id="milestart_date" name="milestart_date" class="form-control" required="true" value="<?php echo substr($start_date, 0, 10); ?>">
															</div>
													</div>
													<div class="form-group row">
														
															
                                                            <label class="col-2 col-form-label" for="example-email">End Date</label>
															<div class="col-10">
                                                            <input type="date" id="mileend_date" name="mileend_date" class="form-control" required="true" value="<?php echo substr($end_date, 0, 10); ?>">
															<input type="hidden" name="project_id" value="<?php echo $project_id;?>">
															</div>
                                                        
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-2 col-form-label" for="example-email">Status</label>
                                                            <div class="col-10">
                                                                
                                                                <select name='status_id' id="status_id" class="form-control">
																	<option value="">Select Status</option>
																	<?php

																	$ret = mysqli_query($con, "select id, StatusName from tblMilestoneStatus order by statusname asc");

																	while (list($stat_id, $statusname) = mysqli_fetch_row($ret)) {
																		echo "<option value=$stat_id";
																		if ($stat_id == $status) {
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
																<p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Update Milestone</button>&nbsp;&nbsp;&nbsp;<button onClick="return confirm('Are you absolutely sure you want to delete?')" type="delete" name="delete" class="btn-custom-primary">Delete Milestone</button></p>
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