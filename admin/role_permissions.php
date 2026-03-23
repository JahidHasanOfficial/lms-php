<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || !hasPermission('manage_rbac')) {
    redirect('index.php');
}

$role_id = $_GET['id'] ?? null;
if (!$role_id) redirect('roles.php');

// Fetch Role
$stmt = $pdo->prepare("SELECT * FROM roles WHERE id = ?");
$stmt->execute([$role_id]);
$role = $stmt->fetch();
if (!$role) redirect('roles.php');

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_permissions = $_POST['permissions'] ?? [];
    
    // Clear existing
    $pdo->prepare("DELETE FROM role_permissions WHERE role_id = ?")->execute([$role_id]);
    
    // Insert new
    foreach ($selected_permissions as $pid) {
        $pdo->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)")
            ->execute([$role_id, $pid]);
    }
    
    // Clear session permissions for current user if they are this role
    if ($_SESSION['user_role'] === $role['slug']) {
        unset($_SESSION['permissions']);
    }
    
    redirect('role_permissions.php?id='.$role_id, "Permissions for " . $role['name'] . " updated successfully!", 'success');
}

// Fetch all permissions grouped by module
$stmt = $pdo->query("SELECT * FROM permissions ORDER BY module, name");
$all_permissions = $stmt->fetchAll();

// Fetch currently assigned permissions
$stmt = $pdo->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
$stmt->execute([$role_id]);
$assigned_perms = $stmt->fetchAll(PDO::FETCH_COLUMN);

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Permission Assignment: <?php echo $role['name']; ?></h2>
         <a href="roles.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Roles</a>
      </div>
   </div>
</div>

<?php displayAlert(); ?>

<form action="" method="POST">
   <div class="row">
      <?php 
      $current_module = ''; 
      foreach ($all_permissions as $perm): 
         if ($current_module != $perm['module']):
            $current_module = $perm['module'];
      ?>
         <div class="col-md-6 mb-4">
            <div class="white_shd full margin_bottom_30">
               <div class="full graph_head bg-light">
                  <div class="heading1 margin_0">
                     <h2 class="text-primary text-capitalize"><?php echo $current_module; ?> Module</h2>
                  </div>
               </div>
               <div class="padding_infor_info">
                  <div class="list-group list-group-flush">
                     <?php foreach ($all_permissions as $p): 
                        if ($p['module'] == $current_module): ?>
                        <div class="list-group-item d-flex align-items-center py-3">
                           <input type="checkbox" name="permissions[]" value="<?php echo $p['id']; ?>" id="p<?php echo $p['id']; ?>" 
                                  class="mr-3" style="width: 20px; height: 20px;"
                                  <?php echo in_array($p['id'], $assigned_perms) ? 'checked' : ''; ?>>
                           <label for="p<?php echo $p['id']; ?>" class="mb-0 cursor-pointer">
                              <strong><?php echo $p['name']; ?></strong><br>
                              <small class="text-muted"><?php echo $p['slug']; ?></small>
                           </label>
                        </div>
                     <?php endif; endforeach; ?>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; endforeach; ?>
   </div>

   <div class="row mb-5">
      <div class="col-12">
         <div class="white_shd full p-4 text-center">
            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm"><i class="fa fa-save mr-2"></i> Save Permissions for <?php echo $role['name']; ?></button>
         </div>
      </div>
   </div>
</form>

<?php include 'includes/footer.php'; ?>
