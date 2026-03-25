<!-- Courses Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
            <span class="px-3 py-1 rounded-pill bg-primary text-white small fw-bold mb-3 d-inline-block shadow-sm">Learning Path</span>
            <h2 class="fw-bold display-6 mt-2">Our <span class="text-primary">Popular Courses</span></h2>
            <div class="mx-auto mt-2 bg-primary rounded" style="width: 80px; height: 3px;"></div>
        </div>
        
        <!-- Featured Courses Grid -->
        <div class="row g-4">
            <?php foreach (array_slice($popularCourses, 0, 6) as $course): ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="course-item-custom bg-white shadow-sm rounded-4 overflow-hidden h-100 p-3">
                    <div class="position-relative overflow-hidden rounded-3 mb-3">
                        <img class="img-fluid w-100" src="<?php echo $course['thumbnail']; ?>" alt="<?php echo $course['title']; ?>" style="height: 220px; object-fit: cover;">
                        <?php if($course['discount_price'] > 0): ?>
                            <div class="position-absolute top-0 end-0 mt-2 me-2">
                                <span class="badge rounded-pill px-3 py-2 bg-primary text-white shadow-sm" style="font-size: 0.75rem;">
                                    ৳ <?php echo ($course['price'] - $course['discount_price']); ?> OFF
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="px-2">
                        <h5 class="mb-3 text-dark fw-bold h6" style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;">
                            <?php echo $course['title']; ?>
                        </h5>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3 text-muted" style="font-size: 0.75rem;">
                            <span><i class="fa fa-book-reader text-primary me-1"></i> 15+ Modules</span>
                            <div class="text-warning small">
                                <i class="fa fa-star"></i> 5.0
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <?php if($course['discount_price'] > 0): ?>
                                <span class="text-muted text-decoration-line-through me-2 small">৳<?php echo $course['price']; ?></span>
                                <span class="fw-bold fs-5 text-primary">৳<?php echo $course['discount_price']; ?></span>
                            <?php else: ?>
                                <span class="fw-bold fs-5 text-primary">৳<?php echo $course['price']; ?></span>
                            <?php endif; ?>
                        </div>

                        <a href="course-details.php?slug=<?php echo $course['slug']; ?>" class="btn w-100 py-2 fw-bold text-white rounded-3 shadow-none overflow-hidden position-relative bg-primary border-0" style="font-size: 0.85rem;">
                            Enroll Now <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Bottom Course Slider -->
        <?php if (count($popularCourses) > 3): ?>
        <div class="mt-5 pt-4 wow fadeInUp" data-wow-delay="0.5s">
            <div class="owl-carousel course-slider">
                <?php foreach (array_slice($popularCourses, 3) as $course): ?>
                <div class="course-slide-item px-2 pb-4">
                    <a href="course-details.php?slug=<?php echo $course['slug']; ?>" class="course-pill d-flex align-items-center bg-white shadow-sm p-3 rounded-4 border-0 text-decoration-none">
                        <div class="course-pill-img me-3 overflow-hidden rounded-3 shadow-sm">
                            <img src="<?php echo $course['thumbnail']; ?>" alt="" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="overflow-hidden">
                           <h6 class="mb-1 text-dark fw-bold text-truncate" style="font-size: 0.85rem;"><?php echo $course['title']; ?></h6>
                           <div class="d-flex align-items-center">
                               <span class="text-primary fw-bold me-2" style="font-size: 0.8rem;">৳<?php echo $course['discount_price'] ?: $course['price']; ?></span>
                               <small class="text-muted" style="font-size: 0.65rem;"><i class="fa fa-heart text-danger me-1"></i> Trending</small>
                           </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.course-item-custom {
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    border: 1px solid rgba(0,0,0,0.03);
}

.course-item-custom:hover {
    transform: translateY(-8px);
    box-shadow: 0 1.5rem 3rem rgba(43, 197, 212, 0.1) !important;
    border-color: rgba(43, 197, 212, 0.3);
}

.course-pill {
    transition: all 0.4s ease;
    border: 1px solid rgba(0,0,0,0.03) !important;
}

.course-pill:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(43, 197, 212, 0.12) !important;
    border-color: #2BC5D4 !important;
}

.course-pill-img {
    width: 60px;
    height: 45px;
    flex-shrink: 0;
}

.course-slider .owl-stage {
    display: flex;
    align-items: center;
}
</style>

<script>
(function initSafeCourseSlider() {
    if (window.jQuery && jQuery.fn.owlCarousel) {
        jQuery(document).ready(function($){
            $(".course-slider").owlCarousel({
                autoplay: true,
                autoplayTimeout: 2500,
                autoplaySpeed: 1000,
                smartSpeed: 1000,
                margin: 15,
                loop: true,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    768: { items: 3 },
                    1200: { items: 4 }
                }
            });
        });
    } else {
        setTimeout(initSafeCourseSlider, 100);
    }
})();
</script>
<!-- Courses End -->
