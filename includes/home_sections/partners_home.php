<!-- Partners Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 wow fadeInLeft" data-wow-delay="0.1s">
                <h1 class="text-dark mb-4 display-6 fw-bold">We are partnering industry <span class="text-primary">top leaders</span></h1>
            </div>
            <div class="col-lg-8 wow fadeInRight" data-wow-delay="0.3s">
                <div class="owl-carousel partner-carousel">
                    <?php foreach ($home_partners as $p): ?>
                    <div class="partner-logo-card bg-white rounded shadow-sm d-flex align-items-center justify-content-center p-3 m-2" style="height: 80px; width: 160px;">
                        <img class="img-fluid" src="<?php echo $p['logo']; ?>" alt="<?php echo $p['name']; ?>" style="max-height: 50px; width: auto; object-fit: contain;">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Partners End -->
