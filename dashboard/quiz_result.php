<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$id = $_GET['id'] ?? null;
if (!$id) redirect('index.php');

$stmt = $pdo->prepare("SELECT qr.*, q.title as quiz_title, c.title as course_title 
                        FROM quiz_results qr 
                        JOIN quizzes q ON qr.quiz_id = q.id 
                        JOIN courses c ON q.course_id = c.id 
                        WHERE qr.id = ? AND qr.user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$result = $stmt->fetch();

if (!$result) redirect('index.php');

$percentage = ($result['score'] / $result['total_marks']) * 100;

include 'includes/header.php';
?>

<div class="row">
   <div class="col-md-8 offset-md-2 mt-5">
      <div class="white_shd full margin_bottom_30 shadow-lg border-0 rounded-lg overflow-hidden">
         <div class="full graph_head bg-primary p-5 text-center text-white">
            <i class="fa fa-trophy fa-5x mb-4 text-warning"></i>
            <h1 class="mb-0 text-white">Quiz Completed!</h1>
            <p class="lead text-white-50 mt-2"><?php echo $result['quiz_title']; ?></p>
         </div>
         <div class="padding_infor_info p-5 text-center">
            <h6 class="text-muted text-uppercase mb-4"><?php echo $result['course_title']; ?></h6>
            
            <div class="display-1 font-weight-bold text-dark mb-2">
               <?php echo $result['score']; ?> <span class="text-muted h3">/ <?php echo $result['total_marks']; ?></span>
            </div>
            <p class="h3 font-weight-light mb-5">Your final score is <strong><?php echo number_format($percentage, 0); ?>%</strong></p>

            <div class="row mb-5">
               <div class="col-6 text-right pr-4 border-right">
                  <h4 class="mb-0"><?php echo $result['score']; ?></h4>
                  <small class="text-muted text-uppercase">Correct Answers</small>
               </div>
               <div class="col-6 text-left pl-4">
                  <h4 class="mb-0"><?php echo $result['total_marks'] - $result['score']; ?></h4>
                  <small class="text-muted text-uppercase">Incorrect Answers</small>
               </div>
            </div>

            <div class="d-flex justify-content-center">
               <a href="index.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm mx-2">Return to Dashboard</a>
               <button class="btn btn-outline-secondary btn-lg px-5 py-3 rounded-pill mx-2" onclick="window.print()">Print Result</button>
            </div>
         </div>
         
         <div class="bg-light p-4 text-center border-top">
            <p class="mb-0 small text-muted">Completed on <?php echo date('M d, Y \a\t h:i A', strtotime($result['completed_at'])); ?></p>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
