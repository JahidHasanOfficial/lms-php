<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Add/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_image'])) {
    $title = sanitize($_POST['title']);
    
    if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] === 0) {
        $uploaded = ImageHelper::upload($_FILES['gallery_image'], '../uploads/gallery/');
        if ($uploaded) {
            $imgPath = str_replace('../', '', $uploaded);
            $stmt = $pdo->prepare("INSERT INTO image_gallery (title, image) VALUES (?, ?)");
            $stmt->execute([$title, $imgPath]);
            redirect('gallery_management.php', 'Image added to gallery!', 'success');
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM image_gallery WHERE id = ?");
    $stmt->execute([$id]);
    redirect('gallery_management.php', 'Image removed from gallery!', 'success');
}

$gallery = $pdo->query("SELECT * FROM image_gallery ORDER BY id DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Image Gallery Management</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addImageModal"><i class="fa fa-plus"></i> Add Gallery Image</button>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="padding_infor_info row">
            <?php foreach ($gallery as $img): ?>
            <div class="col-md-3 mb-4">
               <div class="card shadow-sm">
                  <img src="../<?php echo $img['image']; ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                  <div class="card-body p-2 d-flex justify-content-between align-items-center">
                     <small class="text-truncate"><?php echo $img['title'] ?: 'No Title'; ?></small>
                     <a href="?delete=<?php echo $img['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this image?')"><i class="fa fa-trash"></i></a>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
            
            <?php if (empty($gallery)): ?>
               <div class="col-12 text-center text-muted py-5">
                  <i class="fa fa-image fa-3x mb-3"></i>
                  <p>Gallery is empty. Start adding images!</p>
               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addImageModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header"><h4 class="modal-title">Add Image to Gallery</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
         <form method="POST" enctype="multipart/form-data">
            <div class="modal-body">
               <div class="mb-3"><label>Title (Optional)</label><input type="text" name="title" class="form-control" placeholder="Image Title/Event Name"></div>
               <div class="mb-3"><label>Select Image</label><input type="file" name="gallery_image" class="form-control" accept="image/*" required></div>
            </div>
            <div class="modal-footer"><button type="submit" name="add_image" class="btn btn-primary">Upload & Save</button></div>
         </form>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
