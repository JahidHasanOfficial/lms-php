<?php
require_once 'config/database.php';

echo "Seeding database...<br>";

// 1. Create Default Admin & Instructor
$password = password_hash('password123', PASSWORD_DEFAULT);

// Admin
$stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, role) VALUES ('Admin User', 'admin@example.com', ?, 'admin')");
$stmt->execute([$password]);

// Instructor
$stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, role) VALUES ('John Instructor', 'instructor@example.com', ?, 'instructor')");
$stmt->execute([$password]);
$instructor_id = $pdo->lastInsertId() ?: 2;

// 2. Create Categories
$categories = [
    ['Web Development', 'web-development'],
    ['Graphic Design', 'graphic-design'],
    ['Digital Marketing', 'digital-marketing'],
    ['Video Editing', 'video-editing']
];

foreach ($categories as $cat) {
    $pdo->prepare("INSERT IGNORE INTO categories (name, slug) VALUES (?, ?)")->execute($cat);
}
$category_id = $pdo->lastInsertId() ?: 1;

// 3. Create a Course
$course_data = [
    'Web Development Bootcamp',
    'web-dev-bootcamp',
    'Learn HTML, CSS, JS and PHP from scratch.',
    'frontend-template/img/course-1.jpg',
    99.99,
    $category_id,
    $instructor_id,
    'published'
];

$stmt = $pdo->prepare("INSERT IGNORE INTO courses (title, slug, description, thumbnail, price, category_id, instructor_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute($course_data);
$course_id = $pdo->lastInsertId() ?: 1;

// 4. Create Sections & Lessons
$section_stmt = $pdo->prepare("INSERT IGNORE INTO course_sections (course_id, title, order_index) VALUES (?, 'Introduction', 0)");
$section_stmt->execute([$course_id]);
$section_id = $pdo->lastInsertId();

if ($section_id) {
    $lesson_stmt = $pdo->prepare("INSERT IGNORE INTO lessons (section_id, title, content_type, content_url, duration, order_index) VALUES (?, 'Welcome to the Course', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 0)");
    $lesson_stmt->execute([$section_id]);
}

echo "Seeding completed successfully!";
?>
