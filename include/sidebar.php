<!-- Side Bar -->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="dashboard.php"> <!-- <img alt="image" src="assets/img/logo.png" class="header-logo" />--> <span class="logo-name">Survey Admin</span> 
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
                <a href="dashboard.php" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Survey</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Survey</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="survey-form.php">Survey Form</a></li>
                </ul>
            </li>
            <!-- <li class="menu-header">Reports</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Survey Reports</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="datatables.php">Datatable</a></li>
                    <li><a class="nav-link" href="export-table.php">Export Table</a></li>
                </ul>
            </li> -->
            <li class="menu-header">Auth</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="user-check"></i><span>Authentication</span></a>
              <ul class="dropdown-menu">
                <?php
                if($_SESSION['admin_type'] == 1){
                    echo '<li><a class="nav-link" href="auth-register.php">Manage Surveyor</a></li>';
                }
                ?>
                <li><a class="nav-link" href="auth-reset-password.php">Reset Password</a></li>
              </ul>
            </li>
        </ul>
    </aside>
</div>