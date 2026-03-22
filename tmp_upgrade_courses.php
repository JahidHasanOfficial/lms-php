<?php
require_once 'config/database.php';

try {
    // 1. Update courses table with professional fields
    $pdo->exec("ALTER TABLE courses ADD COLUMN IF NOT EXISTS what_will_learn TEXT DEFAULT NULL");
    $pdo->exec("ALTER TABLE courses ADD COLUMN IF NOT EXISTS requirements TEXT DEFAULT NULL");
    $pdo->exec("ALTER TABLE courses ADD COLUMN IF NOT EXISTS target_audience TEXT DEFAULT NULL");
    $pdo->exec("ALTER TABLE courses ADD COLUMN IF NOT EXISTS discount_price DECIMAL(10, 2) DEFAULT NULL");
    $pdo->exec("ALTER TABLE courses ADD COLUMN IF NOT EXISTS video_preview_url VARCHAR(255) DEFAULT NULL");
    $pdo->exec("ALTER TABLE courses ADD COLUMN IF NOT EXISTS total_duration_hours VARCHAR(50) DEFAULT NULL");

    // 2. Create Course FAQs Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS course_faqs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        order_index INT DEFAULT 0,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    )");

    // 3. Create Course Projects Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS course_projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        image VARCHAR(255) DEFAULT NULL,
        description TEXT,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    )");

    echo "Database schema updated successfully for premium Course Details page!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
