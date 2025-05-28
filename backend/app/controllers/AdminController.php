<?php
class AdminController extends Controller {
    private $adminModel;
    private $vendeurModel;

    public function __construct() {
        $this->adminModel = $this->model('Admin');
        $this->vendeurModel = $this->model('Vendeur');
    }

    // POST /admin/login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['mot_de_passe'];

            $admin = $this->adminModel->getByEmail($email);

            if ($admin && password_verify($password, $admin['mot_de_passe'])) {
                $_SESSION['admin'] = $admin['email'];
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    // GET /admin/vendeurs
    public function vendeurs() {
        if (!isset($_SESSION['admin'])) {
            http_response_code(401);
            echo json_encode(['erreur' => 'non_connecte']);
            return;
        }

        echo json_encode($this->vendeurModel->getAll());
    }

    // POST /admin/statut/5
    public function statut($id) {
        if (!isset($_SESSION['admin'])) {
            http_response_code(401);
            echo json_encode(['erreur' => 'non_connecte']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $statut = $_POST['statut'];
            $ok = $this->vendeurModel->changerStatut($id, $statut);
            echo json_encode(['success' => $ok]);
        }
    }

    // Déconnexion
    public function logout() {
        session_destroy();
        echo json_encode(['success' => true]);
    }
}
?>