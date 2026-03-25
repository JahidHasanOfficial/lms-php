<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Add/Edit Team Member
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $designation = sanitize($_POST['designation']);
    $specializations = sanitize($_POST['specializations'] ?? '');
    $education = sanitize($_POST['education'] ?? '');
    $work_experience = sanitize($_POST['work_experience'] ?? '');
    $work_places = sanitize($_POST['work_places'] ?? '');
    $training_experience = sanitize($_POST['training_experience'] ?? '');
    $total_students = sanitize($_POST['total_students'] ?? '');
    
    if (isset($_POST['add_member'])) {
        $imagePath = 'frontend-template/img/team-1.jpg';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/team/');
            if ($uploaded) $imagePath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("INSERT INTO team_members (name, designation, image, specializations, education, work_experience, work_places, training_experience, total_students) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $designation, $imagePath, $specializations, $education, $work_experience, $work_places, $training_experience, $total_students]);
        redirect('team_management.php', 'Member added!', 'success');
    }

    if (isset($_POST['edit_member'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("SELECT image FROM team_members WHERE id = ?");
        $stmt->execute([$id]);
        $imagePath = $stmt->fetch()['image'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/team/');
            if ($uploaded) $imagePath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("UPDATE team_members SET name = ?, designation = ?, image = ?, specializations = ?, education = ?, work_experience = ?, work_places = ?, training_experience = ?, total_students = ? WHERE id = ?");
        $stmt->execute([$name, $designation, $imagePath, $specializations, $education, $work_experience, $work_places, $training_experience, $total_students, $id]);
        redirect('team_management.php', 'Member updated!', 'success');
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM team_members WHERE id = ?")->execute([$id]);
    redirect('team_management.php', 'Member removed!', 'success');
}

$team = $pdo->query("SELECT * FROM team_members ORDER BY id DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Instructor/Team Management</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addMemberModal"><i class="fa fa-plus"></i> Add New Member</button>
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($team as $m): ?>
                     <tr>
                        <td><img src="../<?php echo $m['image']; ?>" width="60" class="rounded-circle shadow-sm"></td>
                        <td><strong><?php echo $m['name']; ?></strong></td>
                        <td><span class="text-muted"><?php echo $m['designation']; ?></span></td>
                        <td>
                           <button class="btn btn-info btn-xs edit-btn" 
                                   data-id="<?php echo $m['id']; ?>"
                                   data-name="<?php echo htmlspecialchars($m['name']); ?>"
                                   data-designation="<?php echo htmlspecialchars($m['designation']); ?>"
                                   data-image="../<?php echo $m['image']; ?>"
                                   data-specializations="<?php echo htmlspecialchars($m['specializations'] ?? ''); ?>"
                                   data-education="<?php echo htmlspecialchars($m['education'] ?? ''); ?>"
                                   data-experience="<?php echo htmlspecialchars($m['work_experience'] ?? ''); ?>"
                                   data-workplace="<?php echo htmlspecialchars($m['work_places'] ?? ''); ?>"
                                   data-training="<?php echo htmlspecialchars($m['training_experience'] ?? ''); ?>"
                                   data-students="<?php echo htmlspecialchars($m['total_students'] ?? ''); ?>"
                                   data-toggle="modal" data-target="#editMemberModal">
                              <i class="fa fa-edit"></i>
                           </button>
                           <a href="?delete=<?php echo $m['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this member?')"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="addMemberModal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header"><h4 class="modal-title">Add Team Member</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
         <form method="POST" enctype="multipart/form-data">
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-6 mb-3"><label>Full Name</label><input type="text" name="name" class="form-control" required></div>
                   <div class="col-md-6 mb-3"><label>Designation</label><input type="text" name="designation" class="form-control" required placeholder="Ex: Senior Developer"></div>
                   <div class="col-md-12 mb-3"><label>Profile Image</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                   <div class="col-md-6 mb-3"><label>Specialized Area (One per line)</label><textarea name="specializations" class="form-control" rows="4"></textarea></div>
                   <div class="col-md-6 mb-3"><label>Education Qualification (One per line)</label><textarea name="education" class="form-control" rows="4"></textarea></div>
                   <div class="col-md-6 mb-3"><label>Work Experience (One per line)</label><textarea name="work_experience" class="form-control" rows="4"></textarea></div>
                   <div class="col-md-6 mb-3"><label>Work Place (Comma separated)</label><input type="text" name="work_places" class="form-control" placeholder="Fiverr, Upwork, Freelancer"></div>
                   <div class="col-md-6 mb-3"><label>Training Experience</label><input type="text" name="training_experience" class="form-control" placeholder="5 years +"></div>
                   <div class="col-md-6 mb-3"><label>Total Students</label><input type="text" name="total_students" class="form-control" placeholder="2500+"></div>
               </div>
            </div>
            <div class="modal-footer"><button type="submit" name="add_member" class="btn btn-primary">Save Member</button></div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editMemberModal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header"><h4 class="modal-title">Edit Team Member</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
         <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-6 mb-3"><label>Full Name</label><input type="text" name="name" id="edit_name" class="form-control" required></div>
                   <div class="col-md-6 mb-3"><label>Designation</label><input type="text" name="designation" id="edit_designation" class="form-control" required></div>
                   <div class="col-md-12 mb-3">
                      <label>Replace Image (Optional)</label>
                      <div class="mb-2"><img src="" id="edit_img_preview" width="60" class="rounded-circle border"></div>
                      <input type="file" name="image" class="form-control" accept="image/*">
                   </div>
                   <div class="col-md-6 mb-3"><label>Specialized Area</label><textarea name="specializations" id="edit_specializations" class="form-control" rows="4"></textarea></div>
                   <div class="col-md-6 mb-3"><label>Education Qualification</label><textarea name="education" id="edit_education" class="form-control" rows="4"></textarea></div>
                   <div class="col-md-6 mb-3"><label>Work Experience</label><textarea name="work_experience" id="edit_experience" class="form-control" rows="4"></textarea></div>
                   <div class="col-md-6 mb-3"><label>Work Place</label><input type="text" name="work_places" id="edit_work_places" class="form-control"></div>
                   <div class="col-md-6 mb-3"><label>Training Experience</label><input type="text" name="training_experience" id="edit_training" class="form-control"></div>
                   <div class="col-md-6 mb-3"><label>Total Students</label><input type="text" name="total_students" id="edit_students" class="form-control"></div>
               </div>
            </div>
            <div class="modal-footer"><button type="submit" name="edit_member" class="btn btn-primary">Update Member</button></div>
         </form>
      </div>
   </div>
</div>

<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_name').value = this.dataset.name;
        document.getElementById('edit_designation').value = this.dataset.designation;
        document.getElementById('edit_img_preview').src = this.dataset.image;
        document.getElementById('edit_specializations').value = this.dataset.specializations;
        document.getElementById('edit_education').value = this.dataset.education;
        document.getElementById('edit_experience').value = this.dataset.experience;
        document.getElementById('edit_work_places').value = this.dataset.workplace;
        document.getElementById('edit_training').value = this.dataset.training;
        document.getElementById('edit_students').value = this.dataset.students;
    });
});
</script>

<?php include 'includes/footer.php'; ?>
