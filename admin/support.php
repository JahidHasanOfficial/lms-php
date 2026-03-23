<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['user_role'];

if ($role === 'admin' || $role === 'instructor') {
    // Admins see all tickets
    $stmt = $pdo->prepare("SELECT s.*, u.name as user_name FROM support_tickets s JOIN users u ON s.user_id = u.id ORDER BY s.created_at DESC");
    $stmt->execute();
} else {
    // Learners see only their own tickets
    $stmt = $pdo->prepare("SELECT s.*, u.name as user_name FROM support_tickets s JOIN users u ON s.user_id = u.id WHERE s.user_id = ? ORDER BY s.created_at DESC");
    $stmt->execute([$user_id]);
}
$tickets = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Support Tickets</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Support Requests</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($tickets as $ticket): ?>
                     <tr>
                        <td><?php echo $ticket['id']; ?></td>
                        <td><?php echo $ticket['user_name']; ?></td>
                        <td><?php echo $ticket['subject']; ?></td>
                        <td><span class="badge badge-<?php echo ($ticket['status'] === 'open') ? 'success' : 'secondary'; ?>"><?php echo ucfirst($ticket['status']); ?></span></td>
                        <td><?php echo date('M d, Y', strtotime($ticket['created_at'])); ?></td>
                        <td>
                           <a href="view_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-primary btn-xs">View/Reply</a>
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
