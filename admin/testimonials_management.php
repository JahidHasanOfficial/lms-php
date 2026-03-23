<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Status Toggle (Approve/Deactivate)
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $stmt = $pdo->prepare("SELECT status FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    $current = $stmt->fetch()['status'];
    $newStatus = ($current == 'active') ? 'inactive' : 'active';
    
    $pdo->prepare("UPDATE testimonials SET status = ? WHERE id = ?")->execute([$newStatus, $id]);
    redirect('testimonials_management.php', 'Status updated!', 'success');
}

// Handle Add/Edit Testimonial
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['student_name']);
    $profession = sanitize($_POST['profession']);
    $feedback = $_POST['feedback'];
    
    if (isset($_POST['add_testimonial'])) {
        $imagePath = 'frontend-template/img/testimonial-1.jpg';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/testimonials/');
            if ($uploaded) $imagePath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("INSERT INTO testimonials (student_name, profession, feedback, image, status) VALUES (?, ?, ?, ?, 'active')");
        $stmt->execute([$name, $profession, $feedback, $imagePath]);
        redirect('testimonials_management.php', 'Testimonial added (Approved)!', 'success');
    }

    if (isset($_POST['edit_testimonial'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("SELECT image FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);
        $imagePath = $stmt->fetch()['image'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/testimonials/');
            if ($uploaded) $imagePath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("UPDATE testimonials SET student_name = ?, profession = ?, feedback = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $profession, $feedback, $imagePath, $id]);
        redirect('testimonials_management.php', 'Testimonial updated!', 'success');
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM testimonials WHERE id = ?")->execute([$id]);
    redirect('testimonials_management.php', 'Testimonial removed!', 'success');
}

$testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Student Testimonials Approval</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addTestimonialModal"><i class="fa fa-plus"></i> Add Manual Review</button>
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
                        <th>Photo</th>
                        <th>Student</th>
                        <th>Feedback</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($testimonials as $t): ?>
                     <tr>
                        <td><img src="../<?php echo $t['image']; ?>" width="60" class="rounded-circle shadow-sm border"></td>
                        <td>
                           <strong><?php echo $t['student_name']; ?></strong><br>
                           <small class="text-muted"><?php echo $t['profession']; ?></small>
                        </td>
                        <td><small><?php echo substr($t['feedback'], 0, 80); ?>...</small></td>
                        <td>
                           <?php if ($t['status'] == 'active'): ?>
                              <span class="badge badge-success">Approved (Live)</span>
                           <?php else: ?>
                              <span class="badge badge-warning">Pending Review</span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <a href="?toggle=<?php echo $t['id']; ?>" class="btn btn-<?php echo ($t['status'] == 'active') ? 'warning' : 'success'; ?> btn-xs">
                              <i class="fa <?php echo ($t['status'] == 'active') ? 'fa-times' : 'fa-check'; ?>"></i> <?php echo ($t['status'] == 'active') ? 'Unapprove' : 'Approve'; ?>
                           </a>
                           <button class="btn btn-info btn-xs edit-testimonial-btn" 
                                   data-id="<?php echo $t['id']; ?>"
                                   data-name="<?php echo htmlspecialchars($t['student_name']); ?>"
                                   data-profession="<?php echo htmlspecialchars($t['profession']); ?>"
                                   data-feedback="<?php echo htmlspecialchars($t['feedback']); ?>"
                                   data-image="../<?php echo $t['image']; ?>"
                                   data-toggle="modal" data-target="#editTestimonialModal">
                              <i class="fa fa-edit"></i>
                           </button>
                           <a href="?delete=<?php echo $t['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this testimonial?')"><i class="fa fa-trash"></i></a>
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

<!-- Add Modal (Admin can still manually add) -->
<div class="modal fade" id="addTestimonialModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header"><h4 class="modal-title">Add Testimonial</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
         <form method="POST" enctype="multipart/form-data">
            <div class="modal-body">
               <div class="mb-3"><label>Student Name</label><input type="text" name="student_name" class="form-control" required></div>
               <div class="mb-3"><label>Profession/Batch</label><input type="text" name="profession" class="form-control" required placeholder="Ex: Web Design Student"></div>
               <div class="mb-3"><label>Student Photo</label><input type="file" name="image" class="form-control" accept="image/*"></div>
               <div class="mb-3"><label>Feedback Content</label><textarea name="feedback" class="form-control" rows="4" required></textarea></div>
            </div>
            <div class="modal-footer"><button type="submit" name="add_testimonial" class="btn btn-primary">Save as Approved</button></div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editTestimonialModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header"><h4 class="modal-title">Edit Testimonial</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
         <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
               <div class="mb-3"><label>Student Name</label><input type="text" name="student_name" id="edit_name" class="form-control" required></div>
               <div class="mb-3"><label>Profession/Batch</label><input type="text" name="profession" id="edit_profession" class="form-control" required></div>
               <div class="mb-3">
                  <label>Replace Photo (Optional)</label>
                  <div class="mb-2"><img src="" id="edit_img_preview" width="60" class="rounded-circle border"></div>
                  <input type="file" name="image" class="form-control" accept="image/*">
               </div>
               <div class="mb-3"><label>Feedback Content</label><textarea name="feedback" id="edit_feedback" class="form-control" rows="4" required></textarea></div>
            </div>
            <div class="modal-footer"><button type="submit" name="edit_testimonial" class="btn btn-primary">Update Testimonial</button></div>
         </form>
      </div>
   </div>
</div>

<script>
document.querySelectorAll('.edit-testimonial-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_name').value = this.dataset.name;
        document.getElementById('edit_profession').value = this.dataset.profession;
        document.getElementById('edit_feedback').value = this.dataset.feedback;
        document.getElementById('edit_img_preview').src = this.dataset.image;
    });
});
</script>

<?php include 'includes/footer.php'; ?>
