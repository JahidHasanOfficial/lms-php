<?php
require_once 'config/database.php';

try {
    $pdo->exec("ALTER TABLE team_members 
        ADD COLUMN IF NOT EXISTS specializations TEXT AFTER designation,
        ADD COLUMN IF NOT EXISTS education TEXT AFTER specializations,
        ADD COLUMN IF NOT EXISTS work_experience TEXT AFTER education,
        ADD COLUMN IF NOT EXISTS work_places TEXT AFTER work_experience,
        ADD COLUMN IF NOT EXISTS training_experience VARCHAR(255) AFTER work_places,
        ADD COLUMN IF NOT EXISTS total_students VARCHAR(255) AFTER training_experience
    ");
    echo "Database updated successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
