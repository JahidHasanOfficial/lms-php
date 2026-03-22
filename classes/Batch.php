<?php
/**
 * Batch Class for Course Cohorts
 */

class Batch {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    /**
     * Get all batches for a specific course
     */
    public function getByCourse($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM batches WHERE course_id = ? ORDER BY batch_no DESC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get an active or upcoming batch for a course
     */
    public function getActiveBatch($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM batches WHERE course_id = ? AND status IN ('active', 'upcoming') ORDER BY batch_no DESC LIMIT 1");
        $stmt->execute([$course_id]);
        return $stmt->fetch();
    }

    /**
     * Create a new batch
     */
    public function create($course_id, $batch_no, $title = null, $start_date = null, $end_date = null, $status = 'upcoming') {
        $stmt = $this->db->prepare("INSERT INTO batches (course_id, batch_no, title, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$course_id, $batch_no, $title, $start_date, $end_date, $status]);
    }
}
?>
