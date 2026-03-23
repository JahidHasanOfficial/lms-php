<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin')) {
    redirect('../login.php');
}

// Handle Add Coupon
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_coupon'])) {
    $code = sanitize($_POST['code']);
    $type = $_POST['type'];
    $val = (float)$_POST['value'];
    $expiry = $_POST['expiry'];
    $limit = (int)$_POST['usage_limit'];
    
    $stmt = $pdo->prepare("INSERT INTO coupons (code, discount_type, discount_value, expiry_date, usage_limit, status) VALUES (?, ?, ?, ?, ?, 'active')");
    if ($stmt->execute([$code, $type, $val, $expiry, $limit])) {
        redirect('coupons.php', 'Coupon created successfully!', 'success');
    }
}

// Handle Edit Coupon
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_coupon'])) {
    $id = (int)$_POST['coupon_id'];
    $code = sanitize($_POST['code']);
    $type = $_POST['type'];
    $val = (float)$_POST['value'];
    $expiry = $_POST['expiry'];
    $limit = (int)$_POST['usage_limit'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE coupons SET code = ?, discount_type = ?, discount_value = ?, expiry_date = ?, usage_limit = ?, status = ? WHERE id = ?");
    if ($stmt->execute([$code, $type, $val, $expiry, $limit, $status, $id])) {
        redirect('coupons.php', 'Coupon updated successfully!', 'success');
    }
}

// Fetch all coupons
$coupons = $pdo->query("SELECT * FROM coupons ORDER BY created_at DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Coupon Management (P-02)</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addCouponModal"><i class="fa fa-plus"></i> Create New Coupon</button>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Expiry</th>
                        <th>Used Count</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($coupons as $c): ?>
                     <tr>
                        <td><strong><?php echo $c['code']; ?></strong></td>
                        <td><?php echo ($c['discount_type'] === 'percent') ? $c['discount_value'].'%' : '$'.$c['discount_value']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($c['expiry_date'])); ?></td>
                        <td><?php echo $c['used_count']; ?> / <?php echo $c['usage_limit']; ?></td>
                        <td><span class="badge badge-<?php echo ($c['status'] === 'active') ? 'success' : 'secondary'; ?>"><?php echo ucfirst($c['status']); ?></span></td>
                        <td>
                           <button class="btn btn-info btn-xs edit-coupon" 
                              data-id="<?php echo $c['id']; ?>"
                              data-code="<?php echo $c['code']; ?>"
                              data-type="<?php echo $c['discount_type']; ?>"
                              data-value="<?php echo $c['discount_value']; ?>"
                              data-expiry="<?php echo $c['expiry_date']; ?>"
                              data-limit="<?php echo $c['usage_limit']; ?>"
                              data-status="<?php echo $c['status']; ?>"
                              ><i class="fa fa-edit"></i> </button>
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

<!-- Add Modal -->
<div class="modal fade" id="addCouponModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Create Coupon</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form method="POST">
            <div class="modal-body">
               <div class="mb-3">
                  <label>Promo Code</label>
                  <input type="text" name="code" class="form-control" required placeholder="SAVE20">
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label>Type</label>
                     <select name="type" class="form-control">
                        <option value="percent">Percentage (%)</option>
                        <option value="fixed">Fixed Amount ($)</option>
                     </select>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Discount Value</label>
                     <input type="number" name="value" class="form-control" required placeholder="20">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label>Expiry Date</label>
                     <input type="date" name="expiry" class="form-control" required>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Usage Limit (Count)</label>
                     <input type="number" name="usage_limit" class="form-control" required value="100">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" name="add_coupon" class="btn btn-primary">Create Now</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCouponModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Coupon</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form method="POST">
            <input type="hidden" name="coupon_id" id="edit_id">
            <div class="modal-body">
               <div class="mb-3">
                  <label>Promo Code</label>
                  <input type="text" name="code" id="edit_code" class="form-control" required>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label>Type</label>
                     <select name="type" id="edit_type" class="form-control">
                        <option value="percent">Percentage (%)</option>
                        <option value="fixed">Fixed Amount ($)</option>
                     </select>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Discount Value</label>
                     <input type="number" name="value" id="edit_value" class="form-control" required>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label>Expiry Date</label>
                     <input type="date" name="expiry" id="edit_expiry" class="form-control" required>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Usage Limit (Count)</label>
                     <input type="number" name="usage_limit" id="edit_limit" class="form-control" required>
                  </div>
               </div>
               <div class="mb-3">
                  <label>Status</label>
                  <select name="status" id="edit_status" class="form-control">
                     <option value="active">Active</option>
                     <option value="inactive">Inactive</option>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" name="update_coupon" class="btn btn-primary">Update Changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
<script>
$(document).ready(function(){
   $('.edit-coupon').click(function(){
      $('#edit_id').val($(this).data('id'));
      $('#edit_code').val($(this).data('code'));
      $('#edit_type').val($(this).data('type'));
      $('#edit_value').val($(this).data('value'));
      $('#edit_expiry').val($(this).data('expiry'));
      $('#edit_limit').val($(this).data('limit'));
      $('#edit_status').val($(this).data('status'));
      $('#editCouponModal').modal('show');
   });
});
</script>
