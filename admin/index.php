<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('../login.php');
}

// Admin logic here: Count users, courses, revenue
$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$courseCount = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$enrollmentCount = $pdo->query("SELECT COUNT(*) FROM enrollments")->fetchColumn();
$revenue = $pdo->query("SELECT SUM(amount) FROM payments WHERE status = 'success'")->fetchColumn() ?: 0;

// Get latest courses
$stmt = $pdo->query("SELECT c.*, u.name as instructor_name FROM courses c JOIN users u ON c.instructor_id = u.id ORDER BY c.created_at DESC LIMIT 5");
$latestCourses = $stmt->fetchAll();

include 'includes/header.php';
?>
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Dashboard Overview</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-users yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $userCount; ?></p>
                                    <p class="head_couter">Total Users</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-book blue1_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $courseCount; ?></p>
                                    <p class="head_couter">Total Courses</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-graduation-cap green_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $enrollmentCount; ?></p>
                                    <p class="head_couter">Enrollments</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-money red_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no">$<?php echo number_format($revenue, 2); ?></p>
                                    <p class="head_couter">Total Revenue</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- latest courses -->
                     <div class="row column2 graph margin_bottom_30">
                        <div class="col-md-l2 col-lg-12">
                           <div class="white_shd full">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Latest Courses</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>Title</th>
                                             <th>Instructor</th>
                                             <th>Price</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($latestCourses as $course): ?>
                                          <tr>
                                             <td><?php echo $course['id']; ?></td>
                                             <td><?php echo $course['title']; ?></td>
                                             <td><?php echo $course['instructor_name']; ?></td>
                                             <td>$<?php echo $course['price']; ?></td>
                                             <td><span class="badge badge-<?php echo ($course['status'] === 'published') ? 'success' : 'warning'; ?>"><?php echo ucfirst($course['status']); ?></span></td>
                                             <td>
                                                <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                             </td>
                                          </tr>
                                          <?php endforeach; ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- footer -->
                  <div class="container-fluid">
                     <div class="footer">
                        <p>Copyright © 2026 Interactive Cares LMS. All rights reserved.</p>
                     </div>
                  </div>
               </div>
               <!-- end dashboard inner -->
            </div>
         </div>
      </div>

<?php include 'includes/footer.php'; ?>

      <!-- jQuery -->
      <script src="../backend-template/js/jquery.min.js"></script>
      <script src="../backend-template/js/popper.min.js"></script>
      <script src="../backend-template/js/bootstrap.min.js"></script>
      <script src="../backend-template/js/animate.js"></script>
      <script src="../backend-template/js/bootstrap-select.js"></script>
      <script src="../backend-template/js/perfect-scrollbar.min.js"></script>
      <script src="../backend-template/js/custom.js"></script>
   </body>
</html>
