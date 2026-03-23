<?php
require_once '../config/session.php';

if (!isLoggedIn()) {
    echo json_encode(['status' => 'error', 'message' => 'Login required']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['blog_id'])) {
    $blogId = (int)$_POST['blog_id'];
    $userId = $_SESSION['user_id'];
    
    // Check if already liked
    $stmt = $pdo->prepare("SELECT * FROM blog_likes WHERE blog_id = ? AND user_id = ?");
    $stmt->execute([$blogId, $userId]);
    $liked = $stmt->fetch();
    
    $action = '';
    if ($liked) {
        $pdo->prepare("DELETE FROM blog_likes WHERE blog_id = ? AND user_id = ?")->execute([$blogId, $userId]);
        $action = 'unliked';
    } else {
        $pdo->prepare("INSERT INTO blog_likes (blog_id, user_id) VALUES (?, ?)")->execute([$blogId, $userId]);
        $action = 'liked';
    }
    
    // Count new likes
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM blog_likes WHERE blog_id = ?");
    $stmt->execute([$blogId]);
    $newCount = $stmt->fetch()['count'];
    
    echo json_encode(['status' => 'success', 'action' => $action, 'new_likes' => $newCount]);
    exit;
}
?>
