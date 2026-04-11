<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Course.php';
require_once dirname(__DIR__) . '/classes/Category.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('index.php');
}

$categoryObj = new Category($pdo);
$categories = $categoryObj->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseObj = new Course($pdo);
    
    // Handle Thumbnail Upload
    $thumbnail = 'assets/img/course-1.jpg'; // Default
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
        $uploadDir = '../uploads/courses/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = time() . '_' . basename($_FILES['thumbnail']['name']);
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $fileName)) {
            $thumbnail = 'uploads/courses/' . $fileName;
        }
    }

    $data = [
        'title' => sanitize($_POST['title']),
        'slug' => sanitize($_POST['slug']),
        'description' => $_POST['description'],
        'price' => (float)$_POST['price'],
        'discount_price' => (float)($_POST['discount_price'] ?? 0.00),
        'category_id' => (int)$_POST['category_id'],
        'instructor_id' => $_SESSION['user_id'],
        'status' => sanitize($_POST['status']),
        'thumbnail' => $thumbnail,
        'tags' => sanitize($_POST['tags']),
        'career_path' => sanitize($_POST['career_path'])
    ];

    if ($courseId = $courseObj->create($data)) {
        // Automatically create Batch 1 for this new course
        require_once dirname(__DIR__) . '/classes/Batch.php';
        $batchObj = new Batch($pdo);
        $batchObj->create($courseId, 1, 'Inaugural Batch', date('Y-m-d'), null, 'active');
        
        redirect('courses.php', 'Course and Batch 1 created successfully!', 'success');
    } else {
        $error = "Failed to create course.";
    }
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Create New Course</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>Course Details</h2>
            </div>
         </div>
         <div class="padding_infor_info">
            <?php if (isset($error)): ?>
               <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
               <div class="row g-3">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Course Title</label>
                     <input type="text" name="title" class="form-control" required placeholder="Ex: Advanced PHP Mastery">
                  </div>
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Course Slug (URL)</label>
                     <input type="text" name="slug" class="form-control" required placeholder="Ex: advanced-php-mastery">
                  </div>
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Regular Price (৳)</label>
                     <input type="number" step="0.01" name="price" class="form-control" required placeholder="0.00">
                     <small class="text-muted text-italic">Main price of the course.</small>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Discount Price (৳)</label>
                     <input type="number" step="0.01" name="discount_price" class="form-control" placeholder="0.00">
                     <small class="text-muted text-italic">Offer price (Leave 0 or empty for no discount).</small>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Category</label>
                     <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                           <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Status</label>
                     <select name="status" class="form-control">
                        <option value="draft">Draft (Private)</option>
                        <option value="published">Published (Public)</option>
                      </select>
                  </div>
                  
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Career Path</label>
                     <input type="text" name="career_path" class="form-control" placeholder="Full Stack Developer">
                  </div>

                  <div class="col-md-12 mb-3">
                     <label class="form-label">Tags (Comma Separated)</label>
                     <input type="text" name="tags" class="form-control" placeholder="php, web development, backend">
                  </div>

                  <div class="col-md-12 mb-3">
                     <label class="form-label">Course Thumbnail</label>
                     <input type="file" name="thumbnail" class="form-control" accept="image/*">
                  </div>

                  <div class="col-12 mb-3">
                     <label class="form-label">Description</label>
                     <textarea name="description" class="form-control" rows="5" required></textarea>
                  </div>
                  <div class="col-12 text-right">
                     <a href="courses.php" class="btn btn-secondary px-5">Cancel</a>
                     <button type="submit" class="btn btn-primary px-5">Create Course</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>

