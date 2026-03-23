<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Course.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('index.php');
}

$course_id = (int)($_GET['id'] ?? 0);
if (!$course_id) redirect('courses.php');

$courseObj = new Course($pdo);
$stmt = $pdo->prepare("SELECT title FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course_title = $stmt->fetchColumn();

if (!$course_title) redirect('courses.php');

// Handle Operations
$action = $_GET['action'] ?? '';
$type = $_GET['type'] ?? '';
$msg = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_outcome'])) {
        $outcome = sanitize($_POST['outcome']);
        $stmt = $pdo->prepare("INSERT INTO course_outcomes (course_id, outcome) VALUES (?, ?)");
        $stmt->execute([$course_id, $outcome]);
        $_SESSION['flash_msg'] = 'Outcome added!';
    }
    
    if (isset($_POST['add_faq'])) {
        $q = sanitize($_POST['question']);
        $a = sanitize($_POST['answer']);
        $stmt = $pdo->prepare("INSERT INTO course_faqs (course_id, question, answer) VALUES (?, ?, ?)");
        $stmt->execute([$course_id, $q, $a]);
        $_SESSION['flash_msg'] = 'FAQ added!';
    }

    if (isset($_POST['add_project'])) {
        $title = sanitize($_POST['title']);
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = '../uploads/projects/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = time() . '_' . $_FILES['image']['name'];
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                $image = 'uploads/projects/' . $fileName;
            }
        }
        $stmt = $pdo->prepare("INSERT INTO course_projects (course_id, title, image) VALUES (?, ?, ?)");
        $stmt->execute([$course_id, $title, $image]);
        $_SESSION['flash_msg'] = 'Project added!';
    }

    if (isset($_POST['add_testimonial'])) {
        $name = sanitize($_POST['student_name']);
        $role = sanitize($_POST['student_role']);
        $comment = sanitize($_POST['comment']);
        $rating = (int)$_POST['rating'];
        $stmt = $pdo->prepare("INSERT INTO course_testimonials (course_id, student_name, student_role, comment, rating) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$course_id, $name, $role, $comment, $rating]);
        $_SESSION['flash_msg'] = 'Testimonial added!';
    }

    if (isset($_POST['add_instructor'])) {
        $uid = (int)$_POST['user_id'];
        $stmt = $pdo->prepare("INSERT IGNORE INTO course_instructors (course_id, user_id) VALUES (?, ?)");
        $stmt->execute([$course_id, $uid]);
        $_SESSION['flash_msg'] = 'Instructor assigned!';
    }
    if (isset($_POST['add_feature'])) {
        $feature = sanitize($_POST['feature']);
        $stmt = $pdo->prepare("INSERT INTO course_features (course_id, feature) VALUES (?, ?)");
        $stmt->execute([$course_id, $feature]);
        $_SESSION['flash_msg'] = 'Feature added!';
    }

    header("Location: course_builder.php?id=$course_id");
    exit();
}

if ($action === 'delete') {
    $id = (int)$_GET['item_id'];
    $table = '';
    if ($type === 'outcome') $table = 'course_outcomes';
    if ($type === 'faq') $table = 'course_faqs';
    if ($type === 'project') $table = 'course_projects';
    if ($type === 'testimonial') $table = 'course_testimonials';
    if ($type === 'feature') $table = 'course_features';
    
    if ($type === 'instructor') {
        $stmt = $pdo->prepare("DELETE FROM course_instructors WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$id, $course_id]);
        $_SESSION['flash_msg'] = 'Instructor removed!';
    } elseif ($table) {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ? AND course_id = ?");
        $stmt->execute([$id, $course_id]);
        $_SESSION['flash_msg'] = 'Item deleted!';
    }

    header("Location: course_builder.php?id=$course_id");
    exit();
}

// Fetch Data
$outcomes = $courseObj->getOutcomes($course_id);
$features = $courseObj->getFeatures($course_id);
$faqs = $courseObj->getFaqs($course_id);
$projects = $courseObj->getProjects($course_id);
$testimonials = $courseObj->getTestimonials($course_id);
$assigned_instructors = $courseObj->getInstructors($course_id);

// Fetch all possible instructors
$all_instructors = $pdo->query("SELECT id, name FROM users WHERE role IN ('admin', 'instructor')")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
    <div class="col-md-12">
        <div class="page_title">
            <h2>Course Landing Page Builder</h2>
            <p>Managing details for: <strong><?php echo $course_title; ?></strong></p>
            <a href="courses.php" class="btn btn-dark btn-sm"><i class="fa fa-arrow-left"></i> Back to Courses</a>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['flash_msg'])): ?>
    <div class="alert alert-success">
        <?php 
            echo $_SESSION['flash_msg']; 
            unset($_SESSION['flash_msg']);
        ?>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Instructors -->
    <div class="col-md-12 mb-4">
        <div class="white_shd full">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2>Course Instructors Panel</h2></div>
            </div>
            <div class="padding_infor_info">
                <form method="POST" class="form-inline mb-4">
                    <select name="user_id" class="form-control mr-2" required>
                        <option value="">Select Instructor to Add</option>
                        <?php foreach($all_instructors as $inst): ?>
                            <option value="<?php echo $inst['id']; ?>"><?php echo $inst['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="add_instructor" class="btn btn-primary">Assign Instructor</button>
                </form>
                <div class="row">
                    <?php if(empty($assigned_instructors)): ?>
                        <div class="col-12"><p class="text-muted small">No additional instructors assigned. Using default course instructor.</p></div>
                    <?php endif; ?>
                    <?php foreach($assigned_instructors as $inst): ?>
                        <div class="col-md-3 mb-3">
                            <div class="card p-2 text-center bg-light">
                                <h6 class="m-0"><?php echo $inst['name']; ?></h6>
                                <a href="?id=<?php echo $course_id; ?>&action=delete&type=instructor&item_id=<?php echo $inst['id']; ?>" class="text-danger small mt-2" onclick="return confirm('Remove this instructor?')"><i class="fa fa-trash"></i> Remove</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Outcomes -->
    <div class="col-md-6 mb-4">
        <div class="white_shd full">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2>Learning Outcomes (কী কী শিখবেন)</h2></div>
            </div>
            <div class="padding_infor_info">
                <form method="POST" class="mb-4">
                    <div class="input-group">
                        <textarea name="outcome" class="form-control" placeholder="What will they learn?" rows="2" required></textarea>
                        <button type="submit" name="add_outcome" class="btn btn-primary">Add</button>
                    </div>
                </form>
                <ul class="list-group">
                    <?php foreach($outcomes as $o): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="small"><?php echo $o['outcome']; ?></span>
                            <a href="?id=<?php echo $course_id; ?>&action=delete&type=outcome&item_id=<?php echo $o['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="col-md-6 mb-4">
        <div class="white_shd full">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2>Course Features (যা যা থাকছে)</h2></div>
            </div>
            <div class="padding_infor_info">
                <form method="POST" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="feature" class="form-control" placeholder="Example: 100+ Pre-recorded videos" required>
                        <button type="submit" name="add_feature" class="btn btn-primary">Add</button>
                    </div>
                </form>
                <ul class="list-group">
                    <?php foreach($features as $f): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="small"><?php echo $f['feature']; ?></span>
                            <a href="?id=<?php echo $course_id; ?>&action=delete&type=feature&item_id=<?php echo $f['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="col-md-6 mb-4">
        <div class="white_shd full">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2>FAQs</h2></div>
            </div>
            <div class="padding_infor_info">
                <form method="POST" class="mb-4">
                    <input type="text" name="question" class="form-control mb-2" placeholder="Question" required>
                    <textarea name="answer" class="form-control mb-2" placeholder="Answer" rows="2" required></textarea>
                    <button type="submit" name="add_faq" class="btn btn-primary btn-block">Add FAQ</button>
                </form>
                <div class="accordion" id="faqAccordion">
                    <?php foreach($faqs as $i => $f): ?>
                        <div class="card border mb-1">
                            <div class="card-header p-2 d-flex justify-content-between align-items-center">
                                <span class="small font-weight-bold"><?php echo $f['question']; ?></span>
                                <a href="?id=<?php echo $course_id; ?>&action=delete&type=faq&item_id=<?php echo $f['id']; ?>" class="text-danger small" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects -->
    <div class="col-md-6 mb-4">
        <div class="white_shd full">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2>Portfolio Projects</h2></div>
            </div>
            <div class="padding_infor_info">
                <form method="POST" enctype="multipart/form-data" class="mb-4">
                    <input type="text" name="title" class="form-control mb-2" placeholder="Project Title" required>
                    <input type="file" name="image" class="form-control mb-2" required>
                    <button type="submit" name="add_project" class="btn btn-primary btn-block">Add Project</button>
                </form>
                <div class="row">
                    <?php foreach($projects as $p): ?>
                        <div class="col-4 mb-3 position-relative">
                            <img src="../<?php echo $p['image']; ?>" class="img-fluid rounded border">
                            <a href="?id=<?php echo $course_id; ?>&action=delete&type=project&item_id=<?php echo $p['id']; ?>" class="badge badge-danger position-absolute" style="top:0;right:15px;" onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="col-md-6 mb-4">
        <div class="white_shd full">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2>Student Reviews</h2></div>
            </div>
            <div class="padding_infor_info">
                <form method="POST" class="mb-4">
                    <div class="row">
                        <div class="col-6"><input type="text" name="student_name" class="form-control mb-2" placeholder="Student Name" required></div>
                        <div class="col-6"><input type="text" name="student_role" class="form-control mb-2" placeholder="Role/Job" required></div>
                    </div>
                    <textarea name="comment" class="form-control mb-2" placeholder="Review Content" rows="2" required></textarea>
                    <select name="rating" class="form-control mb-2">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                    </select>
                    <button type="submit" name="add_testimonial" class="btn btn-primary btn-block">Add Testimonial</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <?php foreach($testimonials as $t): ?>
                            <tr>
                                <td><strong><?php echo $t['student_name']; ?></strong><br><span class="small"><?php echo substr($t['comment'], 0, 50); ?>...</span></td>
                                <td class="text-right">
                                    <a href="?id=<?php echo $course_id; ?>&action=delete&type=testimonial&item_id=<?php echo $t['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
