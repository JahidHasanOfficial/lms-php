<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];

// 1. Check Enrollments & Profile Pic
$stmt = $pdo->prepare("SELECT e.*, c.title as course_title, b.batch_no, u.profile_pic, u.name as student_name
                        FROM enrollments e 
                        JOIN courses c ON e.course_id = c.id 
                        LEFT JOIN batches b ON e.batch_id = b.id
                        JOIN users u ON e.user_id = u.id
                        WHERE e.user_id = ? AND e.payment_status = 'completed'");
$stmt->execute([$user_id]);
$enrollments = $stmt->fetchAll();

$isEnrolled = count($enrollments) > 0;
$userData = count($enrollments) > 0 ? $enrollments[0] : null;

// 2. Fetch Existing Review
$stmt = $pdo->prepare("SELECT * FROM testimonials WHERE user_id = ?");
$stmt->execute([$user_id]);
$existing = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    if (!$isEnrolled) {
        redirect('testimonial.php', 'You must be enrolled to submit a review.', 'danger');
    }

    $enroll_info = sanitize($_POST['enroll_info']);
    $feedback = sanitize($_POST['feedback']);
    $profile_pic = $userData['profile_pic'] ?: 'backend-template/images/layout_img/user_img.jpg';
    $student_name = $userData['student_name'];

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE testimonials SET student_name = ?, profession = ?, feedback = ?, image = ?, status = 'inactive' WHERE user_id = ?");
        $stmt->execute([$student_name, $enroll_info, $feedback, $profile_pic, $user_id]);
        redirect('testimonial.php', 'Your review has been updated and is pending approval!', 'success');
    } else {
        $stmt = $pdo->prepare("INSERT INTO testimonials (user_id, student_name, profession, feedback, image, status) VALUES (?, ?, ?, ?, ?, 'inactive')");
        $stmt->execute([$user_id, $student_name, $enroll_info, $feedback, $profile_pic]);
        redirect('testimonial.php', 'Review submitted! It will be live after approval.', 'success');
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Student Feedback</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8">
      <?php displayAlert(); ?>
      
      <?php if (!$isEnrolled): ?>
         <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> 
            <strong>Enrollment Required:</strong> You need to be enrolled in at least one course to share feedback.
         </div>
      <?php else: ?>
         <div class="white_shd full margin_bottom_30">
            <div class="full graph_head"><div class="heading1 margin_0"><h2>Share Your Journey</h2></div></div>
            <div class="padding_infor_info">
               <form method="POST">
                  <div class="form-group mb-4">
                     <label>Select Your Course / Batch</label>
                     <select name="enroll_info" class="form-control" required>
                        <option value="">-- Choose Course --</option>
                        <?php foreach ($enrollments as $e): ?>
                           <?php $info = "Student of " . $e['course_title'] . ($e['batch_no'] ? " (Batch " . $e['batch_no'] . ")" : ""); ?>
                           <option value="<?php echo $info; ?>" <?php echo ($existing && $existing['profession'] == $info) ? 'selected' : ''; ?>>
                              <?php echo $e['course_title'] . ($e['batch_no'] ? " - Batch " . $e['batch_no'] : ""); ?>
                           </option>
                        <?php endforeach; ?>
                     </select>
                  </div>

                  <div class="form-group mb-4">
                     <label>Your Review</label>
                     <textarea name="feedback" class="form-control" rows="6" placeholder="How was your learning experience?" required><?php echo $existing['feedback'] ?? ''; ?></textarea>
                     <small class="text-muted">Your profile picture and name will be automatically taken from your account settings.</small>
                  </div>

                  <div class="form-group">
                     <button type="submit" name="submit_review" class="btn btn-primary btn-block">Submit for Approval</button>
                  </div>
               </form>
            </div>
         </div>
      <?php endif; ?>
   </div>
   
   <div class="col-md-4">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head"><div class="heading1 margin_0"><h2>Visual Preview</h2></div></div>
         <div class="padding_infor_info text-center">
            <div class="testimonial-preview border p-4 bg-light rounded shadow-sm">
               <img src="../<?php echo $userData['profile_pic'] ?: 'backend-template/images/layout_img/user_img.jpg'; ?>" 
                    width="100" height="100" class="rounded-circle border mb-3" style="object-fit: cover;">
               <h5 class="mb-1"><?php echo $userData['student_name']; ?></h5>
               <p class="small text-primary mb-3"><?php echo $existing['profession'] ?? 'Select course to see label'; ?></p>
               <div class="feedback-box bg-white p-3 rounded italic small text-muted">
                  <?php echo $existing['feedback'] ?? '"Your review content will appear here..."'; ?>
               </div>
            </div>
            
            <div class="mt-4">
               <?php if ($existing): ?>
                  <div class="badge badge-<?php echo ($existing['status'] == 'active') ? 'success' : 'warning'; ?> p-2 px-3">
                     Status: <?php echo ucfirst($existing['status']); ?>
                  </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
