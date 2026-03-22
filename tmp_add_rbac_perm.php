<?php
require_once 'config/database.php';
try {
    // 1. Add Manage RBAC permission
    $stmt = $pdo->prepare("INSERT IGNORE INTO permissions (name, slug, module) VALUES (?, ?, ?)");
    $stmt->execute(['Manage Roles & Permissions', 'manage_rbac', 'admin']);
    $permId = $pdo->lastInsertId() ?: $pdo->query("SELECT id FROM permissions WHERE slug='manage_rbac'")->fetchColumn();

    // 2. Assign to Admin role
    $adminRoleId = $pdo->query("SELECT id FROM roles WHERE slug='admin'")->fetchColumn();
    $pdo->prepare("INSERT IGNORE INTO role_permissions (role_id, permission_id) VALUES (?, ?)")
        ->execute([$adminRoleId, $permId]);

    echo "Manage RBAC permission added and assigned to Admin!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
