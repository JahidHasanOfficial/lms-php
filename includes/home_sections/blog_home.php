<!-- Blog Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-light text-center text-primary px-3">Our Blogs</h6>
            <h1 class="mb-5" style="color: #111c26;">Insights & Academic Articles</h1>
        </div>
        
        <?php if (count($home_blogs) >= 5): ?>
        <div class="row g-4">
            <!-- Left Column: 2 Small Blogs -->
            <div class="col-lg-3 col-md-6 d-flex flex-column gap-4">
                <?php for($i=1; $i<=2; $i++): $b = $home_blogs[$i]; ?>
                <div class="blog-card-v2 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden rounded-4 shadow-sm bg-white h-100 border-0">
                        <img class="img-fluid w-100" src="<?php echo $b['image']; ?>" style="height: 140px; object-fit: cover;">
                        <div class="p-4">
                            <span class="badge rounded-pill px-3 py-1 mb-2" style="font-size: 0.75rem; background: #e0faff; color: #2BC5D4;"><?php echo $b['category_name']; ?></span>
                            <h6 class="mb-0 fw-bold"><a href="blog_details.php?slug=<?php echo $b['slug']; ?>" class="text-dark text-decoration-none hover-teal"><?php echo $b['title']; ?></a></h6>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Middle Column: 1 Featured (Tall) Blog -->
            <div class="col-lg-6 col-md-12">
                <?php $fb = $home_blogs[0]; ?>
                <div class="featured-blog-card position-relative overflow-hidden rounded-4 shadow-lg wow fadeInUp h-100 border-0" data-wow-delay="0.3s" style="min-height: 450px;">
                    <img class="img-fluid w-100 h-100" src="<?php echo $fb['image']; ?>" style="object-fit: cover; position: absolute; z-index: 1;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-5 text-white" 
                         style="z-index: 2; background: linear-gradient(to top, rgba(0,24,36,0.95) 0%, rgba(0,24,36,0.4) 50%, rgba(0,0,0,0) 100%);">
                        <span class="badge rounded-pill px-3 py-2 mb-3 align-self-start shadow-sm" style="position: relative; z-index: 3; background: rgba(43, 197, 212, 0.9); backdrop-filter: blur(5px);"><?php echo $fb['category_name']; ?></span>
                        <h2 class="text-white mb-3 fw-bold display-6" style="position: relative; z-index: 3;"><?php echo $fb['title']; ?></h2>
                        <p class="mb-4 d-none d-md-block opacity-75" style="position: relative; z-index: 3;"><?php echo substr(strip_tags($fb['content']), 0, 150); ?>...</p>
                        <a href="blog_details.php?slug=<?php echo $fb['slug']; ?>" class="btn py-3 px-5 text-white fw-bold rounded-pill align-self-start shadow-lg" style="position: relative; z-index: 3; background: #2BC5D4;">Read Full Article</a>
                    </div>
                </div>
            </div>

            <!-- Right Column: 2 Small/Medium Blogs -->
            <div class="col-lg-3 col-md-6 d-flex flex-column gap-4">
                <?php for($i=3; $i<=4; $i++): $b = $home_blogs[$i]; ?>
                <div class="blog-card-v2 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative overflow-hidden rounded-4 shadow-sm bg-white h-100 border-0">
                        <img class="img-fluid w-100" src="<?php echo $b['image']; ?>" style="height: 140px; object-fit: cover;">
                        <div class="p-4">
                            <span class="badge rounded-pill px-3 py-1 mb-2" style="font-size: 0.75rem; background: #e0faff; color: #2BC5D4;"><?php echo $b['category_name']; ?></span>
                            <h6 class="mb-0 fw-bold"><a href="blog_details.php?slug=<?php echo $b['slug']; ?>" class="text-dark text-decoration-none hover-teal"><?php echo $b['title']; ?></a></h6>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">Add at least 5 blogs to activate the featured grid.</div>
        <?php endif; ?>

        <div class="text-center mt-5">
            <a href="blog.php" class="btn px-5 py-3 rounded-pill fw-bold" style="border: 2px solid #2BC5D4; color: #2BC5D4; transition: 0.3s;">Explore All Insights <i class="fa fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>

<style>
.featured-blog-card img {
    transition: transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.featured-blog-card:hover img {
    transform: scale(1.1);
}
.blog-card-v2 {
    transition: all 0.4s ease;
}
.blog-card-v2:hover {
    transform: translateY(-8px);
}
.blog-card-v2:hover .shadow-sm {
    box-shadow: 0 15px 45px rgba(43, 197, 212, 0.15) !important;
}
.hover-teal:hover {
    color: #2BC5D4 !important;
}
.rounded-4 {
    border-radius: 1rem !important;
}
</style>
