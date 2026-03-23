<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catId = (int)$_POST['category_id'];
    $title = sanitize($_POST['title']);
    $content = $_POST['content']; // Expecting raw content if using editor
    $status = sanitize($_POST['status']);
    $slug = strtolower(str_replace(' ', '-', $title)) . '-' . rand(100, 999);
    $authorId = $_SESSION['user_id'];
    
    if (isset($_POST['add_blog'])) {
        $imgPath = 'frontend-template/img/course-1.jpg';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/blogs/');
            if ($uploaded) $imgPath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("INSERT INTO blogs (category_id, title, slug, content, image, author_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$catId, $title, $slug, $content, $imgPath, $authorId, $status]);
        redirect('blogs.php', 'Blog post published!', 'success');
    }

    if (isset($_POST['edit_blog'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("SELECT image FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        $imgPath = $stmt->fetch()['image'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/blogs/');
            if ($uploaded) $imgPath = str_replace('../', '', $uploaded);
        }
        $stmt = $pdo->prepare("UPDATE blogs SET category_id = ?, title = ?, content = ?, image = ?, status = ? WHERE id = ?");
        $stmt->execute([$catId, $title, $content, $imgPath, $status, $id]);
        redirect('blogs.php', 'Blog updated!', 'success');
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM blogs WHERE id = ?")->execute([(int)$_GET['delete']]);
    redirect('blogs.php', 'Blog post removed!', 'success');
}

$blogs = $pdo->query("SELECT b.*, bc.name as category_name 
                      FROM blogs b 
                      JOIN blog_categories bc ON b.category_id = bc.id 
                      ORDER BY b.id DESC")->fetchAll();

$categories = $pdo->query("SELECT * FROM blog_categories")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Manage Blogs</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addBlogModal"><i class="fa fa-plus"></i> Write New Blog</button>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="table_section padding_infor_info">
            <table class="table table-hover">
               <thead><tr><th>Image</th><th>Title</th><th>Category</th><th>Status</th><th>Action</th></tr></thead>
               <tbody>
                  <?php foreach ($blogs as $b): ?>
                  <tr>
                     <td><img src="../<?php echo $b['image']; ?>" width="80" class="rounded shadow-sm"></td>
                     <td><strong><?php echo $b['title']; ?></strong><br><small><?php echo date('d M Y', strtotime($b['created_at'])); ?></small></td>
                     <td><span class="badge badge-info"><?php echo $b['category_name']; ?></span></td>
                     <td><span class="badge badge-<?php echo ($b['status'] == 'published') ? 'success' : 'warning'; ?>"><?php echo ucfirst($b['status']); ?></span></td>
                     <td>
                        <button class="btn btn-info btn-xs edit-blog-btn" 
                                data-id="<?php echo $b['id']; ?>"
                                data-title="<?php echo htmlspecialchars($b['title']); ?>"
                                data-content="<?php echo htmlspecialchars($b['content']); ?>"
                                data-cat="<?php echo $b['category_id']; ?>"
                                data-img="../<?php echo $b['image']; ?>"
                                data-status="<?php echo $b['status']; ?>"
                                data-toggle="modal" data-target="#editBlogModal"><i class="fa fa-edit"></i></button>
                        <a href="?delete=<?php echo $b['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this post?')"><i class="fa fa-trash"></i></a>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<!-- Write/Add Modal -->
<div class="modal fade" id="addBlogModal">
   <div class="modal-dialog modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">New Blog Post</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="POST" enctype="multipart/form-data">
         <div class="modal-body">
            <div class="row mb-3">
               <div class="col-md-6"><label>Blog Title</label><input type="text" name="title" class="form-control" required></div>
               <div class="col-md-6"><label>Category</label><select name="category_id" class="form-control" required><?php foreach($categories as $c) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?></select></div>
            </div>
            <div class="mb-3"><label>Featured Image</label><input type="file" name="image" class="form-control" accept="image/*" required></div>
            <div class="mb-3"><label>Content</label><textarea name="content" class="form-control" rows="8" required></textarea></div>
            <div class="mb-3"><label>Status</label><select name="status" class="form-control"><option value="published">Published</option><option value="draft">Draft</option></select></div>
         </div>
         <div class="modal-footer"><button type="submit" name="add_blog" class="btn btn-primary">Publish Post</button></div>
      </form>
   </div></div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editBlogModal">
   <div class="modal-dialog modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Edit Post</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="POST" enctype="multipart/form-data">
         <input type="hidden" name="id" id="edit_id">
         <div class="modal-body">
            <div class="row mb-3">
               <div class="col-md-6"><label>Blog Title</label><input type="text" name="title" id="edit_title" class="form-control" required></div>
               <div class="col-md-6"><label>Category</label><select name="category_id" id="edit_cat" class="form-control" required><?php foreach($categories as $c) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?></select></div>
            </div>
            <div class="mb-3"><label>Featured Image</label><br><img src="" id="edit_img_preview" width="100" class="mb-2 rounded shadow-sm"><input type="file" name="image" class="form-control" accept="image/*"></div>
            <div class="mb-3"><label>Content</label><textarea name="content" id="edit_content" class="form-control" rows="8" required></textarea></div>
            <div class="mb-3"><label>Status</label><select name="status" id="edit_status" class="form-control"><option value="published">Published</option><option value="draft">Draft</option></select></div>
         </div>
         <div class="modal-footer"><button type="submit" name="edit_blog" class="btn btn-primary">Update Post</button></div>
      </form>
   </div></div>
</div>

<script>
document.querySelectorAll('.edit-blog-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_title').value = this.dataset.title;
        document.getElementById('edit_content').value = this.dataset.content;
        document.getElementById('edit_cat').value = this.dataset.cat;
        document.getElementById('edit_status').value = this.dataset.status;
        document.getElementById('edit_img_preview').src = this.dataset.img;
    });
});
</script>

<?php include 'includes/footer.php'; ?>
