<?php
// Class to handle Category-related logic

class Category {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    /**
     * Get all categories
     */
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Create a new category
     */
    public function create($name, $slug, $description = '', $image = '') {
        $stmt = $this->db->prepare("INSERT INTO categories (name, slug, description, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $slug, $description, $image]);
    }
}
?>
