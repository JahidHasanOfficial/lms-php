<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Course.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>My Certificates</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Verified Achievements</h2>
            </div>
         </div>
         <div class="padding_infor_info text-center py-5">
            <i class="fa fa-certificate fa-5x text-warning mb-4"></i>
            <h3>You haven't earned any certificates yet! 🏆</h3>
            <p class="text-muted">Finish your courses to unlock your professional certifications and share your success with the world.</p>
            <a href="my-courses.php" class="btn btn-primary mt-3">Continue Learning</a>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
