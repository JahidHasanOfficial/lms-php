<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$ticket_id = $_GET['id'] ?? null;
if (!$ticket_id) redirect('support.php');

// Fetch Ticket
$stmt = $pdo->prepare("SELECT * FROM support_tickets WHERE id = ? AND user_id = ?");
$stmt->execute([$ticket_id, $_SESSION['user_id']]);
$ticket = $stmt->fetch();

if (!$ticket) redirect('support.php');

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Ticket Details #<?php echo $ticket['id']; ?></h2>
         <a href="support.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Support</a>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8 offset-md-2">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head d-flex justify-content-between">
            <div class="heading1 margin_0">
               <h2><?php echo $ticket['subject']; ?></h2>
            </div>
            <span class="badge badge-<?php echo ($ticket['status'] == 'open') ? 'warning' : 'success'; ?> p-2"><?php echo ucfirst($ticket['status']); ?></span>
         </div>
         <div class="padding_infor_info p-5">
            <div class="message-box bg-light p-4 rounded border mb-4">
               <div class="small text-muted mb-2">You wrote on <?php echo date('M d, Y h:i A', strtotime($ticket['created_at'])); ?>:</div>
               <p class="mb-0"><?php echo nl2br($ticket['message']); ?></p>
            </div>

            <!-- Admin Response Mock -->
            <div class="message-box p-4 rounded border-primary bg-white shadow-sm">
               <div class="d-flex align-items-center mb-3">
                  <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                     <i class="fa fa-user"></i>
                  </div>
                  <div>
                     <h6 class="mb-0 font-weight-bold">Support Team Response</h6>
                     <small class="text-muted">Prime University Mentor</small>
                  </div>
               </div>
               <p class="mb-0 italic text-secondary">
                  Our team is reviewing your ticket. We usually respond within 2-4 hours. Thank you for your patience!
               </p>
            </div>
         </div>
         <div class="modal-footer bg-light border-0">
            <a href="https://wa.me/8801700000000" class="btn btn-success btn-sm"><i class="fa fa-whatsapp"></i> Still Unsolved? Chat on WhatsApp</a>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>

