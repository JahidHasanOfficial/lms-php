<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Course.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$course_id = $_GET['course'] ?? null;
if (!$course_id) redirect('my-courses.php');

$courseObj = new Course($pdo);

// Verify enrollment
$stmt = $pdo->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
$stmt->execute([$_SESSION['user_id'], $course_id]);
$enrollment = $stmt->fetch();

if (!$enrollment) {
    redirect('my-courses.php');
}

// Get rich course data
$stmt = $pdo->prepare("SELECT title, slug FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

$curriculum = $courseObj->getCurriculum($course_id);

// Default to first lesson if none selected
$current_lesson_id = $_GET['lesson'] ?? null;
$current_lesson = null;

if (!$current_lesson_id) {
    foreach ($curriculum as $section) {
        if (!empty($section['lessons'])) {
            $current_lesson = $section['lessons'][0];
            $current_lesson_id = $current_lesson['id'];
            break;
        }
    }
} else {
    // Fetch specific lesson (I'll just find it in the curriculum array for now)
    foreach ($curriculum as $section) {
        foreach ($section['lessons'] as $lesson) {
            if ($lesson['id'] == $current_lesson_id) {
                $current_lesson = $lesson;
                break 2;
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between align-items-center">
         <h2><?php echo $course['title']; ?></h2>
         <a href="my-courses.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Courses</a>
      </div>
   </div>
</div>

<div class="row">
   <!-- Video Player Column -->
   <div class="col-lg-8">
      <div class="white_shd full margin_bottom_30">
         <div class="padding_infor_info p-0">
            <?php if ($current_lesson): ?>
               <div class="embed-responsive embed-responsive-16by9 bg-black rounded shadow-sm overflow-hidden" style="background: #000;">
                  <iframe class="embed-responsive-item" src="<?php echo $current_lesson['url']; ?>" allowfullscreen></iframe>
               </div>
               <div class="p-4">
                  <h3 class="font-weight-bold mb-2"><?php echo $current_lesson['title']; ?></h3>
                  <div class="d-flex align-items-center text-muted small mb-4">
                     <span class="mr-3"><i class="fa fa-clock-o"></i> <?php echo $current_lesson['duration']; ?></span>
                     <span><i class="fa fa-folder-open"></i> <?php echo ucfirst($current_lesson['type']); ?></span>
                  </div>
                  <hr>
                  <h5>About this lesson</h5>
                  <p class="text-muted">Stay focused and take notes! This lesson is a key part of mastering your skills in <?php echo $course['title']; ?>.</p>
               </div>
            <?php else: ?>
               <div class="text-center p-5">
                  <i class="fa fa-play-circle fa-5x text-muted mb-3"></i>
                  <h4>No lessons found in this course yet.</h4>
               </div>
            <?php endif; ?>
         </div>
      </div>

      <!-- Tabbed Info -->
      <div class="white_shd full margin_bottom_30">
        <ul class="nav nav-tabs custom_tabs" id="watchTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="qa-tab" data-toggle="tab" href="#qa" role="tab">Q&A</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab">Resources</a>
            </li>
        </ul>
        <div class="tab-content padding_infor_info" id="watchTabsContent">
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <h6>Course Description</h6>
                <p>Learn at your own pace with high-quality content designed to help you succeed.</p>
            </div>
            <div class="tab-pane fade" id="qa" role="tabpanel">
                <p class="text-center py-4">No questions yet. Be the first to ask! 🙋‍♂️</p>
                <button class="btn btn-primary btn-sm center-block">Ask New Question</button>
            </div>
            <div class="tab-pane fade" id="resources" role="tabpanel">
                <p class="text-center py-4">No extra resources uploaded for this lesson.</p>
            </div>
        </div>
      </div>
   </div>

   <!-- Curriculum Sidebar -->
   <div class="col-lg-4">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Course Curriculum</h2>
            </div>
         </div>
         <div class="padding_infor_info p-0" style="max-height: 800px; overflow-y: auto;">
            <div class="accordion" id="lessonAccordion">
               <?php foreach ($curriculum as $index => $section): ?>
               <div class="card border-0 rounded-0">
                  <div class="card-header bg-light p-3 cursor-pointer d-flex justify-content-between align-items-center" 
                       data-toggle="collapse" 
                       data-target="#sect<?php echo $section['id']; ?>" 
                       aria-expanded="<?php echo ($index == 0) ? 'true' : 'false'; ?>">
                     <h6 class="mb-0 font-weight-bold"><?php echo $section['title']; ?></h6>
                     <i class="fa fa-chevron-down small text-muted"></i>
                  </div>
                  <div id="sect<?php echo $section['id']; ?>" class="collapse <?php echo ($index == 0) ? 'show' : ''; ?>" data-parent="#lessonAccordion">
                     <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                           <?php foreach ($section['lessons'] as $lesson): ?>
                           <li class="list-group-item d-flex align-items-center py-3 <?php echo ($lesson['id'] == $current_lesson_id) ? 'bg-primary-light border-left-primary' : ''; ?>">
                              <a href="?course=<?php echo $course_id; ?>&lesson=<?php echo $lesson['id']; ?>" 
                                 class="text-decoration-none d-flex align-items-center w-100 <?php echo ($lesson['id'] == $current_lesson_id) ? 'text-primary font-weight-bold' : 'text-dark'; ?>">
                                 <i class="fa <?php echo ($lesson['id'] == $current_lesson_id) ? 'fa-play-circle-o' : 'fa-play-circle'; ?> mr-3"></i>
                                 <span class="small"><?php echo $lesson['title']; ?></span>
                                 <span class="ml-auto small text-muted"><?php echo $lesson['duration']; ?></span>
                              </a>
                           </li>
                           <?php endforeach; ?>
                        </ul>
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
.bg-black { background: #000; }
.bg-primary-light { background-color: rgba(3, 169, 244, 0.05); }
.border-left-primary { border-left: 4px solid #03a9f4; }
.cursor-pointer { cursor: pointer; }
</style>

<?php include 'includes/footer.php'; ?>
