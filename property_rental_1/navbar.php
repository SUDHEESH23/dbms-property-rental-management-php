<head>
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    nav#sidebar {
        background-color: #252525;
        color: #fff;
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
        transition: width 0.3s;
        z-index: 1000;
        padding-top: 50px; /* Added padding to prevent overlap with top content */
    }

    .sidebar-list {
        list-style-type: none;
        padding: 0;
    }

    .nav-item {
        padding: 15px 20px;
        color: #fff;
        text-decoration: none;
        transition: background-color 0.3s;
        display: block;
    }

    .nav-item:hover {
        background-color: #444;
    }

    .nav-item .icon-field {
        margin-right: 10px;
    }

    .active {
        background-color: #444 !important;
    }

    /* Icon Styles */
    .icon-field {
        width: 24px;
        height: 24px;
        display: inline-block;
        vertical-align: middle;
    }
</style>
</head>

<nav id="sidebar">
    <div class="sidebar-list">
        <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt"></i></span> Dashboard</a>
        <a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-th-list"></i></span> Property Type</a>
        <a href="index.php?page=houses" class="nav-item nav-houses"><span class='icon-field'><i class="fa fa-home"></i></span> Properties</a>
        <a href="index.php?page=tenants" class="nav-item nav-tenants"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Tenants</a>
        <a href="index.php?page=invoices" class="nav-item nav-invoices"><span class='icon-field'><i class="fa fa-file-invoice"></i></span> Payments</a>
        <a href="index.php?page=reports" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Reports</a>
        <!-- <?php if($_SESSION['login_type'] == 1): ?>
        <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a> -->
        <!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs text-danger"></i></span> System Settings</a> -->
        <!-- <?php endif; ?> -->
    </div>
</nav>

<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
