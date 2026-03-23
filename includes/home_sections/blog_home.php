<!-- Blog Section Start -->
<div class="container-xxl py-5" style="background: #f8f9fa;">
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
                <div class="blog-card-mini wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden rounded shadow-sm bg-white h-100">
                        <img class="img-fluid w-100" src="<?php echo $b['image']; ?>" style="height: 120px; object-fit: cover;">
                        <div class="p-3">
                            <span class="badge bg-primary-soft text-primary mb-2" style="font-size: 0.7rem; background: #e7f1ff;"><?php echo $b['category_name']; ?></span>
                            <h6 class="mb-0"><a href="blog_details.php?slug=<?php echo $b['slug']; ?>" class="text-dark text-decoration-none"><?php echo substr($b['title'], 0, 40); ?>...</a></h6>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Middle Column: 1 Featured (Tall) Blog -->
            <div class="col-lg-6 col-md-12">
                <?php $fb = $home_blogs[0]; ?>
                <div class="featured-blog-card position-relative overflow-hidden rounded shadow-lg wow fadeInUp h-100" data-wow-delay="0.3s" style="height: 410px;">
                    <img class="img-fluid w-100 h-100" src="<?php echo $fb['image']; ?>" style="object-fit: cover; position: absolute; z-index: 1;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-5 text-white" 
                         style="z-index: 2; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0) 100%);">
                        <span class="badge bg-primary align-self-start mb-3" style="position: relative; z-index: 3;"><?php echo $fb['category_name']; ?></span>
                        <h2 class="text-white mb-3" style="position: relative; z-index: 3;"><?php echo $fb['title']; ?></h2>
                        <p class="mb-4 d-none d-md-block" style="position: relative; z-index: 3;"><?php echo substr(strip_tags($fb['content']), 0, 120); ?>...</p>
                        <a href="blog_details.php?slug=<?php echo $fb['slug']; ?>" class="btn btn-primary align-self-start rounded-pill px-4" style="position: relative; z-index: 3;">Read Full Article</a>
                    </div>
                </div>
            </div>

            <!-- Right Column: 2 Small/Medium Blogs -->
            <div class="col-lg-3 col-md-6 d-flex flex-column gap-4">
                <?php for($i=3; $i<=4; $i++): $b = $home_blogs[$i]; ?>
                <div class="blog-card-mini wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative overflow-hidden rounded shadow-sm bg-white h-100">
                        <?php if($i == 4): ?>
                            <img class="img-fluid w-100" src="<?php echo $b['image']; ?>" style="height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <img class="img-fluid w-100" src="<?php echo $b['image']; ?>" style="height: 100px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="p-3">
                            <span class="badge bg-primary-soft text-primary mb-2" style="font-size: 0.7rem; background: #e7f1ff;"><?php echo $b['category_name']; ?></span>
                            <h6 class="mb-0"><a href="blog_details.php?slug=<?php echo $b['slug']; ?>" class="text-dark text-decoration-none"><?php echo substr($b['title'], 0, 45); ?>...</a></h6>
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
            <a href="blog.php" class="btn btn-outline-primary px-5 rounded-pill">View All Insights <i class="fa fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>

<style>
.featured-blog-card img {
    transition: transform 0.8s ease;
}
.featured-blog-card:hover img {
    transform: scale(1.05);
}
.blog-card-mini {
    transition: transform 0.3s ease;
}
.blog-card-mini:hover {
    transform: translateY(-5px);
}
</style>
