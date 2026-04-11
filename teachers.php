<?php
require_once 'config/session.php';
require_once 'classes/Course.php';

// Fetch All Active Mentors
$team_members = $pdo->query("SELECT * FROM team_members WHERE status = 'active' ORDER BY id ASC")->fetchAll();

require_once 'includes/header.php';
?>

<!-- Custom Style for Teachers Page -->
<style>
    .teachers-wrapper {
        background-color: #f8fdff;
        padding-bottom: 80px;
    }
    
    .filter-section {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(43, 197, 212, 0.05);
        margin-top: -40px;
        position: relative;
        z-index: 10;
        border: 1px solid rgba(43, 197, 212, 0.1);
    }
    
    .search-box {
        position: relative;
    }
    
    .search-box i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #2BC5D4;
    }
    
    .search-box input {
        padding-left: 50px;
        height: 55px;
        border-radius: 50px;
        border: 1.5px solid #edf2f7;
        font-weight: 500;
        transition: 0.3s;
    }
    
    .search-box input:focus {
        border-color: #2BC5D4;
        box-shadow: 0 0 0 4px rgba(43, 197, 212, 0.1);
    }

    .mentor-count-badge {
        background: rgba(43, 197, 212, 0.1);
        color: #2BC5D4;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
    }
</style>

<div class="teachers-wrapper">
    <?php 
    $pageTitle = "Our Expert Mentors";
    include 'includes/breadcrumb.php'; 
    ?>

    <!-- Filter/Search Section -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="filter-section wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row align-items-center g-3">
                        <div class="col-md-7">
                            <div class="search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" id="teacherSearch" class="form-control" placeholder="Search by name or expertise...">
                            </div>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <span class="mentor-count-badge">
                                <i class="fa fa-users me-2"></i>Showing <span id="visibleCount"><?php echo count($team_members); ?></span> Mentors
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Grid (Reusing team_home structure but with searchable logic) -->
    <div class="container-xxl py-5 mt-4">
        <div class="container">
            <div class="row g-4" id="teachersGrid">
                <?php if (!empty($team_members)): ?>
                    <?php foreach ($team_members as $index => $m): ?>
                        <div class="col-lg-3 col-md-6 teacher-item wow fadeInUp" data-wow-delay="<?php echo ($index % 4) * 0.1; ?>s" 
                             data-name="<?php echo strtolower($m['name']); ?>" 
                             data-designation="<?php echo strtolower($m['designation']); ?>"
                             data-specialization="<?php echo strtolower($m['specializations'] ?? ''); ?>">
                            <div class="team-card bg-white shadow-sm rounded-4 p-4 h-100 text-center">
                                <div class="position-relative d-inline-block mb-4">
                                    <img class="img-fluid rounded-circle p-1 border border-primary border-2" 
                                         src="<?php echo $m['image']; ?>" 
                                         alt="<?php echo $m['name']; ?>" 
                                         style="width: 140px; height: 140px; object-fit: cover;">
                                </div>
                                <h5 class="mb-1 fw-bold"><?php echo $m['name']; ?></h5>
                                <small class="text-muted d-block mb-3"><?php echo $m['designation']; ?></small>
                                <div class="text-warning small mb-3">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                </div>
                                <button class="btn w-100 py-3 fw-bold text-white rounded-pill shadow-none mt-2 view-profile-btn" 
                                        style="background-color: #2BC5D4; transition: 0.3s;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#instructorModal"
                                        data-name="<?php echo htmlspecialchars($m['name']); ?>"
                                        data-designation="<?php echo htmlspecialchars($m['designation']); ?>"
                                        data-image="<?php echo $m['image']; ?>"
                                        data-specializations="<?php echo htmlspecialchars($m['specializations'] ?? ''); ?>"
                                        data-education="<?php echo htmlspecialchars($m['education'] ?? ''); ?>"
                                        data-experience="<?php echo htmlspecialchars($m['work_experience'] ?? ''); ?>"
                                        data-workplace="<?php echo htmlspecialchars($m['work_places'] ?? ''); ?>"
                                        data-training="<?php echo htmlspecialchars($m['training_experience'] ?? ''); ?>"
                                        data-students="<?php echo htmlspecialchars($m['total_students'] ?? ''); ?>">
                                    View Profile
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <h3 class="text-muted">No mentors found at the moment.</h3>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- No Results Message -->
            <div id="noResults" class="text-center py-5 d-none">
                <i class="fa fa-search-minus mb-4" style="font-size: 4rem; color: #2bc5d4; opacity: 0.3;"></i>
                <h3 class="text-dark">No Mentors Found</h3>
                <p class="text-muted">Try adjusting your search terms to find what you're looking for.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Component -->
<?php include 'includes/home_sections/team_home.php'; // Includes the modal HTML and JS logic ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('teacherSearch');
        const teacherItems = document.querySelectorAll('.teacher-item');
        const visibleCountSpan = document.getElementById('visibleCount');
        const noResults = document.getElementById('noResults');
        const teachersGrid = document.getElementById('teachersGrid');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            teacherItems.forEach(item => {
                const name = item.getAttribute('data-name');
                const designation = item.getAttribute('data-designation');
                const specialization = item.getAttribute('data-specialization');

                if (name.includes(query) || designation.includes(query) || specialization.includes(query)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            visibleCountSpan.textContent = visibleCount;
            
            if (visibleCount === 0) {
                noResults.classList.remove('d-none');
                teachersGrid.classList.add('d-none');
            } else {
                noResults.classList.add('d-none');
                teachersGrid.classList.remove('d-none');
            }
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>
