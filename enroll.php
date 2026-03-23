<?php
require_once 'config/session.php';
require_once 'classes/Course.php';
require_once 'classes/Batch.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$course_id) {
    redirect('courses.php', 'Invalid course ID.', 'error');
}

// Check if already enrolled
$stmt = $pdo->prepare("SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
$stmt->execute([$_SESSION['user_id'], $course_id]);
if ($stmt->fetch()) {
    redirect(DASHBOARD_URL . 'index.php', 'You are already enrolled in this course.', 'info');
}

$stmt_c = $pdo->prepare("SELECT title, price, discount_price FROM courses WHERE id = ?");
$stmt_c->execute([$course_id]);
$course = $stmt_c->fetch();

if (!$course) redirect('index.php');

$final_price = $course['discount_price'] ?: $course['price'];

// If course is NOT free, redirect to checkout
if ($final_price > 0) {
    header("Location: checkout.php?id=$course_id");
    exit();
}

// Find correct batch
$batchObj = new Batch($pdo);
$batch = $batchObj->getActiveBatch($course_id);
$batch_id = $batch ? $batch['id'] : null;

// Enroll user (Free course)
$stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id, batch_id, payment_status, progress_percent) VALUES (?, ?, ?, 'completed', 0)");
if ($stmt->execute([$_SESSION['user_id'], $course_id, $batch_id])) {
    // Record free payment
    $pdo->prepare("INSERT INTO payments (user_id, course_id, amount, method, transaction_id, status) VALUES (?, ?, ?, 'free', ?, 'success')")
        ->execute([$_SESSION['user_id'], $course_id, 0.00, 'FREE-'.time()]);
    
    redirect(DASHBOARD_URL . 'index.php', 'Free enrollment successful! Enjoy your course.', 'success');
}
?>
