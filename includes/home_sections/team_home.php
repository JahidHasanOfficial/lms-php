<!-- Team Start -->
<div class="container-xxl py-5 mt-5">
    <div class="container">
        <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
            <span class="px-3 py-1 rounded-pill bg-primary text-white small fw-bold mb-3 d-inline-block shadow-sm">Expert Mentors</span>
            <h2 class="fw-bold display-6 mt-2">Learn from the <span class="text-primary">Best Minds</span></h2>
            <div class="mx-auto mt-2 bg-primary rounded" style="width: 80px; height: 3px;"></div>
        </div>
        
        <div class="row g-4">
            <?php if (!empty($team_members)): ?>
                <?php foreach ($team_members as $m): ?>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
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
                <!-- Fallback: Placeholder cards omitted for brevity -->
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Instructor Modal -->
<div class="modal fade" id="instructorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <!-- Header Info -->
                <div class="d-flex align-items-center mb-5 pb-4 border-bottom">
                    <img id="modal_image" src="" alt="" class="rounded-pill p-1 border border-primary border-2 shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                    <div class="ms-4">
                        <h2 id="modal_name" class="fw-bold mb-0 text-dark"></h2>
                        <p id="modal_designation" class="text-danger fw-bold mb-0" style="font-size: 1.1rem;"></p>
                    </div>
                </div>

                <!-- Three Column/Two Column Grid -->
                <div class="row g-5">
                    <!-- Left Column -->
                    <div class="col-md-6 border-end">
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3"><i class="fa fa-layer-group text-primary me-2"></i>Specialized Area:</h5>
                            <ul id="modal_specializations" class="list-unstyled ps-2"></ul>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-3"><i class="fa fa-briefcase text-primary me-2"></i>Work Experience:</h5>
                            <ul id="modal_experience" class="list-unstyled ps-2"></ul>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3"><i class="fa fa-graduation-cap text-primary me-2"></i>Education Qualification:</h5>
                            <ul id="modal_education" class="list-unstyled ps-2"></ul>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-3"><i class="fa fa-building text-primary me-2"></i>Work Place:</h5>
                            <div id="modal_workplaces" class="d-flex gap-3 align-items-center flex-wrap"></div>
                        </div>
                    </div>
                </div>

                <!-- Footer Summary Grid -->
                <div class="row mt-5 pt-4 border-top">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-1">Training Experience</h5>
                        <p id="modal_training" class="text-dark fw-bold mb-0 h5"></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-1">Student</h5>
                        <p id="modal_students" class="text-dark fw-bold mb-0 h5"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.team-card {
    transition: all 0.4s ease;
    border: 1px solid rgba(0,0,0,0.03);
}
.team-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(43, 197, 212, 0.12) !important;
    border-color: #2BC5D4;
}
#instructorModal .list-unstyled li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 8px;
    color: #4b5563;
}
#instructorModal .list-unstyled li::before {
    content: "\2022";
    color: #2BC5D4;
    font-weight: bold;
    display: inline-block;
    width: 1em;
    margin-left: -1em;
    font-size: 1.2rem;
    position: absolute;
    top: -2px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const instructorModal = document.getElementById('instructorModal');
    if (instructorModal) {
        instructorModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            // Extract data from attributes
            const name = button.getAttribute('data-name');
            const designation = button.getAttribute('data-designation');
            const image = button.getAttribute('data-image');
            const specializations = button.getAttribute('data-specializations');
            const education = button.getAttribute('data-education');
            const experience = button.getAttribute('data-experience');
            const workplaces = button.getAttribute('data-workplace');
            const training = button.getAttribute('data-training');
            const students = button.getAttribute('data-students');

            // Update modal content
            this.querySelector('#modal_name').textContent = name;
            this.querySelector('#modal_designation').textContent = designation;
            this.querySelector('#modal_image').src = image;
            this.querySelector('#modal_training').textContent = training || 'N/A';
            this.querySelector('#modal_students').textContent = students || 'N/A';

            // Helper to fill lists
            const fillList = (id, text) => {
                const list = this.querySelector(id);
                list.innerHTML = '';
                if (text) {
                    text.split('\n').filter(i => i.trim()).forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item.trim();
                        list.appendChild(li);
                    });
                } else {
                    list.innerHTML = '<li class="text-muted">No information provided</li>';
                }
            };

            fillList('#modal_specializations', specializations);
            fillList('#modal_education', education);
            fillList('#modal_experience', experience);

            // Handle Workplaces
            const workplaceContainer = this.querySelector('#modal_workplaces');
            workplaceContainer.innerHTML = '';
            if (workplaces) {
                workplaces.split(',').forEach(wp => {
                    const span = document.createElement('span');
                    span.className = 'badge bg-light text-dark py-2 px-3 border';
                    span.textContent = wp.trim();
                    workplaceContainer.appendChild(span);
                });
            } else {
                workplaceContainer.innerHTML = '<span class="text-muted small italic">Information pending...</span>';
            }
        });
    }
});
</script>
<!-- Team End -->
