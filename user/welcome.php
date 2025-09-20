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

     <div id="wrapper">

          <?php include_once('includes/sidebar.php');?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                 <?php include_once('includes/header.php');?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">


			<?php include_once('includes/header.php');?>
               
                <!-- Top Bar End -->



                <!-- Start Page content -->
               
                <div class="content">

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Welcome Clark Enersen ERP !</h4>

                                    <div class="row">
                                       

										<div class="col-sm-6 col-lg-6 col-xl-3">
                                            <div class="card-box mb-0 widget-chart-two">
                                                <div class="float-right">
                                                    <?php 
														$uid=$_SESSION['sid'];
														$query3=mysqli_query($con,"SELECT tbluser.FullName, tblprojects.id, tblprojects.project_number, tblprojects.projectname
																			FROM ((tblmain
																			LEFT JOIN tbluser ON tblmain.employee_id = tbluser.id)
																			LEFT JOIN tblprojects ON tblmain.project_id = tblprojects.id)
																			where tblmain.employee_id = '$uid'; ");
														$sercount=mysqli_num_rows($query3);
?>
                                                    <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round
                                                           data-fgColor="#2d7bf4" value="<?php echo $sercount;?>" data-skin="tron" data-angleOffset="180"
                                                           data-readOnly=true data-thickness=".2"/>
                                                </div>
                                                <div class="widget-chart-two-content">
                                                    <p class="text-muted mb-0 mt-2"><a href="view-projects-user.php">Assigned Projects</a></p>
                                                    
                                                </div>

                                            </div>
                                        </div>
										
										<div class="col-sm-6 col-lg-6 col-xl-3">
                                            <div class="card-box mb-0 widget-chart-two">
                                                <div class="float-right">
                                                    <?php
														$query1=mysqli_query($con,"Select * from tblprojects where active = 'yes'");
														$enqcount=mysqli_num_rows($query1);
													?>
                                                    <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round
                                                           data-fgColor="#f9bc0b" value="<?php echo $enqcount;?>" data-skin="tron" data-angleOffset="180"
                                                           data-readOnly=true data-thickness=".2"/>
                                                </div>
                                                <div class="widget-chart-two-content">
                                                    <p class="text-muted mb-0 mt-2"><a href="manage-active-projects.php">Active Projects</a></p>
                                                    
                                                </div>

                                            </div>
                                        </div>
										
										<div class="col-sm-6 col-lg-6 col-xl-3">
                                            <div class="card-box mb-0 widget-chart-two">
                                                <div class="float-right">
                                                    <?php
														$query2=mysqli_query($con,"Select * from tblprojects");
														$project_count=mysqli_num_rows($query2);
													?>
                                                    <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round
                                                           data-fgColor="#f9bc0b" value="<?php echo $project_count;?>" data-skin="tron" data-angleOffset="180"
                                                           data-readOnly=true data-thickness=".2"/>
                                                </div>
                                                <div class="widget-chart-two-content">
                                                    <p class="text-muted mb-0 mt-2"><a href="manage-projects.php">All Projects</a></p>
                                                    
                                                </div>

                                            </div>
                                        </div>
                                  
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>
                        <!-- end row -->



                       
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

        <!-- Flot chart -->
        <script src="../plugins/flot-chart/jquery.flot.min.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.time.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.tooltip.min.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.resize.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.pie.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.crosshair.js"></script>
        <script src="../plugins/flot-chart/curvedLines.js"></script>
        <script src="../plugins/flot-chart/jquery.flot.axislabels.js"></script>

        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="../plugins/jquery-knob/excanvas.js"></script>
        <![endif]-->
        <script src="../plugins/jquery-knob/jquery.knob.js"></script>

        <!-- Dashboard Init -->
        <script src="assets/pages/jquery.dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
<?php } ?>