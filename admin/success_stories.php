<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['student_name']);
    $course = sanitize($_POST['course_info']);
    $video = sanitize($_POST['video_url']);
    
    if (isset($_POST['add_story'])) {
        $imgPath = 'assets/img/course-1.jpg';
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['thumbnail'], '../uploads/stories/');
            if ($uploaded) $imgPath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("INSERT INTO success_stories (student_name, course_info, thumbnail, video_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $course, $imgPath, $video]);
        redirect('success_stories.php', 'Success Story added!', 'success');
    }

    if (isset($_POST['edit_story'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("SELECT thumbnail FROM success_stories WHERE id = ?");
        $stmt->execute([$id]);
        $imgPath = $stmt->fetch()['thumbnail'];

        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['thumbnail'], '../uploads/stories/');
            if ($uploaded) $imgPath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("UPDATE success_stories SET student_name = ?, course_info = ?, thumbnail = ?, video_url = ? WHERE id = ?");
        $stmt->execute([$name, $course, $imgPath, $video, $id]);
        redirect('success_stories.php', 'Success Story updated!', 'success');
    }
}

// Handle Delete/Toggle
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM success_stories WHERE id = ?")->execute([(int)$_GET['delete']]);
    redirect('success_stories.php', 'Story deleted!', 'success');
}

$stories = $pdo->query("SELECT * FROM success_stories ORDER BY id DESC")->fetchAll();
$all_courses = $pdo->query("SELECT c.title, b.batch_no FROM courses c LEFT JOIN batches b ON c.id = b.course_id WHERE c.status = 'published' ORDER BY c.title ASC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Student Success Stories (Video)</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addStoryModal"><i class="fa fa-plus"></i> Add New Story</button>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th>Thumbnail</th>
                        <th>Student & Course</th>
                        <th>Video URL</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($stories as $s): ?>
                     <tr>
                        <td><img src="../<?php echo $s['thumbnail']; ?>" width="100" class="rounded border shadow-sm"></td>
                        <td>
                           <strong><?php echo $s['student_name']; ?></strong><br>
                           <small class="text-muted"><?php echo $s['course_info']; ?></small>
                        </td>
                        <td><a href="<?php echo $s['video_url']; ?>" target="_blank" class="small text-primary"><?php echo $s['video_url']; ?></a></td>
                        <td>
                           <button class="btn btn-info btn-xs edit-story-btn" 
                                   data-id="<?php echo $s['id']; ?>"
                                   data-name="<?php echo htmlspecialchars($s['student_name']); ?>"
                                   data-course="<?php echo htmlspecialchars($s['course_info']); ?>"
                                   data-video="<?php echo htmlspecialchars($s['video_url']); ?>"
                                   data-img="../<?php echo $s['thumbnail']; ?>"
                                   data-toggle="modal" data-target="#editStoryModal">
                              <i class="fa fa-edit"></i>
                           </button>
                           <a href="?delete=<?php echo $s['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this story?')"><i class="fa fa-trash"></i></a>
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

<!-- Add Modal -->
<div class="modal fade" id="addStoryModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header"><h4 class="modal-title">Add Success Story</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
         <form method="POST" enctype="multipart/form-data">
            <div class="modal-body">
               <div class="mb-3"><label>Student Name</label><input type="text" name="student_name" class="form-control" required></div>
               <div class="mb-3">
                  <label>Course/Batch Info</label>
                  <select name="course_info" class="form-control" required>
                     <option value="">-- Select Course/Batch --</option>
                     <?php foreach ($all_courses as $ac): ?>
                        <?php $info = $ac['title'] . ($ac['batch_no'] ? " - Batch " . $ac['batch_no'] : ""); ?>
                        <option value="<?php echo $info; ?>"><?php echo $info; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="mb-3"><label>YouTube/Video Link</label><input type="url" name="video_url" class="form-control" required placeholder="https://youtube.com/watch?v=..."></div>
               <div class="mb-3"><label>Thumbnail Image</label><input type="file" name="thumbnail" class="form-control" accept="image/*" required></div>
            </div>
            <div class="modal-footer"><button type="submit" name="add_story" class="btn btn-primary">Save Story</button></div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editStoryModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header"><h4 class="modal-title">Edit Success Story</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
         <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
               <div class="mb-3"><label>Student Name</label><input type="text" name="student_name" id="edit_name" class="form-control" required></div>
               <div class="mb-3">
                  <label>Course/Batch Info</label>
                  <select name="course_info" id="edit_course" class="form-control" required>
                     <option value="">-- Select Course/Batch --</option>
                     <?php foreach ($all_courses as $ac): ?>
                        <?php $info = $ac['title'] . ($ac['batch_no'] ? " - Batch " . $ac['batch_no'] : ""); ?>
                        <option value="<?php echo $info; ?>"><?php echo $info; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="mb-3"><label>YouTube Link</label><input type="url" name="video_url" id="edit_video" class="form-control" required></div>
               <div class="mb-3">
                  <label>Change Thumbnail (Optional)</label>
                  <div class="mb-2"><img src="" id="edit_img_preview" width="100" class="rounded border"></div>
                  <input type="file" name="thumbnail" class="form-control" accept="image/*">
               </div>
            </div>
            <div class="modal-footer"><button type="submit" name="edit_story" class="btn btn-primary">Update Story</button></div>
         </form>
      </div>
   </div>
</div>

<script>
document.querySelectorAll('.edit-story-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_name').value = this.dataset.name;
        document.getElementById('edit_course').value = this.dataset.course;
        document.getElementById('edit_video').value = this.dataset.video;
        document.getElementById('edit_img_preview').src = this.dataset.img;
    });
});
</script>

<?php include 'includes/footer.php'; ?>

