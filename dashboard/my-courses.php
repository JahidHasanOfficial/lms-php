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

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>My Courses</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Enrolled Courses (<?php echo count($myCourses); ?>)</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <div class="row">
               <?php if (empty($myCourses)): ?>
                  <div class="col-12 text-center p-5">
                     <i class="fa fa-book fa-4x text-muted mb-3"></i>
                     <h4>No courses enrolled yet!</h4>
                     <p>Explore our library and start your learning journey today.</p>
                     <a href="../courses.php" class="btn btn-primary mt-3">Browse Our Courses</a>
                  </div>
               <?php endif; ?>

               <?php foreach ($myCourses as $course): ?>
               <div class="col-md-4 mb-4">
                  <div class="card h-100 shadow-sm border-0">
                     <div class="position-relative">
                        <img src="../<?php echo $course['thumbnail']; ?>" class="card-img-top">
                        <span class="badge badge-primary position-absolute" style="top: 10px; right: 10px;">Batch <?php echo $course['batch_no'] ?: '1'; ?></span>
                     </div>
                     <div class="card-body">
                        <h5 class="card-title font-weight-bold mb-3"><?php echo $course['title']; ?></h5>
                        
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Your Progress</span>
                            <span><?php echo $course['progress_percent']; ?>%</span>
                        </div>
                        <div class="progress mb-4" style="height: 8px;">
                           <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $course['progress_percent']; ?>%;"></div>
                        </div>
                        
                        <div class="row no-gutters">
                           <div class="col-6 pr-1">
                              <a href="watch.php?course=<?php echo $course['course_id']; ?>" class="btn btn-primary btn-block py-2">Watch Now</a>
                           </div>
                           <div class="col-6 pl-1">
                              <a href="../course-details.php?slug=<?php echo $course['slug']; ?>" class="btn btn-outline-secondary btn-block py-2 text-dark">Details</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
