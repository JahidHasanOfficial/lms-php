<?php
require_once 'config/session.php';
if (!isLoggedIn()) {
    redirect('login.php');
}

if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'instructor') {
    header('Location: admin/index.php');
} else {
    header('Location: dashboard/index.php');
}
exit();
?>
