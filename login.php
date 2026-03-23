<?php
require_once 'config/session.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    if ($user = $userObj->login($email, $password)) {
        if ($user['status'] !== 'active') {
            $error = 'Your account has been ' . $user['status'] . '. Please contact support.';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];

            // Record Login History
            $ip = $_SERVER['REMOTE_ADDR'];
            $ua = $_SERVER['HTTP_USER_AGENT'];
            $pdo->prepare("INSERT INTO login_history (user_id, ip_address, user_agent) VALUES (?, ?, ?)")
                ->execute([$user['id'], $ip, $ua]);

            redirect('index.php', 'Welcome back, ' . $user['name'], 'success');
        }
    } else {
        $error = 'Invalid email or password.';
    }
}

require_once 'includes/header.php';
?>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Login</h6>
            <h1 class="mb-5">Welcome Back</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <form action="login.php" method="POST" class="bg-light p-4 rounded shadow-sm">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" value="password123" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    
                    <div class="row my-3 align-items-center">
                        <div class="col"><hr></div>
                        <div class="col-auto text-muted small">OR LOGIN WITH</div>
                        <div class="col"><hr></div>
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <a href="social_login.php?provider=google" class="btn btn-outline-danger btn-sm w-100 mb-2">
                           <i class="fab fa-google me-2"></i> Google
                        </a>
                        <a href="social_login.php?provider=facebook" class="btn btn-outline-primary btn-sm w-100 mb-2">
                           <i class="fab fa-facebook-f me-2"></i> Facebook
                        </a>
                        <a href="social_login.php?provider=linkedin" class="btn btn-outline-info btn-sm w-100">
                           <i class="fab fa-linkedin-in me-2"></i> LinkedIn
                        </a>
                    </div>

                    <div class="mt-3 text-center">
                        <span>Don't have an account? <a href="register.php">Register here</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
