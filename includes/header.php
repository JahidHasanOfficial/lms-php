<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Prime University LMS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="frontend-template/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="frontend-template/lib/animate/animate.min.css" rel="stylesheet">
    <link href="frontend-template/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="frontend-template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="frontend-template/css/style.css" rel="stylesheet">
    
    <!-- Custom Theme Styles -->
    <style>
        :root {
            --primary: #2BC5D4;
        }
        body {
            background-color: #ebf8ff;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 25px 25px;
        }
        .text-primary {
            color: #2BC5D4 !important;
        }
        .bg-primary {
            background-color: #2BC5D4 !important;
        }
        .btn-primary {
            background-color: #2BC5D4 !important;
            border-color: #2BC5D4 !important;
        }
        .btn-primary:hover {
            background-color: #24a8b5 !important;
            border-color: #24a8b5 !important;
        }
        .section-title::before, .section-title::after {
            background: #2BC5D4 !important;
        }
        .back-to-top {
            background-color: #2BC5D4 !important;
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Prime University</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index" class="nav-item nav-link active">Home</a>
                <a href="about" class="nav-item nav-link">About</a>
                <a href="courses" class="nav-item nav-link">Courses</a>
                <a href="teachers" class="nav-item nav-link">Mentors</a>
                <a href="blog" class="nav-item nav-link">Blog</a>
                <a href="success-story" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'success-story' ? 'active' : ''; ?>">Success Stories</a>
                <a href="contact" class="nav-item nav-link">Contact</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard" class="nav-item nav-link">Dashboard</a>
                    <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'instructor'): ?>
                        <a href="admin/index" class="nav-item nav-link text-primary font-weight-bold">Admin Panel</a>
                    <?php endif; ?>
                    <a href="logout" class="nav-item nav-link">Logout</a>
                <?php else: ?>
                    <a href="login" class="nav-item nav-link">Login</a>
                <?php endif; ?>
            </div>
            <div class="ms-lg-4 d-none d-lg-block">
                <form action="courses" method="GET" class="position-relative" id="headerSearchForm">
                    <div class="header-search-v3">
                        <i class="fa fa-search search-icon-left text-success"></i>
                        <input type="text" name="q" id="headerSearchInput" autocomplete="off" placeholder="কি শিখতে চান?..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" class="search-input-pill">
                        
                        <!-- Search Dropdown Results -->
                        <div id="searchResultsDropdown" class="search-results-box shadow-lg d-none">
                            <!-- Results inject here -->
                        </div>

                        <?php if(isset($_GET['q']) && $_GET['q'] != ''): ?>
                            <a href="courses" class="clear-search-right text-decoration-none">
                                <i class="fa fa-times text-primary"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <style>
    .header-search-v3 {
        position: relative;
        width: 320px;
        z-index: 1000;
    }
    .search-input-pill {
        width: 100%;
        height: 48px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        padding: 0 45px 0 50px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    .search-input-pill:focus {
        background: #fff;
        outline: none;
        border-color: #2BC5D4;
        box-shadow: 0 4px 20px rgba(43, 197, 212, 0.15);
    }
    .search-icon-left {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.1rem;
        pointer-events: none;
        z-index: 10;
    }
    .search-results-box {
        position: absolute;
        top: 110%;
        left: 0;
        width: 400px;
        background: #fff;
        border-radius: 15px;
        max-height: 450px;
        overflow-y: auto;
        border: 1px solid #edf2f7;
        z-index: 9999;
        padding: 10px 0;
    }
    .search-result-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        border-bottom: 1px solid #f7fafc;
        transition: 0.2s;
        text-decoration: none;
        color: #2d3748;
    }
    .search-result-item:hover {
        background: #f0f9ff;
    }
    .search-result-item img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 15px;
    }
    .search-result-item .title {
        font-weight: 600;
        font-size: 0.9rem;
        line-height:1.3;
    }
    .search-result-item .price {
        color: #2BC5D4;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .clear-search-right {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1rem;
        z-index: 1001;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('headerSearchInput');
        const resultsBox = document.getElementById('searchResultsDropdown');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                if (query.length > 1) {
                    fetch(`api/search_courses.php?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > 0) {
                                let html = '';
                                data.forEach(course => {
                                    html += `
                                        <a href="course-details.php?slug=${course.slug}" class="search-result-item">
                                            <img src="${course.thumbnail}" alt="">
                                            <div>
                                                <div class="title">${course.title}</div>
                                                <div class="price">৳${course.discount_price || course.price}</div>
                                            </div>
                                        </a>
                                    `;
                                });
                                html += `<a href="courses.php?q=${encodeURIComponent(query)}" class="d-block text-center py-2 text-primary small fw-bold mt-2">সকল কোর্স দেখুন</a>`;
                                resultsBox.innerHTML = html;
                                resultsBox.classList.remove('d-none');
                            } else {
                                resultsBox.innerHTML = '<div class="text-center py-3 text-muted small">কোনো কোর্স পাওয়া যায়নি</div>';
                                resultsBox.classList.remove('d-none');
                            }
                        });
                } else {
                    resultsBox.classList.add('d-none');
                }
            });

            // Close results on click outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                    resultsBox.classList.add('d-none');
                }
            });
        }
    });
    </script>

