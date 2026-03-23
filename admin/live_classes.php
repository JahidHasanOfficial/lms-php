<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn() || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'instructor')) {
    redirect('../login.php');
}

// Handle Add Class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_live'])) {
    $course_id = (int)$_POST['course_id'];
    $title = sanitize($_POST['title']);
    $zoom = $_POST['zoom_link'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    
    $stmt = $pdo->prepare("INSERT INTO live_classes (course_id, title, instructor_id, start_time, end_time, zoom_link) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$course_id, $title, $_SESSION['user_id'], $start, $end, $zoom])) {
        redirect('live_classes.php', 'Live class scheduled successfully!', 'success');
    }
}

// Fetch all live classes
$liveClasses = $pdo->query("SELECT lc.*, c.title as course_title FROM live_classes lc JOIN courses c ON lc.course_id = c.id ORDER BY lc.start_time DESC")->fetchAll();
$courses = $pdo->query("SELECT id, title FROM courses")->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between">
         <h2>Live Class Management (LV-01, LV-02)</h2>
         <button class="btn btn-primary" data-toggle="modal" data-target="#addClassModal"><i class="fa fa-plus"></i> Schedule New Class</button>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php displayAlert(); ?>
      <div class="white_shd full margin_bottom_30">
         <div class="full graph_head">
            <div class="heading1 margin_0">
               <h2>All Scheduled Sessions</h2>
            </div>
         </div>
         <div class="table_section padding_infor_info">
            <div class="table-responsive-sm">
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th>Course</th>
                        <th>Session Title</th>
                        <th>Start Time</th>
                        <th>Duration</th>
                        <th>Link</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($liveClasses as $lc): ?>
                     <tr>
                        <td><?php echo $lc['course_title']; ?></td>
                        <td><strong><?php echo $lc['title']; ?></strong></td>
                        <td><?php echo date('M d, h:i A', strtotime($lc['start_time'])); ?></td>
                        <td><?php 
                           $diff = strtotime($lc['end_time']) - strtotime($lc['start_time']);
                           echo round($diff / 60) . ' mins';
                        ?></td>
                        <td><a href="<?php echo $lc['zoom_link']; ?>" target="_blank" class="btn btn-xs btn-outline-info">Zoom <i class="fa fa-external-link"></i></a></td>
                        <td>
                           <?php if (strtotime($lc['start_time']) > time()): ?>
                              <span class="badge badge-warning">Upcoming</span>
                           <?php elseif (strtotime($lc['end_time']) < time()): ?>
                              <span class="badge badge-secondary">Past</span>
                           <?php else: ?>
                              <span class="badge badge-success pulse-btn">Live Now</span>
                           <?php endif; ?>
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

<!-- Add Modal -->
<div class="modal fade" id="addClassModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Schedule Live Session</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form method="POST">
            <div class="modal-body">
               <div class="mb-3">
                  <label>Course</label>
                  <select name="course_id" class="form-control" required>
                     <?php foreach ($courses as $c): ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['title']; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="mb-3">
                  <label>Session Title</label>
                  <input type="text" name="title" class="form-control" required placeholder="Ex: Week 1 Q&A Session">
               </div>
               <div class="mb-3">
                  <label>Integration Link (Zoom/Jitsi/Google Meet)</label>
                  <input type="url" name="zoom_link" class="form-control" required placeholder="https://zoom.us/j/...">
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label>Start Time</label>
                     <input type="datetime-local" name="start_time" class="form-control" required>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>End Time</label>
                     <input type="datetime-local" name="end_time" class="form-control" required>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" name="add_live" class="btn btn-primary">Schedule Now</button>
            </div>
         </form>
      </div>
   </div>
</div>

<style>
.pulse-btn { animation: pulse 2s infinite; }
@keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0.5; }
  100% { opacity: 1; }
}
</style>

<?php include 'includes/footer.php'; ?>
