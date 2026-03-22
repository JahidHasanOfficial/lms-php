<?php
require_once 'config/database.php';

try {
    // 1. Get all batches
    $batches = $pdo->query("SELECT id, course_id FROM batches")->fetchAll();

    foreach ($batches as $batch) {
        $bid = $batch['id'];
        $cid = $batch['course_id'];

        // Seed 1 Live Class for each batch
        $pdo->prepare("INSERT INTO live_classes (course_id, batch_id, title, instructor_id, start_time, end_time, zoom_link) VALUES (?, ?, ?, ?, ?, ?, ?)")
            ->execute([
                $cid, $bid, 
                "Orientation Session", 
                1, 
                date('Y-m-d H:i:s', strtotime('+2 days')), 
                date('Y-m-d H:i:s', strtotime('+2 days 2 hours')),
                "https://zoom.us/abc-def"
            ]);

        // Seed 1 Assignment for each batch
        $pdo->prepare("INSERT INTO assignments (course_id, batch_id, title, description, deadline, total_marks) VALUES (?, ?, ?, ?, ?, ?)")
            ->execute([
                $cid, $bid, 
                "Project 1: Discovery", 
                "Submit your initial research and discovery artifacts for the course project.", 
                date('Y-m-d H:i:s', strtotime('+7 days')), 
                100
            ]);

        // Seed 1 Quiz for each batch
        $pdo->prepare("INSERT INTO quizzes (course_id, batch_id, title, description, total_questions, status) VALUES (?, ?, ?, ?, ?, 'published')")
            ->execute([
                $cid, $bid, 
                "Weekly Mid-Term Quiz", 
                "Test your knowledge of the first two modules.", 
                2
            ]);
        
        $quizId = $pdo->lastInsertId();
        
        // Seed 2 Questions for each Quiz
        $pdo->prepare("INSERT INTO quiz_questions (quiz_id, question_text, options, correct_answer) VALUES (?, ?, ?, ?)")
            ->execute([
                $quizId, 
                "What is the primary goal of this course?", 
                json_encode(['Mastery', 'Basics', 'Fun', 'Certification']),
                'Mastery'
            ]);
            
        $pdo->prepare("INSERT INTO quiz_questions (quiz_id, question_text, options, correct_answer) VALUES (?, ?, ?, ?)")
            ->execute([
                $quizId, 
                "Which module covers advanced topics?", 
                json_encode(['Module 1', 'Module 2', 'Module 3', 'Module 4']),
                'Module 2'
            ]);
    }

    echo "Batch-specific Live Classes, Assignments, and Quizzes seeded successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
