<!-- Testimonial Start -->
<div id="testimonial" class="container-xxl py-5 mt-5">
    <div class="container">
        <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
            <span class="px-3 py-1 rounded-pill bg-primary text-white small fw-bold mb-3 d-inline-block shadow-sm">Testimonials</span>
            <h2 class="fw-bold display-6 mt-2">What Our <span class="text-primary">Learners Say</span></h2>
            <div class="mx-auto mt-2 bg-primary rounded" style="width: 80px; height: 3px;"></div>
        </div>
        
        <div class="owl-carousel testimonial-carousel position-relative wow fadeInUp" data-wow-delay="0.3s">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $t): ?>
                    <div class="testimonial-card-v2 bg-white shadow-sm rounded-4 p-4 m-2 text-center h-100 border-0">
                        <div class="quote-icon-box mb-3">
                            <i class="fa fa-quote-left text-primary opacity-25 display-4"></i>
                        </div>
                        <div class="text-warning small mb-3">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </div>
                        <div class="feedback-text mb-4 px-2">
                            <p class="text-muted italic mb-0" style="line-height: 1.8; font-size: 0.95rem;">"<?php echo $t['feedback']; ?>"</p>
                        </div>
                        <div class="author-block mt-auto border-top pt-4">
                            <img class="p-1 mb-3 shadow-none border-primary border-2 border" src="<?php echo $t['image']; ?>" 
                                 style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; margin: 0 auto;">
                            <h5 class="mb-1 fw-bold"><?php echo $t['student_name']; ?></h5>
                            <small class="text-primary fw-bold"><?php echo $t['profession']; ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default Placeholder -->
                <div class="testimonial-card-v2 bg-white shadow-sm rounded-4 p-4 m-2 text-center h-100 border-0">
                    <div class="quote-icon-box mb-3">
                         <i class="fa fa-quote-left text-primary opacity-25 display-4"></i>
                    </div>
                    <div class="text-warning small mb-3">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <p class="text-muted italic mb-4">"Learning from this platform was the best decision for my career. The mentors were exceptional."</p>
                    <div class="author-block mt-auto border-top pt-4">
                        <img class="p-1 mb-3 border-primary border-2 border" src="assets/img/testimonial-1.jpg" style="width: 70px; height: 70px; border-radius: 50%; margin: 0 auto;">
                        <h5 class="mb-1 fw-bold">Sample Student</h5>
                        <small class="text-primary fw-bold">Software Engineer</small>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.testimonial-card-v2 {
    transition: all 0.4s ease;
    border: 1px solid rgba(0,0,0,0.03) !important;
}

.testimonial-card-v2:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(43, 197, 212, 0.12) !important;
    border-color: #2BC5D4 !important;
}

.italic {
    font-style: italic;
}

.testimonial-carousel .owl-nav {
    display: none;
}

.testimonial-carousel .owl-dots .owl-dot span {
    background: #cbd5e1;
    width: 10px;
    height: 10px;
}

.testimonial-carousel .owl-dots .owl-dot.active span {
    background: #2BC5D4;
    width: 30px;
}
</style>
<!-- Testimonial End -->

