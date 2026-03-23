<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>LMS Admin - Interactive Cares</title>
      <link rel="icon" href="../backend-template/images/fevicon.png" type="image/png" />
      <link rel="stylesheet" href="../backend-template/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../backend-template/style.css" />
      <link rel="stylesheet" href="../backend-template/css/responsive.css" />
      <link rel="stylesheet" href="../backend-template/css/colors.css" />
      <link rel="stylesheet" href="../backend-template/css/bootstrap-select.css" />
      <link rel="stylesheet" href="../backend-template/css/perfect-scrollbar.css" />
      <link rel="stylesheet" href="../backend-template/css/custom.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <?php include 'sidebar.php'; ?>
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                           <a href="index.php" style="padding: 10px; font-weight: bold; font-size: 20px; color: white; display: inline-block;">Interactive Cares ADMIN</a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="<?php echo $currentUser['profile_pic'] ? '../'.$currentUser['profile_pic'] : '../backend-template/images/layout_img/user_img.jpg'; ?>" alt="#" style="width: 35px; height: 35px; object-fit: cover;" /><span class="name_user"><?php echo $_SESSION['user_name']; ?></span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="profile.php">My Profile</a>
                                       <a class="dropdown-item" href="settings.php">Settings</a>
                                       <a class="dropdown-item" href="../logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->
               <div class="midde_cont">
                  <div class="container-fluid">
