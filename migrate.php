<?php
require_once 'config/database.php';

echo "<h2>LMS Database Migration</h2>";

try {
    $sql = file_get_contents('schema.sql');
    
    // Execute multiple queries
    $pdo->exec($sql);
    
    echo "<p style='color: green;'>Success: Database tables created successfully!</p>";
    echo "<p>You can now run <a href='seed.php'>seed.php</a> to populate data.</p>";
    echo "<p><a href='index.php'>Go to Home Page</a></p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
