<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Course.php';
require_once dirname(__DIR__) . '/classes/Batch.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('index.php');
}

$course_id = $_GET['id'] ?? null;
if (!$course_id) redirect('courses.php');

$courseObj = new Course($pdo);

// Get course by ID
$stmt = $pdo->prepare("SELECT c.*, u.name as instructor_name, cat.name as category_name 
                        FROM courses c
                        JOIN users u ON c.instructor_id = u.id
                        LEFT JOIN categories cat ON c.category_id = cat.id
                        WHERE c.id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

if (!$course) redirect('courses.php');

$curriculum = $courseObj->getCurriculum($course_id);
$instructors = $courseObj->getInstructors($course_id);
$batchObj = new Batch($pdo);
$batches = $batchObj->getByCourse($course_id);

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Course Preview: <?php echo $course['title']; ?></h2>
         <div class="btn-group">
            <a href="courses.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit Course</a>
            <a href="../course-details.php?slug=<?php echo $course['slug']; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-external-link"></i> Live Website</a>
         </div>
      </div>
   </div>
</div>

<div class="row">
   <!-- Course Info Card -->
   <div class="col-md-4">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Course Info</h2>
            </div>
         </div>
         <div class="padding_infor_info text-center">
            <img src="../<?php echo $course['thumbnail']; ?>" class="img-fluid rounded mb-3 shadow-sm">
            <h4 class="mb-1 text-primary"><?php echo $course['title']; ?></h4>
            <p class="text-muted"><?php echo $course['category_name']; ?></p>
            <hr>
            <div class="row text-left">
               <div class="col-6 mb-2"><strong>Instructor:</strong></div>
               <div class="col-6 mb-2"><?php echo $course['instructor_name']; ?></div>
               <div class="col-6 mb-2"><strong>Price:</strong></div>
               <div class="col-6 mb-2">$<?php echo $course['price']; ?></div>
               <div class="col-6 mb-2"><strong>Status:</strong></div>
               <div class="col-6 mb-2"><span class="badge badge-<?php echo ($course['status'] === 'published') ? 'success' : 'warning'; ?>"><?php echo ucfirst($course['status']); ?></span></div>
            </div>
         </div>
      </div>

      <!-- Quick Stats -->
      <div class="white_shd full margin_bottom_30">
        <div class="padding_infor_info d-flex justify-content-around">
            <div class="text-center">
                <i class="fa fa-users fa-2x text-primary"></i>
                <p class="mb-0 mt-2">150</p>
                <small class="text-muted">Enrolled</small>
            </div>
            <div class="text-center">
                <i class="fa fa-book fa-2x text-warning"></i>
                <p class="mb-0 mt-2"><?php echo count($curriculum); ?></p>
                <small class="text-muted">Sections</small>
            </div>
            <div class="text-center">
                <i class="fa fa-calendar fa-2x text-success"></i>
                <p class="mb-0 mt-2"><?php echo count($batches); ?></p>
                <small class="text-muted">Batches</small>
            </div>
        </div>
      </div>
   </div>

   <!-- Curriculum & Batches -->
   <div class="col-md-8">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Course Structure</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <ul class="nav nav-tabs custom_tabs" id="myTab" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" id="curriculum-tab" data-toggle="tab" href="#curriculum" role="tab">Curriculum</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" id="batches-tab" data-toggle="tab" href="#batches" role="tab">Batches</a>
               </li>
            </ul>
            <div class="tab-content mt-4" id="myTabContent">
               <!-- Curriculum Tab -->
               <div class="tab-pane fade show active" id="curriculum" role="tabpanel">
                  <div class="row">
                     <?php foreach ($instructors as $ins): ?>
                     <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                           <div class="card-body">
                              <div class="d-flex align-items-center mb-3">
                                 <img src="../backend-template/images/layout_img/user_img.jpg" class="rounded-circle mr-3" width="60">
                                 <div>
                                    <h5 class="mb-0"><?php echo $ins['name']; ?></h5>
                                    <small class="text-primary font-weight-bold">Lead Trainer</small>
                                 </div>
                              </div>
                              <p class="small text-muted"><?php echo $ins['bio'] ?: 'No bio available.'; ?></p>
                              <div class="d-flex justify-content-between pt-2 border-top">
                                 <span class="small"><i class="fa fa-envelope"></i> <?php echo $ins['email']; ?></span>
                                 <span class="small"><i class="fa fa-star text-warning"></i> 4.5</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php endforeach; ?>
                  </div>

                  <h5 class="mt-4 mb-3 border-bottom pb-2">Lessons Hierarchy</h5>
                  <?php foreach ($curriculum as $section): ?>
                  <div class="card mb-3 border-0 shadow-sm border-left-primary">
                     <div class="card-header bg-light d-flex justify-content-between">
                        <h6 class="mb-0 font-weight-bold"><?php echo $section['title']; ?></h6>
                        <span class="small text-muted"><?php echo count($section['lessons']); ?> Lessons</span>
                     </div>
                     <ul class="list-group list-group-flush">
                        <?php foreach ($section['lessons'] as $lesson): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                           <span class="small"><i class="fa fa-play-circle mr-2 text-primary"></i> <?php echo $lesson['title']; ?></span>
                           <span class="badge badge-light"><?php echo $lesson['duration']; ?></span>
                        </li>
                        <?php endforeach; ?>
                     </ul>
                  </div>
                  <?php endforeach; ?>
               </div>
               
               <!-- Batches Tab -->
               <div class="tab-pane fade" id="batches" role="tabpanel">
                  <div class="table-responsive">
                     <table class="table table-striped table-sm">
                        <thead>
                           <tr>
                              <th>Batch #</th>
                              <th>Status</th>
                              <th>Start Date</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($batches as $batch): ?>
                           <tr>
                              <td>Batch <?php echo $batch['batch_no']; ?></td>
                              <td><span class="badge badge-<?php echo ($batch['status'] === 'active') ? 'success' : 'info'; ?>"><?php echo ucfirst($batch['status']); ?></span></td>
                              <td><?php echo $batch['start_date'] ?: 'Not set'; ?></td>
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
</div>

<?php include 'includes/footer.php'; ?>
