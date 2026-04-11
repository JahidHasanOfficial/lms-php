<?php
require_once 'config/session.php';
require_once 'classes/Course.php';

// Fetch Success Stories
$success_stories = $pdo->query("SELECT * FROM success_stories WHERE status = 'active' ORDER BY id DESC")->fetchAll();

$pageTitle = "Success Stories - Our Proud Students";
require_once 'includes/header.php';
?>

<style>
    /* Premium Page Header */
    .success-header {
        background: linear-gradient(135deg, #111c26 0%, #1a2a3a 100%);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .success-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 30%, rgba(43, 197, 212, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(43, 197, 212, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .success-header::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-image: radial-gradient(#2bc5d4 0.5px, transparent 0.5px);
        background-size: 30px 30px;
        opacity: 0.1;
    }

    .success-header h1 {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(to right, #fff, #2bc5d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
    }

    .success-header p {
        color: rgba(255,255,255,0.7);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Success Grids */
    .success-section {
        background-color: #f8fdff;
        padding: 80px 0;
        position: relative;
    }

    .success-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(43, 197, 212, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        position: relative;
    }

    .success-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(17, 28, 38, 0.08);
        border-color: rgba(43, 197, 212, 0.3);
    }

    .thumbnail-wrapper {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .thumbnail-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .success-card:hover .thumbnail-wrapper img {
        transform: scale(1.1);
    }

    .play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(17, 28, 38, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.8;
        transition: 0.3s;
    }

    .success-card:hover .play-overlay {
        opacity: 1;
        background: rgba(17, 28, 38, 0.3);
    }

    .play-btn-circle {
        width: 60px;
        height: 60px;
        background: #2bc5d4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 0 0 0 rgba(43, 197, 212, 0.4);
        animation: pulse-teal 2s infinite;
        transition: 0.3s;
    }

    .success-card:hover .play-btn-circle {
        transform: scale(1.1);
        background: #25afbc;
    }

    @keyframes pulse-teal {
        0% { box-shadow: 0 0 0 0 rgba(43, 197, 212, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(43, 197, 212, 0); }
        100% { box-shadow: 0 0 0 0 rgba(43, 197, 212, 0); }
    }

    .success-content {
        padding: 1.5rem;
    }

    .student-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111c26;
        margin-bottom: 0.5rem;
    }

    .course-badge {
        display: inline-block;
        padding: 4px 12px;
        background: rgba(43, 197, 212, 0.1);
        color: #2bc5d4;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .rating-stars {
        color: #ffc107;
        margin-bottom: 1rem;
    }

    .watch-story-link {
        color: #2bc5d4;
        text-decoration: none;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .watch-story-link:hover {
        gap: 12px;
        color: #111c26;
    }

    /* Stats Section */
    .success-stats {
        background: white;
        padding: 50px 0;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .stat-item h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2bc5d4;
        margin-bottom: 0px;
    }

    .stat-item p {
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
    }
</style>

<?php 
$pageTitle = "Success Stories";
include 'includes/breadcrumb.php'; 
?>

<!-- Stats Bar -->
<section class="success-stats">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3 stat-item wow fadeIn" data-wow-delay="0.1s">
                <h2>500+</h2>
                <p>Successful Placements</p>
            </div>
            <div class="col-6 col-md-3 stat-item wow fadeIn" data-wow-delay="0.2s">
                <h2>150+</h2>
                <p>Hiring Partners</p>
            </div>
            <div class="col-6 col-md-3 stat-item wow fadeIn" data-wow-delay="0.3s">
                <h2>98%</h2>
                <p>Satisfaction Ratio</p>
            </div>
            <div class="col-6 col-md-3 stat-item wow fadeIn" data-wow-delay="0.4s">
                <h2>24/7</h2>
                <p>Mentor Support</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Stories Grid -->
<section class="success-section">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($success_stories as $index => $s): ?>
                <?php 
                    // Convert YouTube URL to Embed URL
                    $vidUrl = $s['video_url'];
                    if (strpos($vidUrl, 'watch?v=') !== false) {
                        $vidUrl = str_replace('watch?v=', 'embed/', $vidUrl);
                    } elseif (strpos($vidUrl, 'youtu.be/') !== false) {
                        $vidUrl = str_replace('youtu.be/', 'youtube.com/embed/', $vidUrl);
                    }
                    $delay = ($index % 3) * 0.1;
                ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                    <div class="success-card">
                        <div class="thumbnail-wrapper" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#videoModal" data-src="<?php echo $vidUrl; ?>">
                            <img src="<?php echo $s['thumbnail']; ?>" alt="<?php echo $s['student_name']; ?>" loading="lazy">
                            <div class="play-overlay">
                                <div class="play-btn-circle">
                                    <i class="fa fa-play ms-1"></i>
                                </div>
                            </div>
                        </div>
                        <div class="success-content">
                            <span class="course-badge">
                                <?php 
                                    // Extracting course title without batch if too long
                                    $courseTitle = $s['course_info'];
                                    echo strlen($courseTitle) > 35 ? substr($courseTitle, 0, 32) . '...' : $courseTitle;
                                ?>
                            </span>
                            <h3 class="student-name"><?php echo $s['student_name']; ?></h3>
                            <div class="rating-stars">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p class="text-muted small mb-4">"The learning experience was exceptional. The project-based curriculum helped me land my dream job within 3 months of graduation."</p>
                            <a href="javascript:void(0)" class="watch-story-link" data-bs-toggle="modal" data-bs-target="#videoModal" data-src="<?php echo $vidUrl; ?>">
                                Watch Full Story <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($success_stories)): ?>
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fa fa-graduation-cap mb-4" style="font-size: 4rem; color: #2bc5d4; opacity: 0.3;"></i>
                        <h3>Coming Soon!</h3>
                        <p class="text-muted">We are currently recording new success stories. Check back soon!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: #111c26;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-center text-lg-start mb-4 mb-lg-0">
                <h2 class="text-white fw-bold mb-2">Want to be our next Success Story?</h2>
                <p class="text-white-50 mb-0">Join over 10,000+ students learning and growing with us.</p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <a href="courses.php" class="btn btn-lg px-5 py-3 fw-bold rounded-pill" style="background: #2bc5d4; color: #fff; transition: 0.3s;">
                    Browse All Courses
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Video Modal Start -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2 z-index-1" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="ratio ratio-16x9">
                    <iframe id="videoIframe" src="" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Video Modal Logic (Sync with index.php logic if needed)
    var videoModal = document.getElementById('videoModal');
    var videoIframe = document.getElementById('videoIframe');
    
    if(videoModal && videoIframe) {
        videoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var videoSrc = button.getAttribute('data-src');
            videoIframe.src = videoSrc + "?autoplay=1";
        });

        videoModal.addEventListener('hide.bs.modal', function () {
            videoIframe.src = "";
        });
    }
});
</script>

<?php
require_once 'includes/footer.php';
?>
