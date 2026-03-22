<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Batch.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('index.php');
}

$course_id = $_GET['course_id'] ?? null;
if (!$course_id) redirect('courses.php');

$batchObj = new Batch($pdo);

// Handle New Batch Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batch_no = (int)$_POST['batch_no'];
    $title = sanitize($_POST['title']);
    $start_date = $_POST['start_date'];
    $status = $_POST['status'];
    
    if ($batchObj->create($course_id, $batch_no, $title, $start_date, null, $status)) {
        $success = "Batch created successfully!";
    }
}

$batches = $batchObj->getByCourse($course_id);

// Get course title
$stmt = $pdo->prepare("SELECT title FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Monitor Batches – <?php echo $course['title']; ?></h2>
         <a href="courses.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Courses</a>
      </div>
   </div>
</div>

<div class="row">
   <!-- Add Batch Form -->
   <div class="col-md-4">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Create New Batch</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <?php if (isset($success)): ?>
               <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST">
               <div class="mb-3">
                  <label class="form-label">Batch Number</label>
                  <input type="number" name="batch_no" class="form-control" required placeholder="Ex: 5">
               </div>
               <div class="mb-3">
                  <label class="form-label">Custom Title (Optional)</label>
                  <input type="text" name="title" class="form-control" placeholder="Ex: Early Bird Batch">
               </div>
               <div class="mb-3">
                  <label class="form-label">Start Date</label>
                  <input type="date" name="start_date" class="form-control">
               </div>
               <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-control">
                     <option value="upcoming">Upcoming</option>
                     <option value="active">Active</option>
                     <option value="completed">Completed</option>
                  </select>
               </div>
               <button type="submit" class="btn btn-primary w-100">Create Batch</button>
            </form>
         </div>
      </div>
   </div>

   <!-- Batch List -->
   <div class="col-md-8">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Existing Batches</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th>Batch #</th>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (empty($batches)): ?>
                        <tr><td colspan="5" class="text-center">No batches found. Create one now!</td></tr>
                     <?php endif; ?>
                     <?php foreach ($batches as $batch): ?>
                     <tr>
                        <td><strong>Batch <?php echo $batch['batch_no']; ?></strong></td>
                        <td><?php echo $batch['title'] ?: '---'; ?></td>
                        <td><?php echo $batch['start_date'] ?: 'Not set'; ?></td>
                        <td>
                           <?php 
                           $badgeClass = 'secondary';
                           if ($batch['status'] === 'active') $badgeClass = 'success';
                           if ($batch['status'] === 'upcoming') $badgeClass = 'info';
                           ?>
                           <span class="badge badge-<?php echo $badgeClass; ?>"><?php echo ucfirst($batch['status']); ?></span>
                        </td>
                        <td>
                           <button class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
