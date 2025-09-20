<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        
		$ppid = $_POST['ProjectStrange'];
		$eid = mysqli_real_escape_string($con, $_POST['ProjectTeamID']); 
        $disc_id = mysqli_real_escape_string($con, $_POST['disc_id']);  
        $deleted = $_POST['deleted'];

		
		$query=mysqli_query($con, "update tblProjectTeam set proj_disc ='$disc_id', Deleted = '$deleted' where id = '$eid' ");

        if ($query) {
			
			header( "refresh:3;url=view-project.php?projid=$ppid" );
			
            $msg = "The Team Member has been updated";
        } else {
            $msg = "Something Went Wrong. Please try again";
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
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
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
								
									<?php
										$rno = mt_rand(10000, 99999);
									
                                        $sid = substr(base64_decode($_GET['udid']), 0, -5);
										$pid = $_SESSION['ProjectName'];
										$projID = $_SESSION	['ProjectID'];
										
                                        $ret = mysqli_query($con, "SELECT tbluser.FullName, tbldiscipline.id, tblProjectTeam.id, tbluser.ID, tblProjectTeam.project_id, tblProjectTeam.Deleted
																	FROM (((tblProjectTeam
																	LEFT JOIN tbluser ON tblProjectTeam.employee_id = tbluser.ID)
																	LEFT JOIN tblprojects ON tblProjectTeam.project_id = tblprojects.id)
																	LEFT JOIN tbldiscipline ON tbluser.fk_discipline = tbldiscipline.id)
																	where tblProjectTeam.employee_id = '$sid' and tblProjectTeam.project_id = '$projID' and tblProjectTeam.Deleted = '1'");
										
										
                                        list($FullName, $proj_disc, $id, $employee_id, $project_id, $Deleted) = @mysqli_fetch_row($ret);
                                    ?>
									
									<p style="font-size:16px; color:red" align="center">

														<?php if ($msg) {
															
															echo $msg;
														}
														?>
									</p>
							
                                <h4 class="m-t-0 header-title">Edit Project Team Member - <?php echo $FullName; ?></h4>
								                               
                                
                                <p class="text-muted m-b-30 font-14">

                                </p>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-20">
                                            
                                            <form class="form-horizontal" role="form" method="post" name="submit">

                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <label for="example-email">Project Role</label>
                                                        <select name='disc_id' id="disc_id" class="form-control">
                                                            <option value="">Select Project Role</option>
                                                            <?php

                                                            $ret = mysqli_query($con, "select id, DisciplineName from tbldiscipline where active = 'yes' order by DisciplineName asc");

                                                            while (list($disc_id, $project_disc) = mysqli_fetch_row($ret)) {
                                                                echo "<option value=$disc_id";
                                                                if ($disc_id == $proj_disc) {
                                                                    echo " selected";
                                                                }
                                                                echo ">$project_disc</option>";
                                                            }
                                                            mysqli_free_result($ret);
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
												
                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <div class="checkbox checkbox-custom">
                                                            <!-- <input id="deleted" type="checkbox" name="deleted" value="1"> -->
															
															<input id="deleted" type="checkbox" name="deleted" value="0" <?php if ($Deleted == "1") {
																echo " UNCHECKED";
                                                                                                                        } ?>>
															
															<!-- pass hidden variable for id -->
															
															
                                                            <label for="deleted">
															<input type="hidden" name="ProjectTeamID" value=<?php echo "$id;" ?>>
															<input type="hidden" name="ProjectStrange" value=<?php echo base64_encode($project_id . $rno); ?>>
                                                                Remove from Project </a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
												
											

                                                <div class="form-group row">

                                                    <div class="col-12">
														
                                                        <p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Update</button></p>
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