<?php
require_once 'config/database.php';

try {
    // 1. Create Roles Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE,
        slug VARCHAR(50) NOT NULL UNIQUE,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Create Permissions Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS permissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        slug VARCHAR(100) NOT NULL UNIQUE,
        module VARCHAR(50) DEFAULT 'general',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 3. Create Role Permissions (Many-to-Many)
    $pdo->exec("CREATE TABLE IF NOT EXISTS role_permissions (
        role_id INT NOT NULL,
        permission_id INT NOT NULL,
        PRIMARY KEY (role_id, permission_id),
        FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
        FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
    )");

    // 4. Update Users Table to include role_id
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS role_id INT DEFAULT NULL");
    $pdo->exec("ALTER TABLE users ADD CONSTRAINT fk_user_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL");

    // 5. Seed Initial Roles
    $roles = [
        ['Admin', 'admin', 'Full platform access'],
        ['Instructor', 'instructor', 'Manage courses and curriculum'],
        ['Learner', 'learner', 'Access enrolled courses'],
        ['Corporate', 'corporate', 'Business level access']
    ];
    
    foreach ($roles as $r) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO roles (name, slug, description) VALUES (?, ?, ?)");
        $stmt->execute($r);
    }

    // 6. Seed Core Permissions
    $permissions = [
        ['Manage Courses', 'manage_courses', 'courses'],
        ['Manage Users', 'manage_users', 'users'],
        ['Manage Batches', 'manage_batches', 'courses'],
        ['View Own Courses', 'view_my_courses', 'learner'],
        ['Enroll in Courses', 'enroll_courses', 'learner'],
        ['Manage Categories', 'manage_categories', 'courses'],
        ['Access Admin Dashboard', 'access_admin_panel', 'admin']
    ];

    foreach ($permissions as $p) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO permissions (name, slug, module) VALUES (?, ?, ?)");
        $stmt->execute($p);
    }

    // 7. Associate Admin Role with all permissions
    $adminRole = $pdo->query("SELECT id FROM roles WHERE slug = 'admin'")->fetchColumn();
    $allPerms = $pdo->query("SELECT id FROM permissions")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($allPerms as $pid) {
        $pdo->prepare("INSERT IGNORE INTO role_permissions (role_id, permission_id) VALUES (?, ?)")
            ->execute([$adminRole, $pid]);
    }

    // 8. Map existing users to role_id based on their ENUM 'role'
    $pdo->exec("UPDATE users SET role_id = (SELECT id FROM roles WHERE roles.slug = users.role)");

    echo "Dynamic Role & Permission System implemented successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
