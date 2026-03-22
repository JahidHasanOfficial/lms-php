<!-- Sidebar  -->
<nav id="sidebar">
   <div class="sidebar_blog_1">
      <div class="sidebar-header">
         <div class="logo_section">
            <a href="index.php"><img class="logo_icon img-responsive" src="../backend-template/images/logo/logo_icon.png" alt="#" /></a>
         </div>
      </div>
      <div class="sidebar_user_info">
         <div class="user_profle_side">
            <div class="user_img"><img class="img-responsive rounded-circle" src="../backend-template/images/layout_img/user_img.jpg" alt="#" /></div>
            <div class="user_info">
               <h6><?php echo $_SESSION['user_name']; ?></h6>
               <p><span class="online_animation"></span> Online</p>
            </div>
         </div>
      </div>
   </div>
   <div class="sidebar_blog_2">
      <h4>Dashboard</h4>
      <ul class="list-unstyled components">
         <li class="border-bottom border-light">
            <a href="<?php echo DASHBOARD_URL; ?>index.php"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
         </li>

         <!-- Student Navigation -->
         <li class="border-bottom border-light">
            <a href="<?php echo DASHBOARD_URL; ?>my-courses.php"><i class="fa fa-book orange_color"></i> <span>My Courses</span></a>
         </li>
         <li class="border-bottom border-light">
            <a href="<?php echo DASHBOARD_URL; ?>progress.php"><i class="fa fa-line-chart blue1_color"></i> <span>My Progress</span></a>
         </li>
         <li class="border-bottom border-light">
            <a href="<?php echo DASHBOARD_URL; ?>certificates.php"><i class="fa fa-certificate green_color"></i> <span>Certificates</span></a>
         </li>
         
         <li class="border-bottom border-light">
            <a href="<?php echo ADMIN_URL; ?>support.php"><i class="fa fa-ticket purple_color"></i> <span>Support Tickets</span></a>
         </li>

         <?php if (hasPermission('access_admin_panel')): ?>
            <li class="border-bottom border-light">
               <a href="<?php echo ADMIN_URL; ?>index.php"><i class="fa fa-shield red_color"></i> <span>Admin Panel</span></a>
            </li>
         <?php endif; ?>

         <?php if (hasPermission('manage_rbac')): ?>
            <li class="border-bottom border-light">
               <a href="#rbac_management" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-lock purple_color"></i> <span>Access Control</span></a>
               <ul class="collapse list-unstyled" id="rbac_management">
                  <li><a href="<?php echo ADMIN_URL; ?>roles.php">> <span>Manage Roles</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>permissions.php">> <span>Permissions List</span></a></li>
               </ul>
            </li>
         <?php endif; ?>

         <li class="border-bottom border-light">
            <a href="<?php echo ADMIN_URL; ?>support.php"><i class="fa fa-ticket blue1_color"></i> <span>Support Tickets</span></a>
         </li>
         <li class="border-bottom border-light">
            <a href="<?php echo BASE_URL; ?>logout.php"><i class="fa fa-sign-out text-danger"></i> <span class="text-danger">Logout</span></a>
         </li>
      </ul>
   </div>
</nav>
