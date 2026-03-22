<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('index.php');
}

$stmt = $pdo->query("SELECT e.*, u.name as user_name, c.title as course_title, b.batch_no 
                    FROM enrollments e 
                    JOIN users u ON e.user_id = u.id 
                    JOIN courses c ON e.course_id = c.id 
                    LEFT JOIN batches b ON e.batch_id = b.id
                    ORDER BY e.enrollment_date DESC");
$enrollments = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Course Enrollments</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Enrolled Students</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Enrolled At</th>
                        <th>Progress</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($enrollments as $enroll): ?>
                     <tr>
                        <td><?php echo $enroll['id']; ?></td>
                        <td><?php echo $enroll['user_name']; ?></td>
                        <td><?php echo $enroll['course_title']; ?></td>
                        <td>Batch <?php echo $enroll['batch_no'] ?: '1'; ?></td>
                        <td><?php echo date('M d, Y', strtotime($enroll['enrollment_date'])); ?></td>
                        <td>
                           <div class="progress progress-xs">
                              <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $enroll['progress_percent']; ?>%" aria-valuenow="<?php echo $enroll['progress_percent']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                           </div>
                           <small><?php echo $enroll['progress_percent']; ?>%</small>
                        </td>
                        <td><span class="badge badge-success"><?php echo ucfirst($enroll['payment_status']); ?></span></td>
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
