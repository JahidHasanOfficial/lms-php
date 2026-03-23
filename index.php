<?php
require_once 'config/session.php';
require_once 'classes/Course.php';
require_once 'classes/Category.php';

$courseObj = new Course($pdo);
$categoryObj = new Category($pdo);

$popularCourses = $courseObj->getAllPublished(); 
$categories = $categoryObj->getAll();

// Fetch Landing Page Data
$hero_slides = $pdo->query("SELECT * FROM hero_slides WHERE status = 'active' ORDER BY id DESC")->fetchAll();
$site_features = $pdo->query("SELECT * FROM site_features ORDER BY id ASC")->fetchAll();
$about_us = $pdo->query("SELECT * FROM about_us WHERE id = 1")->fetch();
$team_members = $pdo->query("SELECT * FROM team_members WHERE status = 'active' ORDER BY id ASC")->fetchAll();
$testimonials = $pdo->query("SELECT * FROM testimonials WHERE status = 'active' ORDER BY id DESC")->fetchAll();
$success_stories = $pdo->query("SELECT * FROM success_stories WHERE status = 'active' ORDER BY id DESC")->fetchAll();
$gallery_images = $pdo->query("SELECT * FROM image_gallery WHERE status = 'active' ORDER BY id DESC LIMIT 12")->fetchAll();
$home_blogs = $pdo->query("SELECT b.*, bc.name as category_name FROM blogs b JOIN blog_categories bc ON b.category_id = bc.id WHERE b.status = 'published' ORDER BY b.id DESC LIMIT 5")->fetchAll();
$newsletter = $pdo->query("SELECT * FROM newsletter_settings WHERE id = 1")->fetch();
$site_stats = $pdo->query("SELECT * FROM site_stats WHERE id = 1")->fetch();
$home_partners = $pdo->query("SELECT * FROM home_partners WHERE status = 'active' ORDER BY id ASC")->fetchAll();

require_once 'includes/header.php';
?>

<?php 
// Home Page Sections
include 'includes/home_sections/hero_home.php';
include 'includes/home_sections/stats_home.php';
include 'includes/home_sections/about_home.php';
include 'includes/home_sections/categories_home.php';
include 'includes/home_sections/courses_home.php';
include 'includes/home_sections/team_home.php';
include 'includes/home_sections/testimonial_home.php';
include 'includes/home_sections/success_home.php';
include 'includes/home_sections/gallery_home.php';
include 'includes/home_sections/blog_home.php';
include 'includes/home_sections/newsletter_home.php';
include 'includes/home_sections/partners_home.php';
?>

<!-- Video Modal Start -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2 z-index-1" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="ratio ratio-16x9">
                    <iframe id="videoIframe" src="" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Modal Start -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative text-center">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-index-1" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="galleryIframe" src="" class="img-fluid rounded shadow-lg" style="max-height: 80vh;">
                <h5 id="galleryTitle" class="text-white mt-3 fw-bold"></h5>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carousel Initializations
    if($(".header-carousel").length > 0) {
        $(".header-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            items: 1,
            dots: false,
            loop: true,
            nav : true,
            navText : [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ]
        });
    }

    if($(".testimonial-carousel").length > 0) {
        $(".testimonial-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            center: true,
            margin: 24,
            dots: true,
            loop: true,
            nav : false,
            responsive: {
                0:{ items:1 },
                768:{ items:2 },
                992:{ items:3 }
            }
        });
    }

    if($(".gallery-carousel").length > 0) {
        $(".gallery-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            margin: 20,
            dots: false,
            loop: true,
            nav : false,
            responsive: {
                0:{ items:1 },
                768:{ items:2 },
                992:{ items:4 }
            }
        });
    }

    if($(".success-story-carousel").length > 0) {
        $(".success-story-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            center: false,
            margin: 24,
            dots: false,
            loop: true,
            nav : false,
            responsive: {
                0:{ items:1 },
                768:{ items:2 },
                992:{ items:3 }
            }
        });
    }

    if($(".partner-carousel").length > 0) {
        $(".partner-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            margin: 10,
            dots: false,
            loop: true,
            nav : false,
            responsive: {
                0:{ items:2 },
                768:{ items:3 },
                992:{ items:4 }
            }
        });
    }

    if($(".course-carousel").length > 0) {
        $(".course-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            margin: 30,
            dots: false,
            loop: true,
            nav : false,
            responsive: {
                0:{ items:1 },
                768:{ items:2 },
                992:{ items:3 }
            }
        });
    }

    // Video Modal Logic
    var videoModal = document.getElementById('videoModal');
    var videoIframe = document.getElementById('videoIframe');
    
    if(videoModal && videoIframe) {
        videoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var videoSrc = button.getAttribute('data-src');
            videoIframe.src = videoSrc + "?autoplay=1";
        });

        videoModal.addEventListener('hide.bs.modal', function () {
            videoIframe.src = "";
        });
    }

    // Gallery Lightbox Logic
    var galleryModal = document.getElementById('galleryModal');
    var galleryImg = document.getElementById('galleryIframe');
    var galleryTitle = document.getElementById('galleryTitle');
    
    if(galleryModal && galleryImg) {
        galleryModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            galleryImg.src = button.getAttribute('data-img');
            galleryTitle.innerText = button.getAttribute('data-title');
        });
    }

    // Newsletter AJAX Submission
    var newsForm = document.getElementById('newsletter-form');
    var newsMsg = document.getElementById('newsletter-message');
    
    if(newsForm && newsMsg) {
        newsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var email = document.getElementById('news-email').value;
            newsMsg.innerHTML = '<div class="alert alert-info py-2 small">Processing...</div>';
            
            var formData = new FormData();
            formData.append('email', email);
            formData.append('ajax', '1');
            
            fetch('process_subscribe.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                newsMsg.innerHTML = `<div class="alert alert-${data.status} py-2 small">${data.message}</div>`;
                if(data.status === 'success') newsForm.reset();
            })
            .catch(err => {
                newsMsg.innerHTML = '<div class="alert alert-danger py-2 small">Something went wrong.</div>';
            });
        });
    }
});
</script>
  