<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Category.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

$categoryObj = new Category($pdo);
$categories = $categoryObj->getAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Category Management</h2>
         <a href="add_category.php" class="btn btn-success"><i class="fa fa-plus"></i> Add New Category</a>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Categories</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Created At</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($categories as $cat): ?>
                     <tr>
                        <td><?php echo $cat['id']; ?></td>
                        <td><img src="../<?php echo $cat['image'] ?: 'assets/img/cat-1.jpg'; ?>" width="60" class="rounded shadow-sm"></td>
                        <td><?php echo $cat['name']; ?></td>
                        <td><?php echo $cat['slug']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($cat['created_at'])); ?></td>
                        <td>
                           <button class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>
                           <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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

