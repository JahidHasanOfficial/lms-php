<!-- Success Story Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5" style="font-size: 2.5rem; font-weight: 700; color: #111c26;">Our Students Success Story</h1>
        </div>
        <div class="owl-carousel success-story-carousel position-relative">
            <?php foreach ($success_stories as $s): ?>
                <div class="testimonial-item bg-white shadow-sm rounded-4 p-3 m-2">
                    <div class="position-relative overflow-hidden rounded-3 mb-3">
                        <img class="img-fluid w-100" src="<?php echo $s['thumbnail']; ?>" alt="" style="height: 200px; object-fit: cover;">
                        <?php 
                            // Convert YouTube URL to Embed URL
                            $vidUrl = $s['video_url'];
                            if (strpos($vidUrl, 'watch?v=') !== false) {
                                $vidUrl = str_replace('watch?v=', 'embed/', $vidUrl);
                            } elseif (strpos($vidUrl, 'youtu.be/') !== false) {
                                $vidUrl = str_replace('youtu.be/', 'youtube.com/embed/', $vidUrl);
                            }
                        ?>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="fa fa-play-circle text-white opacity-75 hover-opacity-100 video-btn" 
                               style="font-size: 3rem; cursor: pointer;" 
                               data-bs-toggle="modal" 
                               data-bs-target="#videoModal" 
                               data-src="<?php echo $vidUrl; ?>"></i>
                        </div>
                    </div>
                    <h5 class="mb-1" style="color: #111c26;"><?php echo $s['student_name']; ?></h5>
                    <small class="text-muted d-block mb-3"><?php echo $s['course_info']; ?></small>
                    <div class="text-warning small mb-3">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <a href="#" class="btn w-100 py-2 fw-bold text-white rounded-3 shadow-none mt-2 video-btn" 
                       style="background-color: #2BC5D4; transition: 0.3s;"
                       data-bs-toggle="modal" 
                       data-bs-target="#videoModal" 
                       data-src="<?php echo $vidUrl; ?>">
                        Watch Story
                    </a>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($success_stories)): ?>
                <!-- Placeholder if empty -->
                <div class="testimonial-item bg-white shadow-sm rounded-4 p-3 m-2">
                    <div class="position-relative overflow-hidden rounded-3 mb-3">
                        <img class="img-fluid w-100" src="frontend-template/img/course-1.jpg" alt="">
                        <div class="position-absolute top-50 start-50 translate-middle"><i class="fa fa-play-circle text-white opacity-75" style="font-size: 3rem;"></i></div>
                    </div>
                    <div class="text-center">
                        <h5 class="mb-1">Student Name</h5>
                        <small class="text-muted d-block mb-3">Course Batch - 01</small>
                        <div class="text-warning small mb-3">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </div>
                        <a href="#" class="btn w-100 py-2 fw-bold text-white rounded-3 shadow-none mt-2" style="background-color: #2BC5D4; transition: 0.3s;">
                            Watch Story
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<style>
.testimonial-item {
    transition: 0.3s;
    border: 1px solid rgba(0,0,0,0.05);
}
.testimonial-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
}
.rounded-4 {
    border-radius: 1rem !important;
}
</style>
<!-- Success Story End -->
