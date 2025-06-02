<?php
// Je commence par importer le modèle AdminModel, qui contient les fonctions pour accéder à la base de données des admins
require_once __DIR__ . '/../models/AdminModel.php';

// Je crée ma classe AdminController : c’est ici que je vais gérer les actions pour créer un admin et se connecter
class AdminController {

    // Je déclare une variable privée qui va contenir mon modèle AdminModel
    private $adminModel;

    // Cette fonction __construct() s’exécute automatiquement quand je crée un objet de cette classe
    public function __construct() {
        // Ici, j’instancie mon modèle AdminModel pour pouvoir appeler ses fonctions ensuite
        $this->adminModel = new AdminModel();
    }

    // 🔸 Fonction pour créer un admin (quand un nouveau veut s’inscrire)
    public function createAdmin() {
        // J’autorise les requêtes venant de n’importe où (CORS)
        header("Access-Control-Allow-Origin: *");
        // J’autorise les en-têtes de type "Content-Type"
        header("Access-Control-Allow-Headers: Content-Type");
        // Je précise que la réponse envoyée sera en JSON
        header("Content-Type: application/json");

        // Je récupère les données envoyées en JSON depuis le frontend
        $data = json_decode(file_get_contents("php://input"), true);

        // Je prends l’email et le mot de passe dans ce tableau (ou une chaîne vide si manquant)
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // 🔐 Je sécurise le mot de passe avec un hashage (cryptage)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // J’appelle la fonction du modèle pour enregistrer l’admin en base de données
        $result = $this->adminModel->createAdmin($email, $hashedPassword);

        // Si ça a marché, j’envoie une réponse JSON avec un message de succès
        if ($result) {
            echo json_encode([
                "success" => true,
                "message" => "Admin créé avec succès"
            ]);
        } else {
            // Sinon, j’envoie une réponse JSON avec un message d’erreur
            echo json_encode([
                "success" => false,
                "message" => "Échec lors de la création de l'admin"
            ]);
        }
    }

    // 🔸 Fonction pour que l’admin puisse se connecter
    public function login() {
        // Comme pour createAdmin, je configure les en-têtes HTTP
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: application/json");

        // Je récupère les infos envoyées depuis le frontend
        $data = json_decode(file_get_contents("php://input"), true);

        // Je prends les valeurs email et mot de passe (ou vide si elles ne sont pas envoyées)
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Je demande au modèle de me renvoyer l’admin correspondant à l’email
        $admin = $this->adminModel->getAdminByEmail($email);

        // Si l’admin existe et que le mot de passe est correct (grâce à password_verify)
        if ($admin && password_verify($password, $admin['password'])) {
            // Je démarre une session PHP pour garder l’admin connecté
            session_start();
            // Je stocke l’ID de l’admin dans la session (on peut s’en servir plus tard)
            $_SESSION['admin'] = $admin['id'];

            // J’envoie une réponse JSON de succès
            echo json_encode([
                "success" => true,
                "message" => "Connexion réussie"
            ]);
        } else {
            // Si l’email ou le mot de passe est incorrect, j’envoie un message d’erreur
            echo json_encode([
                "success" => false,
                "message" => "Email ou mot de passe invalide"
            ]);
        }
    }
}
?>
