<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['adid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $username=mysqli_real_escape_string($con,$_POST['username']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
	$admin=mysqli_real_escape_string($con,$_POST['admin']);
	$board=mysqli_real_escape_string($con,$_POST['board']);
	$discipline_id=mysqli_real_escape_string($con,$_POST['discipline_id']);
	$office_id=mysqli_real_escape_string($con,$_POST['office_id']);
	$password=md5($_POST['password']);

    $ret=mysqli_query($con, "select Email from tbluser where Email='$email'");
    $result=mysqli_fetch_array($ret);
		if($result>0){
		$msg="This email or Contact Number already associated with another account";
		}
			else {
					$query=mysqli_query($con, "insert into tbluser(FullName, Email, Password, admin, fk_discipline, Board, Deleted, fk_office, active) 
						VALUES('$username', '$email', '$password', '$admin', $discipline_id, $board, '1', $office_id, '1')");
					if ($query) {
								header( "refresh:3;url=manage-user.php" );
								$msg="User has been added successfully, You'll be redirected in about 3 secs.";
								}
				else {
					
						$msg="Something Went Wrong. Please try again";
						/* $msg="Error . '$username', '$email', '$password'"; 
						$msg = mysqli_error($con); */
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


        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="assets/js/modernizr.min.js"></script>
		
		<script type="text/javascript">
			function checkpass()
			{
			if(document.createuser.password.value!=document.createuser.repeatpassword.value)
				{
				alert('Password and Repeat Password field does not match');
				document.createuser.repeatpassword.focus();
				return false;
				}
			return true;
			} 

</script>

    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper">

          <?php include_once('includes/sidebar.php');?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                 <?php include_once('includes/header.php');?>

                <!-- Start Page content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Add User</h4>
                                    <p class="text-muted m-b-30 font-14">
                                       
                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <p style="font-size:16px; color:red" align="center"> <?php if($msg){ echo $msg; }  ?> </p>
												<form class="form-horizontal" role="form" method="post" name="createuser" onsubmit="return checkpass();">
                                                   
                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12"><label for="example-email">User Name</label>
                                                            <input type="text" id="username" name="username" class="form-control"  required="true" autofocus>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20">
                                                        <div class="col-12">
														<label>Discipline</label>
                                                            <select name='discipline_id' id="discipline_id" class="form-control" required="true">
																		<option value="">Select Discipline</option>
																		<?php $query=mysqli_query($con,"select * from tbldiscipline where active = 'yes' order by DisciplineName asc");
																				while($row=mysqli_fetch_array($query))
																				{
																		?>    
																	    <option value="<?php echo $row['id'];?>"><?php echo $row['DisciplineName'];?></option>
																		<?php } 
																			mysqli_free_result($ret);
																		?>  
														   </select>
                                                        </div>
                                                    </div>
													
													<div class="form-group row m-b-20">
                                                        <div class="col-12">
														<label>Office</label>
                                                            <select name='office_id' id="office_id" class="form-control" required="true">
																		<option value="">Select Office</option>
																		<?php $query=mysqli_query($con,"select * from tbloffices where active = 'yes' order by OfficeName asc");
																				while($row=mysqli_fetch_array($query))
																				{
																		?>    
																	    <option value="<?php echo $row['id'];?>"><?php echo $row['OfficeName'];?></option>
																		<?php } 
																			mysqli_free_result($query);
																		?>  
														   </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-20"> 
                                                        <div class="col-12">
														<label for="example-email">User Email</label>
                                                            <input type="email" id="email" name="email" class="form-control">
                                                        </div>
                                                    </div>
													
													<div class="form-group row m-b-20">
														<div class="col-12">
														<label for="password">Password</label>
															<input class="form-control" type="password" id="password" name="password">
														</div>
													</div>
													
													<div class="form-group row m-b-20">
														<div class="col-12">
															<label for="password">Repeat Password</label>
															<input class="form-control" type="password" id="repeatpassword" name="repeatpassword">
														</div>
													</div>
													
													<div class="form-group row m-b-20">
														<div class="col-12">
														<div class="checkbox checkbox-custom">
															<input id="admin" type="checkbox" name="admin" value="1" checked="">
															<label for="admin">
																Admin Permissions </a>
															</label>
														</div>
														</div>
													</div>  
													
													<div class="form-group row m-b-20">
														<div class="col-12">
														<div class="checkbox checkbox-custom">
															<input id="board" type="checkbox" name="board" value="1" checked="">
															<label for="board">
																Board Member
															</label>
														</div>
														</div>
													</div>
                                                 
                                              
													<div class="form-group row">
                                                    
                                                        <div class="col-12">
                                                            <p style="text-align: center;"> <button type="submit" name="submit" class="btn btn-info btn-min-width mr-1 mb-1">Add</button></p>
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

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>
<?php }  ?>