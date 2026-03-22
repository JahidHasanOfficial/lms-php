<?php
require_once dirname(__DIR__) . '/config/session.php';
require_once dirname(__DIR__) . '/classes/Course.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('../login.php');
}

$courseObj = new Course($pdo);

// Get all courses with instructor name
$stmt = $pdo->query("SELECT c.*, u.name as instructor_name FROM courses c JOIN users u ON c.instructor_id = u.id ORDER BY c.created_at DESC");
$allCourses = $stmt->fetchAll();

include 'includes/header.php';
?>
               
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title d-flex justify-content-between">
                              <h2>Course Management</h2>
                              <a href="add_course.php" class="btn btn-success"><i class="fa fa-plus"></i> Add New Course</a>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>All Courses</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                             <th>Thumbnail</th>
                                             <th>Title</th>
                                             <th>Instructor</th>
                                             <th>Price</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($allCourses as $course): ?>
                                          <tr>
                                             <td><img src="../<?php echo $course['thumbnail']; ?>" width="80" class="rounded"></td>
                                             <td><?php echo $course['title']; ?></td>
                                             <td><?php echo $course['instructor_name']; ?></td>
                                             <td>$<?php echo $course['price']; ?></td>
                                             <td><span class="badge badge-<?php echo ($course['status'] === 'published') ? 'success' : 'warning'; ?>"><?php echo ucfirst($course['status']); ?></span></td>
                                             <td>
                                                <div class="btn-group">
                                                   <a href="view_course.php?id=<?php echo $course['id']; ?>" class="btn btn-secondary btn-xs" title="View Source"><i class="fa fa-eye"></i> View</a>
                                                   <a href="curriculum.php?course_id=<?php echo $course['id']; ?>" class="btn btn-info btn-xs" title="Curriculum"><i class="fa fa-list"></i> Curriculum</a>
                                                   <a href="batches.php?course_id=<?php echo $course['id']; ?>" class="btn btn-warning btn-xs" title="Manage Batches"><i class="fa fa-users"></i> Batches</a>
                                                   <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                   <a href="delete_course.php?id=<?php echo $course['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                             </td>
                                          </tr>
                                          <?php endforeach; ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

<?php include 'includes/footer.php'; ?>
      <!-- jQuery and Scripts omitted -->
   </body>
</html>
