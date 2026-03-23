<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch open jobs
$jobs = $pdo->query("SELECT jp.*, cp.company_name, cp.logo 
                    FROM job_postings jp 
                    JOIN job_partners cp ON jp.partner_id = cp.id 
                    WHERE jp.status = 'open' 
                    ORDER BY jp.created_at DESC")->fetchAll();

// Handle Application
if (isset($_POST['apply_job'])) {
    $job_id = (int)$_POST['job_id'];
    $stmt = $pdo->prepare("INSERT INTO job_applications (job_id, user_id, status) VALUES (?, ?, 'applied')");
    if ($stmt->execute([$job_id, $user_id])) {
        $success = "Application submitted successfully! Good luck.";
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Job Placement & Career Opportunities (3.8)</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12 mb-4">
      <div class="alert alert-info border-0 shadow-sm rounded-lg d-flex align-items-center">
         <i class="fa fa-briefcase fa-2x mr-3"></i>
         <div>
            <h5 class="mb-0 font-weight-bold">Unlock Career Opportunities!</h5>
            <p class="mb-0 small">These jobs are exclusive to learners who have completed our courses.</p>
         </div>
      </div>
   </div>

   <?php foreach ($jobs as $job): ?>
      <div class="col-md-6 mb-4">
         <div class="white_shd full h-100 shadow-sm border-0 rounded overflow-hidden">
            <div class="padding_infor_info p-4">
               <div class="media">
                  <img src="../<?php echo $job['logo'] ?: 'backend-template/images/layout_img/user_img.jpg'; ?>" class="mr-3 rounded shadow-sm" width="60" height="60">
                  <div class="media-body">
                     <h5 class="mb-1 font-weight-bold text-dark"><?php echo $job['title']; ?></h5>
                     <p class="mb-2 text-primary small font-weight-bold"><?php echo $job['company_name']; ?></p>
                     
                     <div class="d-flex flex-wrap mb-3">
                        <span class="badge badge-light border mr-2 mb-2"><i class="fa fa-map-marker mr-1"></i> <?php echo $job['location']; ?></span>
                        <span class="badge badge-light border mr-2 mb-2"><i class="fa fa-clock-o mr-1"></i> <?php echo ucfirst(str_replace('_', ' ', $job['job_type'])); ?></span>
                        <span class="badge badge-light border mb-2"><i class="fa fa-money mr-1"></i> <?php echo $job['salary_range']; ?></span>
                     </div>
                     
                     <p class="small text-muted mb-4"><?php echo substr($job['description'], 0, 150); ?>...</p>
                     
                     <form method="POST">
                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                        <button type="submit" name="apply_job" class="btn btn-outline-primary btn-sm px-4 rounded-pill">Apply Now <i class="fa fa-arrow-right ml-1"></i></button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
