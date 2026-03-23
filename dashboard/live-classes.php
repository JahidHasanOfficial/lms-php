<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch all live classes for the user's enrolled courses/batches
$stmt = $pdo->prepare("SELECT lc.*, c.title as course_title, c.thumbnail 
                      FROM live_classes lc 
                      JOIN courses c ON lc.course_id = c.id 
                      JOIN enrollments e ON lc.course_id = e.course_id 
                      WHERE e.user_id = ? 
                      ORDER BY lc.start_time ASC");
$stmt->execute([$user_id]);
$liveSessions = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>My Live Classes (LV-02, LV-06)</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <?php if (empty($liveSessions)): ?>
         <div class="alert alert-info border-0 shadow-sm p-5 text-center bg-white rounded">
            <i class="fa fa-video-camera fa-4x text-muted mb-3"></i>
            <h4>No live sessions scheduled for your courses.</h4>
            <p class="text-muted">Keep an eye on your dashboard or email for announcements.</p>
         </div>
      <?php else: ?>
         <div class="row">
            <?php foreach ($liveSessions as $session): ?>
               <div class="col-md-4 mb-4">
                  <div class="card border-0 shadow-sm rounded overflow-hidden h-100">
                     <div class="position-relative">
                        <img src="../<?php echo $session['thumbnail']; ?>" class="card-img-top">
                        <?php if (strtotime($session['start_time']) <= time() && strtotime($session['end_time']) >= time()): ?>
                           <div class="position-absolute p-2 bg-danger text-white rounded text-xs" style="top: 10px; right: 10px; font-size: 10px; font-weight: bold; border-radius: 4px;">
                              <span class="mr-1 pulse">●</span> LIVE NOW
                           </div>
                        <?php endif; ?>
                     </div>
                     <div class="card-body">
                        <small class="text-primary font-weight-bold d-block mb-1"><?php echo $session['course_title']; ?></small>
                        <h5 class="card-title font-weight-bold mb-3"><?php echo $session['title']; ?></h5>
                        
                        <div class="d-flex align-items-center mb-2 small text-muted">
                           <i class="fa fa-calendar-o mr-2 text-info"></i>
                           <span><?php echo date('D, M d, Y', strtotime($session['start_time'])); ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-4 small text-muted">
                           <i class="fa fa-clock-o mr-2 text-info"></i>
                           <span><?php echo date('h:i A', strtotime($session['start_time'])); ?> - <?php echo date('h:i A', strtotime($session['end_time'])); ?></span>
                        </div>
                        
                        <?php if (strtotime($session['start_time']) <= time() && strtotime($session['end_time']) >= time()): ?>
                           <a href="<?php echo $session['zoom_link']; ?>" target="_blank" class="btn btn-danger btn-block py-2 font-weight-bold shadow-sm">Join Live Class <i class="fa fa-external-link ml-2"></i></a>
                        <?php elseif (strtotime($session['start_time']) > time()): ?>
                           <button disabled class="btn btn-secondary btn-block py-2 font-weight-bold">Upcoming Session</button>
                        <?php else: ?>
                           <a href="<?php echo $session['recording_url'] ?: '#'; ?>" class="btn btn-outline-primary btn-block py-2 <?php echo empty($session['recording_url']) ? 'disabled' : ''; ?>">
                              <i class="fa fa-play-circle mr-2"></i> <?php echo empty($session['recording_url']) ? 'Recording Unavailable' : 'Watch Recording'; ?>
                           </a>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>
      <?php endif; ?>
   </div>
</div>

<style>
.pulse { animation: pulse-text 2s infinite ease-in-out; }
@keyframes pulse-text {
  0% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.2); opacity: 0.5; }
  100% { transform: scale(1); opacity: 1; }
}
</style>

<?php include 'includes/footer.php'; ?>
