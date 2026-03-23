<?php
require_once '../config/session.php';
require_once '../config/ImageHelper.php';

if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
    redirect('index.php');
}

$currentPage = 'home_partners.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM home_partners WHERE id = ?");
    $stmt->execute([$id]);
    redirect('home_partners.php', 'Partner logo deleted!', 'success');
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = sanitize($_POST['name']);
    $logo_url = sanitize($_POST['logo_url']);
    $status = $_POST['status'];

    if (!empty($_FILES['logo_file']['name'])) {
        $uploadPath = ImageHelper::upload($_FILES['logo_file'], '../uploads/partners/');
        if ($uploadPath) {
            // Store only relative path for consistency
            $logo = str_replace('../', '', $uploadPath);
        } else {
            redirect('home_partners.php', 'Upload failed. Check file type (JPG/PNG/WebP).', 'danger');
        }
    } else {
        $logo = !empty($logo_url) ? $logo_url : $_POST['current_logo'];
    }

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE home_partners SET name = ?, logo = ?, status = ? WHERE id = ?");
        $stmt->execute([$name, $logo, $status, $id]);
        redirect('home_partners.php', 'Partner updated!', 'success');
    } else {
        $stmt = $pdo->prepare("INSERT INTO home_partners (name, logo, status) VALUES (?, ?, ?)");
        $stmt->execute([$name, $logo, $status]);
        redirect('home_partners.php', 'Partner added!', 'success');
    }
}

$partners = $pdo->query("SELECT * FROM home_partners ORDER BY id DESC")->fetchAll();
include 'includes/header.php';
?>

<div class="row column_title"><div class="col-md-12"><div class="page_title"><h2>Manage Partner Logos</h2></div></div></div>

<div class="row">
    <div class="col-md-4">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2><?php echo isset($_GET['edit']) ? 'Edit' : 'Add New'; ?> Partner</h2></div>
            </div>
            <div class="padding_infor_info">
                <?php 
                $editPartner = null;
                if(isset($_GET['edit'])) {
                    $eid = (int)$_GET['edit'];
                    foreach($partners as $p) if($p['id'] == $eid) $editPartner = $p;
                }
                ?>
                <form action="home_partners.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $editPartner['id'] ?? 0; ?>">
                    <input type="hidden" name="current_logo" value="<?php echo $editPartner['logo'] ?? ''; ?>">
                    
                    <div class="mb-3">
                        <label>Company Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $editPartner['name'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Logo File (Prefer PNG/SVG)</label>
                        <input type="file" name="logo_file" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label>OR Logo URL (External)</label>
                        <input type="text" name="logo_url" class="form-control" placeholder="https://..." value="<?php echo (isset($editPartner['logo']) && strpos($editPartner['logo'], 'http') !== false) ? $editPartner['logo'] : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active" <?php echo (isset($editPartner['status']) && $editPartner['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo (isset($editPartner['status']) && $editPartner['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary d-block w-100 font-weight-bold">Save Partner</button>
                    <?php if($editPartner): ?>
                    <a href="home_partners.php" class="btn btn-secondary d-block w-100 mt-2">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <?php displayAlert(); ?>
        <div class="white_shd full margin_bottom_30">
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="80">Logo</th>
                                <th>Name</th>
                                <th width="100">Status</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($partners as $partner): ?>
                            <tr>
                                <td>
                                    <div class="bg-light p-1 rounded text-center">
                                        <img src="<?php echo (strpos($partner['logo'], 'http') !== false) ? $partner['logo'] : '../' . $partner['logo']; ?>" alt="" style="max-height: 40px; max-width: 60px;">
                                    </div>
                                </td>
                                <td><b><?php echo $partner['name']; ?></b></td>
                                <td>
                                    <span class="badge badge-<?php echo $partner['status'] == 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($partner['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="home_partners.php?edit=<?php echo $partner['id']; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="home_partners.php?delete=<?php echo $partner['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this logo?')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
