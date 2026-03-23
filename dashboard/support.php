<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];

// Handle New Ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ticket'])) {
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    $stmt = $pdo->prepare("INSERT INTO support_tickets (user_id, subject, message, status) VALUES (?, ?, ?, 'open')");
    if ($stmt->execute([$user_id, $subject, $message])) {
        $success = "Your support ticket has been submitted! Our team will respond soon.";
    }
}

// Fetch user tickets
$stmt = $pdo->prepare("SELECT * FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$tickets = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Support & Helpdesk (S-01, S-02)</h2>
      </div>
   </div>
</div>

<div class="row">
   <!-- Raise Ticket -->
   <div class="col-md-5">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Raise a New Ticket</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <?php if (isset($success)): ?>
               <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST">
               <div class="mb-3">
                  <label class="form-label">Issue Subject</label>
                  <input type="text" name="subject" class="form-control" required placeholder="Ex: Access issue with Python course">
               </div>
               <div class="mb-3">
                  <label class="form-label">Details</label>
                  <textarea name="message" class="form-control" rows="5" required placeholder="Describe your issue in detail..."></textarea>
               </div>
               <button type="submit" name="submit_ticket" class="btn btn-primary w-100">Submit Ticket</button>
            </form>
         </div>
      </div>

      <!-- Quick Contact -->
      <div class="white_shd full margin_bottom_30">
         <div class="padding_infor_info text-center">
            <h5>Need Instant Help?</h5>
            <p class="small text-muted">Join our community or chat with us directly.</p>
            <a href="https://wa.me/8801700000000" target="_blank" class="btn btn-success btn-block mb-2"><i class="fa fa-whatsapp"></i> Chat on WhatsApp</a>
            <a href="mailto:support@interactivecares.com" class="btn btn-outline-info btn-block"><i class="fa fa-envelope"></i> Email Support</a>
         </div>
      </div>
   </div>

   <!-- Ticket List -->
   <div class="col-md-7">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Your Tickets</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (empty($tickets)): ?>
                        <tr><td colspan="4" class="text-center">No active tickets. Everything looks good!</td></tr>
                     <?php endif; ?>
                     <?php foreach ($tickets as $t): ?>
                     <tr>
                        <td>#<?php echo $t['id']; ?></td>
                        <td><strong><?php echo $t['subject']; ?></strong></td>
                        <td>
                           <span class="badge badge-<?php echo ($t['status'] === 'open') ? 'warning' : 'success'; ?>">
                              <?php echo ucfirst($t['status']); ?>
                           </span>
                        </td>
                        <td class="small"><?php echo date('M d, Y', strtotime($t['created_at'])); ?></td>
                        <td>
                           <a href="view_ticket.php?id=<?php echo $t['id']; ?>" class="btn btn-outline-primary btn-xs">View</a>
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
