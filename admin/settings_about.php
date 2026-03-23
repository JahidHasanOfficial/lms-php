<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Fetch About data
$stmt = $pdo->query("SELECT * FROM about_us WHERE id = 1");
$about = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subtitle = sanitize($_POST['subtitle']);
    $title = sanitize($_POST['title']);
    $content = $_POST['content'];
    $btn_text = sanitize($_POST['button_text']);
    $btn_link = sanitize($_POST['button_link']);
    
    $imagePath = $about['image']; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/about/');
        if ($uploaded) {
            $imagePath = str_replace('../', '', $uploaded);
        }
    }

    $stmt = $pdo->prepare("UPDATE about_us SET subtitle = ?, title = ?, content = ?, image = ?, button_text = ?, button_link = ? WHERE id = 1");
    if ($stmt->execute([$subtitle, $title, $content, $imagePath, $btn_text, $btn_link])) {
        redirect('settings_about.php', 'About section updated successfully!', 'success');
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>About Us Settings</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="padding_infor_info">
            <form method="POST" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-md-8">
                     <div class="mb-3">
                        <label>Subtitle (e.g. ABOUT US)</label>
                        <input type="text" name="subtitle" class="form-control" value="<?php echo $about['subtitle']; ?>" required>
                     </div>
                     <div class="mb-3">
                        <label>Main Heading</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $about['title']; ?>" required>
                     </div>
                     <div class="mb-3">
                        <label>Content Text</label>
                        <textarea name="content" class="form-control" rows="8" required><?php echo $about['content']; ?></textarea>
                     </div>
                     <div class="row">
                        <div class="col-6 mb-3">
                           <label>Button Text</label>
                           <input type="text" name="button_text" class="form-control" value="<?php echo $about['button_text']; ?>">
                        </div>
                        <div class="col-6 mb-3">
                           <label>Button Link</label>
                           <input type="text" name="button_link" class="form-control" value="<?php echo $about['button_link']; ?>">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label>About Image</label>
                        <div class="mb-2">
                           <img src="../<?php echo $about['image']; ?>" class="img-fluid rounded border shadow-sm" alt="About Image">
                        </div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Recommended size: 600x400px</small>
                     </div>
                  </div>
               </div>
               <hr>
               <button type="submit" class="btn btn-primary btn-lg shadow-sm"><i class="fa fa-save"></i> Save Changes</button>
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
