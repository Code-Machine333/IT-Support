<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $sid = substr(base64_decode($_GET['custid']), 0, -5);

    $username = $_POST['username'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $address = $_POST['useradd'];
    $admin = $_POST['admin'];
    $active = $_POST['active'];

    /* $query=mysqli_query($con, "update tbluser set FullName='$macname', MobileNumber='$mobno',Email= '$email', Address='$address' where ID=$mid"  ); */
    $query = mysqli_query($con, "update tbluser set FullName='$username', MobileNo='$mobno', Email='$email', Admin='$admin', Active='$active' where ID='$sid' ");
    if ($query) {
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
  <title>Vogt ERP</title>
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
                <h4 class="m-t-0 header-title">Edit Customer</h4>
                <p class="text-muted m-b-30 font-14">

                </p>

                <div class="row">
                  <div class="col-12">
                    <div class="p-20">
                      <p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
                                                                              echo $msg;
                                                                            }  ?> </p>
                      <form class="form-horizontal" role="form" method="post" name="submit">

                        <?php
                        $sid = substr(base64_decode($_GET['custid']), 0, -5);
                        $ret = mysqli_query($con, "select id, customer_name, customer_phone, comments, Active from customers where id='$sid'");
                        list($id, $customer_name, $customer_phone, $comments, $Active) = @mysqli_fetch_row($ret);
                        /* $cnt=1; 
													while ($row=mysqli_fetch_array($ret)) {*/

                        ?>


                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label">Customer Name</label>
                          <div class="col-lg-9">
                            <input class="form-control" type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label">Customer Phone</label>
                          <div class="col-lg-9">
                            <input class="form-control" type="text" name="customer_phone" value="<?php echo $customer_phone; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label">Comments</label>
                          <div class="col-lg-9">
                            <textarea class="form-control" rows="6" name="comments"><?php echo $comments; ?></textarea>
                          </div>
                        </div>
                        <fieldset class="form-group">
                          <div class="row">
                            <label class="col-lg-3 col-form-label form-control-label">Active</label>
                            <div class="custom-control custom-control-inline">
                              <label class="form-check-inline" for="active">
                                <?php if ($active == "1") { ?>
                                  <input type="checkbox" name="active" value="0" checked>
                                <?php
                                } else { ?>
                                  <input type="checkbox" name="active" value="1">
                                <?php
                                }
                                ?>
                              </label>
                            </div>
                          </div>
                        </fieldset>

                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label"></label>
                          <div class="col-lg-9">
                            <button type="submit" class="btn btn-primary" name="reg_p">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.container-fluid-->
            <!-- /.content-wrapper-->
            <footer class="sticky-footer">
              <div class="container">
                <div class="text-center">
                  <small>Copyright © Vogt Excavating 2019</small>
                </div>
              </div>
            </footer>
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
              <i class="fa fa-angle-up"></i>
            </a>
            <!-- Logout Modal-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin.min.js"></script>
          </div>
</body>

</html>