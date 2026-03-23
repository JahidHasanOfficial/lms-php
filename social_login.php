<?php
require_once 'config/session.php';

$provider = isset($_GET['provider']) ? $_GET['provider'] : '';

if (!in_array($provider, ['google', 'facebook', 'linkedin'])) {
    redirect('login.php');
}

// In a real application, you'd use a library like HybridAuth or OAuth2-client.
// This is a simulation showing how it would integrate with our User class.

$social_data = [
    'google' => ['id' => '12345', 'name' => 'John Doe (Google)', 'email' => 'john.google@example.com'],
    'facebook' => ['id' => '67890', 'name' => 'Jane Doe (FB)', 'email' => 'jane.fb@example.com'],
    'linkedin' => ['id' => '54321', 'name' => 'Alice Doe (LI)', 'email' => 'alice.li@example.com'],
];

$user_info = $social_data[$provider];

$existing_user = $userObj->findBySocialId($provider, $user_info['id']);

if ($existing_user) {
    // Log them in
    $_SESSION['user_id'] = $existing_user['id'];
    $_SESSION['user_role'] = $existing_user['role'];
    $_SESSION['user_name'] = $existing_user['name'];

    // Record Login History
    $ip = $_SERVER['REMOTE_ADDR'];
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $pdo->prepare("INSERT INTO login_history (user_id, ip_address, user_agent) VALUES (?, ?, ?)")
        ->execute([$existing_user['id'], $ip, $ua]);

    redirect('dashboard/index.php', 'Social Login Successful!', 'success');
} else {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$user_info['email']]);
    $email_user = $stmt->fetch();

    if ($email_user) {
        // Link account
        $column = $provider . "_id";
        $stmt = $pdo->prepare("UPDATE users SET $column = ?, is_verified = 1 WHERE id = ?");
        $stmt->execute([$user_info['id'], $email_user['id']]);
        
        $_SESSION['user_id'] = $email_user['id'];
        $_SESSION['user_role'] = $email_user['role'];
        $_SESSION['user_name'] = $email_user['name'];

        // Record Login History
        $ip = $_SERVER['REMOTE_ADDR'];
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $pdo->prepare("INSERT INTO login_history (user_id, ip_address, user_agent) VALUES (?, ?, ?)")
            ->execute([$email_user['id'], $ip, $ua]);

        redirect('dashboard/index.php', 'Social Account Linked and Logged In!', 'success');
    } else {
        // Create new account
        if ($userObj->createSocialUser($user_info['name'], $user_info['email'], $provider, $user_info['id'])) {
            $new_user = $userObj->findBySocialId($provider, $user_info['id']);
            $_SESSION['user_id'] = $new_user['id'];
            $_SESSION['user_role'] = $new_user['role'];
            $_SESSION['user_name'] = $new_user['name'];

            // Record Login History
            $ip = $_SERVER['REMOTE_ADDR'];
            $ua = $_SERVER['HTTP_USER_AGENT'];
            $pdo->prepare("INSERT INTO login_history (user_id, ip_address, user_agent) VALUES (?, ?, ?)")
                ->execute([$new_user['id'], $ip, $ua]);

            redirect('dashboard/index.php', 'Social Registration Successful!', 'success');
        } else {
            redirect('login.php', 'Social login failed.', 'danger');
        }
    }
}
?>
