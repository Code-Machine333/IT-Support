<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $sid = substr(base64_decode($_GET['udid']), 0, -5);
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $mobno = mysqli_real_escape_string($con, $_POST['mobilenumber']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $disc_id = mysqli_real_escape_string($con, $_POST['disc_id']);
        $office_id = mysqli_real_escape_string($con, $_POST['office_id']);
        $manager_id = mysqli_real_escape_string($con, $_POST['reports']);
        $admin = $_POST['admin'];
		$board = $_POST['board'];
        $active = $_POST['active'];
		$deleted = $_POST['deleted'];
        /* $password=md5($_POST['password']); */

        $query = mysqli_query($con, "update tbluser set FullName='$username', MobileNo='$mobno', Email='$email', admin='$admin', fk_reports='$manager_id', active='$active', fk_discipline='$disc_id',
								fk_office='$office_id', board='$board', Deleted = '$deleted' where ID='$sid' ");
        if ($query) {
			
			header("refresh:3;url=manage-user.php");
			
            $msg = "User profile has been updated";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

    <script src="assets/js/modernizr.min.js"></script>

    <script type="text/javascript">
        function checkpass() {
            if (document.signup.password.value != document.signup.repeatpassword.value) {
                alert('Password and Repeat Password field does not match');
                document.signup.repeatpassword.focus();
                return false;
            }
            return true;
        }
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

                    <?php
                    $get_url = $_GET;
                    $query_string = http_build_query($get_url) . "\n";
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box shadow">
                                <h4 class="m-t-0 header-title">Edit User</h4>
                                <!-- <a href="updatepassword.php" class="dropdown-item notify-item">
                                        <i class="fi-cog"></i> <span>Change Password</span>
                                    </a> -->
                                <a href="edit-user-password.php?<?php echo $query_string; ?>" class="dropdown-item notify-item">
                                    <i class="fi-cog"></i> <span>Change Password</span>
                                </a>
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

                                                <?php
                                                $sid = substr(base64_decode($_GET['udid']), 0, -5);
                                                $ret = mysqli_query($con, "select ID, FullName, MobileNo, Email, RegDate, active, admin, fk_discipline, fk_office, fk_reports, board from tbluser where ID='$sid'");
                                                list($id, $FullName, $MobileNo, $Email, $RegDate, $active, $admin, $fk_disc, $fk_office, $fk_reports, $board) = @mysqli_fetch_row($ret);
                                                /* $cnt=1; 
													while ($row=mysqli_fetch_array($ret)) {*/

                                                ?>

                                                <div class="form-group row m-b-20">
                                                    <div class="col-12"><label for="example-email">User Name</label>
                                                        <input type="text" id="username" name="username" class="form-control" autofocus required="true" value="<?php echo $FullName; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <label for="example-email">Discipline</label>
                                                        <select name='disc_id' id="disc_id" class="form-control">
                                                            <option value="">Select Discipline</option>
                                                            <?php

                                                            $ret = mysqli_query($con, "select id, DisciplineName from tbldiscipline where active = 'yes' order by DisciplineName asc");

                                                            while (list($disc_id, $disc_name) = mysqli_fetch_row($ret)) {
                                                                echo "<option value=$disc_id";
                                                                if ($disc_id == $fk_disc) {
                                                                    echo " selected";
                                                                }
                                                                echo ">$disc_name</option>";
                                                            }
                                                            mysqli_free_result($ret);
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <label for="example-email">Office</label>
                                                        <select name='office_id' id="office_id" class="form-control">
                                                            <option value="">Select Office</option>
                                                            <?php

                                                            $ret = mysqli_query($con, "select id, OfficeName from tbloffices order by OfficeName asc");

                                                            while (list($office_id, $office_name) = mysqli_fetch_row($ret)) {
                                                                echo "<option value=$office_id";
                                                                if ($office_id == $fk_office) {
                                                                    echo " selected";
                                                                }
                                                                echo ">$office_name</option>";
                                                            }
                                                            mysqli_free_result($ret);
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
												
												<div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <label for="example-email">Reports To</label>
                                                        <select name='reports' id="reports" class="form-control">
                                                            <option value="">Reports To</option>
                                                            <?php

                                                            $ret = mysqli_query($con, "select id, FullName from tbluser order by FullName asc");

                                                            while (list($manager_id, $FullName) = mysqli_fetch_row($ret)) {
                                                                echo "<option value=$manager_id";
                                                                if ($manager_id == $fk_reports) {
                                                                    echo " selected";
                                                                }
                                                                echo ">$FullName</option>";
                                                            }
                                                            mysqli_free_result($ret);
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <label for="example-email">User Email</label>
                                                        <input type="email" id="email" name="email" class="form-control" required="true" value="<?php echo $Email; ?>">
                                                    </div>
                                                </div>
												
                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <div class="checkbox checkbox-custom">
                                                            <input id="admin" type="checkbox" name="admin" value="1" <?php if ($admin == "1") {
                                                                                                                            echo " CHECKED";
                                                                                                                        } ?>>
                                                            <label for="admin">
                                                                Admin </a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
												
												<div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <div class="checkbox checkbox-custom">
                                                            <input id="board" type="checkbox" name="board" value="1" <?php if ($board == "1") {
                                                                                                                            echo " CHECKED";
                                                                                                                        } ?>>
                                                            <label for="board">
                                                                Board Member </a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <div class="checkbox checkbox-custom">
                                                            <input id="active" type="checkbox" name="active" value="1" <?php if ($active == "1") {
                                                                                                                            echo " CHECKED";
                                                                                                                        } ?>>
                                                            <label for="active">
                                                                Active </a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
												
												<div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <div class="checkbox checkbox-custom">
                                                            <input id="deleted" type="checkbox" name="deleted" value="0">
                                                            <label for="deleted">
                                                                Delete User </a>
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