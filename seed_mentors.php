<?php
require_once 'config/database.php';

echo "Starting mentors seeding...\n";

// Clear existing mentors if any
$pdo->exec("TRUNCATE TABLE team_members");

$mentors = [
    ['Dr. Sarah Johnson', 'Dean of Computer Science', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop'],
    ['Prof. David Miller', 'Lead Data Scientist', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop'],
    ['Emma Wilson', 'UX/UI Design Expert', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop'],
    ['James Anderson', 'Senior Software Engineer', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop'],
    ['Dr. Lisa Chen', 'Cyber Security Specialist', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400&h=400&fit=crop'],
    ['Michael Brown', 'Full Stack Developer', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop'],
    ['Sophia Garcia', 'Digital Marketing Coach', 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=400&h=400&fit=crop'],
    ['Robert Taylor', 'AI & Machine Learning Researcher', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&h=400&fit=crop'],
    ['Olivia Martinez', 'Cloud Architecture Expert', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=400&fit=crop'],
    ['William Davis', 'Mobile App developer (Flutter)', 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&h=400&fit=crop'],
    ['Isabella Rodriguez', 'Project Management Professional', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop'],
    ['Joseph Wilson', 'Blockchain developer', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=400&fit=crop'],
    ['Mia Moore', 'Python & Data Analytics Mentor', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=400&fit=crop'],
    ['Alexander White', 'DevOps Engineer', 'https://images.unsplash.com/photo-1504257447784-5ce1059f8164?w=400&h=400&fit=crop'],
    ['Charlotte Clark', 'Frontend Architect (React)', 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=400&h=400&fit=crop'],
    ['Daniel Adams', 'Backend Systems Expert', 'https://images.unsplash.com/photo-1513956589380-bad6acb9b9d4?w=400&h=400&fit=crop'],
    ['Amelia Turner', 'Ethical Hacking Trainer', 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=400&h=400&fit=crop'],
    ['Henry Baker', 'Game Development Expert', 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?w=400&h=400&fit=crop'],
    ['Evelyn Harris', 'Business Analyst Lead', 'https://images.unsplash.com/photo-1567532939103-c053bb14b2b9?w=400&h=400&fit=crop'],
    ['Jackson Scott', 'Software Testing & QA Expert', 'https://images.unsplash.com/photo-1522556189639-b150ed9c4330?w=400&h=400&fit=crop']
];

$stmt = $pdo->prepare("INSERT INTO team_members (name, designation, image, specializations, education, work_experience, work_places, training_experience, total_students, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");

foreach ($mentors as $m) {
    $stmt->execute([
        $m[0], // name
        $m[1], // designation
        $m[2], // image
        'Web Development, Software Engineering, System Design', // specializations
        'PhD in Computer Science from World University', // education
        '10+ years of active contribution in the software industry.', // work_experience
        'Google, Meta, Amazon, Microsoft', // work_places
        'Trained over 5000+ students globally through various bootcamps.', // training_experience
        rand(1000, 5000) // total_students
    ]);
}

echo "Successfully seeded 20 mentors into the Prime University database!\n";
?>
