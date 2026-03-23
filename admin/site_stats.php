<?php
require_once '../config/session.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Fetch existing stats
$stats = $pdo->query("SELECT * FROM site_stats WHERE id = 1")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courses = sanitize($_POST['courses_count']);
    $learners = sanitize($_POST['learners_count']);
    $materials = sanitize($_POST['materials_count']);
    $instructors = sanitize($_POST['instructors_count']);

    $stmt = $pdo->prepare("UPDATE site_stats SET courses_count = ?, learners_count = ?, materials_count = ?, instructors_count = ? WHERE id = 1");
    $stmt->execute([$courses, $learners, $materials, $instructors]);
    redirect('site_stats.php', 'Statistics updated!', 'success');
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Platform Key Statistics</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8 offset-md-2">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="padding_infor_info">
            <form method="POST">
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label>Available Courses</label>
                     <input type="text" name="courses_count" class="form-control" value="<?php echo $stats['courses_count']; ?>" required>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Total Learners</label>
                     <input type="text" name="learners_count" class="form-control" value="<?php echo $stats['learners_count']; ?>" required>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Learning Materials</label>
                     <input type="text" name="materials_count" class="form-control" value="<?php echo $stats['materials_count']; ?>" required>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Top 1% Instructors</label>
                     <input type="text" name="instructors_count" class="form-control" value="<?php echo $stats['instructors_count']; ?>" required>
                  </div>
               </div>
               <div class="mt-4"><button type="submit" class="btn btn-primary d-block w-100 py-3 font-weight-bold">Update Statistics</button></div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
