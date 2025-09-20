  <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <div class="slimscroll-menu" id="remove-scroll">

                    <!-- LOGO -->
                    <div class="topbar-left">
                       <h3>CE ERP </h3>
                       <hr />                    </div>

                    <!-- User box -->
                    <div class="user-box">
                        <div class="user-img">
                            <img src="assets/images/user.png" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        </div>

                        <?php
							$uid=$_SESSION['sid'];
							$ret=mysqli_query($con,"select FullName from tbluser where ID='$uid'");
							$row=mysqli_fetch_array($ret);
							$name=$row['FullName'];
						?>
                        <h5><?php echo $name; ?></a> </h5>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <!--<li class="menu-title">Navigation</li>-->

                            <li>
                                <a href="welcome.php">
                                    <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right"></span> <span> Dashboard </span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);"><i class="fi-layers"></i><span> Projects </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="view-projects-user.php">User Projects</a></li>
									<li><a href="manage-active-projects.php">Active Projects</a></li>
									<li><a href="manage-projects.php">All Projects</a></li>
                                </ul>
                            </li>
							
							<li>
                                <a href="javascript: void(0);"><i class="fi-layers"></i><span> Calendar</span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
									<li><a href="view-calendar.php">View Calendar</a></li>
                                </ul>
                            </li> 

          
							<!-- <li>
                                <a href="javascript: void(0);"><i class="fi-layers"></i><span> Service Request </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="service-request.php">Service Request Form</a></li>
                                    <li><a href="service-history.php">Service History</a></li>
                                </ul>
                            </li> 
                                             
							<li>
                                <a href="javascript: void(0);"><i class="fi-layers"></i><span>Tasks</span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="assigned-tasks.php">Assigned Tasks</a></li>
                                    <li><a href="unassigned-tasks.php">Unassigned Tasks</a></li>
                                </ul>
                            </li> -->

  
                            




                        </ul>

                    </div>
                    <!-- Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->

