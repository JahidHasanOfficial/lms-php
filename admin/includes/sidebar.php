<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$isLandingPageActive = in_array($currentPage, ['hero_slides.php', 'site_features.php', 'settings_about.php', 'team_management.php', 'testimonials_management.php']);
$courseSubpages = ['courses.php', 'categories.php', 'curriculum.php', 'live_classes.php', 'coupons.php', 'all_batches.php', 'add_course.php', 'platform_benefits.php'];
$isCourseActive = in_array($currentPage, $courseSubpages);
$rbacSubpages = ['roles.php', 'permissions.php'];
$isRbacActive = in_array($currentPage, $rbacSubpages);
?>
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
         <li class="border-bottom border-light <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">
            <a href="<?php echo DASHBOARD_URL; ?>index.php"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
         </li>
         <li class="border-bottom border-light">
            <a href="<?php echo BASE_URL; ?>" target="_blank"><i class="fa fa-globe blue2_color"></i> <span>Visit Website</span></a>
         </li>

         <!-- Dynamic Permissions Based Menu -->
         <?php if (hasPermission('manage_courses')): ?>
            <li class="border-bottom border-light <?php echo $isCourseActive ? 'active' : ''; ?>">
               <a href="#course_management" data-toggle="collapse" aria-expanded="<?php echo $isCourseActive ? 'true' : 'false'; ?>" class="dropdown-toggle"><i class="fa fa-book orange_color"></i> <span>Course Management</span></a>
               <ul class="collapse list-unstyled <?php echo $isCourseActive ? 'show' : ''; ?>" id="course_management">
                  <li><a href="<?php echo ADMIN_URL; ?>courses.php" class="<?php echo ($currentPage == 'courses.php') ? 'text-primary' : ''; ?>">> <span>Manage Courses</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>categories.php" class="<?php echo ($currentPage == 'categories.php') ? 'text-primary' : ''; ?>">> <span>Manage Categories</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>curriculum.php" class="<?php echo ($currentPage == 'curriculum.php') ? 'text-primary' : ''; ?>">> <span>Curriculum Builder</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>live_classes.php" class="<?php echo ($currentPage == 'live_classes.php') ? 'text-primary' : ''; ?>">> <span>Live Classes</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>coupons.php" class="<?php echo ($currentPage == 'coupons.php') ? 'text-primary' : ''; ?>">> <span>Manage Coupons</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>all_batches.php" class="<?php echo ($currentPage == 'all_batches.php') ? 'text-primary' : ''; ?>">> <span>Manage All Batches</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>platform_benefits.php" class="<?php echo ($currentPage == 'platform_benefits.php') ? 'text-primary' : ''; ?>">> <span>Platform Benefits</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>add_course.php" class="<?php echo ($currentPage == 'add_course.php') ? 'text-primary' : ''; ?>">> <span>Add New Course</span></a></li>
               </ul>
            </li>
         <?php endif; ?>

         <?php if (hasPermission('manage_users')): ?>
            <li class="border-bottom border-light <?php echo ($currentPage == 'users.php') ? 'active' : ''; ?>">
               <a href="<?php echo ADMIN_URL; ?>users.php"><i class="fa fa-users blue1_color"></i> <span>Manage Users</span></a>
            </li>
         <?php endif; ?>

         <?php if (hasPermission('access_admin_panel')): ?>
            <li class="border-bottom border-light <?php echo ($currentPage == 'enrollments.php') ? 'active' : ''; ?>">
               <a href="<?php echo ADMIN_URL; ?>enrollments.php"><i class="fa fa-graduation-cap green_color"></i> <span>Enrollments</span></a>
            </li>
            <li class="border-bottom border-light <?php echo ($currentPage == 'payments.php') ? 'active' : ''; ?>">
               <a href="<?php echo ADMIN_URL; ?>payments.php"><i class="fa fa-money red_color"></i> <span>Payments</span></a>
            </li>
            <li class="border-bottom border-light <?php echo ($currentPage == 'consultations.php') ? 'active' : ''; ?>">
               <a href="<?php echo ADMIN_URL; ?>consultations.php"><i class="fa fa-phone green_color"></i> <span>Consultation Leads</span></a>
            </li>
            <li class="border-bottom border-light <?php echo $isLandingPageActive ? 'active' : ''; ?>">
               <a href="#landing_page" data-toggle="collapse" aria-expanded="<?php echo $isLandingPageActive ? 'true' : 'false'; ?>" class="dropdown-toggle"><i class="fa fa-desktop purple_color"></i> <span>Landing Page Config</span></a>
               <ul class="collapse list-unstyled <?php echo $isLandingPageActive ? 'show' : ''; ?>" id="landing_page">
                  <li><a href="<?php echo ADMIN_URL; ?>hero_slides.php" class="<?php echo ($currentPage == 'hero_slides.php') ? 'text-primary' : ''; ?>">> <span>Hero Slider</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>site_stats.php" class="<?php echo ($currentPage == 'site_stats.php') ? 'text-primary' : ''; ?>">> <span>Platform Statistics</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>settings_about.php" class="<?php echo ($currentPage == 'settings_about.php') ? 'text-primary' : ''; ?>">> <span>About Section</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>team_management.php" class="<?php echo ($currentPage == 'team_management.php') ? 'text-primary' : ''; ?>">> <span>Instructors Team</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>testimonials_management.php" class="<?php echo ($currentPage == 'testimonials_management.php') ? 'text-primary' : ''; ?>">> <span>Student Testimonials</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>blog_categories.php" class="<?php echo ($currentPage == 'blog_categories.php') ? 'text-primary' : ''; ?>">> <span>Blog Categories</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>blogs.php" class="<?php echo ($currentPage == 'blogs.php') ? 'text-primary' : ''; ?>">> <span>Manage Blogs</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>newsletter_config.php" class="<?php echo ($currentPage == 'newsletter_config.php') ? 'text-primary' : ''; ?>">> <span>Newsletter Section</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>subscribers.php" class="<?php echo ($currentPage == 'subscribers.php') ? 'text-primary' : ''; ?>">> <span>Subscribers List</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>success_stories.php" class="<?php echo ($currentPage == 'success_stories.php') ? 'text-primary' : ''; ?>">> <span>Success Stories (Video)</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>gallery_management.php" class="<?php echo ($currentPage == 'gallery_management.php') ? 'text-primary' : ''; ?>">> <span>Image Gallery</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>home_partners.php" class="<?php echo ($currentPage == 'home_partners.php') ? 'text-primary' : ''; ?>">> <span>Partner Logos</span></a></li>
               </ul>
            </li>
         <?php endif; ?>

         <?php if (hasPermission('manage_rbac')): ?>
            <li class="border-bottom border-light <?php echo $isRbacActive ? 'active' : ''; ?>">
               <a href="#rbac_management" data-toggle="collapse" aria-expanded="<?php echo $isRbacActive ? 'true' : 'false'; ?>" class="dropdown-toggle"><i class="fa fa-lock purple_color"></i> <span>Access Control</span></a>
               <ul class="collapse list-unstyled <?php echo $isRbacActive ? 'show' : ''; ?>" id="rbac_management">
                  <li><a href="<?php echo ADMIN_URL; ?>roles.php" class="<?php echo ($currentPage == 'roles.php') ? 'text-primary' : ''; ?>">> <span>Manage Roles</span></a></li>
                  <li><a href="<?php echo ADMIN_URL; ?>permissions.php" class="<?php echo ($currentPage == 'permissions.php') ? 'text-primary' : ''; ?>">> <span>Permissions List</span></a></li>
               </ul>
            </li>
         <?php endif; ?>

         <li class="border-bottom border-light <?php echo ($currentPage == 'support.php') ? 'active' : ''; ?>">
            <a href="<?php echo ADMIN_URL; ?>support.php"><i class="fa fa-ticket blue1_color"></i> <span>Support Tickets</span></a>
         </li>
         <li class="border-bottom border-light">
            <a href="<?php echo BASE_URL; ?>logout.php"><i class="fa fa-sign-out text-danger"></i> <span class="text-danger">Logout</span></a>
         </li>
      </ul>
   </div>
</nav>
