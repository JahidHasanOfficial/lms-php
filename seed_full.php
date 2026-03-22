<?php
require_once 'config/database.php';

echo "Starting full database seeding...\n";

// Clear existing data (in order of dependencies)
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
$pdo->exec("TRUNCATE TABLE lessons");
$pdo->exec("TRUNCATE TABLE course_sections");
$pdo->exec("TRUNCATE TABLE enrollments");
$pdo->exec("TRUNCATE TABLE batches");
$pdo->exec("TRUNCATE TABLE payments");
$pdo->exec("TRUNCATE TABLE courses");
$pdo->exec("TRUNCATE TABLE categories");
$pdo->exec("TRUNCATE TABLE users");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

// 1. Seed Users (10)
$roles = ['admin', 'instructor', 'learner'];
for ($i = 1; $i <= 10; $i++) {
    $role = $roles[array_rand($roles)];
    if ($i == 1) $role = 'admin'; // Ensure at least one admin
    if ($i == 2) $role = 'instructor'; 

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, status, bio) VALUES (?, ?, ?, ?, 'active', ?)");
    $stmt->execute([
        "Trainer $i",
        "trainer$i@example.com",
        password_hash('password123', PASSWORD_DEFAULT),
        $role,
        "Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training."
    ]);
}
echo "- Seeded 10 users.\n";

// 2. Seed Categories (10)
$catNames = ['Web Development', 'App Design', 'Marketing', 'Photography', 'Business', 'Soft Skills', 'Graphics Design', 'Data Science', 'Networking', 'Cyber Security'];
foreach ($catNames as $index => $name) {
    $slug = strtolower(str_replace(' ', '-', $name));
    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $name,
        $slug,
        "Master the art of $name with our expert-led courses.",
        "frontend-template/img/cat-" . (($index % 4) + 1) . ".jpg"
    ]);
}
echo "- Seeded 10 categories.\n";

// Get some IDs
$instructors = $pdo->query("SELECT id FROM users WHERE role = 'instructor'")->fetchAll(PDO::FETCH_COLUMN);
$admins = $pdo->query("SELECT id FROM users WHERE role = 'admin'")->fetchAll(PDO::FETCH_COLUMN);
$allInstructors = array_merge($instructors, $admins);
$categoryIds = $pdo->query("SELECT id FROM categories")->fetchAll(PDO::FETCH_COLUMN);

// 3. Seed Courses (10)
for ($i = 1; $i <= 10; $i++) {
    $stmt = $pdo->prepare("INSERT INTO courses (title, slug, description, thumbnail, price, discount_price, category_id, instructor_id, status, what_will_learn, requirements, target_audience, video_preview_url, total_duration_hours) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'published', ?, ?, ?, ?, ?)");
    $stmt->execute([
        "Advanced Course $i",
        "advanced-course-$i",
        "This is a comprehensive guide to mastering the topics covered in Course $i. You will learn everything from basics to advanced levels.",
        "frontend-template/img/course-" . (($i % 3) + 1) . ".jpg",
        rand(50, 100) . ".00",
        rand(30, 49) . ".99",
        $categoryIds[array_rand($categoryIds)],
        $allInstructors[array_rand($allInstructors)],
        "[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]",
        "[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]",
        "[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]",
        "https://www.youtube.com/embed/dQw4w9WgXcQ",
        "25.5"
    ]);
    
    $courseId = $pdo->lastInsertId();
    
    // Seed FAQs for each course
    for ($f = 1; $f <= 3; $f++) {
        $pdo->prepare("INSERT INTO course_faqs (course_id, question, answer) VALUES (?, ?, ?)")
            ->execute([$courseId, "Common Question $f?", "Detailed answer for the FAQ. This course covers everything you need to know about this specific topic."]);
    }

    // Seed Projects for each course
    for ($p = 1; $p <= 2; $p++) {
        $pdo->prepare("INSERT INTO course_projects (course_id, title, image, description) VALUES (?, ?, ?, ?)")
            ->execute([$courseId, "Project $p: Real World App", "frontend-template/img/course-1.jpg", "A hands-on project that teaches you industry best practices."]);
    }

    // NEW: Seed Multiple Instructors (2-3 per course)
    $assignedCount = rand(2, 3);
    $shuffledInstructors = $allInstructors;
    shuffle($shuffledInstructors);
    $selected = array_slice($shuffledInstructors, 0, $assignedCount);
    
    foreach ($selected as $uid) {
        $pdo->prepare("INSERT INTO course_instructors (course_id, user_id) VALUES (?, ?)")
            ->execute([$courseId, $uid]);
    }
}
echo "- Seeded 10 courses.\n";

$courseIds = $pdo->query("SELECT id FROM courses")->fetchAll(PDO::FETCH_COLUMN);

// 4. Seed Batches (10)
foreach ($courseIds as $cid) {
    $stmt = $pdo->prepare("INSERT INTO batches (course_id, batch_no, title, status, start_date) VALUES (?, ?, ?, 'active', ?)");
    $stmt->execute([
        $cid,
        1,
        "Inaugural Batch",
        date('Y-m-d', strtotime('+' . rand(1, 10) . ' days'))
    ]);
}
echo "- Seeded 1 batch for each course.\n";

// 5. Seed Curriculum (Sections & Lessons)
foreach ($courseIds as $cid) {
    // 2 Sections per course
    for ($s = 1; $s <= 2; $s++) {
        $stmt = $pdo->prepare("INSERT INTO course_sections (course_id, title, order_index) VALUES (?, ?, ?)");
        $stmt->execute([$cid, "Module $s: Foundations", $s]);
        $sectionId = $pdo->lastInsertId();

        // 3 Lessons per section
        for ($l = 1; $l <= 3; $l++) {
            $stmt = $pdo->prepare("INSERT INTO lessons (section_id, title, content_type, content_url, duration, order_index) VALUES (?, ?, 'video', ?, '10:00', ?)");
            $stmt->execute([
                $sectionId, 
                "Lesson $l: Getting Started", 
                "https://www.youtube.com/embed/dQw4w9WgXcQ", 
                $l
            ]);
        }
    }
}
echo "- Seeded curriculum for all courses.\n";

echo "Seeding completed successfully!\n";
?>
