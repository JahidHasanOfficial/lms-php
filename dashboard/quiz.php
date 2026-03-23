<?php
require_once dirname(__DIR__) . '/config/session.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$quiz_id = $_GET['id'] ?? null;
if (!$quiz_id) redirect('index.php');

// Fetch Quiz & Questions
$stmt = $pdo->prepare("SELECT q.*, c.title as course_title FROM quizzes q JOIN courses c ON q.course_id = c.id WHERE q.id = ?");
$stmt->execute([$quiz_id]);
$quiz = $stmt->fetch();

if (!$quiz) redirect('index.php');

// Fetch Questions with Options
$stmt_q = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY id ASC");
$stmt_q->execute([$quiz_id]);
$questions = $stmt_q->fetchAll();

foreach ($questions as &$q) {
    $stmt_o = $pdo->prepare("SELECT * FROM quiz_options WHERE question_id = ?");
    $stmt_o->execute([$q['id']]);
    $q['options'] = $stmt_o->fetchAll();
}

// Handle Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $score = 0;
    $total = count($questions);
    
    foreach ($questions as $q) {
        $ans = $_POST['q_' . $q['id']] ?? null;
        if ($ans) {
            $stmt_check = $pdo->prepare("SELECT is_correct FROM quiz_options WHERE id = ?");
            $stmt_check->execute([$ans]);
            if ($stmt_check->fetchColumn()) {
                $score++;
            }
        }
    }
    
    // Save Result
    $stmt_res = $pdo->prepare("INSERT INTO quiz_results (quiz_id, user_id, score, total_marks) VALUES (?, ?, ?, ?)");
    $stmt_res->execute([$quiz_id, $user_id, $score, $total]);
    
    $success = "You scored $score out of $total!";
}

include 'includes/header.php';
?>

<div class="row column_title">
   <div class="col-md-12">
      <div class="page_title">
         <h2>Quiz: <?php echo $quiz['title']; ?> (A-03, A-06)</h2>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-8 offset-md-2">
      <?php if (isset($success)): ?>
         <div class="white_shd full margin_bottom_30 p-5 text-center bg-white rounded shadow">
            <i class="fa fa-trophy fa-4x text-warning mb-3"></i>
            <h3>Assessment Complete!</h3>
            <p class="lead"><?php echo $success; ?></p>
            <a href="index.php" class="btn btn-primary px-5 mt-3">Back to Dashboard</a>
         </div>
      <?php else: ?>
         <form method="POST">
            <div id="quiz-container">
               <?php foreach ($questions as $index => $q): ?>
                  <div class="white_shd full margin_bottom_30 quiz-step <?php echo ($index == 0) ? '' : 'd-none'; ?>" id="q-<?php echo $index; ?>">
                     <div class="full graph_head p-4">
                        <div class="d-flex justify-content-between">
                           <h5 class="mb-0 font-weight-bold text-primary">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></h5>
                           <span class="badge badge-info">1 Point</span>
                        </div>
                     </div>
                     <div class="padding_infor_info p-5">
                        <h4 class="mb-4 text-dark"><?php echo $q['question']; ?></h4>
                        <div class="options-list">
                           <?php foreach ($q['options'] as $opt): ?>
                              <label class="option-item d-block p-3 border rounded mb-3 cursor-pointer">
                                 <input type="radio" name="q_<?php echo $q['id']; ?>" value="<?php echo $opt['id']; ?>" class="mr-3">
                                 <?php echo $opt['option_text']; ?>
                              </label>
                           <?php endforeach; ?>
                        </div>
                     </div>
                     <div class="modal-footer border-0 p-4">
                        <?php if ($index > 0): ?>
                           <button type="button" class="btn btn-secondary px-4" onclick="showStep(<?php echo $index - 1; ?>)">Previous</button>
                        <?php endif; ?>
                        
                        <?php if ($index < count($questions) - 1): ?>
                           <button type="button" class="btn btn-primary px-4" onclick="showStep(<?php echo $index + 1; ?>)">Next Question</button>
                        <?php else: ?>
                           <button type="submit" class="btn btn-success px-4" onclick="return confirm('Finish assessment?')">Submit Quiz</button>
                        <?php endif; ?>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
         </form>
      <?php endif; ?>
   </div>
</div>

<script>
function showStep(step) {
    document.querySelectorAll('.quiz-step').forEach(div => div.classList.add('d-none'));
    document.getElementById('q-' + step).classList.remove('d-none');
}

// Timer Logic (A-06)
<?php if (!isset($success)): ?>
let timeLeft = <?php echo $quiz['time_limit'] * 60; ?>;
const timerInterval = setInterval(() => {
    timeLeft--;
    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        alert('Time is up!');
        document.forms[0].submit();
    }
}, 1000);
<?php endif; ?>
</script>

<style>
.option-item { transition: all 0.2s; }
.option-item:hover { background-color: #f8f9fa; border-color: #03a9f4; }
.cursor-pointer { cursor: pointer; }
.option-item input:checked + i { color: #03a9f4; }
</style>

<?php include 'includes/footer.php'; ?>
