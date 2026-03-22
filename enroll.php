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

// Find correct batch
$batchObj = new Batch($pdo);
$batch = $batchObj->getActiveBatch($course_id);
$batch_id = $batch ? $batch['id'] : null;

// Enroll user
$stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id, batch_id, payment_status, progress_percent) VALUES (?, ?, ?, 'completed', 0)");
if ($stmt->execute([$_SESSION['user_id'], $course_id, $batch_id])) {
    redirect(DASHBOARD_URL . 'index.php', 'Enrollment successful! You are added to Batch ' . ($batch['batch_no'] ?? '1') . '.', 'success');
} else {
    redirect('courses.php', 'Enrollment failed. Please try again.', 'error');
}
?>
