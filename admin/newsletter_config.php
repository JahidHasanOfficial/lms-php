<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Fetch existing settings
$settings = $pdo->query("SELECT * FROM newsletter_settings WHERE id = 1")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $subtitle = sanitize($_POST['subtitle']);
    $bgImg = $settings['background_img'];

    if (isset($_FILES['background_img']) && $_FILES['background_img']['error'] === 0) {
        $uploaded = ImageHelper::upload($_FILES['background_img'], '../uploads/newsletter/');
        if ($uploaded) $bgImg = str_replace('../', '', $uploaded);
    }

    $stmt = $pdo->prepare("UPDATE newsletter_settings SET title = ?, subtitle = ?, background_img = ? WHERE id = 1");
    $stmt->execute([$title, $subtitle, $bgImg]);
    redirect('newsletter_config.php', 'Newsletter settings updated!', 'success');
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Newsletter Configuration</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8 offset-md-2">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="padding_infor_info">
            <form method="POST" enctype="multipart/form-data">
               <div class="form-group">
                  <label>Section Title</label>
                  <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($settings['title']); ?>" required>
               </div>
               <div class="form-group">
                  <label>Section Subtitle</label>
                  <input type="text" name="subtitle" class="form-control" value="<?php echo htmlspecialchars($settings['subtitle']); ?>" required>
               </div>
               <div class="form-group">
                  <label>Background Image</label><br>
                  <img src="../<?php echo $settings['background_img']; ?>" width="300" class="mb-3 rounded border shadow-sm"><br>
                  <input type="file" name="background_img" class="form-control" accept="image/*">
               </div>
               <div class="mt-4"><button type="submit" class="btn btn-primary d-block w-100">Update Settings</button></div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
