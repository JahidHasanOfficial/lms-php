<?php
require_once 'config/session.php';
require_once 'classes/Course.php';

$slug = $_GET['slug'] ?? '';
$courseObj = new Course($pdo);
$course = $courseObj->getBySlug($slug);

if (!$course) {
    redirect('index.php');
}

$curriculum = $courseObj->getCurriculum($course['id']);
$faqs = $courseObj->getFaqs($course['id']);
$projects = $courseObj->getProjects($course['id']);

$what_learn = json_decode($course['what_will_learn'], true) ?: [];
$requirements = json_decode($course['requirements'], true) ?: [];

include 'includes/header.php';
?>

<!-- Course Header Section -->
<div class="container-fluid bg-dark text-white py-5 mb-5" style="background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('<?php echo $course['thumbnail']; ?>'); background-size: cover;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 text-white mb-4"><?php echo $course['title']; ?></h1>
                <p class="lead mb-4"><?php echo substr($course['description'], 0, 200); ?>...</p>
                <div class="d-flex align-items-center mb-4">
                    <img class="img-fluid rounded-circle mr-3" src="backend-template/images/layout_img/user_img.jpg" width="50">
                    <span class="mr-4">Created by: <strong><?php echo $course['instructor_name']; ?></strong></span>
                    <span class="mr-4"><i class="fa fa-star text-warning"></i> 4.8 (2,500 ratings)</span>
                    <span><i class="fa fa-users text-primary"></i> 15,000+ Enrolled</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="mr-4">Last updated: <?php echo date('M Y', strtotime($course['updated_at'])); ?></span>
                    <span><i class="fa fa-globe"></i> English / Bengali</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-0 overflow-hidden rounded">
                        <div class="position-relative">
                            <img src="<?php echo $course['thumbnail']; ?>" class="img-fluid w-100">
                            <a href="<?php echo $course['video_preview_url']; ?>" target="_blank" class="btn btn-primary position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-play"></i>
                            </a>
                        </div>
                        <div class="p-4">
                            <div class="d-flex align-items-center mb-3">
                                <h2 class="mb-0 text-primary mr-3">$<?php echo $course['discount_price'] ?: $course['price']; ?></h2>
                                <?php if ($course['discount_price']): ?>
                                    <del class="text-muted">$<?php echo $course['price']; ?></del>
                                <?php endif; ?>
                            </div>
                            <a href="enroll.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-block py-3 font-weight-bold">Enroll Now</a>
                            <p class="text-center mt-3 small text-muted">30-Day Money-Back Guarantee</p>
                            
                            <hr>
                            <h6 class="font-weight-bold mb-3">This course includes:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fa fa-video-camera text-primary mr-2"></i> <?php echo $course['total_duration_hours']; ?> hours on-demand video</li>
                                <li class="mb-3"><i class="fa fa-file-text text-primary mr-2"></i> Full lifetime access</li>
                                <li class="mb-3"><i class="fa fa-mobile text-primary mr-2"></i> Access on mobile and TV</li>
                                <li class="mb-2"><i class="fa fa-certificate text-primary mr-2"></i> Certificate of completion</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Learning Objectives -->
            <div class="card mb-5 border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <h3 class="mb-4">What you'll learn</h3>
                    <div class="row">
                        <?php foreach ($what_learn as $item): ?>
                            <div class="col-md-6 mb-3">
                                <i class="fa fa-check text-success mr-2"></i> <?php echo $item; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Curriculum -->
            <h3 class="mb-4">Course Content</h3>
            <div class="accordion mb-5" id="curriculumAccordion">
                <?php foreach ($curriculum as $section): ?>
                <div class="card border-0 mb-2 shadow-sm">
                    <div class="card-header bg-white p-3 d-flex justify-content-between cursor-pointer" id="heading<?php echo $section['id']; ?>" data-toggle="collapse" data-target="#collapse<?php echo $section['id']; ?>">
                        <h6 class="mb-0 font-weight-bold"><i class="fa fa-chevron-right mr-2 small text-muted"></i> <?php echo $section['title']; ?></h6>
                        <span class="text-muted small"><?php echo count($section['lessons']); ?> lessons</span>
                    </div>
                    <div id="collapse<?php echo $section['id']; ?>" class="collapse" data-parent="#curriculumAccordion">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($section['lessons'] as $lesson): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-play-circle mr-2 text-primary"></i> <?php echo $lesson['title']; ?></span>
                                    <span class="text-muted small"><?php echo $lesson['duration']; ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Description -->
            <h3 class="mb-4">Description</h3>
            <div class="mb-5 text-muted lead">
                <?php echo nl2br($course['description']); ?>
            </div>

            <!-- FAQ -->
            <h3 class="mb-4">Frequently Asked Questions</h3>
            <div class="accordion mb-5" id="faqAccordion">
                <?php foreach ($faqs as $index => $faq): ?>
                <div class="card border-0 mb-2 shadow-sm">
                    <div class="card-header bg-white p-3" id="faq<?php echo $index; ?>" data-toggle="collapse" data-target="#faqCollapse<?php echo $index; ?>">
                        <h6 class="mb-0"><?php echo $faq['question']; ?></h6>
                    </div>
                    <div id="faqCollapse<?php echo $index; ?>" class="collapse" data-parent="#faqAccordion">
                        <div class="card-body text-muted">
                            <?php echo $faq['answer']; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
