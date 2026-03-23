<?php
require_once 'config/session.php';

$blogs = $pdo->query("SELECT b.*, bc.name as category_name, (SELECT COUNT(*) FROM blog_likes WHERE blog_id = b.id) as like_count 
                      FROM blogs b 
                      JOIN blog_categories bc ON b.category_id = bc.id 
                      WHERE b.status = 'published' 
                      ORDER BY b.id DESC")->fetchAll();

require_once 'includes/header.php';
?>

<!-- Header Start -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-3 text-white animated slideInDown">Our Latest Blogs</h1>
    </div>
</div>
<!-- Header End -->

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($blogs as $b): ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="blog-item bg-light rounded overflow-hidden shadow-sm h-100 d-flex flex-column">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?php echo $b['image']; ?>" alt="" style="height: 250px; object-fit: cover;">
                            <div class="bg-primary text-white position-absolute top-0 start-0 m-3 py-1 px-3 rounded">
                                <?php echo $b['category_name']; ?>
                            </div>
                        </div>
                        <div class="p-4 flex-grow-1">
                            <div class="d-flex mb-3">
                                <small class="me-3"><i class="fa fa-calendar-alt text-primary me-2"></i><?php echo date('d M, Y', strtotime($b['created_at'])); ?></small>
                                <small id="like-count-<?php echo $b['id']; ?>"><i class="fa fa-heart text-danger me-2"></i><?php echo $b['like_count']; ?> Likes</small>
                            </div>
                            <h4 class="mb-3"><?php echo $b['title']; ?></h4>
                            <p><?php echo substr(strip_tags($b['content']), 0, 100); ?>...</p>
                        </div>
                        <div class="p-4 pt-0 mt-auto border-top d-flex justify-content-between align-items-center">
                            <a href="blog_details.php?slug=<?php echo $b['slug']; ?>" class="btn btn-primary rounded-pill px-4">Read More</a>
                            <?php if (isLoggedIn()): ?>
                                <button class="btn btn-outline-danger btn-sm rounded-circle like-btn" data-id="<?php echo $b['id']; ?>">
                                    <i class="fa fa-heart"></i>
                                </button>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline-secondary btn-sm rounded-circle" title="Login to like">
                                    <i class="fa fa-heart"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const blogId = this.dataset.id;
        fetch('ajax/like_blog.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `blog_id=${blogId}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById(`like-count-${blogId}`).innerHTML = `<i class="fa fa-heart text-danger me-2"></i>${data.new_likes} Likes`;
                if (data.action === 'liked') this.classList.add('btn-danger', 'text-white');
                else this.classList.remove('btn-danger', 'text-white');
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
