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
        <title>Vehicle Service Managment System</title>
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
<script type="text/javascript">
  function printdata()
  {
    window.print();
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
                                    <h4 class="m-t-0 header-title">Service History View</h4>
                                    <p class="text-muted m-b-30 font-14">
                                       
                                    </p>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
         
         <form method="post">
        <p style="font-size:16px; color:red" align="left"> <?php if($msg){
    echo $msg;
  }  ?> </p>
         <?php
$cid=substr(base64_decode($_GET['srid']),0,-4);
$uid=$_SESSION['sid'];
$ret=mysqli_query($con,"select * from tblservicerequest where ID='$cid' and UserId='$uid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>

<table border="1" class="table table-bordered mg-b-0">
 
   <tr>
    <th>Service Request Date</th>
    <td><?php  echo $row['ServicerequestDate'];?></td>
  </tr>
<tr>
    <th>Service Number</th>
    <td><?php  echo $row['ServiceNumber'];?></td>
  </tr>

<tr>
    <th>Category</th>
    <td><?php  echo $row['Category'];?></td>
  </tr>

<tr>
    <th>Vehicle Name</th>
    <td><?php  echo $row['VehicleName'];?></td>
  </tr>

  <tr>
    <th>Vehicle Model</th>
    <td><?php  echo $row['VehicleModel'];?></td>
  </tr>

  <tr>
    <th>Vehicle Brand</th>
    <td><?php  echo $row['VehicleBrand'];?></td>
  </tr>
  <tr>
    <th>Vehicle Registration Number</th>
    <td><?php  echo $row['VehicleRegno'];?></td>
  </tr>
  <tr>
    <th>Service Date</th>
    <td><?php  echo $row['ServiceDate'];?></td>
  </tr>

<tr>
    <th>Service Time</th>
    <td><?php  echo $row['ServiceTime'];?></td>
  </tr>

<tr>
    <th>Delivery Type</th>
    <td><?php  echo $row['DeliveryType'];?></td>
  </tr>

<tr>
    <th>Pickup Address</th>
    <td><?php  echo $row['PickupAddress'];?></td>
  </tr>

  <tr>
    <th>Service Request Date</th>
    <td><?php  echo $row['ServicerequestDate'];?></td>
  </tr>






  <tr>
    <th>Admin Remark</th>
    <td><?php
if($row['AdminRemark']==""){
  echo "No action taken yet";
} else {
      echo $row['AdminRemark'];
    }?></td>
  </tr>


 

  <tr>
    <th>Admin Remark date</th>
    <td>
<?php
if($row['AdminRemarkdate']==""){
  echo "No action taken yet";
} else {
      echo $row['AdminRemarkdate'];
    }?>

  </td>
  </tr>

  <tr>
    <th>Service Charge</th>
    <td><?php echo $schrg=$row['ServiceCharge']; ?></td>
  </tr>
  <tr>
    <th>Parts Charge</th>
    <td><?php echo $pchrg=$row['PartsCharge']; ?></td>
  </tr>
<tr>
    <th>Other Charge(if any)</th>
    <td><?php echo $ochrg=$row['OtherCharge']; ?></td>
  </tr> 
<tr>
    <th>Total Amount</th>
    <td><?php echo $ochrg+$schrg+$pchrg; ?></td>
  </tr>

  

</table>
<p style="text-align: center;"><button type="text" name='print' id="print" onclick="return printdata();" class="btn btn-info btn-min-width mr-1 mb-1">Print</button></p>
<?php } ?>
</form>
</div>
</div>
</div>
</div>
</div>
</div></div></div></div></div>
</body>
</html>

<?php } ?>