<?php
class Admin extends Model {
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>