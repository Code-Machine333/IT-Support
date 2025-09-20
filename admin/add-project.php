<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $project_number = mysqli_real_escape_string($con, $_POST['project_number']);
        $projectname = mysqli_real_escape_string($con, $_POST['projectname']);
        $poc_id = mysqli_real_escape_string($con, $_POST['POC']);
		$pm_id = mysqli_real_escape_string($con, $_POST['PM']);
		$marketID = mysqli_real_escape_string($con, $_POST['marketID']);
        $startdate = mysqli_real_escape_string($con, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($con, $_POST['enddate']);


		/* Check to see if project number has been taken */
		$ret = mysqli_query($con, "select project_number from tblprojects where project_number='$project_number'");
        $result = mysqli_fetch_array($ret);
        if ($result > 0) {
			
			            $error_msg = "This Project Number is already being used";
			
        } else {
			
			$query = mysqli_query($con, "INSERT INTO tblprojects (project_number, projectname, Project_StartDate, Project_EndDate, status_id, ProjectMarket, PM, active) VALUES ('$project_number', '$projectname', '$startdate', '$enddate', '1', '$marketID', '$pm_id', 'yes')");
			
				if ($query) {
					
					/* get the last tblprojects id created and add POC */
					$last_id = mysqli_insert_id($con);
					mysqli_query($con, "INSERT INTO tblProjectTeam (project_id, employee_id, proj_disc, Deleted) VALUES ('$last_id', '$poc_id', '100', '1')");
					
					/* add PM if one is selected */
						if ($pm_id !== Null){
							mysqli_query($con, "INSERT INTO tblProjectTeam (project_id, employee_id, proj_disc, Deleted) VALUES ('$last_id', '$pm_id', '101', '1')");
						}						
					
					
					$rno = mt_rand(10000, 99999);
					
					$pid = base64_encode($last_id . $rno);
					
					header( "refresh:3;url=view-project.php?projid=$pid" );
					
					$msg = "Project has been added. You'll be redirected in about 3 secs..";
					
				} else {
					
					$msg = "Something Went Wrong. Please try again. Error: " . mysqli_error($con);
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
                                    <h4 class="m-t-0 header-title">Add New Project</h4>
                                    <p class="text-muted m-b-30 font-14">

                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <p style="font-size:16px; color:red" align="center">
                                                    <?php if ($error_msg) {
														
                                                        echo $error_msg;
														
													} else {
														
														echo $msg;
														
                                                        header("refresh:5;url=dashboard.php");
                                                      
                                                    }
                                                    ?>
                                                </p>
                                                <form class="form-horizontal" role="form" method="post" name="submit">

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">															

                                                            <label for="example-email">Project Number <font color="red"> (Project number nomenclature xxx-xxx-xx)</font></label>
                                                            <input type="text" id="project_number" name="project_number" class="form-control" required="true" autofocus>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="example-email">Project Name</label>
                                                            <input type="text" id="projectname" name="projectname" class="form-control" required="true">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="POC">Principal In Charge</label>
                                                            <select name="POC" id="POC" class="form-control">
                                                                <option value="">Select PIC</option>
                                                                <?php

                                                                $ret1 = mysqli_query($con, "select * from tbluser where active = '1' order by FullName ");

                                                                while ($row = mysqli_fetch_array($ret1)) {
                                                                    echo "<option value='" . $row['ID'] . "'>" . $row['FullName'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret1);
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
													
													
													<div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="PM">Project Manager</label>
                                                            <select name="PM" id="PM" class="form-control">
                                                                <option value="">Select PM</option>
                                                                <?php

                                                                $ret2 = mysqli_query($con, "select * from tbluser where active = '1' order by FullName ");

                                                                while ($row = mysqli_fetch_array($ret2)) {
                                                                    echo "<option value='" . $row['ID'] . "'>" . $row['FullName'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret2);
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
													
													<div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Market Sector</label>
                                                            <select name='marketID' id="marketID" class="form-control" required="true">
                                                                <option value="">Select Market Sector</option>
                                                                <?php $query = mysqli_query($con, "select * from tblMarketSector where active = '1'");
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php }
                                                                mysqli_free_result($ret);
                                                                ?>
                                                            </select>
                                                </div>
                                            </div>


                                                    <!-- <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="PM">Project Manager</label>
                                                            <select name="PM" id="PM" class="form-control">
                                                                <option value="">Select PM</option>
                                                                <?php

                                                                $ret2 = mysqli_query($con, "select * from tbluser where active = '1' order by FullName");

                                                                while ($row = mysqli_fetch_array($ret2)) {
                                                                    echo "<option value='" . $row['ID'] . "'>" . $row['FullName'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret2);
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>

                                                     <div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="PM">Project Architect</label>
                                                            <select name="PA" id="PA" class="form-control">
                                                                <option value="">Select PA</option>
                                                                <?php

                                                                $ret3 = mysqli_query($con, "select * from tbluser where active = '1'");

                                                                while ($row = mysqli_fetch_array($ret3)) {
                                                                    echo "<option value='" . $row['ID'] . "'>" . $row['FullName'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret3);
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
													
													
													
													<div class="form-group row m-b-20">
                                                        <div class="col-12">
                                                            <label for="PM">Select Project Disciplines</label>
                                                            <select name="PA" id="PA" class="form-control">
                                                                <option value="">Select PA</option>
                                                                <?php

                                                                $ret2 = mysqli_query($con, "select * from tbldiscipline where active = '1'");

                                                                while ($row = mysqli_fetch_array($ret2)) {
                                                                    echo "<option value='" . $row['ID'] . "'>" . $row['DisciplineName'] . " </option>";
                                                                }

                                                                mysqli_free_result($ret2);
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
													-->
													
                                            </div>
											
											<!-- 
											<div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Estimated Cost</label>
                                                    <input type="text" id="estimatedcost" name="estimatedcost" class="form-control">
                                                </div>
                                            </div>
											
											-->
											

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">Start Date</label>
                                                    <input type="date" id="startdate" name="startdate" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <label for="example-email">End Date</label>
                                                    <input type="date" id="enddate" name="enddate" class="form-control" required>
                                                </div>
                                            </div> 
											
                                            <div class="form-group row mt-5">

                                                <div class="col-12">
                                                    <p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Add Project</button></p>
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