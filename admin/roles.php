<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || !hasPermission('manage_rbac')) {
    redirect('index.php');
}

$stmt = $pdo->query("SELECT r.*, (SELECT COUNT(*) FROM role_permissions rp WHERE rp.role_id = r.id) as perm_count 
                    FROM roles r ORDER BY r.id ASC");
$roles = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Role Management</h2>
         <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New Role</button>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>System Roles</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                        <th>Slug</th>
                        <th>Permissions</th>
                        <th>Description</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($roles as $role): ?>
                     <tr>
                        <td><?php echo $role['id']; ?></td>
                        <td><strong><?php echo $role['name']; ?></strong></td>
                        <td><code><?php echo $role['slug']; ?></code></td>
                        <td><span class="badge badge-info"><?php echo $role['perm_count']; ?> Assigned</span></td>
                        <td><?php echo $role['description']; ?></td>
                        <td>
                           <a href="role_permissions.php?id=<?php echo $role['id']; ?>" class="btn btn-warning btn-xs" title="Manage Permissions"><i class="fa fa-lock"></i> Permissions</a>
                           <button class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>
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
