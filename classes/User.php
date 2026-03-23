<?php
// Classes to handle core business logic

class User {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function register($name, $email, $phone, $password, $role_slug = 'learner') {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Find role_id by slug
        $stmt_role = $this->db->prepare("SELECT id FROM roles WHERE slug = ?");
        $stmt_role->execute([$role_slug]);
        $role_id = $stmt_role->fetchColumn();

        // Generate OTP (Optional: good for security logs but not mandatory for registration wall)
        $otp = rand(100000, 999999);

        $stmt = $this->db->prepare("INSERT INTO users (name, email, phone, password, role, role_id, otp_code, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $hashed_password, $role_slug, $role_id, $otp, 1]);
    }

    public function verifyOTP($email, $otp) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? AND otp_code = ?");
        $stmt->execute([$email, $otp]);
        $user = $stmt->fetch();

        if ($user) {
            $stmt = $this->db->prepare("UPDATE users SET is_verified = 1, otp_code = NULL WHERE id = ?");
            return $stmt->execute([$user['id']]);
        }
        return false;
    }

    public function findBySocialId($provider, $id) {
        $column = $provider . "_id";
        $stmt = $this->db->prepare("SELECT * FROM users WHERE $column = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createSocialUser($name, $email, $provider, $id) {
        $column = $provider . "_id";
        
        // Find role_id for learner
        $stmt_role = $this->db->prepare("SELECT id FROM roles WHERE slug = 'learner'");
        $stmt_role->execute();
        $role_id = $stmt_role->fetchColumn();

        $stmt = $this->db->prepare("INSERT INTO users (name, email, role, role_id, $column, is_verified) VALUES (?, ?, 'learner', ?, ?, 1)");
        return $stmt->execute([$name, $email, $role_id, $id]);
    }

    /**
     * Login a user
     */
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT u.*, r.slug as role_slug, r.name as role_name 
                                    FROM users u
                                    LEFT JOIN roles r ON u.role_id = r.id
                                    WHERE u.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get user permissions by ID
     */
    public function getPermissions($user_id) {
        $stmt = $this->db->prepare("SELECT p.slug 
                                    FROM permissions p 
                                    JOIN role_permissions rp ON p.id = rp.permission_id 
                                    JOIN users u ON rp.role_id = u.role_id 
                                    WHERE u.id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Update user profile
     */
    public function updateProfile($id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
}
?>
