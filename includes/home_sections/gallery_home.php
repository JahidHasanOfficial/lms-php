<!-- Image Gallery Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Gallery</h6>
            <h1 class="mb-5" style="color: #111c26;">Our Platform Moments</h1>
        </div>
        <div class="owl-carousel gallery-carousel position-relative">
            <?php foreach ($gallery_images as $img): ?>
                <div class="testimonial-item text-center p-3">
                    <div class="card border-0 shadow-sm overflow-hidden gallery-card" 
                         style="border-radius: 15px; cursor: pointer;"
                         data-bs-toggle="modal" 
                         data-bs-target="#galleryModal" 
                         data-img="<?php echo $img['image']; ?>"
                         data-title="<?php echo $img['title']; ?>">
                        <img class="img-fluid" src="<?php echo $img['image']; ?>" alt="<?php echo $img['title']; ?>" style="height: 250px; object-fit: cover; transition: transform 0.5s ease;">
                        <?php if ($img['title']): ?>
                            <div class="card-footer bg-white text-center p-2 border-0">
                                <small class="text-muted fw-bold"><?php echo $img['title']; ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
.gallery-card:hover img {
    transform: scale(1.1);
}
.gallery-card {
    border-radius: 15px;
    cursor: pointer;
}
</style>
<!-- Image Gallery End -->
