<?php
// Class to handle Course-related logic

class Course {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    /**
     * Get all published courses
     */
    public function getAllPublished() {
        $stmt = $this->db->prepare("SELECT c.*, u.name as instructor_name, cat.name as category_name, 
                                           (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as student_count,
                                           (SELECT CONCAT('Batch ', batch_no) FROM batches WHERE course_id = c.id AND status != 'completed' ORDER BY start_date ASC LIMIT 1) as next_batch_name,
                                           (SELECT enrollment_deadline FROM batches WHERE course_id = c.id AND status != 'completed' ORDER BY start_date ASC LIMIT 1) as enrollment_deadline
                                    FROM courses c
                                    JOIN users u ON c.instructor_id = u.id
                                    LEFT JOIN categories cat ON c.category_id = cat.id
                                    WHERE c.status = 'published'
                                    ORDER BY c.created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get course by Slug
     */
    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT c.*, u.name as instructor_name, cat.name as category_name 
                                    FROM courses c
                                    JOIN users u ON c.instructor_id = u.id
                                    LEFT JOIN categories cat ON c.category_id = cat.id
                                    WHERE c.slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO courses (title, slug, description, thumbnail, price, discount_price, category_id, instructor_id, status, tags, career_path) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([
            $data['title'],
            $data['slug'],
            $data['description'],
            $data['thumbnail'],
            $data['price'],
            $data['discount_price'] ?? 0.00,
            $data['category_id'],
            $data['instructor_id'],
            $data['status'],
            $data['tags'] ?? NULL,
            $data['career_path'] ?? NULL
        ])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Update a course
     */
    public function update($id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $sql = "UPDATE courses SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Get sections and lessons for a course
     */
    public function getCurriculum($course_id) {
        $stmt = $this->db->prepare("SELECT s.title as section_title, s.id as section_id, 
                                           l.id as lesson_id, l.title as lesson_title, l.content_type, l.content_url, l.duration
                                    FROM course_sections s
                                    LEFT JOIN lessons l ON s.id = l.section_id
                                    WHERE s.course_id = ?
                                    ORDER BY s.order_index, l.order_index");
        $stmt->execute([$course_id]);
        $rows = $stmt->fetchAll();

        $curriculum = [];
        foreach ($rows as $row) {
            $section_id = $row['section_id'];
            if (!isset($curriculum[$section_id])) {
                $curriculum[$section_id] = [
                    'id' => $section_id,
                    'title' => $row['section_title'],
                    'lessons' => []
                ];
            }
            if ($row['lesson_id']) {
                $curriculum[$section_id]['lessons'][] = [
                    'id' => $row['lesson_id'],
                    'title' => $row['lesson_title'],
                    'type' => $row['content_type'],
                    'url' => $row['content_url'],
                    'duration' => $row['duration']
                ];
            }
        }
        return $curriculum;
    }

    /**
     * Get FAQs for a course
     */
    public function getFaqs($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM course_faqs WHERE course_id = ? ORDER BY order_index ASC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get Projects for a course
     */
    public function getProjects($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM course_projects WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get all instructors for a course
     */
    public function getInstructors($course_id) {
        $stmt = $this->db->prepare("SELECT u.* FROM users u 
                                    JOIN course_instructors ci ON u.id = ci.user_id 
                                    WHERE ci.course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get outcomes for a course
     */
    public function getOutcomes($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM course_outcomes WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get testimonials for a course
     */
    public function getTestimonials($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM course_testimonials WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    /**
     * Get features for a course
     */
    public function getFeatures($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM course_features WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }
}
?>
