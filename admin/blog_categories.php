<?php
require_once '../config/session.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Add/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = sanitize($_POST['name']);
    $slug = strtolower(str_replace(' ', '-', $name));
    $stmt = $pdo->prepare("INSERT INTO blog_categories (name, slug) VALUES (?, ?)");
    $stmt->execute([$name, $slug]);
    redirect('blog_categories.php', 'Category added!', 'success');
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM blog_categories WHERE id = ?")->execute([(int)$_GET['delete']]);
    redirect('blog_categories.php', 'Category deleted!', 'success');
}

$categories = $pdo->query("SELECT * FROM blog_categories ORDER BY id DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Blog Categories</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addCatModal"><i class="fa fa-plus"></i> Add Category</button>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="table_section padding_infor_info">
            <table class="table table-hover">
               <thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Action</th></tr></thead>
               <tbody>
                  <?php foreach ($categories as $c): ?>
                  <tr>
                     <td><?php echo $c['id']; ?></td>
                     <td><?php echo $c['name']; ?></td>
                     <td><small><?php echo $c['slug']; ?></small></td>
                     <td><a href="?delete=<?php echo $c['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this category?')"><i class="fa fa-trash"></i></a></td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addCatModal">
   <div class="modal-dialog"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Add Category</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="POST"><div class="modal-body"><label>Category Name</label><input type="text" name="name" class="form-control" required></div>
      <div class="modal-footer"><button type="submit" name="add_category" class="btn btn-primary">Save Category</button></div></form>
   </div></div>
</div>

<?php include 'includes/footer.php'; ?>
