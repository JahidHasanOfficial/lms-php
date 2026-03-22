<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

$stmt = $pdo->query("SELECT p.*, u.name as user_name, c.title as course_title 
                    FROM payments p 
                    JOIN users u ON p.user_id = u.id 
                    JOIN courses c ON p.course_id = c.id 
                    ORDER BY p.created_at DESC");
$payments = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Payment Transactions</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Payments</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Course</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($payments as $pay): ?>
                     <tr>
                        <td><?php echo $pay['id']; ?></td>
                        <td><?php echo $pay['user_name']; ?></td>
                        <td><?php echo $pay['course_title']; ?></td>
                        <td>$<?php echo $pay['amount']; ?></td>
                        <td><span class="badge badge-info"><?php echo strtoupper($pay['method']); ?></span></td>
                        <td><span class="badge badge-<?php echo ($pay['status'] === 'success') ? 'success' : 'warning'; ?>"><?php echo ucfirst($pay['status']); ?></span></td>
                        <td><?php echo date('M d, Y', strtotime($pay['created_at'])); ?></td>
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
