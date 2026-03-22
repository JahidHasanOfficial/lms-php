<?php
require_once 'config/session.php';
require_once 'classes/Course.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';
$courseObj = new Course($pdo);
$course = $courseObj->getBySlug($slug);

if (!$course) {
    redirect('dashboard.php', 'Course not found.', 'error');
}

// Check enrollment
$stmt = $pdo->prepare("SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
$stmt->execute([$_SESSION['user_id'], $course['id']]);
if (!$stmt->fetch()) {
    redirect('course-details.php?slug=' . $slug, 'You must enroll in the course first.', 'error');
}

$curriculum = $courseObj->getCurriculum($course['id']);

require_once 'includes/header.php';
?>

<div class="container-xxl py-5">
    <div class="container-fluid">
        <div class="row g-5">
            <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
                <div class="video-container mb-4 position-relative bg-dark rounded shadow-lg overflow-hidden" style="padding-bottom: 56.25%; height: 0;">
                    <iframe class="position-absolute top-0 start-0 w-100 h-100" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="m-0"><?php echo $course['title']; ?></h1>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm px-4" style="border-radius: 30px;"><i class="fa fa-backward me-2"></i>Previous Lesson</button>
                        <button class="btn btn-primary btn-sm px-4" style="border-radius: 30px;">Next Lesson<i class="fa fa-forward ms-2"></i></button>
                    </div>
                </div>

                <div class="course-meta bg-light p-4 rounded shadow-sm border-start border-primary border-5">
                    <h5 class="mb-3">About this lesson</h5>
                    <p class="mb-0 text-muted">This lesson covers the fundamental concepts of <?php echo $course['title']; ?> and its applications in real-world projects. Pay close attention to the examples provided in the video.</p>
                </div>
            </div>

            <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.3s">
                <h5 class="mb-4">Course Curriculum</h5>
                <div class="accordion" id="learningAccordion">
                    <?php if (empty($curriculum)): ?>
                        <p>No content added yet.</p>
                    <?php else: ?>
                        <?php $i = 0; foreach ($curriculum as $section_id => $section): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?php echo $section_id; ?>">
                                    <button class="accordion-button <?php echo ($i > 0) ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $section_id; ?>" aria-expanded="<?php echo ($i === 0) ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $section_id; ?>">
                                        <?php echo $section['title']; ?>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $section_id; ?>" class="accordion-collapse collapse <?php echo ($i === 0) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $section_id; ?>" data-bs-parent="#learningAccordion">
                                    <div class="accordion-body p-0">
                                        <div class="list-group list-group-flush">
                                            <?php if (empty($section['lessons'])): ?>
                                                <div class="list-group-item">No lessons available.</div>
                                            <?php else: ?>
                                                <?php foreach ($section['lessons'] as $lesson): ?>
                                                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                                        <span>
                                                            <i class="fa fa-<?php echo ($lesson['type'] === 'video') ? 'play-circle' : 'file-pdf'; ?> me-2 text-primary"></i>
                                                            <?php echo $lesson['title']; ?>
                                                        </span>
                                                        <span class="badge bg-light text-dark rounded-circle border p-2"><i class="fa fa-check text-success"></i></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
