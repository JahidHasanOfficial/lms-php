<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="<?php echo $about_us['image'] ?: 'assets/img/about.jpg'; ?>" alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title text-start text-primary pe-3"><?php echo $about_us['subtitle'] ?: 'About Us'; ?></h6>
                <h1 class="mb-4"><?php echo $about_us['title'] ?: 'Welcome to Prime University'; ?></h1>
                <p class="mb-4"><?php echo nl2br($about_us['content'] ?: 'Tempor erat elitr rebum at clita...'); ?></p>
                <div class="row gy-2 gx-4 mb-4">
                    <?php if (!empty($site_features)): ?>
                        <?php foreach (array_slice($site_features, 0, 4) as $f): ?>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i><?php echo $f['title']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <a class="btn btn-primary py-3 px-5 mt-2" href="<?php echo $about_us['button_link'] ?: '#'; ?>"><?php echo $about_us['button_text'] ?: 'Read More'; ?></a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


