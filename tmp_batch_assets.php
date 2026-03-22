<?php
require_once 'config/database.php';

try {
    // 1. Add batch_id to live_classes
    $pdo->exec("ALTER TABLE live_classes ADD COLUMN IF NOT EXISTS batch_id INT DEFAULT NULL AFTER course_id");
    $pdo->exec("ALTER TABLE live_classes ADD CONSTRAINT fk_live_batch FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE");

    // 2. Add batch_id to assignments
    $pdo->exec("ALTER TABLE assignments ADD COLUMN IF NOT EXISTS batch_id INT DEFAULT NULL AFTER course_id");
    $pdo->exec("ALTER TABLE assignments ADD CONSTRAINT fk_assign_batch FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE");

    // 3. Create Quizzes Table if NOT exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS quizzes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        batch_id INT DEFAULT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        total_questions INT DEFAULT 0,
        time_limit_minutes INT DEFAULT 30,
        status ENUM('draft', 'published') DEFAULT 'draft',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
        FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE
    )");

    // 4. Create Questions Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS quiz_questions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        quiz_id INT NOT NULL,
        question_text TEXT NOT NULL,
        options JSON NOT NULL, -- JSON array of options
        correct_answer VARCHAR(255) NOT NULL,
        marks INT DEFAULT 1,
        FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
    )");

    // 5. Create Quiz Results Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS quiz_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        quiz_id INT NOT NULL,
        user_id INT NOT NULL,
        score INT DEFAULT 0,
        total_marks INT DEFAULT 0,
        completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    echo "Batch-linked Assignments, Live Classes, and Quizzes system implemented successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
