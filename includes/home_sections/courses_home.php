<!-- Courses Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
            <h1 class="mb-5">Popular Courses</h1>
        </div>
        <div class="owl-carousel course-carousel wow fadeInUp" data-wow-delay="0.1s">
            <?php foreach ($popularCourses as $course): ?>
            <div class="course-item bg-light shadow-sm rounded overflow-hidden mx-2">
                <div class="position-relative overflow-hidden">
                    <img class="img-fluid w-100" src="<?php echo $course['thumbnail']; ?>" alt="" style="height: 230px; object-fit: cover;">
                    <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                        <a href="course-details.php?slug=<?php echo $course['slug']; ?>" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                        <a href="enroll.php?id=<?php echo $course['id']; ?>" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a>
                    </div>
                </div>
                <div class="text-center p-4 pb-0">
                    <h3 class="mb-2">
                        <?php if($course['discount_price'] > 0): ?>
                            <span class="text-primary">$<?php echo $course['discount_price']; ?></span>
                            <small class="text-decoration-line-through text-muted" style="font-size: 1.2rem;">$<?php echo $course['price']; ?></small>
                        <?php else: ?>
                            <span class="text-primary">$<?php echo $course['price']; ?></span>
                        <?php endif; ?>
                    </h3>
                    <div class="mb-3">
                        <small class="fa fa-star text-primary"></small>
                        <small class="fa fa-star text-primary"></small>
                        <small class="fa fa-star text-primary"></small>
                        <small class="fa fa-star text-primary"></small>
                        <small class="fa fa-star text-primary"></small>
                    </div>
                    <h5 class="mb-1 text-truncate px-2"><?php echo $course['title']; ?></h5>
                    <?php if($course['next_batch_name']): ?>
                        <small class="text-primary d-block mb-1 font-weight-bold"><?php echo $course['next_batch_name']; ?></small>
                    <?php endif; ?>
                    <?php if($course['enrollment_deadline']): ?>
                        <div class="badge bg-danger mb-3 px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                            <i class="fa fa-clock me-1"></i> Last Date: <?php echo date('d M, Y', strtotime($course['enrollment_deadline'])); ?>
                        </div>
                    <?php else: ?>
                        <div style="height: 48px;"></div>
                    <?php endif; ?>
                </div>
                <div class="d-flex border-top text-muted">
                    <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i><?php echo substr($course['instructor_name'], 0, 10); ?><?php echo strlen($course['instructor_name']) > 10 ? '..' : ''; ?></small>
                    <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i><?php echo $course['total_duration_hours']; ?> Hrs</small>
                    <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i><?php echo $course['student_count']; ?> Studs</small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Courses End -->
