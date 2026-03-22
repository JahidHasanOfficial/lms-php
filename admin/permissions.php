<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || !hasPermission('manage_rbac')) {
    redirect('index.php');
}

$stmt = $pdo->query("SELECT * FROM permissions ORDER BY module, name");
$perms = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Permission Directory</h2>
         <button class="btn btn-info btn-sm"><i class="fa fa-plus"></i> New Permission</button>
      </div>
   </div>
</div>

<div class="row">
   <?php 
   $current_module = ''; 
   foreach ($perms as $perm): 
      if ($current_module != $perm['module']):
         $current_module = $perm['module'];
   ?>
      <div class="col-md-4 mb-4">
         <div class="white_shd full margin_bottom_30 h-100">
            <div class="full graph_head bg-light">
               <div class="heading1 margin_0">
                  <h2 class="text-primary text-capitalize"><?php echo $current_module; ?> Module</h2>
               </div>
            </div>
            <div class="padding_infor_info">
               <ul class="list-group list-group-flush">
                  <?php foreach ($perms as $p): 
                     if ($p['module'] == $current_module): ?>
                     <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0 bg-transparent">
                        <code><?php echo $p['slug']; ?></code>
                        <span class="small text-muted"><?php echo $p['name']; ?></span>
                     </li>
                  <?php endif; endforeach; ?>
               </ul>
            </div>
         </div>
      </div>
   <?php endif; endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
