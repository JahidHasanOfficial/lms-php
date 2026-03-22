<?php
require_once 'config/database.php';
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS course_instructors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        user_id INT NOT NULL,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    echo "Table 'course_instructors' created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
