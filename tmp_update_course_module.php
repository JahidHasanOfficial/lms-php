<?php
require_once 'config/database.php';

try {
    // 1. Add Tags and Career Path to Courses
    $pdo->exec("ALTER TABLE courses 
        ADD COLUMN IF NOT EXISTS tags VARCHAR(255) DEFAULT NULL,
        ADD COLUMN IF NOT EXISTS career_path VARCHAR(100) DEFAULT NULL
    ");

    // 2. Create Course Reviews Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS course_reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        user_id INT NOT NULL,
        rating TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
        review TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY (course_id, user_id),
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    echo "Database updated for Course Management Module.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
