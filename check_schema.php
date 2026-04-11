<?php
require_once 'config/database.php';
echo "--- about_us table ---\n";
$stmt = $pdo->query("DESCRIBE about_us");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

echo "\n--- site_stats table ---\n";
$stmt = $pdo->query("DESCRIBE site_stats");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
