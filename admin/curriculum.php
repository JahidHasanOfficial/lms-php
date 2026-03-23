<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Curriculum.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('index.php');
}

$course_id = $_GET['course_id'] ?? null;
if (!$course_id) redirect('courses.php');

$curr = new Curriculum($pdo);

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_section'])) {
        $title = sanitize($_POST['section_title']);
        $curr->addSection($course_id, $title);
        redirect('curriculum.php?course_id='.$course_id, "Section added!", 'success');
    }
    if (isset($_POST['add_lesson'])) {
        $section_id = (int)$_POST['section_id'];
        $title = sanitize($_POST['lesson_title']);
        $type = $_POST['content_type'];
        $url = $_POST['content_url'];
        $duration = sanitize($_POST['duration']);
        $curr->addLesson($section_id, $title, $type, $url, $duration);
        redirect('curriculum.php?course_id='.$course_id, "Lesson added!", 'success');
    }
    if (isset($_POST['delete_lesson'])) {
        $lesson_id = (int)$_POST['lesson_id'];
        $pdo->prepare("DELETE FROM lessons WHERE id = ?")->execute([$lesson_id]);
        redirect('curriculum.php?course_id='.$course_id, "Lesson removed!", 'success');
    }
}

$sections = $curr->getSections($course_id);

// Course info
$stmt = $pdo->prepare("SELECT title FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Curriculum – <?php echo $course['title']; ?></h2>
         <a href="courses.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
   </div>
   <!-- Add Section -->
   <div class="col-md-4">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Add New Section</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <form method="POST">
               <div class="mb-3">
                  <label class="form-label">Section Title</label>
                  <input type="text" name="section_title" class="form-control" required placeholder="Ex: Introduction to Coding">
               </div>
               <button type="submit" name="add_section" class="btn btn-primary w-100">Add Section</button>
            </form>
         </div>
      </div>
   </div>

   <!-- Section List -->
   <div class="col-md-8">
      <?php if (empty($sections)): ?>
         <div class="alert alert-info">No sections yet. Create your first one on the left!</div>
      <?php endif; ?>

      <?php foreach ($sections as $sec): ?>
         <div class="white_shd full margin_bottom_30">
            <div class="full graph_head d-flex justify-content-between">
               <div class="heading1 margin_0">
                  <h4 class="text-primary"><i class="fa fa-folder-open"></i> <?php echo $sec['title']; ?></h4>
               </div>
               <button class="btn btn-sm btn-outline-primary" data-toggle="collapse" data-target="#addLesson_<?php echo $sec['id']; ?>">
                  <i class="fa fa-plus"></i> Add Lesson
               </button>
            </div>
            
            <div id="addLesson_<?php echo $sec['id']; ?>" class="collapse padding_infor_info bg-light border-bottom">
               <form method="POST" class="row g-2">
                  <input type="hidden" name="section_id" value="<?php echo $sec['id']; ?>">
                  <div class="col-md-5">
                     <input type="text" name="lesson_title" class="form-control form-control-sm" placeholder="Lesson Name" required>
                  </div>
                  <div class="col-md-3">
                     <select name="content_type" class="form-control form-control-sm">
                        <option value="video">Video</option>
                        <option value="pdf">PDF</option>
                        <option value="text">Article</option>
                        <option value="quiz">Quiz</option>
                        <option value="assignment">Assignment</option>
                     </select>
                  </div>
                  <div class="col-md-4">
                     <input type="text" name="content_url" class="form-control form-control-sm" placeholder="Link (YouTube/Vimeo)">
                  </div>
                  <div class="col-md-3 mt-2">
                     <input type="text" name="duration" class="form-control form-control-sm" placeholder="Duration (e.g. 5:30)">
                  </div>
                  <div class="col-md-3 mt-2">
                     <button type="submit" name="add_lesson" class="btn btn-success btn-sm w-100">Save Lesson</button>
                  </div>
               </form>
            </div>

            <div class="table_section padding_infor_info">
               <div class="table-responsive-sm">
                  <table class="table table-sm hover">
                     <tbody>
                        <?php 
                        $lessons = $curr->getLessons($sec['id']);
                        if (empty($lessons)):
                        ?>
                           <tr><td class="text-muted italic">No lessons in this section.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($lessons as $index => $les): ?>
                        <tr>
                           <td width="5%"><?php echo $index + 1; ?>.</td>
                           <td width="10%"><i class="fa fa-<?php echo ($les['content_type'] === 'video') ? 'play-circle' : 'file-text'; ?> text-secondary"></i></td>
                           <td><?php echo $les['title']; ?></td>
                           <td class="text-right d-flex align-items-center justify-content-end">
                              <span class="small text-muted mr-3"><?php echo $les['duration']; ?></span>
                              <form method="POST" style="display:inline;" onsubmit="return confirm('Remove this lesson?');">
                                 <input type="hidden" name="lesson_id" value="<?php echo $les['id']; ?>">
                                 <button type="submit" name="delete_lesson" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                              </form>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      <?php endforeach; ?>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
