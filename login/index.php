<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login']))
  {
    $emailcon=$_POST['emailcont'];
    $password=md5($_POST['password']);
    $query=mysqli_query($con,"select ID, admin, active, Deleted from tbluser where  (Email='$emailcon') && Password='$password' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
        $is_active = $ret['active'];
		$not_deleted = $ret['Deleted'];
        if($is_active == '1' and $not_deleted ==  '1'){
			
            $yes_admin = $ret['admin'];
				
            if($yes_admin=='1'){
                $_SESSION['adid']=$ret['ID'];
                header('location:/admin/dashboard.php');
            }
            else{
                $_SESSION['sid']=$ret['ID'];
                header('location:/user/welcome.php');
            }
            $_SESSION['user_id'] = $ret['ID'];
        } else {
            $msg="Don't have access at this time.";
        }
    } else {
        $msg="Invalid Details.";
    }
  }
  ?>







<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>CE ERP | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body class="account-pages">

        <!-- Begin page -->
        <div class="accountbg" >
            <img src="assets/images/Stacked-Red&.png" alt="user-img" title="Mat Helme">
        </div>

        <div class="wrapper-page account-page-full">

            <div class="card">
                <div class="card-block">

                    <div class="account-box">

                        <div class="card-box p-5">
                            <h3 class="text-uppercase text-center pb-4">
                                <a href="../index.php" class="text-success">
                                    <font color= #F04E24> <span>User Login</span> </font>
                                </a>
                            </h3>
                            <p style="font-size:16px; color:red" align="center"> <?php if($msg){
								echo $msg;
							  }  ?> 
							</p>

                            <form class="" action="#" name="login" method="post">

                                <div class="form-group row m-b-20 ">
                                    <div class="col-12">
                                        <label for="emailaddress">Email address</label>
                                        <input style="border-radius: 5px" class="form-control" type="text" id="emailcont" name="emailcont" required="" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        
                                        <label for="password">Password</label>
                                        <input style="border-radius: 5px" class="form-control" type="password" required="" id="password" name="password">
										<a href="forget-password.php" class="text-muted float-right"><small>Forgot your password?</small></a>
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">

                                        

                                    </div>
                                </div>

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button style="background-color:#F04E24; border-color:#F04E24; border-radius: 5px; box-shadow: none" class="btn btn-block btn-custom waves-effect waves-light" type="submit" name="login">Sign In</button>
                                    </div>
                                </div>

                            </form>

                           </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright">2023 © Clark & Enersen ERP</p>
            </div>

        </div>



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
