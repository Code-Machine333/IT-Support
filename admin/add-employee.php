<?php
	session_start();
	error_reporting(0);
	include('includes/dbconnection.php');
	if (strlen($_SESSION['adid']==0)) {
		header('location:logout.php');
		} else{
		
		if(isset($_POST['submit']))
		{
			$pid = $_POST['EmpID'];
			
			$project_id=substr(base64_decode($_GET['projid']),0,-5);
			
			$employee_id=mysqli_real_escape_string($con,$_POST['district']);
			
			$proj_disc=mysqli_real_escape_string($con,$_POST['state']);
			
			/* $created_by=$_SESSION['adid']; */
			
			
			
			$query=mysqli_query($con, "insert into tblProjectTeam(project_id, employee_id, proj_disc, Deleted)
			value ('$project_id','$employee_id', '$proj_disc', '1')");
			if ($query) {
				
				header( "refresh:3;url=view-projects-team.php?projid=$pid" );
				
				$msg="Project Team Member has been added.";
				
			}
			else
			{
				$msg="Something Went Wrong. Please try again";
				
				
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
			<script src="assets/js/selectpicker.js"></script>
			
			<!-- used for double drop downs 
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
			
			<script>
			function getdistrict(val) {
				$.ajax({
					type: "POST",
					url: "get_district.php",
					data:'state_id='+val,
					success: function(data){
						$("#district-list").html(data);
					}
				});
			}
			function selectCountry(val) {
				$("#search-box").val(val);
				$("#suggesstion-box").hide();
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
									<div class="card-box shadow">
										<div class="d-flex align-items-center justify-content-between">
											<h5 class="m-t-0 mb-0  header-title">Add Employee to Project</h5>
										</div>
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
																<label>Project Discipline</label>
																
																<select onChange="getdistrict(this.value);"  name="state" id="state" class="form-control" >
																	<option value="">Select</option>
																	<?php $query =mysqli_query($con,"SELECT DISTINCT DisciplineName, id FROM tbldiscipline where active = 'yes' order by DisciplineName asc;");
																		while($row=mysqli_fetch_array($query))
																		{ ?>
																		<option value="<?php echo $row['id'];?>"><?php echo $row['DisciplineName'];?></option>
																		<?php
																		}
																	?>
																</select>
																
																
																
																
																<!-- new select from  secondary drop down 
																
																<select name='project_disc' id="project_disc" class="form-control" required="true">
																	<option value="">Select Project Discipline</option>
																	
																	<?php
																		$rno = mt_rand(10000, 99999);
																		$sid=substr(base64_decode($_GET['projid']),0,-5);
																		
																		
																		$ret=mysqli_query($con,"SELECT DISTINCT DisciplineName, id FROM tbldiscipline where active = 'yes' order by DisciplineName asc;");
																		
																		
																		
																		while ($row = mysqli_fetch_array($ret)) 
																		{
																		?>    
																		<option value="<?php echo $row['id'];?>"><?php echo $row['DisciplineName'];?></option>
																		<?php } 
																		mysqli_free_result($ret);
																	?>  
																</select> -->
															</div>
														</div>
														
														<div class="form-group row m-b-20">
															<div class="col-12">
																<label>Employee</label>
																
																<!-- new select from  secondary drop down -->
																
																<select name="district" id="district-list" class="form-control">
																<option value="">Select</option>
																</select>
															
																<!-- old select from  secondary drop down 
																<select name='emp_id' id="emp_id" class="form-control selectpicker" required="true">
																</select>-->
																
																<input type="hidden" name="EmpID" value=<?php echo base64_encode($sid . $rno); ?>>
															</div>
														</div>													
														
														<div class="form-group row">
															
															<div class="col-12">
																<p style="text-align: center;"> <button type="submit" name="submit" class="btn-custom-primary">Add Employee</button></p>
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
			
			<script>
				$( "select[name='project_disc']" ).change(function () {
					var PDID = $(this).val();
					
					
					if(PDID) {
						
						
						$.ajax({
							url: "ajaxpro.php",
							dataType: 'Json',
							data: {'id':PDID},
							success: function(data) {
								$('select[name="emp_id"]').empty();
								$.each(data, function(key, value) {
									$('select[name="emp_id"]').append('<option value="'+ key +'">'+ value +'</option>');
								});
							}
						});
						
						
						}else{
						$('select[name="emp_id"]').empty();
					}
				});
			</script>
			
		</body>
	</html>
<?php }  ?>		