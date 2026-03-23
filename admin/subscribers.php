<?php
require_once '../config/session.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM subscribers WHERE id = ?")->execute([$id]);
    redirect('subscribers.php', 'Subscriber removed!', 'success');
}

$subscribers = $pdo->query("SELECT * FROM subscribers ORDER BY id DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between align-items-center">
         <h2>Newsletter Subscribers</h2>
         <span class="badge badge-info badge-pill py-2 px-3"><?php echo count($subscribers); ?> Total Subscriptions</span>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover table-striped">
                  <thead class="thead-dark">
                     <tr>
                        <th>#</th>
                        <th>Email Address</th>
                        <th>Subscription Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $count = 1; foreach ($subscribers as $s): ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><strong><?php echo htmlspecialchars($s['email']); ?></strong></td>
                        <td><small class="text-muted"><i class="fa fa-clock-o mr-2"></i><?php echo date('d M Y, h:i A', strtotime($s['created_at'])); ?></small></td>
                        <td>
                           <a href="?delete=<?php echo $s['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this subscriber?')">
                              <i class="fa fa-trash"></i> Delete
                           </a>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                     
                     <?php if (empty($subscribers)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-5">No subscribers yet.</td></tr>
                     <?php endif; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
