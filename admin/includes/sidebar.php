  <!-- ========== Left Sidebar Start ========== -->
  <div class="left side-menu shadow">

      <div class="slimscroll-menu" id="remove-scroll">

          <!-- LOGO -->
          <div class="topbar-left d-flex align-items-center justify-content-center">
              <img src="assets/images/logo.png" alt="user-img" width="160" class="img-fluid bg-white">
          </div>

          <!-- User box -->
          <div class="user-box d-flex align-items-center">
              <div class="user-img">
                  <img src="assets/images/user.png" alt="user-img" width="80" class="rounded-circle img-fluid bg-white">
              </div>

              <?php
                $uid = $_SESSION['adid'];
                $ret = mysqli_query($con, "select FullName from tbluser where ID='$uid'");
                $row = mysqli_fetch_array($ret);
                $name = $row['FullName'];
                ?>
              <h3 class="text-center"><?php echo $name; ?></a> </h3>
          </div>

          <!--- Sidemenu -->
          <div id="sidebar-menu">

              <ul class="metismenu" id="side-menu">

                  <!--<li class="menu-title">Navigation</li>-->

                  <li>
                      <a href="dashboard.php">
                          <img src="assets/images/home-svg.svg" alt="home-img" width="22"><span class="badge badge-danger badge-pill float-right"></span> <span class="ml-3"> Dashboard </span>
                      </a>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><img src="assets/images/layers-svg.svg" alt="layers-img" width="22"><span class="ml-3"> Projects </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="add-project.php">Add Project</a></li>
                          <li><a href="manage-active-projects.php">Active Projects</a></li>
                          <li><a href="manage-onhold-projects.php">On Hold Projects</a></li>
                          <li><a href="manage-archived-projects.php">Archived Projects</a></li>
						  <li><a href="view-projects-user.php">Your Projects</a></li>
                          <li><a href="manage-all-projects.php">All Projects</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><img src="assets/images/calendar-svg.svg" alt="calendar-img" width="22"><span class="ml-3"> Calendar</span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="view-calendar.php">View Calendar</a></li>
						  <li><a href="view-personal-calendar.php">My Calendar</a></li>
                          <li><a href="view-gantt.php">View Gantt Chart</a></li>
						  <li><a href="view-personal-gantt.php">My Gantt Chart</a></li>
                      </ul>
                  </li>



                  <li>
                      <a href="javascript: void(0);"><img src="assets/images/settings-svg.svg" alt="layers-img" width="22"><span class="ml-3"> Settings </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="manage-user.php">Manage Users</a></li>
                          <li><a href="manage-offices.php">Manage Offices</a></li>
                          <li><a href="manage-disciplines.php">Manage Disciplines</a></li>
                          <!-- <li><a href="manage-project-disciplines.php">Manage Project Roles</a></li> -->
                          <li><a href="manage-status.php">Manage Project Status</a></li>
						  <li><a href="manage-milestone-status.php">Manage Milestone Status</a></li>
						  <li><a href="manage-marketsector.php">Manage Market Sector</a></li>

                      </ul>
                  </li>
					
				  <!--  Remove search and other menu items
				  
                  <li>
                      <a href="normal-search1.php">
                          <img src="assets/images/search-svg.svg" alt="search-img" width="22"><span class="badge badge-danger badge-pill float-right"></span> <span class="ml-3"> Search </span>
                      </a>
                  </li>


-->


              </ul>

          </div>
          <!-- Sidebar -->

          <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->