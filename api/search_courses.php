<?php
require_once '../config/database.php';

$query = $_GET['q'] ?? '';

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, title, slug, thumbnail, price, discount_price 
                           FROM courses 
                           WHERE status = 'published' AND title LIKE ? 
                           LIMIT 5");
    $stmt->execute(["%$query%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode([]);
}
