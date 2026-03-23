<?php
require_once '../config/session.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Status Update
if (isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = sanitize($_POST['status']);
    $pdo->prepare("UPDATE consultation_requests SET status = ? WHERE id = ?")->execute([$status, $id]);
    redirect('consultations.php', 'Status updated successfully!', 'success');
}

// Filtering Logic
$where_clauses = [];
$params = [];

if (isset($_GET['start_date']) && $_GET['start_date'] != '') {
    $where_clauses[] = "DATE(cr.created_at) >= ?";
    $params[] = $_GET['start_date'];
}
if (isset($_GET['end_date']) && $_GET['end_date'] != '') {
    $where_clauses[] = "DATE(cr.created_at) <= ?";
    $params[] = $_GET['end_date'];
}
if (isset($_GET['course_id']) && $_GET['course_id'] != '') {
    $where_clauses[] = "cr.course_id = ?";
    $params[] = (int)$_GET['course_id'];
}
if (isset($_GET['batch_id']) && $_GET['batch_id'] != '') {
    $where_clauses[] = "cr.batch_id = ?";
    $params[] = (int)$_GET['batch_id'];
}
if (isset($_GET['status']) && $_GET['status'] != '') {
    $where_clauses[] = "cr.status = ?";
    $params[] = $_GET['status'];
}

$where_sql = $where_clauses ? "WHERE " . implode(" AND ", $where_clauses) : "";
$query = "SELECT cr.*, c.title as course_title, b.batch_no FROM consultation_requests cr 
          LEFT JOIN courses c ON cr.course_id = c.id 
          LEFT JOIN batches b ON cr.batch_id = b.id
          $where_sql ORDER BY cr.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$consultations = $stmt->fetchAll();

// Fetch courses and batches for filter
$all_courses = $pdo->query("SELECT id, title FROM courses ORDER BY title ASC")->fetchAll();
$all_batches = (isset($_GET['course_id']) && $_GET['course_id'] != '') 
    ? $pdo->prepare("SELECT id, batch_no FROM batches WHERE course_id = ?") 
    : null;
if ($all_batches) {
    $all_batches->execute([$_GET['course_id']]);
    $batches_filter = $all_batches->fetchAll();
} else {
    $batches_filter = [];
}

function getStatusBadgeClass($status) {
    switch(strtolower($status)) {
        case 'busy': return 'badge-secondary';
        case 'contacted': return 'badge-info';
        case 'interested': return 'badge-success';
        case 'nointerest': return 'badge-danger';
        default: return 'badge-warning';
    }
}
include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Consultation Requests & Reporting</h2>
         <p>Manage prospective students and lead inquiries.</p>
      </div>
   </div>
</div>

<!-- Search and Filter Form -->
<div class="row mb-5">
    <div class="col-md-12">
        <div class="white_shd full">
            <div class="padding_infor_info">
                <form method="GET" class="row align-items-end g-2">
                    <div class="col-md-2 form-group">
                        <label class="small font-weight-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="<?php echo $_GET['start_date'] ?? ''; ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="small font-weight-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="<?php echo $_GET['end_date'] ?? ''; ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="small font-weight-bold">Course Filter</label>
                        <select name="course_id" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">All Courses</option>
                            <?php foreach($all_courses as $c): ?>
                                <option value="<?php echo $c['id']; ?>" <?php echo (isset($_GET['course_id']) && $_GET['course_id'] == $c['id']) ? 'selected' : ''; ?>><?php echo $c['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="small font-weight-bold">Batch Filter</label>
                        <select name="batch_id" class="form-control form-control-sm">
                            <option value="">All Batches</option>
                            <?php if(!empty($batches_filter)): ?>
                                <?php foreach($batches_filter as $b): ?>
                                    <option value="<?php echo $b['id']; ?>" <?php echo (isset($_GET['batch_id']) && $_GET['batch_id'] == $b['id']) ? 'selected' : ''; ?>>Batch <?php echo $b['batch_no']; ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Select Course First</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="small font-weight-bold">Status Filter</label>
                        <select name="status" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="New" <?php echo (isset($_GET['status']) && $_GET['status'] == 'New') ? 'selected' : ''; ?>>New</option>
                            <option value="Busy" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Busy') ? 'selected' : ''; ?>>Busy</option>
                            <option value="Contacted" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Contacted') ? 'selected' : ''; ?>>Contacted</option>
                            <option value="Interested" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Interested') ? 'selected' : ''; ?>>Interested</option>
                            <option value="NoInterest" <?php echo (isset($_GET['status']) && $_GET['status'] == 'NoInterest') ? 'selected' : ''; ?>>No Interest</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <button type="submit" class="btn btn-primary btn-sm px-3">Search <i class="fa fa-search shadow-sm"></i></button>
                        <a href="consultations.php" class="btn btn-outline-secondary btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php displayAlert(); ?>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Results: <span class="text-primary"><?php echo count($consultations); ?> Leads Found</span></h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover table-striped">
                  <thead class="thead-dark">
                     <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course Interest</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (empty($consultations)): ?>
                        <tr><td colspan="6" class="text-center font-weight-bold p-5">No consultation requests found yet.</td></tr>
                     <?php endif; ?>
                     <?php foreach ($consultations as $row): ?>
                     <tr>
                        <td><?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></td>
                        <td><strong><?php echo $row['name']; ?></strong></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><a href="tel:<?php echo $row['phone']; ?>" class="btn btn-outline-success btn-sm"><i class="fa fa-phone"></i> <?php echo $row['phone']; ?></a></td>
                        <td>
                           <span class="badge badge-info"><?php echo $row['course_title'] ?: 'General'; ?></span>
                           <?php if($row['batch_no']): ?>
                              <span class="badge badge-dark">Batch <?php echo $row['batch_no']; ?></span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <form method="POST" class="d-flex align-items-center">
                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                              <select name="status" class="form-control form-control-sm mr-2" style="width: 120px;" onchange="this.form.submit()">
                                 <option value="New" <?php echo $row['status'] == 'New' ? 'selected' : ''; ?>>New</option>
                                 <option value="Busy" <?php echo $row['status'] == 'Busy' ? 'selected' : ''; ?>>Busy</option>
                                 <option value="Contacted" <?php echo $row['status'] == 'Contacted' ? 'selected' : ''; ?>>Contacted</option>
                                 <option value="Interested" <?php echo $row['status'] == 'Interested' ? 'selected' : ''; ?>>Interested</option>
                                 <option value="NoInterest" <?php echo $row['status'] == 'NoInterest' ? 'selected' : ''; ?>>No Interest</option>
                              </select>
                              <input type="hidden" name="update_status" value="1">
                              <span class="badge <?php echo getStatusBadgeClass($row['status']); ?>"><?php echo $row['status']; ?></span>
                           </form>
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
