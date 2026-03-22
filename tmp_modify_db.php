<?php
require_once 'config/database.php';
try {
    $pdo->exec("ALTER TABLE categories DROP COLUMN IF EXISTS icon");
    echo "Column 'icon' dropped successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
