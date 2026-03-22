<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$quiz_id = $_GET['id'] ?? null;
if (!$quiz_id) redirect('index.php');

// Fetch Quiz Details
$stmt = $pdo->prepare("SELECT q.*, c.title as course_title 
                        FROM quizzes q 
                        JOIN courses c ON q.course_id = c.id 
                        WHERE q.id = ? AND q.status = 'published'");
$stmt->execute([$quiz_id]);
$quiz = $stmt->fetch();

if (!$quiz) redirect('index.php');

// Check if user has already attempted this quiz
$stmt_check = $pdo->prepare("SELECT id FROM quiz_results WHERE quiz_id = ? AND user_id = ?");
$stmt_check->execute([$quiz_id, $_SESSION['user_id']]);
$existing_result = $stmt_check->fetch();

if ($existing_result) {
    header("Location: quiz_result.php?id=" . $existing_result['id']);
    exit();
}

// Fetch Questions
$stmt = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY id ASC");
$stmt->execute([$quiz_id]);
$questions = $stmt->fetchAll();

// Handle Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_answers = $_POST['answers'] ?? [];
    $score = 0;
    $total_marks = 0;

    foreach ($questions as $q) {
        $total_marks += $q['marks'];
        if (isset($user_answers[$q['id']]) && $user_answers[$q['id']] === $q['correct_answer']) {
            $score += $q['marks'];
        }
    }

    // Save result
    $stmt = $pdo->prepare("INSERT INTO quiz_results (quiz_id, user_id, score, total_marks) VALUES (?, ?, ?, ?)");
    $stmt->execute([$quiz_id, $_SESSION['user_id'], $score, $total_marks]);
    
    $result_id = $pdo->lastInsertId();
    header("Location: quiz_result.php?id=" . $result_id);
    exit();
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title d-flex justify-content-between align-items-center">
         <div>
            <h2 class="mb-0"><?php echo $quiz['title']; ?></h2>
            <p class="text-muted small mb-0"><?php echo $quiz['course_title']; ?></p>
         </div>
         <div class="text-right">
            <h4 class="text-primary mb-0" id="timer"><?php echo $quiz['time_limit_minutes']; ?>:00</h4>
            <small class="text-muted">Remaining Time</small>
         </div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <form action="" method="POST" id="quizForm">
         <?php foreach ($questions as $index => $q): 
            $options = json_decode($q['options'], true);
         ?>
         <div class="white_shd full margin_bottom_30 shadow-sm border-0">
            <div class="full graph_head bg-light pl-4 py-3">
               <div class="heading1 margin_0">
                  <h6 class="font-weight-bold">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></h6>
               </div>
            </div>
            <div class="padding_infor_info p-4">
               <h5 class="mb-4 text-dark"><?php echo $q['question_text']; ?></h5>
               <div class="row">
                  <?php foreach ($options as $optIndex => $option): ?>
                  <div class="col-md-6 mb-3">
                     <label class="d-flex align-items-center p-3 rounded border question_option cursor-pointer transition-all" for="q<?php echo $q['id']; ?>o<?php echo $optIndex; ?>">
                        <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="<?php echo $option; ?>" id="q<?php echo $q['id']; ?>o<?php echo $optIndex; ?>" class="mr-3 custom_radio">
                        <span><?php echo $option; ?></span>
                     </label>
                  </div>
                  <?php endforeach; ?>
               </div>
            </div>
         </div>
         <?php endforeach; ?>

         <div class="text-center mb-5">
            <button type="submit" class="btn btn-primary btn-lg px-5 py-3 shadow-lg rounded-pill font-weight-bold">
               <i class="fa fa-paper-plane mr-2"></i> Submit My Answers
            </button>
         </div>
      </form>
   </div>
</div>

<style>
.question_option { border: 2px solid #eee; transition: all 0.2s; }
.question_option:hover { border-color: #03a9f4; background-color: rgba(3, 169, 244, 0.05); }
.custom_radio { width: 18px; height: 18px; }
input[type="radio"]:checked + span { font-weight: bold; color: #03a9f4; }
.transition-all { transition: all 0.3s; }
.cursor-pointer { cursor: pointer; }
</style>

<script>
// Simple Timer
let timeLeft = <?php echo $quiz['time_limit_minutes'] * 60; ?>;
const timerDisplay = document.getElementById('timer');

const timerInterval = setInterval(() => {
    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        document.getElementById('quizForm').submit();
    } else {
        timeLeft--;
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
}, 1000);
</script>

<?php include 'includes/footer.php'; ?>
