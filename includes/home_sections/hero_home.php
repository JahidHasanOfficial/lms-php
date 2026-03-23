<!-- Hero Section Start -->
<?php
// Since we refactored to single record, $hero should already be fetched in index.php
if (!isset($hero)) {
    $hero = $pdo->query("SELECT * FROM hero_slides WHERE id = 1")->fetch();
}
?>
<section class="hero-section py-5 position-relative overflow-hidden" style="background: #f8fafc; min-height: 80vh; display: flex; align-items: center;">
    <!-- Modern Grid Pattern Background -->
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="background-image: radial-gradient(#d1d5db 1px, transparent 1px); background-size: 30px 30px; z-index: 1;"></div>
    
    <!-- Abstract Shapes for Premium Look -->
    <div class="position-absolute top-0 end-0 bg-primary opacity-10 rounded-circle" style="width: 400px; height: 400px; margin-top: -200px; margin-right: -100px; filter: blur(80px); z-index: 1;"></div>
    <div class="position-absolute bottom-0 start-0 bg-success opacity-10 rounded-circle" style="width: 300px; height: 300px; margin-bottom: -150px; margin-left: -50px; filter: blur(60px); z-index: 1;"></div>

    <div class="container position-relative py-5" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <!-- Left Info Area -->
            <div class="col-lg-7 text-center text-lg-start">
                <h5 class="text-primary fw-bold text-uppercase mb-3 animated slideInDown font-weight-bold" style="letter-spacing: 2px; font-size: 1.1rem !important;">
                    <?php echo $hero['subtitle']; ?>
                </h5>
                <h1 class="display-3 text-dark fw-bold mb-4 animated slideInDown" style="line-height: 1.15; font-weight: 900 !important; color: #1e293b !important;">
                    <?php echo $hero['title']; ?>
                </h1>
                <p class="fs-5 text-muted mb-5 animated slideInDown pe-lg-5">
                    <?php echo $hero['description']; ?>
                </p>
                <div class="d-flex justify-content-center justify-content-lg-start gap-3 animated slideInUp">
                    <a href="courses.php" class="btn btn-success py-3 px-5 rounded-pill shadow-lg border-0 d-flex align-items-center" style="background: #198754; font-weight: 700;">
                        কোর্স ব্রাউজ করুন <i class="fa fa-arrow-right ms-2 fs-6"></i>
                    </a>
                    <a href="contact.php" class="btn btn-outline-dark py-3 px-5 rounded-pill fw-bold" style="border: 2px solid #334155; color: #334155;">
                        ফ্রি সেমিনার
                    </a>
                </div>
            </div>

            <!-- Right Media Area (Auto-playing Video Card) -->
            <div class="col-lg-5 animated zoomIn">
                <div class="position-relative hero-video-card">
                    <div class="video-preview-wrapper position-relative rounded-4 shadow-2xl border border-white border-5 bg-white overflow-hidden shadow-lg" style="min-height: 320px;">
                        
                        <!-- Auto-playing Background Video inside Card -->
                        <?php if(file_exists('assets/video/hero.mp4')): ?>
                            <video autoplay muted loop playsinline class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover;">
                                <source src="assets/video/hero.mp4" type="video/mp4">
                            </video>
                        <?php else: ?>
                            <img src="<?php echo $hero['image']; ?>" class="img-fluid w-100" style="object-fit: cover; min-height: 320px;">
                        <?php endif; ?>
                        
                        <!-- Premium Interactive Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.15); z-index: 5;">
                            <a href="javascript:void(0);" 
                               class="play-trigger shadow-2xl d-flex align-items-center justify-content-center" 
                               data-bs-toggle="modal" 
                               data-src="<?php echo file_exists('assets/video/hero.mp4') ? 'assets/video/hero.mp4' : ''; ?>" 
                               data-bs-target="#videoModal">
                                <span class="pulse-ring"></span>
                                <i class="fa fa-play fs-1 text-white ms-1"></i>
                            </a>
                        </div>

                        <!-- Live Status Badge -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, transparent 100%); z-index: 6;">
                             <div class="text-white small fw-bold"><i class="fa fa-circle text-danger me-2 tiny-pulse"></i> LIVE CLASS</div>
                             <div class="badge bg-white text-dark rounded-pill px-3 py-2 fw-bold shadow-sm">সফলতার গল্প</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.rounded-4 { border-radius: 2rem !important; }
.hero-video-card:hover { transform: translateY(-10px); transition: 0.5s; }

.play-trigger {
    width: 90px;
    height: 90px;
    background: #198754;
    border-radius: 50%;
    position: relative;
    z-index: 5;
    transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 15px 35px rgba(25, 135, 84, 0.5);
}

.play-trigger:hover {
    transform: scale(1.15) rotate(10deg);
    background: #157347;
}

.pulse-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    background: #198754;
    border-radius: 50%;
    opacity: 0.6;
    animation: pulse-gate 2s infinite;
    z-index: -1;
}

@keyframes pulse-gate {
    0% { transform: translate(-50%, -50%) scale(1); opacity: 0.6; }
    100% { transform: translate(-50%, -50%) scale(1.8); opacity: 0; }
}

.tiny-pulse { animation: blink 1s infinite alternate; }
@keyframes blink { from { opacity: 0.5; } to { opacity: 1; } }

@media (max-width: 991px) {
    .display-3 { font-size: 2.8rem !important; }
    .hero-section { min-height: auto; padding: 60px 0; }
}
</style>
<!-- Hero Section End -->
