<?php
include "config/session.php";
include "config/database.php";
$pageTitle = "Image Gallery - Prime University";
include "includes/header.php";
include "includes/breadcrumb.php";
?>

<style>
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 30px;
        cursor: pointer;
    }
    
    .gallery-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(43, 197, 212, 0.3);
    }
    
    .gallery-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .gallery-item:hover .gallery-img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(43, 197, 212, 0.8), transparent);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 25px;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    
    .category-badge {
        background: #fff;
        color: #2bc5d4;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 10px;
        display: inline-block;
    }
    
    .gallery-title {
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .gallery-filter {
        margin-bottom: 50px;
    }
    
    .filter-btn {
        background: #f8f9fa;
        color: #666;
        border: 2px solid transparent;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 5px;
    }
    
    .filter-btn.active, .filter-btn:hover {
        background: #2bc5d4;
        color: #fff;
        border-color: #2bc5d4;
    }
</style>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Our Moments</h6>
            <h1 class="mb-5">Prime University Life</h1>
        </div>

        <div class="row g-4">
            <!-- Gallery Items (Simulated with quality placeholders matching University theme) -->
            <?php
            $galleryItems = [
                ['img' => 'assets/img/course-1.jpg', 'title' => 'Main Campus Building', 'cat' => 'Campus'],
                ['img' => 'assets/img/cat-1.jpg', 'title' => 'Programming Lab Session', 'cat' => 'Lab'],
                ['img' => 'assets/img/cat-2.jpg', 'title' => 'Annual Convocation 2024', 'cat' => 'Events'],
                ['img' => 'assets/img/course-2.jpg', 'title' => 'Library Resource Center', 'cat' => 'Library'],
                ['img' => 'assets/img/course-3.jpg', 'title' => 'Cultural Festival', 'cat' => 'Life'],
                ['img' => 'assets/img/cat-3.jpg', 'title' => 'Robotics Workshop', 'cat' => 'Robotics'],
                ['img' => 'assets/img/cat-4.jpg', 'title' => 'University Cafeteria', 'cat' => 'Life'],
                ['img' => 'assets/img/course-1.jpg', 'title' => 'CSE Alumni Meetup', 'cat' => 'Events'],
                ['img' => 'assets/img/course-2.jpg', 'title' => 'Basketball Tournament', 'cat' => 'Sports']
            ];

            foreach ($galleryItems as $index => $item) : ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= 0.1 * ($index % 3 + 1) ?>s">
                    <div class="gallery-item">
                        <img class="gallery-img" src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>">
                        <div class="gallery-overlay">
                            <span class="category-badge"><?= $item['cat'] ?></span>
                            <h5 class="gallery-title"><?= $item['title'] ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
