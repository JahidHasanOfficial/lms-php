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
         <h2>My Progress</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Detailed Learning Stats</h2>
            </div>
         </div>
         <div class="padding_infor_info text-center py-5">
            <i class="fa fa-line-chart fa-5x text-primary mb-4"></i>
            <h3>Your Learning Insights are being calculated! 📊</h3>
            <p class="text-muted">Stay tuned. We're building a comprehensive analytics system to show you exactly where you excel.</p>
            <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
