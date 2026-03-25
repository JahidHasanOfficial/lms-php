<!-- Categories Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
            <span class="px-3 py-1 rounded-pill bg-primary text-white small fw-bold mb-3 d-inline-block shadow-sm">Skill Sets</span>
            <h2 class="fw-bold display-6 mt-2">Browse <span class="text-primary">Top Categories</span></h2>
            <div class="mx-auto mt-2 bg-primary rounded" style="width: 80px; height: 3px;"></div>
        </div>
        
        <div class="row g-4 masonry-categories">
            <?php if (!empty($categories)): ?>
            <div class="col-lg-7 col-md-12">
                <div class="row g-4">
                    <!-- Featured Wide Category -->
                    <div class="col-12 wow zoomIn" data-wow-delay="0.1s">
                        <a class="category-item position-relative d-block overflow-hidden rounded-4 shadow-sm" href="courses.php?category=<?php echo $categories[0]['slug'] ?? ''; ?>">
                            <img class="img-fluid w-100" src="<?php echo $categories[0]['image'] ?: 'frontend-template/img/cat-1.jpg'; ?>" alt="" style="height: 300px; object-fit: cover;">
                            <div class="category-overlay p-4">
                                <span class="badge bg-primary rounded-pill mb-2 px-3 py-2 small fw-bold">Popular</span>
                                <h3 class="text-dark fw-bold mb-1 h5"><?php echo $categories[0]['name'] ?? 'Web Development'; ?></h3>
                                <small class="text-primary fw-bold">120+ Courses <i class="fa fa-arrow-right ms-1 small"></i></small>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Two Small Categories -->
                    <?php if (isset($categories[1])): ?>
                    <div class="col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <a class="category-item position-relative d-block overflow-hidden rounded-4 shadow-sm" href="courses.php?category=<?php echo $categories[1]['slug']; ?>">
                            <img class="img-fluid w-100" src="<?php echo $categories[1]['image'] ?: 'frontend-template/img/cat-2.jpg'; ?>" alt="" style="height: 200px; object-fit: cover;">
                            <div class="category-overlay-mini p-4">
                                <h4 class="text-dark fw-bold mb-0 h6"><?php echo $categories[1]['name']; ?></h4>
                                <small class="text-primary fw-bold">Explore <i class="fa fa-chevron-right ms-1" style="font-size: 0.6rem;"></i></small>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($categories[2])): ?>
                    <div class="col-md-6 wow zoomIn" data-wow-delay="0.5s">
                        <a class="category-item position-relative d-block overflow-hidden rounded-4 shadow-sm" href="courses.php?category=<?php echo $categories[2]['slug']; ?>">
                            <img class="img-fluid w-100" src="<?php echo $categories[2]['image'] ?: 'frontend-template/img/cat-3.jpg'; ?>" alt="" style="height: 200px; object-fit: cover;">
                            <div class="category-overlay-mini p-4">
                                <h4 class="text-dark fw-bold mb-0 h6"><?php echo $categories[2]['name']; ?></h4>
                                <small class="text-primary fw-bold">Explore <i class="fa fa-chevron-right ms-1" style="font-size: 0.6rem;"></i></small>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Tall Side Category -->
            <div class="col-lg-5 col-md-12 wow zoomIn" data-wow-delay="0.7s">
                <?php if (isset($categories[3])): ?>
                <a class="category-item position-relative d-block h-100 overflow-hidden rounded-4 shadow-sm" href="courses.php?category=<?php echo $categories[3]['slug']; ?>">
                    <img class="img-fluid w-100 h-100" src="<?php echo $categories[3]['image'] ?: 'frontend-template/img/cat-4.jpg'; ?>" alt="" style="object-fit: cover; min-height: 525px;">
                    <div class="category-overlay p-4">
                        <span class="badge bg-primary rounded-pill mb-2 px-3 py-2 small fw-bold">Trending</span>
                        <h3 class="text-dark fw-bold mb-1 h5"><?php echo $categories[3]['name']; ?></h3>
                        <small class="text-primary fw-bold">New Opportunities <i class="fa fa-arrow-right ms-1 small"></i></small>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Bottom Category Carousel -->
        <?php if (count($categories) > 4): ?>
        <div class="mt-4 wow fadeInUp" data-wow-delay="0.9s">
            <div class="owl-carousel category-slider">
                <?php foreach (array_slice($categories, 4) as $c): ?>
                <div class="category-slide-item px-2 pb-4">
                    <a href="courses.php?category=<?php echo $c['slug']; ?>" class="category-pill d-flex align-items-center bg-white shadow-sm p-3 rounded-4 border-0 text-decoration-none h-100">
                        <div class="category-icon-box me-3 overflow-hidden">
                            <img src="<?php echo $c['image'] ?: 'frontend-template/img/cat-1.jpg'; ?>" alt="" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div>
                           <h6 class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;"><?php echo $c['name']; ?></h6>
                           <small class="text-muted" style="font-size: 0.7rem;">Explore Skills</small>
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
.category-item img {
    transition: transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.category-item:hover img {
    transform: scale(1.15);
}

.category-overlay {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.4);
    transition: 0.4s;
    z-index: 10;
}

.category-overlay-mini {
    position: absolute;
    bottom: 15px;
    left: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: 0.4s;
    z-index: 10;
}

.category-item:hover .category-overlay,
.category-item:hover .category-overlay-mini {
    transform: translateY(-5px);
    background: #ffffff;
    border-color: #2BC5D4;
}

.category-pill {
    transition: all 0.4s ease;
    border: 1px solid rgba(0,0,0,0.03) !important;
}

.category-pill:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(43, 197, 212, 0.15) !important;
    border-color: #2BC5D4 !important;
}

.category-icon-box {
    width: 40px;
    height: 40px;
    background: #e0faff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.category-slider .owl-stage {
    display: flex;
    align-items: center;
}
</style>

<script>
// Safe initialization to avoid spinner issues
(function initSafeCategorySlider() {
    if (window.jQuery && jQuery.fn.owlCarousel) {
        jQuery(document).ready(function($){
            $(".category-slider").owlCarousel({
                autoplay: true,
                autoplayTimeout: 2000,
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
                    1000: { items: 5 }
                }
            });
        });
    } else {
        setTimeout(initSafeCategorySlider, 100);
    }
})();
</script>
<!-- Categories End -->
<!-- Categories End -->