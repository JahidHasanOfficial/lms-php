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

                     <div class="row">
                        <!-- Revenue Analysis Chart (R-03) -->
                        <div class="col-md-l2 col-lg-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Revenue Analysis (Last 7 Days)</h2>
                                 </div>
                              </div>
                              <div class="padding_infor_info">
                                 <canvas id="revenueChart" height="100"></canvas>
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
                                    <h2>Active Courses (R-02)</h2>
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
                                             <th>Revenue</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($latestCourses as $course): 
                                             $cRev = $pdo->prepare("SELECT SUM(amount) FROM payments WHERE course_id = ? AND status = 'success'");
                                             $cRev->execute([$course['id']]);
                                             $thisCourseRev = $cRev->fetchColumn() ?: 0;
                                          ?>
                                          <tr>
                                             <td><?php echo $course['id']; ?></td>
                                             <td><strong><?php echo $course['title']; ?></strong></td>
                                             <td><?php echo $course['instructor_name']; ?></td>
                                             <td>$<?php echo number_format($thisCourseRev, 2); ?></td>
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

                     <div class="row">
                        <!-- Recent Logins -->
                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Recent Logins (Analytics)</h2>
                                 </div>
                              </div>
                              <div class="padding_infor_info">
                                 <ul class="list-unstyled">
                                    <?php 
                                    $recentLogins = $pdo->query("SELECT lh.*, u.name as user_name FROM login_history lh JOIN users u ON lh.user_id = u.id ORDER BY lh.login_at DESC LIMIT 5")->fetchAll();
                                    foreach ($recentLogins as $login): ?>
                                       <li class="border-bottom py-2">
                                          <strong><?php echo $login['user_name']; ?></strong> 
                                          <span class="small text-muted float-right"><?php echo date('M d, H:i', strtotime($login['login_at'])); ?></span>
                                          <br><small class="text-primary"><?php echo $login['ip_address']; ?></small>
                                       </li>
                                    <?php endforeach; ?>
                                 </ul>
                              </div>
                           </div>
                        </div>

                        <!-- Enrollment Progress -->
                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Student Progress</h2>
                                 </div>
                              </div>
                              <div class="padding_infor_info">
                                 <ul class="list-unstyled">
                                    <?php 
                                    $recentEnrolls = $pdo->query("SELECT e.*, u.name as user_name, c.title as course_title FROM enrollments e JOIN users u ON e.user_id = u.id JOIN courses c ON e.course_id = c.id ORDER BY e.enrollment_date DESC LIMIT 5")->fetchAll();
                                    foreach ($recentEnrolls as $enroll): ?>
                                       <li class="mb-3">
                                          <div class="d-flex justify-content-between">
                                             <span class="small"><strong><?php echo $enroll['user_name']; ?></strong> in <?php echo $enroll['course_title']; ?></span>
                                             <span class="small"><?php echo $enroll['progress_percent']; ?>%</span>
                                          </div>
                                          <div class="progress" style="height: 5px;">
                                             <div class="progress-bar bg-success" style="width: <?php echo $enroll['progress_percent']; ?>%"></div>
                                          </div>
                                       </li>
                                    <?php endforeach; ?>
                                 </ul>
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
      <script src="../backend-template/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <?php
      // Revenue Chart Data (R-03)
      $days = [];
      $revs = [];
      for ($i = 6; $i >= 0; $i--) {
          $date = date('Y-m-d', strtotime("-$i days"));
          $days[] = date('D', strtotime($date));
          $stmt_r = $pdo->prepare("SELECT SUM(amount) FROM payments WHERE DATE(created_at) = ? AND status = 'success'");
          $stmt_r->execute([$date]);
          $revs[] = (float)($stmt_r->fetchColumn() ?: 0);
      }
      ?>

      <script>
      var ctx = document.getElementById('revenueChart').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: <?php echo json_encode($days); ?>,
              datasets: [{
                  label: 'Revenue ($)',
                  data: <?php echo json_encode($revs); ?>,
                  backgroundColor: 'rgba(3, 169, 244, 0.2)',
                  borderColor: 'rgba(3, 169, 244, 1)',
                  borderWidth: 2,
                  fill: true,
                  tension: 0.4
              }]
          },
          options: {
              scales: { y: { beginAtZero: true } },
              responsive: true,
              plugins: { legend: { display: false } }
          }
      });
      </script>
      <script src="../backend-template/js/custom.js"></script>
   </body>
</html>
