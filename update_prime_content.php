<?php
require_once 'config/database.php';

echo "Updating Prime University content (Schema Corrected)...\n";

// Update About Us Table
$about_title = "Shaping the Future Since 2002";
$about_subtitle = "Prime University is committed to providing high-quality education to meet the needs of a dynamic society.";

$about_content = "### Mission\nTo provide high-quality education and research facilities, creating productive members of the community who can lead innovation and social change.\n\n### Vision\nTo become a centre of excellence for higher learning and research, recognized globally for academic standards and strategic innovation.\n\n### History\nEstablished in 2002 by a group of philanthropists under the Prime University Trust, it is one of the leading private universities in Bangladesh, approved by the government and the UGC.";

$stmt = $pdo->prepare("UPDATE about_us SET title = ?, subtitle = ?, content = ? WHERE id = 1");
$stmt->execute([$about_title, $about_subtitle, $about_content]);

// Update Site Stats Table
$learners = "8000+";
$courses = "20+";
$materials = "5000+";
$instructors = "100+";

$stmt = $pdo->prepare("UPDATE site_stats SET learners_count = ?, courses_count = ?, materials_count = ?, instructors_count = ? WHERE id = 1");
$stmt->execute([$learners, $courses, $materials, $instructors]);

echo "Database updated successfully!\n";
?>
