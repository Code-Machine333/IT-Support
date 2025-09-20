<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {

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
                                    <h4 class="m-t-0 header-title">Project Team
                                        <p class="text-muted m-b-30 font-14">

                                        </p>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="p-20">
													
													
													<table class="table mb-0">
                                                        <thead>
                                            
                                                        </thead>
                                                            <?php
                                                                $rno = mt_rand(10000, 99999);
                                                                $sid = substr(base64_decode($_GET['udid']), 0, -5);
                                                                
                                                                $managed_by = $_SESSION['adid'];
                                                                
                                                                $ret=mysqli_query($con,"select tbluser.ID, tbluser.FullName
																						from (tblManagedBy
																						LEFT JOIN tbluser ON tblManagedBy.employee_id = tbluser.ID)
																						where tblManagedBy.ManagedBy_id = '$managed_by' order by FullName ASC;");
																
																	
                                                                $cnt=1;
                                                                while ($row=mysqli_fetch_array($ret)) {
                                                                $employee_id = $row[employee_id];	
                                                            ?>
                                                            
                                                            <tr>
                                                                <td class="border-0"><?php  echo $row[FullName]; ?></td>
                                                            </tr>
                                                            
                                                                                                            
                                                                                                            
                                                                    <?php
                                                                        $rno=mt_rand(10000,99999); 
                                                                        
                                                                        $today = date('Y-m-d');

                                                                        $retb = mysqli_query($con, "SELECT tbluser.FullName, tblprojects.id, tblprojects.project_number, tblprojects.projectname
                                                                                        from (((tblProjectTeam
                                                                                        LEFT JOIN tbluser ON tblProjectTeam.employee_id = tbluser.ID)
                                                                                        LEFT JOIN tblManagedBy ON tbluser.ID = tblManagedBy.employee_id)
                                                                                        LEFT JOIN tblprojects ON tblProjectTeam.project_id = tblprojects.id)
                                                                                        where tblProjectTeam.Deleted = '1' and tblManagedBy.ManagedBy_id = '$managed_by';");
                                                                        
                                                                        $cntb=1;
                                                                        while ($data=mysqli_fetch_array($retb)) {
                                                                            if ($row[FullName] == $data[FullName]) {
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><a href="view-project.php?projid=<?php echo base64_encode($data['id'].$rno);?>"><?php  echo $data['project_number'];?></a></td>
                                                                                        <td><?php  echo $data['projectname'];?></td>
                                                                                    </tr>
                                                                                                                                
                                                                                    <?php
                                                                            }
                                                                     $cntb++; } ?>
                                                                                                                            
                                                            <?php } ?>
                                                    </table>

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