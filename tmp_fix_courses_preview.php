<?php
$file = 'h:\xampp\htdocs\my\lms-php\admin\courses.php';
$content = file_get_contents($file);
$pattern = '/<a href="view_course\.php\?id=<\?php echo \$course\[\'id\'\]; \?>" class="btn btn-secondary btn-xs" title="View Source"><i class="fa fa-eye"><\/i> View<\/a>/';
$replacement = '<a href="../course-details.php?slug=<?php echo $course[\'slug\']; ?>" target="_blank" class="btn btn-dark btn-xs" title="Preview Public Page"><i class="fa fa-external-link"></i> Preview</a>';
$newContent = preg_replace($pattern, $replacement, $content);
file_put_contents($file, $newContent);
echo "Successfully updated courses.php\n";
?>
