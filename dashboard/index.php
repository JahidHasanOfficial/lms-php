<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Course.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];
$courseObj = new Course($pdo);

// Fetch enrolled courses for student
$stmt = $pdo->prepare("SELECT e.*, c.title, c.thumbnail, c.slug, b.batch_no 
                        FROM enrollments e 
                        JOIN courses c ON e.course_id = c.id 
                        LEFT JOIN batches b ON e.batch_id = b.id
                        WHERE e.user_id = ? 
                        ORDER BY e.enrollment_date DESC");
$stmt->execute([$user_id]);
$myCourses = $stmt->fetchAll();

// Fetch Certificates count
$stmt_cert = $pdo->prepare("SELECT COUNT(*) FROM certificates WHERE user_id = ?");
$stmt_cert->execute([$user_id]);
$certCount = $stmt_cert->fetchColumn();

// Fetch Support Tickets (Q&A) count
$stmt_qa = $pdo->prepare("SELECT COUNT(*) FROM support_tickets WHERE user_id = ?");
$stmt_qa->execute([$user_id]);
$qaCount = $stmt_qa->fetchColumn();

// Fetch Next Live Class (Specific to student's batches)
$stmt_live = $pdo->prepare("SELECT lc.*, c.title as course_title 
                            FROM live_classes lc 
                            JOIN enrollments e ON lc.batch_id = e.batch_id 
                            JOIN courses c ON lc.course_id = c.id 
                            WHERE e.user_id = ? AND lc.start_time > NOW() 
                            ORDER BY lc.start_time ASC LIMIT 1");
$stmt_live->execute([$user_id]);
$nextLive = $stmt_live->fetch();

// Fetch Pending Assignments
$stmt_assign = $pdo->prepare("SELECT a.*, c.title as course_title 
                                FROM assignments a 
                                JOIN enrollments e ON a.batch_id = e.batch_id 
                                JOIN courses c ON a.course_id = c.id 
                                WHERE e.user_id = ? AND a.deadline > NOW() 
                                ORDER BY a.deadline ASC LIMIT 3");
$stmt_assign->execute([$user_id]);
$pendingAssignments = $stmt_assign->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Student Dashboard</h2>
      </div>
   </div>
</div>

<!-- Welcome Message -->
<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Welcome back, <?php echo $_SESSION['user_name']; ?>! 👋</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <p>You have <strong><?php echo count($myCourses); ?></strong> active course(s). Continue where you left off!</p>
         </div>
      </div>
   </div>
</div>

<!-- Counter Stats -->
<div class="row column1">
   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-book yellow_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no"><?php echo count($myCourses); ?></p>
               <p class="head_couter">Courses</p>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-clock-o blue1_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no">0h</p>
               <p class="head_couter">Learning Time</p>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-certificate green_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no"><?php echo $certCount; ?></p>
               <p class="head_couter">Certificates</p>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="full counter_section margin_bottom_30">
         <div class="couter_icon">
            <div><i class="fa fa-question-circle purple_color"></i></div>
         </div>
         <div class="counter_no">
            <div>
               <p class="total_no"><?php echo $qaCount; ?></p>
               <p class="head_couter">Q&A Asking</p>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- My Learning Schedule -->
<div class="row">
   <!-- Live Class & Assignments -->
   <div class="col-md-7">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Upcoming Live Classes</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <?php if ($nextLive): ?>
               <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
                  <div class="mr-4 text-center p-2 bg-info text-white rounded" style="min-width: 80px;">
                     <h3 class="mb-0"><?php echo date('d', strtotime($nextLive['start_time'])); ?></h3>
                     <small><?php echo date('M', strtotime($nextLive['start_time'])); ?></small>
                  </div>
                  <div>
                     <h5 class="mb-1 font-weight-bold text-dark"><?php echo $nextLive['title']; ?></h5>
                     <p class="mb-1 small text-muted"><i class="fa fa-book"></i> <?php echo $nextLive['course_title']; ?></p>
                     <p class="mb-0 small text-primary font-weight-bold"><i class="fa fa-clock-o"></i> <?php echo date('h:i A', strtotime($nextLive['start_time'])); ?></p>
                  </div>
                  <div class="ml-auto">
                     <a href="<?php echo $nextLive['zoom_link']; ?>" target="_blank" class="btn btn-primary btn-sm rounded-pill px-4">Join Now</a>
                  </div>
               </div>
            <?php else: ?>
               <p class="text-center py-4 text-muted">No live classes scheduled for your batches.</p>
            <?php endif; ?>
         </div>
      </div>

      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Pending Assignments</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th>Subject</th>
                        <th>Deadline</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (empty($pendingAssignments)): ?>
                        <tr><td colspan="3" class="text-center text-muted">All caught up! No pending assignments.</td></tr>
                     <?php endif; ?>
                     <?php foreach ($pendingAssignments as $assign): ?>
                     <tr>
                        <td>
                           <strong><?php echo $assign['title']; ?></strong><br>
                           <small class="text-muted"><?php echo $assign['course_title']; ?></small>
                        </td>
                        <td>
                           <span class="text-danger small font-weight-bold"><?php echo date('M d, h:i A', strtotime($assign['deadline'])); ?></span>
                        </td>
                        <td><button class="btn btn-xs btn-outline-primary">Submit</button></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>

   <!-- Quizzes & Activity -->
   <div class="col-md-5">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Active Quizzes</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <?php 
            // Fetch quizzes assigned to user's batches BUT EXCLUDE those already completed
            $stmt_quizzes = $pdo->prepare("SELECT q.*, c.title as course_title 
                                          FROM quizzes q 
                                          JOIN enrollments e ON q.batch_id = e.batch_id 
                                          JOIN courses c ON q.course_id = c.id 
                                          LEFT JOIN quiz_results qr ON q.id = qr.quiz_id AND qr.user_id = ? 
                                          WHERE e.user_id = ? 
                                          AND q.status = 'published' 
                                          AND qr.id IS NULL 
                                          LIMIT 3");
            $stmt_quizzes->execute([$user_id, $user_id]);
            $activeQuizzes = $stmt_quizzes->fetchAll();
            
            if (empty($activeQuizzes)): ?>
               <p class="text-center py-4 text-muted">No active quizzes at the moment.</p>
            <?php endif; ?>
            
            <?php foreach ($activeQuizzes as $quiz): ?>
               <div class="media mb-4 border-bottom pb-3">
                  <div class="bg-warning-light p-3 rounded mr-3">
                     <i class="fa fa-pencil text-warning"></i>
                  </div>
                  <div class="media-body">
                     <h6 class="mb-0 font-weight-bold text-dark"><?php echo $quiz['title']; ?></h6>
                     <small class="text-muted d-block mb-2"><?php echo $quiz['course_title']; ?></small>
                     <div class="d-flex align-items-center">
                        <span class="badge badge-warning text-white mr-3"><?php echo $quiz['total_questions']; ?> Qs</span>
                        <a href="quiz.php?id=<?php echo $quiz['id']; ?>" class="small font-weight-bold text-primary">Start Attempt <i class="fa fa-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>
      </div>
   </div>
</div>

<!-- My Enrolled Courses Section -->
<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>My Enrolled Courses</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <div class="row">
               <?php if (empty($myCourses)): ?>
                  <div class="col-12 text-center p-5">
                     <i class="fa fa-book fa-4x text-muted mb-3"></i>
                     <h4>No courses enrolled yet!</h4>
                     <a href="../courses.php" class="btn btn-primary mt-3">Browse Courses</a>
                  </div>
               <?php endif; ?>

               <?php foreach ($myCourses as $course): ?>
               <div class="col-md-4 mb-4">
                  <div class="card h-100 shadow-sm border-0 overflow-hidden">
                     <img src="../<?php echo $course['thumbnail']; ?>" class="card-img-top">
                     <div class="card-body">
                        <h5 class="card-title font-weight-bold"><?php echo $course['title']; ?></h5>
                        <p class="badge bg-primary-light text-primary mb-3">Batch <?php echo $course['batch_no'] ?: '1'; ?></p>
                        
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Progress</span>
                            <span><?php echo $course['progress_percent']; ?>%</span>
                        </div>
                        <div class="progress mb-4" style="height: 8px;">
                           <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $course['progress_percent']; ?>%;"></div>
                        </div>
                        
                        <a href="watch.php?course=<?php echo $course['course_id']; ?>" class="btn btn-primary btn-block py-2">Continue Learning</a>
                     </div>
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</div>

<style>
.bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
.bg-primary-light { background-color: rgba(3, 169, 244, 0.1); }
</style>

<?php include 'includes/footer.php'; ?>
