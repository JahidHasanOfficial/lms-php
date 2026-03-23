<?php
require_once 'config/session.php';

if (!isset($_GET['slug'])) {
    redirect('blog.php');
}

$slug = sanitize($_GET['slug']);
$stmt = $pdo->prepare("SELECT b.*, bc.name as category_name, (SELECT COUNT(*) FROM blog_likes WHERE blog_id = b.id) as like_count 
                      FROM blogs b 
                      JOIN blog_categories bc ON b.category_id = bc.id 
                      WHERE b.slug = ? AND b.status = 'published'");
$stmt->execute([$slug]);
$blog = $stmt->fetch();

if (!$blog) {
    redirect('blog.php');
}

// Check if current user liked it
$userLiked = false;
if (isLoggedIn()) {
    $stmt = $pdo->prepare("SELECT * FROM blog_likes WHERE blog_id = ? AND user_id = ?");
    $stmt->execute([$blog['id'], $_SESSION['user_id']]);
    $userLiked = $stmt->fetch() ? true : false;
}

require_once 'includes/header.php';
?>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <img class="img-fluid w-100 rounded mb-5 shadow" src="<?php echo $blog['image']; ?>" alt="">
                <div class="d-flex mb-4">
                    <span class="badge bg-primary px-3 mb-2 me-3"><?php echo $blog['category_name']; ?></span>
                    <small class="me-3"><i class="fa fa-calendar-alt text-primary me-2"></i><?php echo date('d M, Y', strtotime($blog['created_at'])); ?></small>
                    <small id="like-count-detail"><i class="fa fa-heart text-danger me-2"></i><?php echo $blog['like_count']; ?> Likes</small>
                </div>
                <h1 class="mb-4"><?php echo $blog['title']; ?></h1>
                <div class="blog-content mb-5" style="line-height: 1.8; font-size: 1.1rem;">
                    <?php echo nl2br($blog['content']); ?>
                </div>
                
                <div class="p-4 bg-light rounded d-flex justify-content-between align-items-center">
                    <div class="social-share">
                        <strong>Share:</strong>
                        <a class="btn btn-square btn-outline-primary rounded-circle mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-primary rounded-circle mx-1" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-primary rounded-circle mx-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <?php if (isLoggedIn()): ?>
                        <button class="btn <?php echo $userLiked ? 'btn-danger' : 'btn-outline-danger'; ?> rounded-pill px-4 like-btn" data-id="<?php echo $blog['id']; ?>">
                            <i class="fa fa-heart me-2"></i> <?php echo $userLiked ? 'Liked' : 'Like Post'; ?>
                        </button>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-secondary rounded-pill px-4">Login to Like</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Sidebar -->
                <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                    <div class="section-title section-title-sm position-relative pb-3 mb-4">
                        <h3 class="mb-0">Recent Posts</h3>
                    </div>
                    <?php 
                    $recent = $pdo->query("SELECT * FROM blogs WHERE status = 'published' AND slug != '$slug' ORDER BY id DESC LIMIT 5")->fetchAll();
                    foreach ($recent as $r):
                    ?>
                    <div class="d-flex rounded overflow-hidden mb-3 bg-light p-2 shadow-sm border-left">
                        <img class="img-fluid rounded" src="<?php echo $r['image']; ?>" style="width: 80px; height: 80px; object-fit: cover;" alt="">
                        <a href="blog_details.php?slug=<?php echo $r['slug']; ?>" class="h6 d-flex align-items-center px-3 mb-0 text-decoration-none text-dark">
                            <?php echo substr($r['title'], 0, 50); ?>...
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
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
                document.getElementById(`like-count-detail`).innerHTML = `<i class="fa fa-heart text-danger me-2"></i>${data.new_likes} Likes`;
                if (data.action === 'liked') {
                    this.classList.replace('btn-outline-danger', 'btn-danger');
                    this.innerHTML = '<i class="fa fa-heart me-2"></i> Liked';
                } else {
                    this.classList.replace('btn-danger', 'btn-outline-danger');
                    this.innerHTML = '<i class="fa fa-heart me-2"></i> Like Post';
                }
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
