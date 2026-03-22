<?php
require_once 'config/session.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        try {
            if ($userObj->register($name, $email, $phone, $password)) {
                redirect('login.php', 'Registration successful! Please login.', 'success');
            } else {
                $error = 'Registration failed. Please try again.';
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                 $error = 'Email already exists.';
            } else {
                 $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Register</h6>
            <h1 class="mb-5">Join Our Platform</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5 col-md-8 wow fadeInUp" data-wow-delay="0.3s">
                <form action="register.php" method="POST" class="bg-light p-4 rounded shadow-sm">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Create Account</button>
                    <div class="mt-3 text-center">
                        <span>Already have an account? <a href="login.php">Login here</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
