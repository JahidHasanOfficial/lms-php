<?php
// Global helper functions

/**
 * Sanitize input to prevent XSS
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Handle redirects with alert messages
 */
function redirect($url, $message = '', $type = 'info') {
    if ($message) {
        $_SESSION['alert'] = ['message' => $message, 'type' => $type];
    }
    header("Location: $url");
    exit();
}

/**
 * Display alert messages
 */
function displayAlert() {
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        $type = $alert['type'] === 'error' ? 'danger' : ($alert['type'] === 'success' ? 'success' : 'info');
        echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
                ' . $alert['message'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        unset($_SESSION['alert']);
    }
}

/**
 * Check if the user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Logout the user
 */
function logout() {
    session_destroy();
    redirect('login.php', 'You have been logged out successfully.', 'success');
}
?>
