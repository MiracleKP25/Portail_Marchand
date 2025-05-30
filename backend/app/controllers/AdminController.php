<?php

require_once __DIR__ . '/../models/AdminModel.php';
class AdminController {

    
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    public function createAdmin() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    $data = json_decode(file_get_contents("php://input"), true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // Hashage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Enregistrement via le modèle
    $result = $this->adminModel->createAdmin($email, $hashedPassword);

    if ($result) {
        echo json_encode([
            "success" => true,
            "message" => "Admin créé avec succès"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Échec lors de la création de l'admin"
        ]);
    }
    }


    public function login() {
        // Autoriser les requêtes CORS
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: application/json");

        // Lire les données JSON envoyées par le frontend
        $data = json_decode(file_get_contents("php://input"), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Récupérer l'admin par email
        $admin = $this->adminModel->getAdminByEmail($email);

        // Vérification du mot de passe
        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['admin'] = $admin['id'];

            echo json_encode([
                "success" => true,
                "message" => "Connexion réussie"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Email ou mot de passe invalide"
            ]);
        }
    }
}
?>
