<?php
require_once 'config/session.php';
require_once 'classes/Course.php';

$courseObj = new Course($pdo);
$courses = $courseObj->getAllPublished();

require_once 'includes/header.php';
?>

<!-- Custom Style Link -->
<link href="assets/css/courses-custom.css" rel="stylesheet">

<?php 
$pageTitle = "All Courses";
include 'includes/breadcrumb.php'; 
?>

<div class="container-xxl pb-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <div class="row g-4 mt-5">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="filter-card shadow-sm">
                    <!-- Search -->
                    <div class="mb-4">
                        <div class="filter-group-header">
                            <span>Search by Course</span>
                        </div>
                        <div class="search-input-group mt-2">
                            <i class="fa fa-search"></i>
                            <input type="text" id="courseSearch" placeholder="Search by course name..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <div class="filter-group-header">
                            <span>Course Category</span>
                        </div>
                        <ul class="filter-items-list mt-2">
                            <li><input type="checkbox" class="category-filter" value="web"> Web & Software Development</li>
                            <li><input type="checkbox" class="category-filter" value="graphics"> Graphics and Multimedia</li>
                            <li><input type="checkbox" class="category-filter" value="marketing"> Digital Marketing</li>
                            <li><input type="checkbox" class="category-filter" value="networking"> Networking</li>
                            <li><input type="checkbox" class="category-filter" value="cpa"> CPA and Affiliate Marketing</li>
                        </ul>
                    </div>

                    <!-- Dual Handle Price Range (NEW) -->
                    <div class="mb-4">
                        <div class="filter-group-header">
                            <span>Price Range</span>
                        </div>
                        <div class="middle">
                            <div class="multi-range-slider">
                                <input type="range" id="input-left" class="price-input" min="0" max="100000" value="0">
                                <input type="range" id="input-right" class="price-input" min="0" max="100000" value="100000">

                                <div class="slider">
                                    <div class="track"></div>
                                    <div class="range"></div>
                                    <div class="thumb left"></div>
                                    <div class="thumb right"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <span id="minPriceDisplay" class="small fw-bold text-success">৳ 0</span>
                                <span id="maxPriceDisplay" class="small fw-bold text-success">৳ 100000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Level -->
                    <div class="mb-4">
                        <div class="filter-group-header">
                            <span>Level</span>
                        </div>
                        <ul class="filter-items-list mt-2">
                            <li><input type="checkbox" class="level-filter" value="Beginner"> Beginner</li>
                            <li><input type="checkbox" class="level-filter" value="Intermediate"> Intermediate</li>
                            <li><input type="checkbox" class="level-filter" value="Advanced"> Advanced</li>
                        </ul>
                    </div>

                    <button id="clearFilters" class="btn btn-success w-100 py-3 mt-3 shadow-sm border-0" style="background: #28a745; border-radius: 5px; font-weight: 700;">
                        <i class="fa fa-filter me-2"></i> Clear Query Filters
                    </button>
                </div>
            </div>

            <!-- Course Content -->
            <div class="col-lg-9">
                <div class="row g-4" id="courseContainer">
                    <?php if (empty($courses)): ?>
                        <div class="col-12 text-center py-5"><h3 class="text-muted">No courses available.</h3></div>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-lg-4 col-md-6 course-item-v2 wow fadeInUp" 
                                 data-title="<?php echo strtolower($course['title']); ?>"
                                 data-category="<?php echo strtolower($course['category_name'] ?? 'web'); ?>" 
                                 data-price="<?php echo $course['price']; ?>"
                                 data-level="<?php echo $course['level'] ?? 'Beginner'; ?>"
                                 data-wow-delay="0.1s">
                                <div class="course-card-v2 shadow-sm">
                                    <div class="thumb-v2">
                                        <img src="<?php echo $course['thumbnail']; ?>" alt="<?php echo $course['title']; ?>" loading="lazy">
                                        <span class="off-badge">৳ <?php echo ceil($course['price'] * 0.2); ?> off</span>
                                    </div>
                                    <div class="content-v2">
                                        <h5 class="title-v2"><?php echo $course['title']; ?></h5>
                                        <div class="rating-v2"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                                        <div class="meta-v2"><span><i class="fa fa-book"></i> 15 Classes</span><span><i class="fa fa-clock"></i> 60 days</span></div>
                                        <div class="price-v2 mt-3"><span class="old-price">৳ <?php echo $course['price'] + ceil($course['price'] * 0.2); ?></span><span class="new-price">৳ <?php echo $course['price']; ?></span></div>
                                        <a href="course-details.php?slug=<?php echo $course['slug']; ?>" class="btn-v2 text-decoration-none">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="noDataMessage" class="col-12 text-center py-5" style="display: none;"><h3 class="text-muted">No courses found matching your criteria.</h3></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputLeft = document.getElementById("input-left");
        const inputRight = document.getElementById("input-right");
        const thumbLeft = document.querySelector(".slider > .thumb.left");
        const thumbRight = document.querySelector(".slider > .thumb.right");
        const range = document.querySelector(".slider > .range");
        const minDisplay = document.getElementById('minPriceDisplay');
        const maxDisplay = document.getElementById('maxPriceDisplay');

        function setLeftValue() {
            const _this = inputLeft, min = parseInt(_this.min), max = parseInt(_this.max);
            _this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value) - 1);
            const percent = ((_this.value - min) / (max - min)) * 100;
            thumbLeft.style.left = percent + "%";
            range.style.left = percent + "%";
            minDisplay.innerText = '৳ ' + _this.value;
            filterCourses();
        }

        function setRightValue() {
            const _this = inputRight, min = parseInt(_this.min), max = parseInt(_this.max);
            _this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value) + 1);
            const percent = ((_this.value - min) / (max - min)) * 100;
            thumbRight.style.right = (100 - percent) + "%";
            range.style.right = (100 - percent) + "%";
            maxDisplay.innerText = '৳ ' + _this.value;
            filterCourses();
        }

        inputLeft.addEventListener("input", setLeftValue);
        inputRight.addEventListener("input", setRightValue);

        // Hover effects for thumbs
        inputLeft.addEventListener("mouseover", () => thumbLeft.classList.add("hover"));
        inputLeft.addEventListener("mouseout", () => thumbLeft.classList.remove("hover"));
        inputRight.addEventListener("mouseover", () => thumbRight.classList.add("hover"));
        inputRight.addEventListener("mouseout", () => thumbRight.classList.remove("hover"));

        // General Filter Logic
        const searchInput = document.getElementById('courseSearch');
        const categoryCheckboxes = document.querySelectorAll('.category-filter');
        const levelCheckboxes = document.querySelectorAll('.level-filter');
        const courseItems = document.querySelectorAll('.course-item-v2');
        const noDataMessage = document.getElementById('noDataMessage');

        function filterCourses() {
            const searchTerm = searchInput.value.toLowerCase();
            const minPrice = parseInt(inputLeft.value);
            const maxPrice = parseInt(inputRight.value);
            const selectedCategories = Array.from(categoryCheckboxes).filter(cb => cb.checked).map(cb => cb.value.toLowerCase());
            const selectedLevels = Array.from(levelCheckboxes).filter(cb => cb.checked).map(cb => cb.value);

            let visibleCount = 0;
            courseItems.forEach(item => {
                const title = item.getAttribute('data-title');
                const category = item.getAttribute('data-category');
                const price = parseInt(item.getAttribute('data-price'));
                const level = item.getAttribute('data-level');

                const matchesSearch = title.includes(searchTerm);
                const matchesPrice = price >= minPrice && price <= maxPrice;
                const matchesCategory = selectedCategories.length === 0 || selectedCategories.some(cat => category.includes(cat));
                const matchesLevel = selectedLevels.length === 0 || selectedLevels.includes(level);

                if (matchesSearch && matchesPrice && matchesCategory && matchesLevel) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            noDataMessage.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterCourses);
        categoryCheckboxes.forEach(cb => cb.addEventListener('change', filterCourses));
        levelCheckboxes.forEach(cb => cb.addEventListener('change', filterCourses));

        document.getElementById('clearFilters').addEventListener('click', () => {
            searchInput.value = '';
            inputLeft.value = 0;
            inputRight.value = 100000;
            categoryCheckboxes.forEach(cb => cb.checked = false);
            levelCheckboxes.forEach(cb => cb.checked = false);
            setLeftValue();
            setRightValue();
        });

        // Initialize display
        setLeftValue();
        setRightValue();

        // Auto-select category based on search results if q is present
        if (searchInput.value.trim() !== '') {
            const visibleItems = Array.from(courseItems).filter(item => item.style.display !== 'none');
            if (visibleItems.length > 0) {
                const categoriesToSelect = new Set();
                visibleItems.forEach(item => {
                    const cat = item.getAttribute('data-category');
                    if (cat) categoriesToSelect.add(cat.toLowerCase());
                });

                categoryCheckboxes.forEach(cb => {
                    if (categoriesToSelect.has(cb.value.toLowerCase())) {
                        cb.checked = true;
                    }
                });
                // Re-run filter to ensure everything is synced (though this is double filtering, it's safer)
                filterCourses();
            }
        }
    });
</script>

<?php require_once 'includes/footer.php'; ?>

