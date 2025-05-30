<?php
require_once __DIR__ . '/../../config/config.php';


class AdminModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAdminByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createAdmin($email, $password)
    {
        $stmt = $this->db->prepare("INSERT INTO admin (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // ici c'est déjà hashé
        return $stmt->execute();
    }

}
