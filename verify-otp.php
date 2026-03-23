<?php
require_once 'config/session.php';

if (!isset($_SESSION['pending_otp_email'])) {
    redirect('register.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = sanitize($_POST['otp']);
    $email = $_SESSION['pending_otp_email'];

    if ($userObj->verifyOTP($email, $otp)) {
        unset($_SESSION['pending_otp_email']);
        redirect('login.php', 'Email verified successfully! You can now login.', 'success');
    } else {
        $error = 'Invalid OTP code. Please try again.';
    }
}

require_once 'includes/header.php';
?>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Verification</h6>
            <h1 class="mb-5">Verify Your Account</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5 col-md-8 wow fadeInUp" data-wow-delay="0.3s">
                <form action="verify-otp.php" method="POST" class="bg-light p-4 rounded shadow-sm">
                    <?php flash(); ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <p class="text-muted mb-4">A 6-digit OTP has been sent to <strong><?php echo $_SESSION['pending_otp_email']; ?></strong>. Please enter the code below to verify your account.</p>
                    <div class="mb-3">
                        <label for="otp" class="form-label">Enter OTP</label>
                        <input type="text" name="otp" class="form-control text-center" id="otp" maxlength="6" placeholder="123456" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                    <div class="mt-3 text-center">
                        <span>Didn't receive code? <a href="register.php">Register again</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
