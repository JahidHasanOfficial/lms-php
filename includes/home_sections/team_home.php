<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
            <h1 class="mb-5">Expert Instructors</h1>
        </div>
        <div class="row g-4">
            <?php if (!empty($team_members)): ?>
                <?php foreach ($team_members as $m): ?>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light">
                            <div class="overflow-hidden">
                                <img class="img-fluid" src="<?php echo $m['image']; ?>" alt="">
                            </div>
                            <div class="text-center p-4">
                                <h5 class="mb-0"><?php echo $m['name']; ?></h5>
                                <small><?php echo $m['designation']; ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback if empty -->
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden"><img class="img-fluid" src="frontend-template/img/team-1.jpg" alt=""></div>
                        <div class="text-center p-4"><h5 class="mb-0">John Doe</h5><small>Senior Developer</small></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Team End -->
