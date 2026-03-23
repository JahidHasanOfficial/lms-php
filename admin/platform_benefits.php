<?php
require_once '../config/session.php';
require_once '../classes/Course.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_benefit'])) {
        $title = sanitize($_POST['title']);
        $icon = sanitize($_POST['icon']);
        $stmt = $pdo->prepare("INSERT INTO platform_benefits (title, icon) VALUES (?, ?)");
        $stmt->execute([$title, $icon]);
        $_SESSION['flash_msg'] = 'Benefit added successfully!';
        header("Location: platform_benefits.php");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM platform_benefits WHERE id = ?")->execute([$id]);
    $_SESSION['flash_msg'] = 'Benefit deleted successfully!';
    header("Location: platform_benefits.php");
    exit();
}

$benefits = $pdo->query("SELECT * FROM platform_benefits")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Platform Benefits Management</h2>
      </div>
   </div>
</div>

<?php if (isset($_SESSION['flash_msg'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['flash_msg']; unset($_SESSION['flash_msg']); ?>
    </div>
<?php endif; ?>

<div class="row">
   <!-- Add Benefit Form -->
   <div class="col-md-4">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Add New Benefit</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <form method="POST">
               <div class="form-group">
                  <label>Benefit Title</label>
                  <input type="text" name="title" class="form-control" placeholder="e.g. Lifetime Access" required>
               </div>
               <div class="form-group">
                  <label>FontAwesome Icon Class</label>
                  <input type="text" name="icon" class="form-control" placeholder="e.g. fa-infinity" required>
                  <small class="text-muted">Use <a href="https://fontawesome.com/v4/icons/" target="_blank">FontAwesome 4.7</a> classes.</small>
               </div>
               <button type="submit" name="add_benefit" class="btn btn-primary btn-block">Add Benefit</button>
            </form>
         </div>
      </div>
   </div>

   <!-- Benefits List -->
   <div class="col-md-8">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Existing Benefits</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover">
                  <thead class="thead-dark">
                     <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($benefits as $b): ?>
                     <tr>
                        <td><i class="fa <?php echo $b['icon']; ?> fa-lg text-success"></i></td>
                        <td><?php echo $b['title']; ?></td>
                        <td>
                           <a href="?delete=<?php echo $b['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
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
