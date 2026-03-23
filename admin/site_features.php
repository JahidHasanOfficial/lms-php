<?php
require_once '../config/session.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Add Feature
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_feature'])) {
    $title = sanitize($_POST['title']);
    $icon = sanitize($_POST['icon']);
    $desc = $_POST['description'];
    
    $stmt = $pdo->prepare("INSERT INTO site_features (title, icon, description) VALUES (?, ?, ?)");
    if ($stmt->execute([$title, $icon, $desc])) {
        redirect('site_features.php', 'Feature added successfully!', 'success');
    }
}

// Handle Edit Feature
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_feature'])) {
    $id = (int)$_POST['id'];
    $title = sanitize($_POST['title']);
    $icon = sanitize($_POST['icon']);
    $desc = $_POST['description'];
    
    $stmt = $pdo->prepare("UPDATE site_features SET title = ?, icon = ?, description = ? WHERE id = ?");
    if ($stmt->execute([$title, $icon, $desc, $id])) {
        redirect('site_features.php', 'Feature updated successfully!', 'success');
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM site_features WHERE id = ?")->execute([$id]);
    redirect('site_features.php', 'Feature deleted!', 'success');
}

$features = $pdo->query("SELECT * FROM site_features ORDER BY id ASC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Core Platform Features</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addFeatureModal"><i class="fa fa-plus"></i> Add New Feature</button>
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
                        <th>Icon</th>
                        <th>Feature Title</th>
                        <th>Description</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($features as $f): ?>
                     <tr>
                        <td><div class="bg-light p-3 rounded" style="width: 50px;"><i class="<?php echo $f['icon']; ?> fa-2x text-primary"></i></div></td>
                        <td><strong><?php echo $f['title']; ?></strong></td>
                        <td><?php echo $f['description']; ?></td>
                        <td>
                           <button class="btn btn-info btn-xs edit-feature-btn" 
                                   data-id="<?php echo $f['id']; ?>"
                                   data-title="<?php echo htmlspecialchars($f['title']); ?>"
                                   data-icon="<?php echo htmlspecialchars($f['icon']); ?>"
                                   data-description="<?php echo htmlspecialchars($f['description']); ?>"
                                   data-toggle="modal" data-target="#editFeatureModal">
                              <i class="fa fa-edit"></i>
                           </button>
                           <a href="?delete=<?php echo $f['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"><i class="fa fa-trash"></i></a>
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

<div class="modal fade" id="addFeatureModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Feature Box</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form method="POST">
            <div class="modal-body">
               <div class="mb-3">
                  <label>Feature Title</label>
                  <input type="text" name="title" class="form-control" required placeholder="Ex: Skilled Instructors">
               </div>
               <div class="mb-3">
                  <label>FontAwesome Icon (e.g. fa-graduation-cap)</label>
                  <input type="text" name="icon" class="form-control" required placeholder="fa-book">
               </div>
               <div class="mb-3">
                  <label>Short Description</label>
                  <textarea name="description" class="form-control" rows="3" required></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" name="add_feature" class="btn btn-primary">Save Feature</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="editFeatureModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Feature Box</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form method="POST">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
               <div class="mb-3">
                  <label>Feature Title</label>
                  <input type="text" name="title" id="edit_title" class="form-control" required>
               </div>
               <div class="mb-3">
                  <label>FontAwesome Icon (e.g. fa-graduation-cap)</label>
                  <input type="text" name="icon" id="edit_icon" class="form-control" required>
               </div>
               <div class="mb-3">
                  <label>Short Description</label>
                  <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" name="edit_feature" class="btn btn-primary">Update Feature</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
document.querySelectorAll('.edit-feature-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_title').value = this.dataset.title;
        document.getElementById('edit_icon').value = this.dataset.icon;
        document.getElementById('edit_description').value = this.dataset.description;
    });
});
</script>

<?php include 'includes/footer.php'; ?>
