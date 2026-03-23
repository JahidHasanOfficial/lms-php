<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];
$user = $userObj->getById($user_id);

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => sanitize($_POST['name']),
        'bio' => sanitize($_POST['bio']),
        'skills' => sanitize($_POST['skills']),
        'phone' => sanitize($_POST['phone'])
    ];

    // Profile Picture Upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $uploadDir = '../uploads/profiles/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        $fileName = time() . '_' . basename($_FILES['profile_pic']['name']);
        $targetFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
            $data['profile_pic'] = 'uploads/profiles/' . $fileName;
        }
    }

    if ($userObj->updateProfile($user_id, $data)) {
        $success = 'Profile updated successfully!';
        $_SESSION['user_name'] = $data['name'];
        $user = $userObj->getById($user_id);
    } else {
        $error = 'Failed to update profile.';
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <h2>Profile Management</h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head text-center">
                <h2>Your Progress</h2>
            </div>
            <div class="padding_infor_info text-center">
                <img src="../<?php echo $user['profile_pic'] ?: 'assets/images/layout_img/user_img.jpg'; ?>" class="rounded-circle mb-3 border shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                <h4 class="mb-1"><?php echo $user['name']; ?></h4>
                <p class="badge badge-info p-2 mb-3"><?php echo ucfirst($user['role_name']); ?></p>
                <hr>
                <div class="text-left">
                    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $user['phone'] ?: 'N/A'; ?></p>
                    <p><strong>Status:</strong> <span class="badge badge-success"><?php echo ucfirst($user['status']); ?></span></p>
                </div>
                <hr>
                <div class="text-left">
                    <h6>Recent Login History</h6>
                    <ul class="list-unstyled small">
                        <?php
                        $lh_stmt = $pdo->prepare("SELECT * FROM login_history WHERE user_id = ? ORDER BY login_at DESC LIMIT 5");
                        $lh_stmt->execute([$user_id]);
                        $history = $lh_stmt->fetchAll();
                        foreach ($history as $h) {
                            echo "<li><i class='fa fa-clock-o'></i> " . date('M d, H:i', strtotime($h['login_at'])) . " (" . $h['ip_address'] . ")</li>";
                        }
                        if (empty($history)) echo "<li>No history found.</li>";
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit Profile</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $user['phone']; ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bio (Short Intro)</label>
                        <textarea name="bio" class="form-control" rows="3"><?php echo $user['bio']; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Skills (Comma separated, e.g. PHP, Laravel, SQL)</label>
                        <input type="text" name="skills" class="form-control" value="<?php echo $user['skills']; ?>">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_pic" class="form-control">
                        <small class="text-muted">Current: <?php echo basename($user['profile_pic']); ?></small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
