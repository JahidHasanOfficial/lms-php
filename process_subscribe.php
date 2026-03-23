<?php
require_once 'config/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $isAjax = isset($_POST['ajax']);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $check = $pdo->prepare("SELECT id FROM subscribers WHERE email = ?");
            $check->execute([$email]);
            
            if ($check->rowCount() > 0) {
                if($isAjax) { echo json_encode(['status' => 'warning', 'message' => 'You are already subscribed!']); exit; }
                redirect('index.php', 'You are already subscribed to our newsletter!', 'info');
            } else {
                $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (?)");
                $stmt->execute([$email]);
                if($isAjax) { echo json_encode(['status' => 'success', 'message' => '🎉 Successfully subscribed!']); exit; }
                redirect('index.php', '🎉 Thank you! You have successfully subscribed.', 'success');
            }
        } catch (PDOException $e) {
            if($isAjax) { echo json_encode(['status' => 'danger', 'message' => 'Server error.']); exit; }
            redirect('index.php', 'An error occurred.', 'danger');
        }
    } else {
        if($isAjax) { echo json_encode(['status' => 'warning', 'message' => 'Invalid email address.']); exit; }
        redirect('index.php', 'Invalid email address.', 'warning');
    }
}
 else {
    redirect('index.php');
}
?>
