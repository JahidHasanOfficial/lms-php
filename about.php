<?php
require_once 'config/session.php';
require_once 'classes/Course.php';
require_once 'classes/Category.php';

$courseObj = new Course($pdo);
$categoryObj = new Category($pdo);

// Fetch Necessary Data
$about_us = $pdo->query("SELECT * FROM about_us WHERE id = 1")->fetch();
$team_members = $pdo->query("SELECT * FROM team_members WHERE status = 'active' ORDER BY id ASC")->fetchAll();
$home_partners = $pdo->query("SELECT * FROM home_partners WHERE status = 'active' ORDER BY id ASC")->fetchAll();
$site_stats = $pdo->query("SELECT * FROM site_stats WHERE id = 1")->fetch();

require_once 'includes/header.php';
?>

<!-- Custom Style Link -->
<link href="frontend-template/css/about-custom.css" rel="stylesheet">

<div class="about-page-wrapper">
    <!-- Hero Section Start -->
    <div class="container-fluid p-0 mb-5 overflow-hidden">
        <div class="about-hero animate-up">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="container py-5 text-center hero-content position-relative" style="z-index: 2;">
                <h6 class="text-primary text-uppercase fw-bold mb-3 animate__animated animate__fadeIn" style="letter-spacing: 5px;">Interactive Cares</h6>
                <h1 class="display-1 text-white mb-4 animate__animated animate__zoomIn">Designing The Future Of Learning</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Partners Section Start -->
    <div class="container-fluid partners-section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row align-items-center g-4 justify-content-center">
                <?php foreach (array_slice($home_partners, 0, 5) as $partner): ?>
                    <div class="col-lg-2 col-md-4 col-6 text-center"><img src="<?php echo $partner['image']; ?>" class="partner-logo-item img-fluid" alt=""></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Partners Section End -->

    <!-- Experience Section Start -->
    <div class="container-xxl py-5 position-relative">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="experience-image-wrapper">
                        <img class="img-fluid w-100" src="<?php echo $about_us['image'] ?: 'frontend-template/img/about.jpg'; ?>" alt="About" style="min-height: 500px; object-fit: cover;">
                        <div class="experience-badge animate__animated animate__pulse animate__infinite">
                            <h2>15+</h2>
                            <p>Years of <br> Excellence</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                    <h6 class="section-title text-start bg-light text-primary pe-3">Our Identity</h6>
                    <h1 class="mb-4 display-5 fw-bold text-dark"><?php echo $about_us['title'] ?: 'Empowering Minds, Transforming Futures'; ?></h1>
                    <p class="mb-4 lead text-secondary"><?php echo nl2br($about_us['subtitle'] ?: 'Interactive Cares is building a community of lifelong learners.'); ?></p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="value-item shadow-sm"><i class="fa fa-graduation-cap text-primary"></i>
                                <h5>Expert Led Courses</h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="value-item shadow-sm"><i class="fa fa-certificate text-primary"></i>
                                <h5>Global Accreditation</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a class="btn btn-gradient rounded-pill py-3 px-5 me-4" href="courses.php">Explore Courses</a>
                        <div class="d-flex align-items-center">
                            <div class="btn-lg-square bg-primary text-white rounded-circle shadow"><i class="fa fa-phone-alt"></i></div>
                            <div class="ms-3">
                                <p class="mb-1 text-secondary">Contact Us</p>
                                <h5 class="mb-0 text-dark fw-bold">+012 345 6789</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Experience Section End -->

    <!-- Learning Process Start -->
    <div class="container-xxl py-5 process-section">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center bg-light text-primary px-3">How it works</h6>
                <h1 class="mb-5 display-5 fw-bold">Your Success Blueprint</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="process-step-box">
                        <div class="process-step-num">01</div>
                        <h4 class="mt-3">Join Program</h4>
                        <p class="text-secondary">Explore and enroll in industry-vetted courses tailored for your career.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="process-step-box">
                        <div class="process-step-num">02</div>
                        <h4 class="mt-3">Learn & Apply</h4>
                        <p class="text-secondary">Engage with expert mentors and apply knowledge to real projects.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="process-step-box">
                        <div class="process-step-num">03</div>
                        <h4 class="mt-3">Get Certified</h4>
                        <p class="text-secondary">Validate your skills with a globally recognized professional certificate.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="process-step-box">
                        <div class="process-step-num">04</div>
                        <h4 class="mt-3">Land Dream Job</h4>
                        <p class="text-secondary">Access our hiring network and launch your career with confidence.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Learning Process End -->

    <!-- Mentors Section Start -->
    <div class="container-xxl py-5 mentors-section">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary px-3">Expertise</h6>
                <h1 class="mb-5 display-5 fw-bold">Learn from Industry Leaders</h1>
            </div>
            <div class="row g-4">
                <?php if (!empty($team_members)): ?>
                    <?php foreach (array_slice($team_members, 0, 4) as $m): ?>
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-card bg-white shadow-sm rounded-4 p-4 h-100 text-center border-0">
                                <div class="position-relative d-inline-block mb-4">
                                    <img class="img-fluid rounded-circle p-1 border border-primary border-2" src="<?php echo $m['image']; ?>" alt="<?php echo $m['name']; ?>" style="width: 140px; height: 140px; object-fit: cover;">
                                </div>
                                <h5 class="mb-1 fw-bold"><?php echo $m['name']; ?></h5>
                                <small class="text-muted d-block mb-3"><?php echo $m['designation']; ?></small>
                                <div class="text-warning small mb-4">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                </div>
                                <button class="btn w-100 py-3 fw-bold text-white rounded-pill shadow-none view-profile-btn" style="background-color: #2BC5D4; transition: 0.3s;" data-bs-toggle="modal" data-bs-target="#instructorModal" data-name="<?php echo htmlspecialchars($m['name']); ?>" data-designation="<?php echo htmlspecialchars($m['designation']); ?>" data-image="<?php echo $m['image']; ?>" data-specializations="<?php echo htmlspecialchars($m['specializations'] ?? ''); ?>" data-education="<?php echo htmlspecialchars($m['education'] ?? ''); ?>" data-experience="<?php echo htmlspecialchars($m['work_experience'] ?? ''); ?>" data-workplace="<?php echo htmlspecialchars($m['work_places'] ?? ''); ?>" data-training="<?php echo htmlspecialchars($m['training_experience'] ?? ''); ?>" data-students="<?php echo htmlspecialchars($m['total_students'] ?? ''); ?>">
                                    View Profile
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">No instructors found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Mentors Section End -->

    <!-- Stats Section Start -->
    <div class="container-fluid stats-section my-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa fa-user-graduate"></i></div><span class="stat-number"><?php echo $site_stats['learners_count'] ?: '50k'; ?>+</span><span class="stat-label">Active Learners</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa fa-laptop-code"></i></div><span class="stat-number"><?php echo $site_stats['courses_count'] ?: '200'; ?>+</span><span class="stat-label">Premium Courses</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa fa-chalkboard-teacher"></i></div><span class="stat-number">150+</span><span class="stat-label">Expert Mentors</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fa fa-award"></i></div><span class="stat-number">95%</span><span class="stat-label">Success Rate</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Stats Section End -->

    <!-- Gallery Section Start -->
    <div class="container-xxl py-5 gallery-section mt-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary px-3">Our World</h6>
                <h1 class="mb-5 display-5 fw-bold">Life at Interactive Cares</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="gallery-item"><img src="frontend-template/img/cat-1.jpg" alt="Culture 1">
                        <div class="gallery-overlay">
                            <h5>Innovation Hub</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="gallery-item"><img src="frontend-template/img/cat-2.jpg" alt="Culture 2">
                        <div class="gallery-overlay">
                            <h5>Global Workspace</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="gallery-item"><img src="frontend-template/img/cat-3.jpg" alt="Culture 3">
                        <div class="gallery-overlay">
                            <h5>Student Meetups</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Section End -->

    <!-- Journey Section Start -->
    <div class="container-xxl py-5 journey-section">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary px-3">Our History</h6>
                <h1 class="mb-5 display-5 fw-bold">The Journey of Impact</h1>
            </div>
            <div class="timeline">
                <div class="timeline-item left wow slideInLeft" data-wow-delay="0.1s">
                    <div class="timeline-content">
                        <h5 class="fw-bold text-primary">2010 - The Beginning</h5>
                        <p class="mb-0 text-secondary">Started as a small tutoring center with a vision to revolutionize learning through digital media.</p>
                    </div>
                </div>
                <div class="timeline-item right wow slideInRight" data-wow-delay="0.2s">
                    <div class="timeline-content">
                        <h5 class="fw-bold text-primary">2015 - Going Digital</h5>
                        <p class="mb-0 text-secondary">Launched our first online platform, reaching students across the nation for the first time.</p>
                    </div>
                </div>
                <div class="timeline-item left wow slideInLeft" data-wow-delay="0.3s">
                    <div class="timeline-content">
                        <h5 class="fw-bold text-primary">2020 - Global Reach</h5>
                        <p class="mb-0 text-secondary">Expanded services internationally and introduced mentor-based learning models.</p>
                    </div>
                </div>
                <div class="timeline-item right wow slideInRight" data-wow-delay="0.4s">
                    <div class="timeline-content">
                        <h5 class="fw-bold text-primary">Today - EdTech Leader</h5>
                        <p class="mb-0 text-secondary">Leading the industry with 200+ courses and a community of 50k+ active learners.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Journey Section End -->

    <!-- Testimonial Section Start -->
    <div class="container-xxl py-5 testimonial-section">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary px-3">Success Stories</h6>
                <h1 class="mb-5 display-5 fw-bold">Words from Our Alumni</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-box"><i class="fa fa-quote-right quote-icon"></i>
                        <p class="mb-0">This platform changed my life! Practical courses for real-world jobs.</p>
                        <div class="testimonial-user"><img src="frontend-template/img/testimonial-1.jpg" alt="User 1">
                            <div>
                                <h6>Rubens Davis</h6><small>Software Engineer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="testimonial-box"><i class="fa fa-quote-right quote-icon"></i>
                        <p class="mb-0">Interactive learning at its best. Career growth is guaranteed.</p>
                        <div class="testimonial-user"><img src="frontend-template/img/testimonial-2.jpg" alt="User 2">
                            <div>
                                <h6>Jesicca Doe</h6><small>UX Designer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="testimonial-box"><i class="fa fa-quote-right quote-icon"></i>
                        <p class="mb-0">Bridges the gap between theory and industry reality perfectly.</p>
                        <div class="testimonial-user"><img src="frontend-template/img/testimonial-3.jpg" alt="User 3">
                            <div>
                                <h6>Alex Morgan</h6><small>Data Scientist</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial Section End -->

    <!-- FAQ Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-start text-primary pe-3">Common Queries</h6>
                    <h1 class="mb-4 display-6 fw-bold">Frequently Asked Questions</h1>
                    <div class="faq-container">
                        <div class="faq-item">
                            <div class="faq-header">
                                <h5>Instructors?</h5><i class="fa fa-chevron-down"></i>
                            </div>
                            <div class="faq-body">Industry experts with years of experience.</div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-header">
                                <h5>Certificate?</h5><i class="fa fa-chevron-down"></i>
                            </div>
                            <div class="faq-body">Globally recognized certificate upon completion.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="rounded p-5 bg-light shadow-lg position-relative overflow-hidden">
                        <div class="floating-shape shape-2" style="opacity: 0.05;"></div>
                        <h3 class="fw-bold mb-4">Have Questions?</h3>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6"><input type="text" class="form-control border-white py-3" placeholder="Name"></div>
                                <div class="col-md-6"><input type="email" class="form-control border-white py-3" placeholder="Email"></div>
                                <div class="col-12"><textarea class="form-control border-white" placeholder="Message" style="height: 150px"></textarea></div>
                                <div class="col-12"><button class="btn btn-gradient w-100 py-3 rounded-pill" type="submit">Send Message</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section End -->

    <!-- CTA Section Start -->
    <div class="container-fluid bg-primary py-5 my-5 wow zoomIn" data-wow-delay="0.1s">
        <div class="container py-5 text-center">
            <h1 class="text-white mb-4 display-5 fw-bold">Ready to Start Your Journey?</h1>
            <p class="text-white mb-4 lead opacity-75">Join thousands of students and transform your career today.</p>
            <div class="d-flex justify-content-center"><a href="register.php" class="btn btn-light py-3 px-5 rounded-pill me-3 shadow-lg">Join Now <i class="fa fa-arrow-right ms-2"></i></a><a href="courses.php" class="btn btn-outline-light py-3 px-5 rounded-pill shadow">Browse Courses</a></div>
        </div>
    </div>
    <!-- CTA Section End -->
</div>

<!-- Modal Logic for Profiles -->
<?php include 'includes/home_sections/team_home.php'; // Includes instructor modal logic ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const counters = document.querySelectorAll('.stat-number');
        const animateCounter = (counter) => {
            const targetStr = counter.innerText.replace('+', '').replace('k', '000').replace('%', '');
            const target = +targetStr;
            const increment = target / 100;
            const updateCounter = () => {
                const count = +counter.innerText.replace(/[^\d]/g, '');
                if (count < target) {
                    const nextValue = Math.ceil(count + increment);
                    if (nextValue >= target) {
                        counter.innerText = counter.innerText.includes('k') ? (target / 1000) + 'k+' : counter.innerText.includes('%') ? target + '%' : target + '+';
                    } else {
                        counter.innerText = nextValue + (counter.innerText.includes('k') ? 'k+' : counter.innerText.includes('%') ? '%' : '+');
                        setTimeout(updateCounter, 10);
                    }
                }
            };
            updateCounter();
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });
        counters.forEach(counter => observer.observe(counter));
        document.querySelectorAll('.faq-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                item.classList.toggle('active');
                document.querySelectorAll('.faq-item').forEach(otherItem => {
                    if (otherItem !== item) otherItem.classList.remove('active');
                });
            });
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>
