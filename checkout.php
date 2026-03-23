<?php
require_once 'config/session.php';
require_once 'classes/Course.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$course_id = (int)$_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

if (!$course) redirect('index.php');

$price = $course['discount_price'] ?: $course['price'];
$coupon_discount = 0;
$final_total = $price;

// Handle Promo Code (Simple logic)
if (isset($_POST['apply_coupon'])) {
    $code = sanitize($_POST['coupon_code']);
    $stmt_cp = $pdo->prepare("SELECT * FROM coupons WHERE code = ? AND status = 'active' AND expiry_date >= CURDATE()");
    $stmt_cp->execute([$code]);
    $cp = $stmt_cp->fetch();
    
    if ($cp) {
        if ($cp['discount_type'] === 'percent') {
            $coupon_discount = ($price * $cp['discount_value']) / 100;
        } else {
            $coupon_discount = $cp['discount_value'];
        }
        $final_total = $price - $coupon_discount;
        $success = "Coupon applied! Discount: $$coupon_discount";
    } else {
        $error = "Invalid or expired coupon.";
    }
}

// Handle Payment (Mock P-01)
if (isset($_POST['pay_now'])) {
    $method = $_POST['payment_method'];
    $amount = (float)$_POST['final_amount'];
    $txid = 'TXN-'.time();
    
    // Enroll logic after "successful" payment
    $pdo->prepare("INSERT INTO enrollments (user_id, course_id, payment_status, progress_percent) VALUES (?, ?, 'completed', 0)")
        ->execute([$_SESSION['user_id'], $course_id]);
    
    $pdo->prepare("INSERT INTO payments (user_id, course_id, amount, method, transaction_id, status) VALUES (?, ?, ?, ?, ?, 'success')")
        ->execute([$_SESSION['user_id'], $course_id, $amount, $method, $txid]);
        
    redirect(DASHBOARD_URL . 'index.php', "Payment Success! Transaction ID: $txid", 'success');
}

include 'includes/header.php';
?>

<div class="checkout-premium py-5" style="background-color: #ffffff; color: #1e293b; min-height: 100vh;">
    <div class="container py-4">
        <!-- Page Title -->
        <div class="text-center mb-5">
            <h1 class="font-weight-bold" style="color: #1e293b; font-size: 2.5rem;">Complete your Enrollment</h1>
            <p class="text-muted" style="font-size: 1.1rem;">You're just a moment away from accessing premium course</p>
        </div>

        <div class="row">
            <!-- Left Column: Order & Coupon -->
            <div class="col-lg-7">
                <p class="small text-muted mb-4" style="max-width: 500px;">Please review your course details and select your preferred payment gateway to complete your enrollment. If you have a promo or affiliate code, apply it below.</p>
                
                <!-- Order Item Card -->
                <div class="card mb-4 border-0 shadow-sm" style="background-color: #ffffff; border-radius: 12px; border: 1px solid rgba(0,0,0,0.08);">
                    <div class="card-body p-4">
                        <h6 class="text-dark mb-4" style="font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Order Details</h6>
                        <div class="d-flex align-items-center flex-wrap flex-md-nowrap">
                            <img src="<?php echo $course['thumbnail']; ?>" class="rounded mb-3 mb-md-0 mr-md-4 shadow-sm" style="width: 160px; height: 90px; object-fit: cover; border: 1px solid rgba(0,0,0,0.05);">
                            <div class="flex-grow-1">
                                <h5 class="mb-1 text-dark font-weight-bold"><?php echo $course['title']; ?></h5>
                                <div class="mb-3">
                                    <?php 
                                        $stmt_b = $pdo->prepare("SELECT title, batch_no FROM batches WHERE course_id = ? AND status IN ('active', 'upcoming') ORDER BY batch_no DESC LIMIT 1");
                                        $stmt_b->execute([$course_id]);
                                        $batch_data = $stmt_b->fetch();
                                        $batch_name = $batch_data ? ($batch_data['title'] ?: 'Batch-' . $batch_data['batch_no']) : 'Main Batch';
                                        
                                        $stmt_l = $pdo->prepare("SELECT COUNT(*) FROM lessons l JOIN course_sections s ON l.section_id = s.id WHERE s.course_id = ?");
                                        $stmt_l->execute([$course_id]);
                                        $lesson_count = $stmt_l->fetchColumn();

                                        $stmt_a = $pdo->prepare("SELECT COUNT(*) FROM assignments WHERE course_id = ?");
                                        $stmt_a->execute([$course_id]);
                                        $assignment_count = $stmt_a->fetchColumn();
                                    ?>
                                    <span class="badge badge-success small py-1 px-2 mr-2" style="background-color: #27ae60; font-weight: 500;"><?php echo $batch_name; ?></span>
                                    <span class="text-warning small">
                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i>
                                        <span class="text-muted ml-1" style="font-weight: 500;">4.8 (120+ Reviews)</span>
                                    </span>
                                </div>
                                <div class="d-flex flex-wrap align-items-center small text-muted">
                                    <div class="mr-4 mb-2 d-flex align-items-center">
                                        <i class="fa fa-play-circle mr-2 text-primary" style="font-size: 14px;"></i>
                                        <span><?php echo $lesson_count; ?> Lessons</span>
                                    </div>
                                    <div class="mr-4 mb-2 d-flex align-items-center">
                                        <i class="fa fa-file-text-o mr-2 text-info" style="font-size: 14px;"></i>
                                        <span><?php echo $assignment_count; ?> Assignments</span>
                                    </div>
                                    <div class="mb-2 d-flex align-items-center">
                                        <i class="fa fa-infinity mr-2 text-success" style="font-size: 14px;"></i>
                                        <span>Lifetime access</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coupon Section -->
                <div class="mb-5 p-4 border rounded shadow-sm" style="background-color: #f8fafc; border-color: rgba(0,0,0,0.05);">
                    <h6 class="text-dark mb-3" style="font-weight: 600;">Promo Code</h6>
                    <?php if ($coupon_discount > 0): ?>
                        <!-- Applied Coupon Style -->
                        <div class="p-3 rounded mb-3 d-flex align-items-center justify-content-between" style="background-color: rgba(39, 174, 96, 0.08); border: 1px dashed #27ae60;">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 8px;">
                                    <i class="fa fa-ticket text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-success font-weight-bold">Coupon Applied</h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($_POST['coupon_code']); ?> - successfully verified</small>
                                </div>
                            </div>
                            <a href="checkout.php?id=<?php echo $course_id; ?>" class="text-muted hover:text-danger" title="Remove coupon"><i class="fa fa-times"></i></a>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="mb-0">
                        <div class="input-group checkout-input-group shadow-sm">
                            <input type="text" name="coupon_code" class="form-control" placeholder="Enter promo code" style="border: none; height: 55px; padding-left: 20px; font-weight: 500;">
                            <div class="input-group-append">
                                <button type="submit" name="apply_coupon" class="btn btn-dark px-4" style="font-weight: 600; border-radius: 0 8px 8px 0; min-width: 100px;">Apply</button>
                            </div>
                        </div>
                    </form>
                    <?php if (isset($error)): ?>
                        <small class="text-danger mt-2 d-block ml-1 font-weight-bold"><i class="fa fa-exclamation-circle mr-1"></i> <?php echo $error; ?></small>
                    <?php endif; ?>
                </div>

               
  </div>
            <!-- Right Column: Summary & Payment -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg" style="background-color: #ffffff; border-radius: 12px; border: 1px solid rgba(0,0,0,0.08); overflow: hidden;">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-5 font-weight-bold" style="color: #1e293b;">Order Summary</h4>
                        
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <?php 
                                $regularPrice = $course['price'] > 0 ? $course['price'] : 10000;
                                $platformDiscount = $course['discount_price'] ? ($regularPrice - $course['discount_price']) : 0;
                            ?>
                            <span style="font-weight: 500;">Regular Price</span>
                            <span><del>৳<?php echo number_format($regularPrice); ?></del></span>
                        </div>
                        <?php if ($platformDiscount > 0): ?>
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span style="font-weight: 500;">Platform Discount</span>
                            <span style="font-weight: 600;">-৳<?php echo number_format($platformDiscount); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($coupon_discount > 0): ?>
                            <div class="d-flex justify-content-between mb-3 text-success">
                                <span style="font-weight: 500;">Coupon Discount</span>
                                <span style="font-weight: 600;">-৳<?php echo number_format($coupon_discount); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <hr style="border-top: 1px solid rgba(0,0,0,0.08);">
                        
                        <div class="d-flex justify-content-between mb-5 align-items-center">
                            <h4 class="mb-0 text-dark font-weight-bold">Total Amount</h4>
                            <h4 class="mb-0 font-weight-bold" style="color: #27ae60;">৳<?php echo number_format($final_total); ?>.00</h4>
                        </div>

                        <!-- Payment Gateways Mock -->
                        <h6 class="text-dark mb-3 font-weight-bold">Payment Method</h6>
                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="payment-card d-block p-3 rounded text-center border cursor-pointer active" style="background-color: #f8fafc; border-color: #27ae60; transition: 0.3s;">
                                    <input type="radio" name="payment_method" value="sslcommerz" checked style="display:none;">
                                    <div class="bg-primary text-white rounded-circle mb-2 mx-auto d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-weight: bold; font-family: sans-serif;">SSL</div>
                                    <span class="small font-weight-bold d-block text-dark">SSL Commerz</span>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="payment-card d-block p-3 rounded text-center border cursor-pointer" style="background-color: #f8fafc; border-color: rgba(0,0,0,0.08); transition: 0.3s;">
                                    <input type="radio" name="payment_method" value="stripe" style="display:none;">
                                    <span class="text-primary d-block mb-1" style="font-weight: 900; letter-spacing: -1px; font-style: italic; font-size: 1.2rem;">stripe</span>
                                    <span class="small font-weight-bold d-block text-muted">International Cards</span>
                                </label>
                            </div>
                        </div>

                        <form method="POST">
                            <input type="hidden" name="final_amount" value="<?php echo $final_total; ?>">
                            <input type="hidden" name="payment_method" value="sslcommerz" id="selected_method">
                            <button type="submit" name="pay_now" class="btn btn-primary btn-block py-3 font-weight-bold shadow" style="background-color: #1e293b; border: none; border-radius: 8px; font-size: 1.1rem; color: #fff;">
                                Pay Now & Enroll <i class="fa fa-lock ml-2"></i>
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p class="small text-muted"><i class="fa fa-shield mr-1"></i> Highly secure encrypted transaction</p>
                            <img src="https://securepay.sslcommerz.com/gw/asset/img/footer/pay.png" class="img-fluid mt-2 opacity-75" style="max-height: 20px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
.payment-card:hover, .payment-card.active { border-color: #27ae60 !important; background-color: rgba(39, 174, 96, 0.05) !important; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
.gap-2 { gap: 0.5rem; }
.gap-3 { gap: 1rem; }
.cursor-pointer { cursor: pointer; }
.shadow-lg { box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important; }

.checkout-input-group {
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    transition: all 0.3s;
    height: 55px;
    display: flex;
    align-items: stretch;
}
.checkout-input-group .form-control {
    border: none !important;
    height: 100% !important;
    box-shadow: none !important;
    padding-left: 20px;
}
.checkout-input-group .btn {
    border-radius: 0 !important;
    height: 100% !important;
    min-width: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
</style>
.gap-2 { gap: 0.5rem; }
.gap-3 { gap: 1rem; }
.cursor-pointer { cursor: pointer; }

.payment-method input { position: absolute; top: 10px; right: 10px; }
.payment-method:hover { background-color: #fff; border-color: #03a9f4; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
</style>

<script>
$(document).ready(function(){
    $('.payment-card').click(function(){
        $('.payment-card').removeClass('active');
        $(this).addClass('active');
        $('#selected_method').val($(this).find('input').val());
    });
});
</script>
