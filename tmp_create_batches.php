<?php
require_once 'config/database.php';
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS batches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        batch_no INT NOT NULL,
        title VARCHAR(255) DEFAULT NULL,
        start_date DATE DEFAULT NULL,
        end_date DATE DEFAULT NULL,
        status ENUM('active', 'upcoming', 'completed') DEFAULT 'upcoming',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    )");
    echo "Table 'batches' created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
