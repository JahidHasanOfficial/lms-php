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

// Track Progress (Mark current lesson as completed)
if ($current_lesson_id) {
    // 1. Mark lesson as completed
    $stmt_p = $pdo->prepare("INSERT IGNORE INTO lesson_progress (user_id, course_id, lesson_id, status) VALUES (?, ?, ?, 'completed')");
    $stmt_p->execute([$_SESSION['user_id'], $course_id, $current_lesson_id]);

    // 2. Update overall enrollment progress %
    // Get total lessons
    $totalLessons = 0;
    foreach ($curriculum as $section) {
        $totalLessons += count($section['lessons']);
    }

    // Get completed lessons
    $stmt_c = $pdo->prepare("SELECT COUNT(*) FROM lesson_progress WHERE user_id = ? AND course_id = ? AND status = 'completed'");
    $stmt_c->execute([$_SESSION['user_id'], $course_id]);
    $completedCount = $stmt_c->fetchColumn();

    if ($totalLessons > 0) {
        $progress = floor(($completedCount / $totalLessons) * 100);
        $pdo->prepare("UPDATE enrollments SET progress_percent = ? WHERE user_id = ? AND course_id = ?")
            ->execute([$progress, $_SESSION['user_id'], $course_id]);
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
         <div class="padding_infor_info p-0 shadow-lg rounded overflow-hidden">
            <?php if ($current_lesson): ?>
               <!-- Enhanced Video Player (supports playback speed via video.js if needed, or native html5) -->
               <div class="bg-black" style="background: #000; position: relative;">
                  <?php if ($current_lesson['type'] === 'video'): ?>
                     <video id="my-video" class="video-js vjs-big-play-centered w-100" controls preload="auto" width="640" height="264" poster="../<?php echo $course['thumbnail']; ?>" data-setup='{"playbackRates": [0.5, 1, 1.25, 1.5, 1.75, 2]}'>
                        <source src="<?php echo $current_lesson['url']; ?>" type="video/mp4" />
                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                     </video>
                  <?php elseif ($current_lesson['type'] === 'pdf'): ?>
                     <iframe src="<?php echo $current_lesson['url']; ?>" width="100%" height="500px"></iframe>
                  <?php else: ?>
                     <div class="p-5 text-white"><?php echo $current_lesson['content_url']; ?></div>
                  <?php endif; ?>
               </div>
               
               <div class="p-4 bg-white">
                  <div class="d-flex justify-content-between align-items-start">
                     <div>
                        <h3 class="font-weight-bold mb-2"><?php echo $current_lesson['title']; ?></h3>
                        <div class="d-flex align-items-center text-muted small mb-0">
                           <span class="mr-3"><i class="fa fa-clock-o"></i> <?php echo $current_lesson['duration']; ?></span>
                           <span><i class="fa fa-folder-open"></i> <?php echo ucfirst($current_lesson['type']); ?></span>
                        </div>
                     </div>
                     <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm" onclick="bookmarkLesson(<?php echo $current_lesson_id; ?>)"><i class="fa fa-bookmark"></i> Bookmark</button>
                        <button class="btn btn-primary btn-sm ml-2" onclick="openNoteModal()"><i class="fa fa-edit"></i> Take Note</button>
                     </div>
                  </div>
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
                <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab">My Notes</a>
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
                <h6>About this lesson</h6>
                <p class="text-muted">Stay focused and take notes! This lesson is a key part of mastering your skills in <?php echo $course['title']; ?>.</p>
                <hr>
                <h6>Course Description</h6>
                <p>Learn at your own pace with high-quality content designed to help you succeed.</p>
            </div>
            <div class="tab-pane fade" id="notes" role="tabpanel">
                <div id="notes-list">
                    <p class="text-muted small">Your notes for this lesson will appear here.</p>
                </div>
                <textarea id="note-text" class="form-control mt-3" rows="3" placeholder="Type your note here..."></textarea>
                <button class="btn btn-primary btn-sm mt-2" onclick="saveNote(<?php echo $current_lesson_id; ?>)">Save Note</button>
            </div>
            <div class="tab-pane fade" id="qa" role="tabpanel">
                <p class="text-center py-4">No questions yet. Be the first to ask! 🙋‍♂️</p>
                <button class="btn btn-primary btn-sm center-block">Ask New Question</button>
            </div>
            <div class="tab-pane fade" id="resources" role="tabpanel">
                <p class="text-center py-4 text-muted small">No extra resources uploaded for this lesson.</p>
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

<!-- Floating Action Buttons -->
<div class="fixed-bottom p-4 d-flex justify-content-end" style="pointer-events: none;">
   <button class="btn btn-dark shadow-lg rounded-circle" id="darkModeToggle" style="pointer-events: auto; width: 50px; height: 50px;">
      <i class="fa fa-moon-o"></i>
   </button>
</div>

<script>
document.getElementById('darkModeToggle').addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    const icon = this.querySelector('i');
    icon.classList.toggle('fa-moon-o');
    icon.classList.toggle('fa-sun-o');
});

function saveNote(lessonId) {
    const note = document.getElementById('note-text').value;
    if (!note) return alert('Please enter a note!');
    
    // Simulate AJAX save
    console.log('Saving note for lesson ' + lessonId + ':', note);
    const notesList = document.getElementById('notes-list');
    const div = document.createElement('div');
    div.className = 'alert alert-light border-0 shadow-sm small mb-2';
    div.innerHTML = '<strong>Me:</strong> ' + note;
    notesList.prepend(div);
    document.getElementById('note-text').value = '';
    alert('Note saved!');
}

function bookmarkLesson(lessonId) {
    console.log('Bookmarking lesson ' + lessonId);
    alert('Lesson bookmarked!');
}

function openNoteModal() {
    document.getElementById('notes-tab').click();
    document.getElementById('note-text').focus();
}
</script>

<style>
.bg-black { background: #000; }
.bg-primary-light { background-color: rgba(3, 169, 244, 0.05); }
.border-left-primary { border-left: 4px solid #03a9f4; }
.cursor-pointer { cursor: pointer; }

/* Dark Mode Styles */
body.dark-mode { background-color: #1a1a1a !important; color: #e0e0e0; }
body.dark-mode .white_shd { background-color: #262626 !important; color: #e0e0e0; }
body.dark-mode .page_title h2, body.dark-mode h1, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 { color: #fff; }
body.dark-mode .card, body.dark-mode .list-group-item { background-color: #2d2d2d; color: #ccc; border-color: #444; }
body.dark-mode .text-muted { color: #888 !important; }
body.dark-mode .bg-light { background-color: #333 !important; }
body.dark-mode .nav-tabs .nav-link { color: #aaa; }
body.dark-mode .nav-tabs .nav-link.active { background-color: #262626; color: #03a9f4; border-color: #444 #444 #262626; }
</style>

<link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

<?php include 'includes/footer.php'; ?>
