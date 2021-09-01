<?php

session_start();
if(isset($_SESSION['ADMIN_ID']))
{}
else{
    header('location:index.php');
}
include '../connection.inc.php';

include 'function.inc.php';
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ela Admin - HTML5 Admin Template</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="stylesheet.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>
<body>
    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="menu-title"><a href="dashboard.php" style="color: black; letter-spacing: 2px; font-size: 1.4em; font-variant: small-caps;">DASHBOARD</a></li>
                    
                  <?php if($_SESSION['ADMIN_ROLE']==1){?>
                  <li class="menu-item-has-children dropdown">
                        <a href="product.php"> <i class="menu-icon fa fa-cogs"></i>Product Master</a></li>

                    <li class="menu-item-has-children dropdown">
                        <a href="order_master_vendor.php"> <i class="menu-icon fa fa-cogs"></i>Order Master</a></li>

                   <?php } else{?>   
                    <li class="menu-item-has-children dropdown">
                        <a href="categories.php"> <i class="menu-icon fa fa-cogs"></i>Categories Master</a></li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="sub_categories.php"> <i class="menu-icon fa fa-cogs"></i>Sub Categories Master</a></li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="product.php"> <i class="menu-icon fa fa-cogs"></i>Product Master</a></li>

                    <li class="menu-item-has-children dropdown">
                        <a href="order_master.php"> <i class="menu-icon fa fa-cogs"></i>Order Master</a></li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="coupon_master.php"> <i class="menu-icon fa fa-cogs"></i>Coupon Master</a></li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#"> <i class="menu-icon fa fa-cogs"></i>User Master</a></li>    

                    <li class="menu-item-has-children dropdown">
                        <a href="vendor_management.php"> <i class="menu-icon fa fa-cogs"></i>Vendor Management</a></li>
                    <li class="menu-item-has-children dropdown">
                        <a href="contact.php"> <i class="menu-icon fa fa-cogs"></i>Contact Us</a></li>            
                            <?php } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" style="font-weight: bold; font-size: 1.3em; letter-spacing: 2px; font-family: serif; color: gray;">ADMIN PANEL</a>
                    <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="dropdown for-message" style="color: gray;">Welcome <?=$_SESSION['ADMIN_USERNAME']; ?>
                        </div>
                   

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i>My Profile</a>

                            <a class="nav-link" href="#"><i class="fa fa-bell-o"></i>Notifications <span class="count">13</span></a>

                            <a class="nav-link" href="#"><i class="fa fa-cog"></i>Settings</a>

                            <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>