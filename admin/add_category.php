<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Category.php';
require_once dirname(__DIR__) . '/config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryObj = new Category($pdo);
    
    $name = sanitize($_POST['name']);
    $slug = sanitize($_POST['slug']);
    $description = $_POST['description'];
    
    // Handle Image Upload
    $imagePath = '';
    if (isset($_FILES['image'])) {
        $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/categories/');
        if ($uploaded) {
            $imagePath = str_replace('../', '', $uploaded); // Save relative to root
        }
    }

    if ($categoryObj->create($name, $slug, $description, $imagePath)) {
        redirect('categories.php', 'Category created successfully!', 'success');
    } else {
        $error = "Failed to create category.";
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Create New Category</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Category Details</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <?php if (isset($error)): ?>
               <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
               <div class="row g-3">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Category Name</label>
                     <input type="text" name="name" class="form-control" required placeholder="Ex: Web Development">
                  </div>
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Slug (URL)</label>
                     <input type="text" name="slug" class="form-control" required placeholder="Ex: web-development">
                  </div>
                  <div class="col-md-12 mb-3">
                     <label class="form-label">Category Image (Auto WebP Optimization)</label>
                     <input type="file" name="image" class="form-control" accept="image/*" required>
                     <small>Uploaded images will be automatically converted to <strong>WebP</strong> format for fast loading.</small>
                  </div>
                  <div class="col-12 mb-3">
                     <label class="form-label">Description</label>
                     <textarea name="description" class="form-control" rows="5"></textarea>
                  </div>
                  <div class="col-12">
                     <button type="submit" class="btn btn-primary px-5">Create Category</button>
                     <a href="categories.php" class="btn btn-secondary px-5">Cancel</a>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
