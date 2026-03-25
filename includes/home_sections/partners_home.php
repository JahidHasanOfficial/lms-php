<!-- Partners Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
            <h2 class="fw-bold display-6 mt-2">Our <span class="text-primary">Partners</span></h2>
            <div class="mx-auto mt-2 bg-primary rounded" style="width: 80px; height: 3px;"></div>
        </div>
        
        <div class="row g-4 justify-content-center wow fadeInUp" data-wow-delay="0.3s">
            <?php foreach ($home_partners as $p): ?>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="partner-card-v2">
                    <div class="partner-logo-box">
                        <img src="<?php echo $p['logo']; ?>" alt="<?php echo $p['name']; ?>" class="partner-img-v2">
                    </div>
                    <div class="partner-name-box">
                        <span class="partner-name-v2"><?php echo $p['name']; ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
.partner-card-v2 {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    padding: 15px;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
    border: 1px solid #eee;
    text-decoration: none;
    text-align: center;
}

.partner-card-v2:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: #2BC5D4;
}

.partner-logo-box {
    height: 80px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

.partner-img-v2 {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.partner-name-v2 {
    color: #0d47a1;
    font-weight: 700;
    font-size: 0.85rem;
    line-height: 1.2;
    display: block;
}

.partner-name-box {
    width: 100%;
}
</style>
<!-- Partners End -->
