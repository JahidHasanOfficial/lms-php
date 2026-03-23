<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$ticket_id = $_GET['id'] ?? null;
if (!$ticket_id) redirect('support.php');

// Fetch Ticket
$stmt = $pdo->prepare("SELECT s.*, u.name as user_name, u.email as user_email FROM support_tickets s JOIN users u ON s.user_id = u.id WHERE s.id = ?");
$stmt->execute([$ticket_id]);
$ticket = $stmt->fetch();

if (!$ticket) redirect('support.php');

// Handle Reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_ticket'])) {
    $reply = sanitize($_POST['reply']);
    $status = $_POST['status'];
    
    // In a real system, we'd save to a 'ticket_replies' table
    // For now, we update the ticket status and maybe record the last response
    $stmt = $pdo->prepare("UPDATE support_tickets SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $ticket_id])) {
        redirect('view_ticket.php?id='.$ticket_id, 'Reply sent and status updated!', 'success');
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Ticket #<?php echo $ticket['id']; ?></h2>
         <a href="support.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Tickets</a>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8">
      <!-- Original Message -->
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2><?php echo $ticket['subject']; ?></h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <div class="msg_list_main">
               <ul class="list-unstyled">
                  <li>
                     <span><img src="../backend-template/images/layout_img/user_img.jpg" class="img-responsive rounded-circle" alt="#"></span>
                     <span class="name_user"><?php echo $ticket['user_name']; ?></span>
                     <span class="msg_user"><?php echo $ticket['message']; ?></span>
                     <span class="time_ago"><?php echo date('M d, Y h:i A', strtotime($ticket['created_at'])); ?></span>
                  </li>
               </ul>
            </div>
         </div>
      </div>

      <!-- Reply Box -->
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Response / Reply</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <?php displayAlert(); ?>
            <form method="POST">
               <div class="mb-3">
                  <label>Update Status</label>
                  <select name="status" class="form-control">
                     <option value="open" <?php echo ($ticket['status'] == 'open') ? 'selected' : ''; ?>>Open</option>
                     <option value="in_progress" <?php echo ($ticket['status'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                     <option value="closed" <?php echo ($ticket['status'] == 'closed') ? 'selected' : ''; ?>>Closed / Resolved</option>
                  </select>
               </div>
               <div class="mb-3">
                  <label>Message to User</label>
                  <textarea name="reply" class="form-control" rows="5" required placeholder="Type your response here..."></textarea>
               </div>
               <button type="submit" name="reply_ticket" class="btn btn-primary">Send Reply</button>
            </form>
         </div>
      </div>
   </div>

   <div class="col-md-4">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>User Details</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <p><strong>Name:</strong> <?php echo $ticket['user_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $ticket['user_email']; ?></p>
            <p><strong>Role:</strong> Learner</p>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
