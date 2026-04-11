<style>
    /* Premium Page Header (Breadcrumb) */
    .page-hero-section {
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 120px 0;
        position: relative;
        overflow: hidden;
    }
<?php 
    // Detect current page filename
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    // Map pages to images in frontend-template/img/
    $pageImageMap = [
        'about.php' => 'frontend-template/img/about.jpg',
        'courses.php' => 'frontend-template/img/carousel-1.jpg',
        'course-details.php' => 'frontend-template/img/carousel-2.jpg',
        'success-story.php' => 'frontend-template/img/cat-3.jpg',
        'contact.php' => 'frontend-template/img/cat-4.jpg',
        'blog.php' => 'frontend-template/img/carousel-1.jpg',
        'blog_details.php' => 'frontend-template/img/carousel-1.jpg',
        'teachers.php' => 'frontend-template/img/carousel-1.jpg',
        'login.php' => 'frontend-template/img/carousel-2.jpg',
        'register.php' => 'frontend-template/img/carousel-2.jpg',
        'checkout.php' => 'frontend-template/img/carousel-2.jpg',
        'enroll.php' => 'frontend-template/img/carousel-2.jpg',
    ];

    // Default image if no mapping exists
    $defaultBg = 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=70&w=1200&auto=format&fit=crop';
    
    // Determine the image to use
    if (isset($breadcrumbImage)) {
        $bgImage = $breadcrumbImage;
    } elseif (isset($pageImageMap[$currentPage])) {
        // Prepend BASE_URL if it's a local path (starts with frontend-template)
        $bgImage = (defined('BASE_URL') ? BASE_URL : '') . $pageImageMap[$currentPage];
    } else {
        $bgImage = $defaultBg;
    }

    // Optimize unsplash URL if it's an unsplash URL
    if (strpos($bgImage, 'unsplash.com') !== false) {
        $bgImage = str_replace(['w=1600', 'q=80'], ['w=1200', 'q=70'], $bgImage);
    }
?>

    .page-hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 30%, rgba(43, 197, 212, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(43, 197, 212, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
    }

    .page-hero-section::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-image: radial-gradient(#2bc5d4 0.5px, transparent 0.5px);
        background-size: 30px 30px;
        opacity: 0.1;
        z-index: 1;
    }

    .page-hero-section h1 {
        font-size: 3.5rem;
        font-weight: 900;
        color: #fff;
        text-shadow: 0 4px 10px rgba(0,0,0,0.5), 0 0 20px rgba(0,0,0,0.3);
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .breadcrumb-custom {
        padding: 0;
        margin: 0;
        background: transparent;
        justify-content: center;
        display: flex;
        gap: 10px;
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        text-shadow: 0 2px 5px rgba(0,0,0,0.5);
        position: relative;
        z-index: 2;
    }

    .breadcrumb-custom a {
        color: #2bc5d4;
        text-decoration: none;
        transition: 0.3s;
    }

    .breadcrumb-custom a:hover {
        color: #fff;
        text-shadow: 0 0 10px #2bc5d4;
    }

    .breadcrumb-separator {
        opacity: 0.8;
    }
</style>

<section class="page-hero-section text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo $bgImage; ?>');">
    <div class="container-fluid px-lg-5 position-relative z-index-1">
        <h1 class="wow fadeInUp" data-wow-delay="0.1s"><?php echo isset($breadcrumbTitle) ? $breadcrumbTitle : (isset($pageTitle) ? $pageTitle : "Page Title"); ?></h1>
        <div class="breadcrumb-custom wow fadeInUp" data-wow-delay="0.2s">
            <a href="index.php">Home</a>
            <span class="breadcrumb-separator">/</span>
            <span><?php echo isset($breadcrumbTitle) ? $breadcrumbTitle : (isset($pageTitle) ? $pageTitle : "Page"); ?></span>
        </div>
    </div>
</section>
