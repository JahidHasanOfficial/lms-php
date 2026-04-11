<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Fetch the single hero record (ID: 1)
$stmt = $pdo->prepare("SELECT * FROM hero_slides WHERE id = 1");
$stmt->execute();
$hero = $stmt->fetch();

// If record missing, seed it back
if (!$hero) {
    $pdo->query("INSERT INTO hero_slides (id, subtitle, title, description, image) VALUES (1, 'Best Online Courses', 'The Best Online Learning Platform', 'Discover professional courses that will help you grow your skills.', 'assets/img/carousel-1.jpg')");
    $hero = $pdo->query("SELECT * FROM hero_slides WHERE id = 1")->fetch();
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_hero'])) {
    $subtitle = sanitize($_POST['subtitle']);
    $title = sanitize($_POST['title']);
    $desc = $_POST['description'];
    $btn_text = sanitize($_POST['btn_text']);
    $btn_link = sanitize($_POST['btn_link']);
    
    $imagePath = $hero['image'];

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploaded = ImageHelper::upload($_FILES['image'], '../uploads/sliders/');
        if ($uploaded) {
            $imagePath = str_replace('../', '', $uploaded);
        }
    }

    // Handle Video Upload (Saves as hero.mp4)
    if (isset($_FILES['hero_video']) && $_FILES['hero_video']['error'] === 0) {
        $allowed = ['mp4', 'webm'];
        $ext = pathinfo($_FILES['hero_video']['name'], PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed)) {
            $targetDir = "../assets/video/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            move_uploaded_file($_FILES['hero_video']['tmp_name'], $targetDir . "hero.mp4");
        }
    }

    $stmt = $pdo->prepare("UPDATE hero_slides SET subtitle = ?, title = ?, description = ?, image = ?, btn_text = ?, btn_link = ? WHERE id = 1");
    if ($stmt->execute([$subtitle, $title, $desc, $imagePath, $btn_text, $btn_link])) {
        redirect('hero_slides.php', 'Hero section updated successfully!', 'success');
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Hero Section Management</h2>
         <p class="text-muted">Directly manage fonts, images, and background video for the homepage.</p>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Configure Landing Page Entry</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <form method="POST" enctype="multipart/form-data">
               <div class="row">
                  <!-- Text Configuration -->
                  <div class="col-md-6 border-right">
                     <h5 class="mb-4 text-primary"><i class="fa fa-font mr-2"></i> Content & Text</h5>
                     <div class="mb-3">
                        <label class="font-weight-bold">Subtitle (Small Upper Text)</label>
                        <input type="text" name="subtitle" class="form-control" value="<?php echo htmlspecialchars($hero['subtitle']); ?>" required>
                     </div>
                     <div class="mb-3">
                        <label class="font-weight-bold">Primary Heading</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($hero['title']); ?>" required>
                     </div>
                     <div class="mb-3">
                        <label class="font-weight-bold">Description Text</label>
                        <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($hero['description']); ?></textarea>
                     </div>
                     <div class="row">
                        <div class="col-6 mb-3">
                           <label class="font-weight-bold">Button 1 Text</label>
                           <input type="text" name="btn_text" class="form-control" value="<?php echo htmlspecialchars($hero['btn_text']); ?>">
                        </div>
                        <div class="col-6 mb-3">
                           <label class="font-weight-bold">Button 1 Link</label>
                           <input type="text" name="btn_link" class="form-control" value="<?php echo htmlspecialchars($hero['btn_link']); ?>">
                        </div>
                     </div>
                  </div>

                  <!-- Media Configuration -->
                  <div class="col-md-6">
                     <h5 class="mb-4 text-primary"><i class="fa fa-image mr-2"></i> Media & Background</h5>
                     
                     <!-- Background Image Container -->
                     <div class="mb-4">
                        <label class="font-weight-bold">Hero Background Image</label>
                        <div class="mb-2">
                           <img src="../<?php echo $hero['image']; ?>" class="rounded shadow-sm border" style="width: 100%; height: 150px; object-fit: cover;">
                        </div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Used as a fallback for the video on mobile/slow connections.</small>
                     </div>

                     <!-- Background Video Container -->
                     <div class="mb-3 p-3 bg-light rounded border">
                        <label class="font-weight-bold text-dark"><i class="fa fa-video text-danger mr-2"></i> Hero Background Video (MP4)</label>
                        <?php if(file_exists('../assets/video/hero.mp4')): ?>
                           <div class="mb-2">
                              <video src="../assets/video/hero.mp4" muted autoplay loop class="rounded w-100 shadow-sm" style="height: 100px; object-fit: cover;"></video>
                              <span class="badge badge-success mt-1">Status: Active</span>
                           </div>
                        <?php else: ?>
                           <div class="alert alert-warning py-1 small mb-2"><i class="fa fa-exclamation-triangle"></i> No video found. Image background active.</div>
                        <?php endif; ?>
                        <input type="file" name="hero_video" class="form-control" accept="video/mp4">
                        <small class="text-muted d-block mt-1">Recommended: Optimized H.264 MP4 under 10MB.</small>
                     </div>
                  </div>
               </div>

               <hr class="my-4">
               <div class="text-right">
                  <button type="submit" name="update_hero" class="btn btn-primary px-5 py-2"><i class="fa fa-save mr-2"></i> Save Changes & Apply to Homepage</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>

