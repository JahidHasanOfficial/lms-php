<?php
require_once 'h:/xampp/htdocs/my/lms-php/config/database.php';

$stories = [
    ['Priyabrata Chowdhury', 'Web Development with Python, Django & React Batch - 11', 'assets/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Anamika Abedin', 'UI/UX Design Career Path Batch - 2', 'assets/img/course-2.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Md Jawadul Karim', 'UI/UX Design Career Path Batch - 2', 'assets/img/course-3.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Mariya Sharmin', 'Data Analytics and Power BI Career Path Batch - 2', 'assets/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['KM Nurunnabi', 'Laravel Career Path Batch - 1', 'assets/img/course-2.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Mahmudul Haque Shawon', 'Full Stack Web Development with Python, Django & React Batch - 10', 'assets/img/course-3.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Sumaiya Akter', 'Graphic Design Batch - 04', 'assets/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Tanvir Ahmed', 'Cyber Security Batch - 01', 'assets/img/course-2.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Nabila Islam', 'Digital Marketing Batch - 08', 'assets/img/course-3.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    ['Sajid Hasan', 'App Development Batch - 03', 'assets/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']
];

$stmt = $pdo->prepare("INSERT INTO success_stories (student_name, course_info, thumbnail, video_url) VALUES (?, ?, ?, ?)");

foreach ($stories as $story) {
    if ($stmt->execute($story)) {
        echo "Inserted: " . $story[0] . "\n";
    } else {
        echo "Failed: " . $story[0] . "\n";
    }
}

echo "Seeding completed!\n";
?>

