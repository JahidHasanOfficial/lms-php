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

// Dynamic Stats
$stmt_stats = $pdo->prepare("SELECT COUNT(*) as student_count FROM enrollments WHERE course_id = ?");
$stmt_stats->execute([$course['id']]);
$student_count = $stmt_stats->fetchColumn();

$stmt_rating = $pdo->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM course_reviews WHERE course_id = ?");
$stmt_rating->execute([$course['id']]);
$rating_data = $stmt_rating->fetch();
$avg_rating = number_format($rating_data['avg_rating'] ?: 0, 1);
$review_count = $rating_data['review_count'];

// Fetch Reviews
$stmt_rev = $pdo->prepare("SELECT cr.*, u.name as user_name, u.profile_pic FROM course_reviews cr JOIN users u ON cr.user_id = u.id WHERE cr.course_id = ? ORDER BY cr.created_at DESC");
$stmt_rev->execute([$course['id']]);
$reviews = $stmt_rev->fetchAll();

// Platform Benefits
$stmt_ben = $pdo->query("SELECT * FROM platform_benefits");
$platform_benefits = $stmt_ben->fetchAll();

// Handle Consultation Booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_consultation'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $batch_id = (int)$_POST['batch_id'];
    $stmt = $pdo->prepare("INSERT INTO consultation_requests (name, email, phone, course_id, batch_id) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $phone, $course['id'], $batch_id])) {
        $_SESSION['consult_success'] = 'Your consultation request has been sent! We will contact you soon.';
        header("Location: course-details.php?slug=" . $slug . "#consultation-form");
        exit();
    }
}

// Fetch Batches for this course
$stmt_batches = $pdo->prepare("SELECT * FROM batches WHERE course_id = ? AND status = 'active' ORDER BY batch_no DESC");
$stmt_batches->execute([$course['id']]);
$available_batches = $stmt_batches->fetchAll();

include 'includes/header.php';

// Fetch additional premium data
$course_id = $course['id'];
$outcomes = $courseObj->getOutcomes($course_id);
$features = $courseObj->getFeatures($course_id);
$faqs = $courseObj->getFaqs($course_id);
$projects = $courseObj->getProjects($course_id);
$instructors = $courseObj->getInstructors($course_id);
if (empty($instructors)) {
    // Basic fallback to the main instructor from the courses table
    $stmt_inst = $pdo->prepare("SELECT u.* FROM users u WHERE u.id = ?");
    $stmt_inst->execute([$course['instructor_id']]);
    $instructors = [$stmt_inst->fetch()];
}
$testimonials = $courseObj->getTestimonials($course_id);
$curriculum = $courseObj->getCurriculum($course_id);
?>

<style>
:root {
    --primary-neon: #ccff00;
    --primary-blue: #007bff;
    --bg-white: #ffffff;
    --bg-light: #f8fafc;
    --card-bg: #ffffff;
    --text-dark: #1e293b;
    --text-muted: #64748b;
    --header-gradient: radial-gradient(circle at 20% 50%, rgba(0, 123, 255, 0.05) 0%, transparent 40%),
                       radial-gradient(circle at 80% 80%, rgba(204, 255, 0, 0.1) 0%, transparent 40%),
                       #ffffff;
}

body {
    background-color: var(--bg-white);
    color: var(--text-dark);
    font-family: 'Inter', 'Heebo', sans-serif;
}

/* Header & Breadcrumb */
.premium-course-header {
    background: var(--header-gradient);
    padding: 80px 0 100px;
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.premium-course-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(0,0,0,0.02) 1px, transparent 1px);
    background-size: 30px 30px;
    opacity: 0.8;
}

.breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
    color: var(--text-muted);
    content: "/";
}

/* Sub Navigation */
.sub-nav-sticky {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 999;
}

.nav-link-premium {
    color: var(--text-muted);
    padding: 1.25rem 1rem;
    font-weight: 500;
    transition: all 0.3s;
    border-bottom: 3px solid transparent;
    cursor: pointer;
}

.nav-link-premium:hover, .nav-link-premium.active {
    color: var(--primary-blue);
    border-bottom-color: var(--primary-blue);
}

/* Sidebar & Cards */
.sticky-sidebar {
    position: sticky;
    top: 130px;
    z-index: 10;
    align-self: flex-start;
}

.premium-card {
    background: var(--card-bg);
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
}

.btn-neon {
    background-color: #000;
    color: var(--primary-neon);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    transition: transform 0.2s, box-shadow 0.2s;
}

.btn-neon:hover {
    background-color: #222;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    color: var(--primary-neon);
}

/* Accordion Custom */
.accordion-premium .accordion-item {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 12px;
    margin-bottom: 15px;
    overflow: hidden;
}

.accordion-premium .accordion-button {
    background: transparent !important;
    color: var(--text-dark) !important;
    padding: 20px 25px;
    font-weight: 600;
}

.accordion-premium .accordion-button:not(.collapsed) {
    background: var(--bg-light) !important;
}

/* Grid & Images */
.project-thumb {
    border-radius: 15px;
    overflow: hidden;
    position: relative;
    aspect-ratio: 16/10;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
}

.project-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.project-thumb:hover img {
    transform: scale(1.08);
}

.instructor-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid var(--bg-light);
}

.project-overlay {
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
}

/* Text Overrides */
.text-primary-neon {
    color: var(--primary-blue) !important; /* Switch to primary blue for light theme accents */
}

.opacity-75, .opacity-80 {
    opacity: 1 !important; /* Full opacity on light theme for contrast */
}

.border-white\/5 {
    border-color: rgba(0,0,0,0.05) !important;
}

.project-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.project-thumb:hover img {
    transform: scale(1.08);
}

.instructor-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid rgba(204, 255, 0, 0.1);
}

@media (max-width: 991px) {
    .sub-nav-sticky { display: none; }
}
</style>

<!-- Top Hero Section -->
<section class="premium-course-header">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb breadcrumb-custom bg-transparent p-0 small">
                        <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="courses.php" class="text-muted">Career Paths</a></li>
                        <li class="breadcrumb-item active text-white"><?php echo $course['title']; ?></li>
                    </ol>
                </nav>
                <h1 class="font-weight-bold display-4 mb-3" style="color: dark;"><?php echo $course['title']; ?> <span class="text-primary-neon" style="color:var(--primary-neon);">+</span></h1>
                <p class="lead opacity-75 mb-5" style="max-width: 600px; font-size: 1rem; line-height: 1.8;">
                    <?php echo strip_tags($course['description']); ?>
                </p>

                <div class="d-flex align-items-center mb-5">
                    <?php 
                        $regPrice = $course['price'] > 0 ? $course['price'] : 10000;
                        $finalPrice = $course['discount_price'] ?: $course['price'];
                    ?>
                    <h2 class="font-weight-bold mr-4 mb-0" style="font-size: 1.8rem;">৳<?php echo number_format($finalPrice); ?> BDT</h2>
                    <?php if ($course['discount_price']): ?>
                        <del class="text-muted mr-3 mb-0 h6">৳<?php echo number_format($regPrice); ?></del>
                    <?php endif; ?>
                </div>

                <div class="d-flex flex-wrap gap-4">
                    <a href="enroll.php?id=<?php echo $course['id']; ?>" class="btn btn-neon px-5 py-3 rounded-pill btn-lg mb-2">এনরোল করুন <i class="fa fa-arrow-right ml-2"></i></a>
                    <a href="#" class="btn btn-outline-light px-5 py-3 rounded-pill btn-lg mb-2 opacity-75 d-none">সিলেবাস ডাউনলোড <i class="fa fa-download ml-2"></i></a>
                </div>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0">
                <div class="position-relative rounded-20 overflow-hidden shadow-2xl" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                    <?php 
                        $thumb = $course['thumbnail']; 
                        $thumb_url = (empty($thumb) || strpos($thumb, 'course_') !== false) ? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800' : $thumb;
                    ?>
                    <img src="<?php echo $thumb_url; ?>" class="img-fluid w-100" style="filter: brightness(0.95); aspect-ratio: 16/9; object-fit: cover;">
                    <div class="position-absolute inset-0 d-flex align-items-center justify-content-center" style="top:0;left:0;right:0;bottom:0;">
                        <a href="#" class="rounded-circle bg-white shadow-lg d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; transition: 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="fa fa-play text-primary fa-2x ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sub Nav -->
<nav class="sub-nav-sticky">
    <div class="container">
        <div class="d-flex justify-content-center gap-2">
            <a href="#curriculum" class="nav-link-premium section-trigger active">কারিকুলাম</a>
            <a href="#instructors" class="nav-link-premium section-trigger">ইন্সট্রাক্টর</a>
            <a href="#projects" class="nav-link-premium section-trigger">প্রজেক্টসমূহ</a>
            <a href="#reviews" class="nav-link-premium section-trigger">মতামত</a>
            <a href="#faq" class="nav-link-premium section-trigger">জিজ্ঞাসিত প্রশ্ন</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            
            <!-- Features (What's Included) -->
            <div id="features" class="mb-5 py-5 border-bottom border-white/5">
                <h3 class="font-weight-bold mb-5">এই কোর্সে যা যা থাকছে</h3>
                <div class="row">
                    <?php if($features): ?>
                        <?php foreach($features as $feat): ?>
                            <div class="col-md-6 mb-4 d-flex">
                                <i class="fa fa-check-circle text-primary-neon mr-3 mt-1" style="color:#27ae60;"></i>
                                <span class="opacity-80 font-weight-bold" style="color:var(--text-dark);"><?php echo $feat['feature']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1" style="color:#27ae60;"></i> <span class="opacity-80 font-weight-bold">১০০+ প্রি-রেকর্ডড ভিডিও</span></div>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1" style="color:#27ae60;"></i> <span class="opacity-80 font-weight-bold">১০ টি প্রজেক্ট</span></div>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1" style="color:#27ae60;"></i> <span class="opacity-80 font-weight-bold">জব প্লেসমেন্ট সাপোর্ট</span></div>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1" style="color:#27ae60;"></i> <span class="opacity-80 font-weight-bold">লাইভ সাপোর্ট সেশন</span></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Learning Outcomes -->
            <div id="outcomes" class="mb-5 py-5 border-bottom border-white/5">
                <h3 class="font-weight-bold mb-5">এই কোর্স থেকে আপনি কী কী শিখবেন?</h3>
                <div class="row">
                    <?php if($outcomes): ?>
                        <?php foreach($outcomes as $outcome): ?>
                            <div class="col-md-6 mb-4 d-flex">
                                <i class="fa fa-check-circle text-primary-neon mr-3 mt-1" style="color:var(--primary-neon);"></i>
                                <span class="opacity-80"><?php echo $outcome['outcome']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1 text-primary-neon"></i> <span class="opacity-80">আধুনিক ফ্রন্টএন্ড ওয়েব ডেভেলপমেন্ট মাস্টারি</span></div>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1 text-primary-neon"></i> <span class="opacity-80">প্রফেশনাল লেভেল ব্যাকএন্ড সার্ভার ম্যানেজমেন্ট</span></div>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1 text-primary-neon"></i> <span class="opacity-80">১০+ পজিটিভ রিয়েল লাইফ প্রজেক্ট পোর্টফোলিও</span></div>
                        <div class="col-md-6 mb-4 d-flex"><i class="fa fa-check-circle mr-3 mt-1 text-primary-neon"></i> <span class="opacity-80">জব এবং ফ্রিল্যান্সিং ক্যারিয়ার গাইডেন্স</span></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Curriculum -->
            <section id="curriculum" class="mb-5 py-5 border-bottom border-white/5">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <h3 class="font-weight-bold m-0">কোর্স কারিকুলাম</h3>
                    <span class="text-muted small">৮০+ ঘণ্টার আপ-টু-ডেট সিলেবাস</span>
                </div>
                <div class="accordion accordion-premium" id="curriculumAccordion">
                    <?php foreach ($curriculum as $idx => $section): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="head<?php echo $section['id']; ?>">
                                <button class="accordion-button <?php echo $idx === 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $section['id']; ?>">
                                    <div class="d-flex justify-content-between w-100 pr-4">
                                        <span><?php echo $section['title']; ?></span>
                                        <span class="text-muted font-weight-light small"><?php echo count($section['lessons']); ?> লেসন</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $section['id']; ?>" class="accordion-collapse collapse <?php echo $idx === 0 ? 'show' : ''; ?>" data-bs-parent="#curriculumAccordion">
                                <div class="accordion-body px-0 py-0 pb-3">
                                    <ul class="list-group list-group-flush bg-transparent">
                                        <?php foreach ($section['lessons'] as $lesson): ?>
                                            <li class="list-group-item bg-transparent border-white/5 py-3 d-flex align-items-center">
                                                <i class="fa fa-play-circle mr-3 opacity-50 <?php echo $lesson['type'] === 'video' ? 'text-primary' : 'text-muted'; ?>"></i>
                                                <span class="opacity-75"><?php echo $lesson['title']; ?></span>
                                                <span class="ml-auto small text-muted italic"><?php echo $lesson['duration']; ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Instructors -->
            <section id="instructors" class="mb-5 py-5 border-bottom border-white/5">
                <h3 class="font-weight-bold mb-5">কোর্স ইন্সট্রাক্টর মেন্টর প্যানেল</h3>
                <div class="row">
                    <?php foreach($instructors as $inst): ?>
                        <div class="col-md-6 mb-4">
                            <div class="premium-card h-100 text-center">
                                <?php 
                                    $p_pic = $inst['profile_pic'];
                                    $p_url = (empty($p_pic) || $p_pic == 'default_user.png') ? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300' : $p_pic;
                                ?>
                                <img src="<?php echo $p_url; ?>" class="instructor-img mb-4">
                                <h4 class="font-weight-bold mb-1"><?php echo $inst['name']; ?></h4>
                                <p class="text-primary-neon small mb-3"><?php echo $inst['role'] ?: 'Lead Instructor'; ?></p>
                                <p class="small text-muted mb-4 opacity-75">
                                    <?php echo $inst['bio'] ?: 'দীর্ঘ ৫+ বছর যাবত ইন্ডাস্ট্রিতে কাজ করার অভিজ্ঞতা নিয়ে আপনার শেখার যাত্রাকে আরও সহজ করতে আমি থাকছি আপনার সাথে।'; ?>
                                </p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="#" class="text-muted"><i class="fab fa-linkedin-in fa-lg"></i></a>
                                    <a href="#" class="text-muted"><i class="fab fa-facebook-f fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Projects -->
            <section id="projects" class="mb-5 py-5 border-bottom border-white/5">
                <h3 class="font-weight-bold mb-5">রিয়েল লাইফ প্রজেক্ট পোর্টফোলিও</h3>
                <div class="row g-4">
                    <?php if($projects): ?>
                        <?php foreach($projects as $p): ?>
                            <div class="col-md-6 mb-4">
                                <div class="project-thumb">
                                    <?php 
                                        $p_img = $p['image'];
                                        $p_img_url = (empty($p_img) || strpos($p_img, 'course_') !== false) ? 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600' : $p_img;
                                    ?>
                                    <img src="<?php echo $p_img_url; ?>" alt="Project">
                                    <div class="position-absolute p-4 text-white" style="bottom:0; background:linear-gradient(transparent, rgba(0,0,0,0.8)); left:0; right:0;">
                                        <h5 class="m-0 font-weight-bold text-white">
                                            <strong class="text-white p-2 bg-primary"><?php echo $p['title']; ?></strong>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-6 mb-4"><div class="project-thumb"><img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600" alt="P1"></div></div>
                        <div class="col-md-6 mb-4"><div class="project-thumb"><img src="https://images.unsplash.com/photo-1551033406-611cf9a28f67?w=600" alt="P2"></div></div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Reviews -->
            <section id="reviews" class="mb-5 py-5 border-bottom border-white/5">
                <h3 class="font-weight-bold mb-5">শিক্ষার্থীদের মূল্যবান মতামত</h3>
                <div class="row">
                    <?php if($testimonials): ?>
                        <?php foreach($testimonials as $t): ?>
                            <div class="col-md-6 mb-4">
                                <div class="premium-card h-100">
                                    <div class="text-warning mb-3">
                                        <?php for($i=0; $i<$t['rating']; $i++): ?><i class="fa fa-star"></i><?php endfor; ?>
                                    </div>
                                    <p class="small text-muted mb-4">"<?php echo $t['comment']; ?>"</p>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0 font-weight-bold"><?php echo $t['student_name']; ?></h6>
                                            <small class="text-muted opacity-50"><?php echo $t['student_role']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-6 mb-4"><div class="premium-card"><h6>মোঃ আরিফ হোসেন</h6><small>ফুল স্ট্যাক ডেভেলপার</small><p class="small mt-3 opacity-75">এই কোর্সটি করে আমার ক্যারিয়ারের আমূল পরিবর্তন এসেছে।</p></div></div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- FAQ -->
            <section id="faq" class="py-5 mb-5">
                <h3 class="font-weight-bold mb-5">Frequently asked questions</h3>
                <div class="accordion accordion-premium" id="faqAccordion">
                    <?php if($faqs): ?>
                        <?php foreach($faqs as $f_idx => $faq): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f<?php echo $f_idx; ?>"><?php echo $faq['question']; ?></button></h2>
                                <div id="f<?php echo $f_idx; ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body opacity-75"><?php echo $faq['answer']; ?></div></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#f1">কোর্সটি কি একদম বিগিনারদের জন্য?</button></h2><div id="f1" class="accordion-collapse collapse show"><div class="accordion-body">জ্বি, এই কোর্সটি একদম জিরো থেকে শুরু করা হয়েছে যাতে যে কেউ শিখতে পারে।</div></div></div>
                    <?php endif; ?>
                </div>
            </section>

        </div>

        <!-- Sticky Sidebar -->
        <div class="col-lg-4">
            <div class="sticky-sidebar">
                <div class="premium-card mb-4 text-center">
                    <h5 class="font-weight-bold mb-4">ভর্তি হওয়ার এখনই সময়!</h5>




                    <div class="mb-4">
                     <div class="d-flex justify-content-center align-items-center mb-5">
                    <?php 
                        $regPrice = $course['price'] > 0 ? $course['price'] : 10000;
                        $finalPrice = $course['discount_price'] ?: $course['price'];
                    ?>
                    <h2 class="font-weight-bold mr-4 mb-0" style="font-size: 1rem; padding-right: 5px;">৳<?php echo number_format($finalPrice); ?> BDT</h2>
                    <?php if ($course['discount_price']): ?>
                        <del class="text-muted mr-3 mb-0 h6">৳<?php echo number_format($regPrice); ?></del>
                    <?php endif; ?>
                </div>
                        <p class="text-muted small">সম্পূর্ণ কোর্স এবং লাইফটাইম এক্সেস</p>
                    </div>
                    <ul class="list-unstyled text-left small mb-5">
                        <li class="mb-3 d-flex align-items-center"><i class="fa fa-infinity text-primary-neon mr-3"></i> লাইফ টাইম এক্সেস গ্যারান্টি</li>
                        <li class="mb-3 d-flex align-items-center"><i class="fa fa-certificate text-primary-neon mr-3"></i> ভেরিফাইড ডিজিটাল সার্টিফিকেট</li>
                        <li class="mb-3 d-flex align-items-center"><i class="fa fa-headset text-primary-neon mr-3"></i> ২৪/৭ ডেডিকেটেড সাপোর্ট</li>
                        <li class="mb-3 d-flex align-items-center"><i class="fa fa-briefcase text-primary-neon mr-3"></i> ১০+ মেগা প্রজেক্ট পোর্টফোলিও</li>
                    </ul>
                    <a href="enroll.php?id=<?php echo $course['id']; ?>" class="btn btn-neon btn-block py-3 rounded-pill">এখনই ভর্তি হোন <i class="fa fa-plus-circle ml-1"></i></a>
                    <p class="mt-4 small text-muted"><i class="fa fa-shield mr-1"></i> Secure Payment by SSLCommerz</p>
                </div>

                <div class="premium-card">
                    <h6 class="font-weight-bold mb-3">সহযোগিতা প্রয়োজন?</h6>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="rounded-circle bg-primary-neon/10 p-2"><i class="fa fa-phone text-primary-neon"></i></div>
                        <span class="small">+880 1234 567890</span>
                    </div>
                    <p class="small text-muted m-0">সকাল ৯টা থেকে রাত ১০টা পর্যন্ত</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Platform Benefits Section -->
<section class="platform-benefits-section py-5 my-5" style="background-color: #f8fafc; border: 1px solid rgba(0,0,0,0.05); border-radius: 24px; color: #1e293b; margin-inline: 15px;">
    <div class="container text-center py-4">
        <h2 class="font-weight-bold mb-3" style="font-size: 2.2rem; color: #1e293b;">Interactive Cares এর কোর্স ও ক্যারিয়ার পাথগুলোর বেনিফিট</h2>
        <p class="text-muted mb-5 mx-auto" style="max-width: 800px;">ইন্ডাস্ট্রি স্ট্যান্ডার্ড আউটলাইন এবং দেশসেরা মেন্টরদের গাইডেন্সে নিজেকে প্রিপেয়ার করুন জব মার্কেটের জন্য!</p>
        
        <div class="row g-4 px-lg-5">
            <?php foreach($platform_benefits as $benefit): ?>
                <div class="col-md-4 mb-4 text-left d-flex align-items-center">
                    <div class="benefit-icon-wrapper p-3 mr-3" style="background: rgba(39, 174, 96, 0.08); border-radius: 12px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa <?php echo $benefit['icon']; ?> text-success" style="font-size: 1.2rem;"></i>
                    </div>
                    <span class="font-weight-bold" style="font-size: 0.95rem; color: #334155;"><?php echo $benefit['title']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Consultation Section -->
<section class="consultation-section py-5 my-5" style="background-color: #f8fafc; border: 1px solid rgba(0,0,0,0.05); border-radius: 24px; color: #1e293b; margin-inline: 15px; position: relative; overflow: hidden;">
    <div class="p-lg-5 p-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 text-left">
                <h1 class="font-weight-bold mb-2" style="font-size: 3rem; color: #1e293b;">Get Your Free</h1>
                <h1 class="font-weight-bold mb-4" style="font-size: 3rem; color: #00a65a;">Consultation Today!</h1>
                <p class="text-muted mb-5" style="font-size: 1.1rem; max-width: 450px;">Take the first step towards success. Schedule your free consultation today!</p>
                
                <div class="d-flex align-items-center">
                    <div class="avatar-stack d-flex mr-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" class="rounded-circle border border-white shadow-sm" style="width: 45px; height: 45px; margin-right: -15px;">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" class="rounded-circle border border-white shadow-sm" style="width: 45px; height: 45px; margin-right: -15px;">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop" class="rounded-circle border border-white shadow-sm" style="width: 45px; height: 45px;">
                    </div>
                    <span class="font-weight-bold text-muted">1500+ students got consultation</span>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1" id="consultation-form">
                <div class="card border-0 p-4 shadow-sm" style="background-color: #ffffff !important; border-radius: 20px; border: 1px solid rgba(0,0,0,0.05) !important;">
                    <h4 class="mb-4 font-weight-bold text-dark">Book the call</h4>
                    
                    <?php if (isset($_SESSION['consult_success'])): ?>
                        <div class="alert alert-success small"><?php echo $_SESSION['consult_success']; unset($_SESSION['consult_success']); ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group mb-4">
                            <label class="small text-muted font-weight-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" style="background: #fdfdfd; border: 1px solid #e2e8f0; color: #1e293b; height: 50px;" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small text-muted font-weight-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" style="background: #fdfdfd; border: 1px solid #e2e8f0; color: #1e293b; height: 50px;" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small text-muted font-weight-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" style="background: #fdfdfd; border: 1px solid #e2e8f0; color: #1e293b; height: 50px;" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small text-muted font-weight-bold">Select Batch</label>
                            <select name="batch_id" class="form-control" style="background: #fdfdfd; border: 1px solid #e2e8f0; color: #1e293b; height: 50px;">
                                <option value="">Select Target Batch</option>
                                <?php foreach($available_batches as $b): ?>
                                    <option value="<?php echo $b['id']; ?>">Batch <?php echo $b['batch_no']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="book_consultation" class="btn btn-block py-3 font-weight-bold shadow-sm" style="background-color: #00a65a; color: #fff; border-radius: 12px; font-size: 1.1rem; transition: all 0.3s;">Schedule Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Tab Activation on Scroll
window.addEventListener('scroll', () => {
    let sections = document.querySelectorAll('section');
    let navLinks = document.querySelectorAll('.nav-link-premium');
    
    sections.forEach(section => {
        let top = window.scrollY;
        let offset = section.offsetTop - 150;
        let height = section.offsetHeight;
        let id = section.getAttribute('id');
        
        if(top >= offset && top < offset + height) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if(link.getAttribute('href') == '#' + id) {
                    link.classList.add('active');
                }
            });
        }
    });
});

// Smooth Scroll
document.querySelectorAll('.section-trigger').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        window.scrollTo({
            top: document.querySelector(targetId).offsetTop - 130,
            behavior: 'smooth'
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
