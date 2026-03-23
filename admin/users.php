<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

// Handle Actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    
    if ($action === 'suspend') {
        $pdo->prepare("UPDATE users SET status = 'suspended' WHERE id = ?")->execute([$id]);
        redirect('users.php', 'User suspended successfully.', 'success');
    } elseif ($action === 'activate') {
        $pdo->prepare("UPDATE users SET status = 'active' WHERE id = ?")->execute([$id]);
        redirect('users.php', 'User activated successfully.', 'success');
    } elseif ($action === 'delete') {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
        redirect('users.php', 'User deleted successfully.', 'success');
    }
}

$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$allUsers = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>User Management</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Registered Users</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined At</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($allUsers as $user): ?>
                     <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><span class="badge badge-info"><?php echo ucfirst($user['role']); ?></span></td>
                        <td><span class="badge badge-<?php echo ($user['status'] === 'active') ? 'success' : 'danger'; ?>"><?php echo ucfirst($user['status']); ?></span></td>
                        <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                         <td>
                            <?php if ($user['status'] === 'active'): ?>
                               <a href="users.php?action=suspend&id=<?php echo $user['id']; ?>" class="btn btn-warning btn-xs" title="Suspend"><i class="fa fa-pause"></i></a>
                            <?php else: ?>
                               <a href="users.php?action=activate&id=<?php echo $user['id']; ?>" class="btn btn-success btn-xs" title="Activate"><i class="fa fa-play"></i></a>
                            <?php endif; ?>
                            <a href="users.php?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this user?')" title="Delete"><i class="fa fa-trash"></i></a>
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
