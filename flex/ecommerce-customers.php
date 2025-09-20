 <?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');

/* 
if (strlen($_SESSION['adid']==0)) {
  header('location:logout.php');
  } else{

*/ ?> 

<!DOCTYPE html>
<!-- 
Template Name: FlexAdmin - Bootstrap 5 Admin Template
Version: 1.0.1
Author: TEachProd.
Website: https://teachprod.com
-->

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Customers - Ecommerce">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
  <meta property="og:image" content="https://www.teachprod.com/wp-content/uploads/2020/10/carrot.jpg">
  <title>Customers - Ecommerce - FlexAdmin</title>
  <link href="assets/css/vendor~app.css" rel="stylesheet"><link href="assets/css/app.css" rel="stylesheet"><link href="assets/css/ecommerce.css" rel="stylesheet">
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-180917586-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-180917586-1');
  </script>
</head>
<!-- Possible Body Attributes
    * data-theme-header-fixed = 'true'       - For fixed Header
    * data-theme-header-fixed = 'false'      - For static Header
    * data-theme-sidebar-fixed = 'true'      - For fixed Left Navigation
    * data-theme-sidebar-fixed = 'false'     - For static Left Navigation
    * data-theme-sidebar-shrinked = 'true'   - For shrinking Left Navigation
    * data-theme-footer-fixed = 'true'       - For fixed Footer
    * data-theme-footer-fixed = 'false'      - For static Footer
    * data-theme-mode = 'dark-mode'          - For Dark Mode
-->

<body>
    <!-- apply javascript before page content be loaded -->
    <script>
      'use strict';
      var defaultConfig = {
        fixedLeftSidebar: true,
        fixedHeader: false,
        fixedFooter: false,
        isShrinked: false,
        themeColor: 'app-theme-facebook',
        themeMode: 'default-mode'
      };
      var globalConfigs = JSON.parse(localStorage.getItem('ABCADMIN_CONFIG')) || defaultConfig;
      var appThemeMode = globalConfigs.themeMode;
      var isShrinked = globalConfigs.isShrinked;
      var body = document.getElementsByTagName("body")[0];
      body.setAttribute("data-theme-mode", appThemeMode);
      body.setAttribute("data-theme-sidebar-shrinked", isShrinked)
    </script>
	
	<!-- start left sidebar -->
	<?php include_once('includes/flex_sidebar.php');?>
	
    <!-- start navbar  -->
	<?php include_once('includes/nav_bar.php');?>
      <!-- end navbar -->
      <div class="page-content">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb ps-0 fs-base">
    <li class="breadcrumb-item"><a href="#">FlexAdmin</a></li>
    <li class="breadcrumb-item"><span>Ecommerce</span></li>
    <li class="breadcrumb-item active" aria-current="page">Customers</li>
  </ol>
</nav>
<div class="row header justify-content-between mb-4">
  <div class="col-xl-5 col-lg-12">
    <h1 class="header-title h3">
      <i class="fad fa-star-half-alt text-highlight"></i>
      Users
    </h1>
  </div>
</div>
<div class="row mb-4">
  <div class="col-12">
    <div class="mt-3 mt-xl-0">
      <div class="input-group mb-3">
        <button class="btn btn-highlight" type="button"><i class="fal fa-plus-circle"></i> <span class="d-none d-md-inline">Add Customer</span></button>
        <button class="btn btn-highlight" type="button"><i class="fal fa-file-import"></i> <span class="d-none d-md-inline">Import</span></button>
        <button class="btn btn-highlight" type="button"><i class="fal fa-arrow-to-bottom"></i> <span class="d-none d-md-inline">Export</span></button>
        <button class="btn btn-highlight" type="button"><i class="fal fa-list-ul"></i> <span class="d-none d-md-inline">Customize Columns</span></button>
        <button type="button" class="btn btn-highlight dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fal fa-pen"></i> <span class="d-none d-md-inline">Bulk Actions</span>
        </button>
        <ul class="dropdown-menu" style="">
          <li><a class="dropdown-item" href="#">Delete</a></li>
          <li><a class="dropdown-item" href="#">Update Statuses</a></li>
          <li><a class="dropdown-item" href="#">Create Notes</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="ecommerce-datatable" class="table table-middle table-hover table-responsive">
            <thead>
              <tr>
                <th class="no-sort">
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </th>
                <th class="no-sort">Image</th>
                <th>Full Name</th>
                <th>Mobile #</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Active</th>
                <th>Postcode</th>
                <th>Status</th>
                <th style="width: 80px;" class="text-center no-sort">Action</th>
              </tr>
            </thead>
            <tbody>
				
					
					
				<!-- start of list of users -->
				
				<?php
					$rno=mt_rand(10000,99999); 
					$ret=mysqli_query($con,"select * from tbluser");
					$cnt=1;
						while ($row=mysqli_fetch_array($ret)) {

				?>
				
				<tr>
					<td>
					  <label class="custom-checkbox">
						<input type="checkbox">
						<span></span>
					  </label>
					</td>
					<td>
					  <a href="#"><img src="assets/images/avatar.png" style="height: 50px;" alt="User" class="rounded-circle"></a>
					</td>
					<td><?php  echo $row['FullName'];?></td>
					
					<td><a href="edit-user.php?udid=<?php echo base64_encode($row['ID'].$rno)>{$row['FullName']};?>" </a></td>
					<td><?php  echo $row['MobileNo'];?></td>
					<td><?php  echo $row['Email'];?></td>
					<td><?php if ($row['admin'] == "on") 
						{ echo "Yes";}
							else 
						{ echo "No";}
						?>
					</td>
					<td><?php if ($row['active'] == "on") 
						{ echo "Active";}
							else 
						{ echo "Not Active";}
						?>
					</td>
					<td><a href="edit-user.php?udid=<?php echo base64_encode($row['ID'].$rno);?>" title="Edit user details"> Edit Details</a></td>
				
					<?php 
						$cnt=$cnt+1;
					}?>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Megan Harrison</a>
                </td>
                <td>
                  September 12, 2020
                </td>
                <td>
                  <a href="#">megan@techprod.com</a>
                </td>
                <td>
                  2
                </td>
                <td>
                  $1,700
                </td>
                <td>
                  60400
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Zoe Tamayo</a>
                </td>
                <td>
                  Jul 24, 2020
                </td>
                <td>
                  <a href="#">zoe@techprod.com</a>
                </td>
                <td>
                  4
                </td>
                <td>
                  $2,500
                </td>
                <td>
                  50200
                </td>
                <td>
                  <span class="badge bg-danger rounded">Deactive</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Paul G Conger</a>
                </td>
                <td>
                  Jun 3, 2020
                </td>
                <td>
                  <a href="#">paul@techprod.com</a>
                </td>
                <td>
                  6
                </td>
                <td>
                  $5,100
                </td>
                <td>
                  41500
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Sandra H Williams</a>
                </td>
                <td>
                  September 18, 2020
                </td>
                <td>
                  <a href="#">sandra@techprod.com</a>
                </td>
                <td>
                  5
                </td>
                <td>
                  $4,200
                </td>
                <td>
                  52650
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Delores W Hartwell</a>
                </td>
                <td>
                  Aug 12, 2020
                </td>
                <td>
                  <a href="#">delores@techprod.com</a>
                </td>
                <td>
                  2
                </td>
                <td>
                  $1,700
                </td>
                <td>
                  60400
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Roderick A Jorgensen</a>
                </td>
                <td>
                  Jul 24, 2020
                </td>
                <td>
                  <a href="#">roderick@techprod.com</a>
                </td>
                <td>
                  11
                </td>
                <td>
                  $3,500
                </td>
                <td>
                  77493
                </td>
                <td>
                  <span class="badge bg-danger rounded">Deactive</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Christian G Stone</a>
                </td>
                <td>
                  Jun 3, 2020
                </td>
                <td>
                  <a href="#">christian@techprod.com</a>
                </td>
                <td>
                  6
                </td>
                <td>
                  $5,100
                </td>
                <td>
                  41500
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Zoe Tamayo</a>
                </td>
                <td>
                  Jul 24, 2020
                </td>
                <td>
                  <a href="#">zoe@techprod.com</a>
                </td>
                <td>
                  4
                </td>
                <td>
                  $2,500
                </td>
                <td>
                  50200
                </td>
                <td>
                  <span class="badge bg-danger rounded">Deactive</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Paul G Conger</a>
                </td>
                <td>
                  Jun 3, 2020
                </td>
                <td>
                  <a href="#">paul@techprod.com</a>
                </td>
                <td>
                  6
                </td>
                <td>
                  $5,100
                </td>
                <td>
                  41500
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Sandra H Williams</a>
                </td>
                <td>
                  September 18, 2020
                </td>
                <td>
                  <a href="#">sandra@techprod.com</a>
                </td>
                <td>
                  5
                </td>
                <td>
                  $4,200
                </td>
                <td>
                  52650
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Delores W Hartwell</a>
                </td>
                <td>
                  Aug 12, 2020
                </td>
                <td>
                  <a href="#">delores@techprod.com</a>
                </td>
                <td>
                  2
                </td>
                <td>
                  $1,700
                </td>
                <td>
                  60400
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Roderick A Jorgensen</a>
                </td>
                <td>
                  Jul 24, 2020
                </td>
                <td>
                  <a href="#">roderick@techprod.com</a>
                </td>
                <td>
                  11
                </td>
                <td>
                  $3,500
                </td>
                <td>
                  77493
                </td>
                <td>
                  <span class="badge bg-danger rounded">Deactive</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input type="checkbox">
                    <span></span>
                  </label>
                </td>
                <td>
                  <a href="#"><img src="assets/images/default-female-avatar.jpg" style="height: 50px;" alt="user-image" class="rounded-circle"></a>
                </td>
                <td>
                  <a href="#">Christian G Stone</a>
                </td>
                <td>
                  Jun 3, 2020
                </td>
                <td>
                  <a href="#">christian@techprod.com</a>
                </td>
                <td>
                  6
                </td>
                <td>
                  $5,100
                </td>
                <td>
                  41500
                </td>
                <td>
                  <span class="badge bg-success rounded">Active</span>
                </td>
                <td>
                  <ul class="list-unstyled table-actions">
                    <li><a href="#"><i class="fal fa-pen" data-bs-original-title="Edit" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-cog" data-bs-original-title="Settings" data-bs-toggle="tooltip"></i></a></li>
                    <li><a href="#"><i class="fal fa-trash" data-bs-original-title="Archive" data-bs-toggle="tooltip"></i></a></li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
      </div>
      <!-- end page-content -->
      <div id="footer" class="d-flex align-items-center">
        <div class="row w-100">
          <div class="footer-nav col-md-8 col-sm-6">
            <a href="#" target="_blank" class="footer-nav-item">About</a>
            <a href="#" target="_blank" class="footer-nav-item">Support</a>
            <a href="#" target="_blank" class="footer-nav-item">Contact</a>
          </div>
          <div class="copyright text-end col-md-4 col-sm-6">
            2020&nbsp;©&nbsp;<a href="#" target="_blank">TEachProd</a>
          </div>
        </div>
      </div>    </div>
    <!-- end page-container -->
  <div class="modal right fade" id="right-sidebar" tabindex="-1" aria-labelledby="modalSetting" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content custom-scroll" style="max-height: 100%">
        <div class="align-items-center bg-trans-gradient justify-content-center modal-header rounded-0 w-100">
          <h4 class="m-0 text-center text-white fw-700">
            Settings
            <small class="mb-0 opacity-80">User Interface Settings</small>
          </h4>
          <a href="#" class="pos-top-right text-white p-2 m-1 me-2 fs-md" data-dismiss="modal" aria-label="Close"><i class="fal fa-times"></i></a>
        </div>
        <div class="modal-body p-0">
          <div class="settings-panel">
            <div class="mx-3 mt-2">
              <p class="text-muted fs-base">Customize layout, left sidebar menu, etc. FlexAdmin stores the preferences in local storage.</p>
            </div>
            <div class="mt-4 ps-3 pe-2">
              <h5 class="p-0 fw-700">
                Layout Options
              </h5>
            </div>
            <div class="ps-3 pe-2">
              <div class="d-flex mb-2">
                <div class="custom-switcher custom-switcher-info">
                  <input type="checkbox" name="app-shrinking-left-sidebar" id="app-shrinking-left-sidebar">
                  <label for="app-shrinking-left-sidebar"></label>
                </div>
                <div class="ms-3"><label for="app-shrinking-left-sidebar">Shrinking Left Navigation</label></div>
              </div>
              <div class="d-flex mb-2">
                <div class="custom-switcher custom-switcher-info">
                  <input type="checkbox" name="app-fixed-header" id="app-fixed-header" value=true>
                  <label for="app-fixed-header"></label>
                </div>
                <div class="ms-3"><label for="app-fixed-header">Fixed Header</label></div>
              </div>
              <div class="d-flex mb-2">
                <div class="custom-switcher custom-switcher-info">
                  <input type="checkbox" name="app-fixed-left-sidebar" id="app-fixed-left-sidebar">
                  <label for="app-fixed-left-sidebar"></label>
                </div>
                <div class="ms-3"><label for="app-fixed-left-sidebar">Fixed Navigation</label></div>
              </div>
              <div class="d-flex mb-2">
                <div class="custom-switcher custom-switcher-info">
                  <input type="checkbox" name="app-fixed-footer" id="app-fixed-footer">
                  <label for="app-fixed-footer"></label>
                </div>
                <div class="ms-3"><label for="app-fixed-footer">Fixed Footer</label></div>
              </div>
            </div>          <div class="mt-4 ps-3 pe-2">
              <h5 class="p-0 fw-700">
                  Theme Colors
              </h5>
            </div>
            <div class="theme-colors ps-3 pe-2">
              <ul class="m-0 p-0">
                <li>
                  <a href="#" class="bg-anchor" data-theme-color="app-theme-anchor" data-bs-toggle="tooltip" data-bs-original-title="Anchor"></a>
                </li>
                <li>
                  <a href="#" class="bg-maroon" data-theme-color="app-theme-maroon" data-bs-toggle="tooltip" data-bs-original-title="Maroon"></a>
                </li>
                <li>
                  <a href="#" class="bg-carrot" data-theme-color="app-theme-carrot" data-bs-toggle="tooltip" data-bs-original-title="Carrot"></a>
                </li>
                <li>
                  <a href="#" class="bg-lollipop" data-theme-color="app-theme-lollipop" data-bs-toggle="tooltip" data-bs-original-title="Lollipop"></a>
                </li>
                <li>
                  <a href="#" class="bg-gold" data-theme-color="app-theme-gold" data-bs-toggle="tooltip" data-bs-original-title="Gold"></a>
                </li>
                <li>
                  <a href="#" class="bg-forest" data-theme-color="app-theme-forest" data-bs-toggle="tooltip" data-bs-original-title="Forest"></a>
                </li>
                <li>
                  <a href="#" class="bg-hoki" data-theme-color="app-theme-hoki" data-bs-toggle="tooltip" data-bs-original-title="Hoki"></a>
                </li>
                <li>
                  <a href="#" class="bg-facebook" data-theme-color="app-theme-facebook" data-bs-toggle="tooltip" data-bs-original-title="Facebook"></a>
                </li>
                <li>
                  <a href="#" class="bg-purple" data-theme-color="app-theme-purple" data-bs-toggle="tooltip" data-bs-original-title="Purple"></a>
                </li>
                <li>
                  <a href="#" class="bg-indigo" data-theme-color="app-theme-indigo" data-bs-toggle="tooltip" data-bs-original-title="Indigo"></a>
                </li>
                <li>
                  <a href="#" class="bg-cafe" data-theme-color="app-theme-cafe" data-bs-toggle="tooltip" data-bs-original-title="Cafe"></a>
                </li>
                <li>
                  <a href="#" class="bg-charcoal" data-theme-color="app-theme-charcoal" data-bs-toggle="tooltip" data-bs-original-title="Charcoal"></a>
                </li>
              </ul>
            </div>          <div class="mt-4 ps-3 pe-2">
              <h5 class="p-0 fw-700">
                  Theme Modes
              </h5>
            </div>
            <div class="theme-modes ps-3 pe-2">
              <div class="row">
                <div class="col-6 pe-2 text-center">
                  <div data-theme-mode="default-mode" class="theme-mode-config d-flex bg-white border border-secondary rounded overflow-hidden text-success" style="height: 100px">
                    <div class="map-left-sidebar px-2 pt-0 border-right"></div>
                    <div class="d-flex w-100 flex-column flex-1">
                      <div class="bg-white border-bottom py-1"></div>
                      <div class="bg-white h-100 flex-1 pt-3 pb-3 px-2">
                        <div class="py-3 h-100" style="background:url('assets/images/website-layout.jpg') top left no-repeat;background-size: 100%;"></div>
                      </div>
                    </div>
                  </div>
                  Default
                </div>
                <div class="col-6 ps-2 text-center">
                  <div data-theme-mode="dark-mode" class="theme-mode-config d-flex border border-white rounded overflow-hidden text-success bg-dark" style="height: 100px">
                    <div class="px-2 pt-0 border-right"></div>
                    <div class="d-flex w-100 flex-column flex-1">
                      <div class="border-bottom py-1"></div>
                      <div class="flex-1 h-100 pt-3 pb-3 px-2">
                        <div class="py-3 h-100 " style="background:url('assets/images/website-layout-dark.jpg') top left no-repeat;background-size: 100%;"></div>
                      </div>
                    </div>
                  </div>
                  Dark
                </div>
              </div>
            </div>          <div class="d-flex justify-content-center mt-4 pt-4">
              <button id="reset-setting" type="button" class="btn btn-warning btn-rounded d-block w-75">Reset</button>
            </div>
            <div class="d-flex justify-content-center mt-4 mb-4">
              <a class="btn btn-rose btn-rounded d-block w-75" href="https://codecanyon.net/item/flexadmin-bootstrap-5-admin-template/29011667" target="_blank">Buy Now</a>
            </div>
          </div>
  
        </div>
      </div>
      <!-- end modal-content -->
    </div>
    <!-- end modal-dialog -->
  </div>
  <!-- end right-sidebar -->  <script src="assets/js/vendor~app~dashboard_analytics~dashboard_ecommerce~demo_add_product~demo_calendar~demo_datatable~dem~cf3c0e0d.js"></script><script src="assets/js/vendor~app.js"></script><script src="assets/js/app.js"></script><script src="assets/js/vendor~dashboard_analytics~dashboard_ecommerce~demo_add_product~demo_chartjs~demo_dropzone~demo_widg~79dfae0c.js"></script><script src="assets/js/ecommerce.js"></script>
</body>
</html>