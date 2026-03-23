<!-- Statistics Section Start -->
<div class="container-xxl py-5 pb-0">
    <div class="container">
        <div class="stats-box rounded shadow-lg p-5" style="background: #ffffff; margin-top: -100px; position: relative; z-index: 10; border: 1px solid rgba(0,0,0,0.05); border-radius: 10px !important;">
            <div class="row g-4 text-center align-items-center">
                <div class="col-md-3 border-end stats-col">
                    <h1 class="display-4 fw-bold mb-1" style="color: #ffc107;"><?php echo $site_stats['courses_count']; ?></h1>
                    <p class="text-dark opacity-75 mb-0 text-uppercase small fw-bold" style="letter-spacing: 1px;">Available Courses</p>
                </div>
                <div class="col-md-3 border-end stats-col">
                    <h1 class="display-4 fw-bold mb-1" style="color: #28a745;"><?php echo $site_stats['learners_count']; ?></h1>
                    <p class="text-dark opacity-75 mb-0 text-uppercase small fw-bold" style="letter-spacing: 1px;">Total Learners</p>
                </div>
                <div class="col-md-3 border-end stats-col">
                    <h1 class="display-4 fw-bold mb-1" style="color: #20c997;"><?php echo $site_stats['materials_count']; ?></h1>
                    <p class="text-dark opacity-75 mb-0 text-uppercase small fw-bold" style="letter-spacing: 1px;">Learning Materials</p>
                </div>
                <div class="col-md-3 stats-col">
                    <h1 class="display-4 fw-bold mb-1" style="color: #00bfff;"><?php echo $site_stats['instructors_count']; ?></h1>
                    <p class="text-dark opacity-75 mb-0 text-uppercase small fw-bold" style="letter-spacing: 1px;">Top 1% Instructors</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-box {
    border-bottom: 5px solid #06BBCC !important;
}
@media (max-width: 991px) {
    .stats-box { margin-top: -50px !important; padding: 2rem !important; }
}
@media (max-width: 767px) {
    .stats-box { margin-top: 2rem !important; }
    .stats-col { border: none !important; border-bottom: 1px solid rgba(0,0,0,0.05) !important; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    .stats-col:last-child { border: none !important; margin-bottom: 0; padding-bottom: 0; }
}
</style>
<!-- Statistics Section End -->
