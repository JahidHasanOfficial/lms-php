<?php
// Session configuration and core objects initialization
session_start();

// Define Base URLs (Adjust the subdirectory if needed)
define('BASE_URL', '/my/lms-php/'); 
define('ADMIN_URL', BASE_URL . 'admin/');
define('DASHBOARD_URL', BASE_URL . 'dashboard/');

require_once 'database.php';
require_once 'functions.php';
require_once dirname(__DIR__) . '/classes/User.php';

// Initialize the User class and assign to a global variable
$userObj = new User($pdo);

// Set default logged in user if session exists
$currentUser = null;
if (isset($_SESSION['user_id'])) {
    $currentUser = $userObj->getById($_SESSION['user_id']);
    if (!$currentUser) {
        session_destroy();
        redirect('login.php');
    }
    
    // Cache permissions in session if not set
    if (!isset($_SESSION['permissions'])) {
        $_SESSION['permissions'] = $userObj->getPermissions($_SESSION['user_id']);
    }
}

/**
 * Helper to check permission
 */
function hasPermission($perm_slug) {
    return isset($_SESSION['permissions']) && in_array($perm_slug, $_SESSION['permissions']);
}
?>
