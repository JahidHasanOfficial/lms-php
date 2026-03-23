<!-- Testimonial Start -->
<div id="testimonial" class="container-xxl py-5" style="background: #ffffff; color: #333; margin-top: 50px;">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h2 class="mb-2" style="font-size: 2.5rem; font-weight: 700; color: #111c26;">কী বলছেন আমাদের সাকসেসফুল লার্নাররা</h2>
            <p class="mb-5 text-muted" style="font-size: 1.1rem;">জেনে নিন আমাদের লার্নারদের রিয়েল লাইফ এক্সপেরিয়েন্স, যা বদলে দিচ্ছে তাদের ক্যারিয়ার।</p>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $t): ?>
                    <div class="testimonial-item text-center p-4 m-2" style="background: #f8f9fa; border: 1px solid #eee; border-radius: 20px; min-height: 400px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <div class="content">
                            <img class="border border-primary p-1 mx-auto mb-4" src="<?php echo $t['image']; ?>" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                            <div class="testimonial-text mb-4">
                                <p class="mb-0 text-muted" style="font-style: italic; line-height: 1.6;"><?php echo $t['feedback']; ?></p>
                            </div>
                        </div>
                        <div class="author mt-auto">
                            <h5 class="mb-1" style="color: #111c26;"><?php echo $t['student_name']; ?></h5>
                            <small class="text-primary" style="font-weight: 600;"><?php echo $t['profession']; ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default Placeholder -->
                <div class="testimonial-item text-center p-4 m-2" style="background: #f8f9fa; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <img class="border border-primary p-1 mx-auto mb-4" src="frontend-template/img/testimonial-1.jpg" style="width: 80px; height: 80px; border-radius: 50%;">
                    <p class="text-muted italic">Learning from this platform was the best decision for my career...</p>
                    <h5 class="mb-1">Sample Student</h5>
                    <small class="text-primary">MERN Stack Batch 01</small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Testimonial End -->
