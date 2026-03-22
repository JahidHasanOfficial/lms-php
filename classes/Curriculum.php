<?php
/**
 * Curriculum Class
 * Handles Sections and Lessons
 */

class Curriculum {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getSections($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM course_sections WHERE course_id = ? ORDER BY order_index ASC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    public function getLessons($section_id) {
        $stmt = $this->db->prepare("SELECT * FROM lessons WHERE section_id = ? ORDER BY order_index ASC");
        $stmt->execute([$section_id]);
        return $stmt->fetchAll();
    }

    public function addSection($course_id, $title, $order = 0) {
        $stmt = $this->db->prepare("INSERT INTO course_sections (course_id, title, order_index) VALUES (?, ?, ?)");
        return $stmt->execute([$course_id, $title, $order]);
    }

    public function addLesson($section_id, $title, $type, $url, $duration = null, $order = 0) {
        $stmt = $this->db->prepare("INSERT INTO lessons (section_id, title, content_type, content_url, duration, order_index) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$section_id, $title, $type, $url, $duration, $order]);
    }
}
?>
