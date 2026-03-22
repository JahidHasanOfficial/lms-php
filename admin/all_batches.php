<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Batch.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('index.php');
}

$batchObj = new Batch($pdo);

// Handle Batch Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_batch'])) {
    $course_id = (int)$_POST['course_id'];
    $batch_no = (int)$_POST['batch_no'];
    $title = sanitize($_POST['title']);
    $status = $_POST['status'];
    $start_date = $_POST['start_date'];
    
    if ($batchObj->create($course_id, $batch_no, $title, $start_date, null, $status)) {
        $msg = "Batch created successfully!";
    }
}

$allBatches = $pdo->query("SELECT b.*, c.title as course_title FROM batches b JOIN courses c ON b.course_id = c.id ORDER BY b.created_at DESC")->fetchAll();
$allCourses = $pdo->query("SELECT id, title FROM courses WHERE status = 'published'")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Global Batch Management</h2>
         <button class="btn btn-success" data-toggle="collapse" data-target="#createBatchForm"><i class="fa fa-plus"></i> Create New Batch</button>
      </div>
   </div>
</div>

<!-- Create Batch Form -->
<div id="createBatchForm" class="collapse <?php echo isset($msg) ? 'show' : ''; ?> row mb-4">
   <div class="col-md-12">
      <div class="white_shd full">
         <div class="padding_infor_info">
            <?php if (isset($msg)): ?>
               <div class="alert alert-success"><?php echo $msg; ?></div>
            <?php endif; ?>
            <form method="POST" class="row">
               <div class="col-md-3 mb-3">
                  <label>Select Course</label>
                  <select name="course_id" class="form-control" required>
                     <option value="">-- Select Course --</option>
                     <?php foreach ($allCourses as $c): ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['title']; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="col-md-2 mb-3">
                  <label>Batch No.</label>
                  <input type="number" name="batch_no" class="form-control" placeholder="1" required>
               </div>
               <div class="col-md-3 mb-3">
                  <label>Batch Title</label>
                  <input type="text" name="title" class="form-control" placeholder="Optional title">
               </div>
               <div class="col-md-2 mb-3">
                  <label>Status</label>
                  <select name="status" class="form-control">
                     <option value="upcoming">Upcoming</option>
                     <option value="active">Active</option>
                  </select>
               </div>
               <div class="col-md-2 mb-3">
                  <label>Action</label>
                  <button type="submit" name="create_batch" class="btn btn-primary btn-block">Create Now</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Active/Upcoming Batches</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Course</th>
                        <th>Batch #</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($allBatches as $batch): ?>
                     <tr>
                        <td><?php echo $batch['id']; ?></td>
                        <td><?php echo $batch['course_title']; ?></td>
                        <td>Batch <?php echo $batch['batch_no']; ?></td>
                        <td>
                           <span class="badge badge-<?php echo ($batch['status'] === 'active') ? 'success' : 'info'; ?>">
                              <?php echo ucfirst($batch['status']); ?>
                           </span>
                        </td>
                        <td><?php echo $batch['start_date'] ?: 'N/A'; ?></td>
                        <td>
                           <a href="batches.php?course_id=<?php echo $batch['course_id']; ?>" class="btn btn-primary btn-xs">Manage</a>
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
