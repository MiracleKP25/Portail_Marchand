<?php
require_once './app/models/Vendeur.php';

class VendeurController
{
    public function store()
    {
        // Entêtes CORS et JSON
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Content-Type: application/json");

        // Récupération et décodage du JSON brut
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        // Vérification du format JSON
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Format JSON invalide']);
            exit;
        }

        // Vérification des champs requis
        $required = ['nom', 'prenom', 'produits', 'dejaVendu', 'actifAilleurs', 'email', 'telephone', 'valeur'];
        // foreach ($required as $field) {
        //     if (isset($data[$field])) {
        //         http_response_code(400);
        //         echo json_encode(['success' => false, 'error' => "Le champ '$field' est requis."]);
        //         return;
        //     }
        // }

        // Création de l'objet vendeur
        $vendeur = new Vendeur();
        $vendeur->nom = htmlspecialchars($data['nom']);
        $vendeur->prenom = htmlspecialchars($data['prenom']);
        $vendeur->produits = htmlspecialchars($data['produits']);
        $vendeur->dejaVendu = htmlspecialchars($data['dejaVendu']);
        $vendeur->lieuVente = isset($data['lieuVente']) ? htmlspecialchars($data['lieuVente']) : 'Non défini';
        $vendeur->actifAilleurs = htmlspecialchars($data['actifAilleurs']);
        $vendeur->email = htmlspecialchars($data['email']);
        $vendeur->telephone = htmlspecialchars($data['telephone']);
        $vendeur->valeur = floatval($data['valeur']);
        $vendeur->statut = 'En attente';

        // Sauvegarde
        if ($vendeur->save()) {
            echo json_encode(['success' => true]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => "Erreur lors de l'enregistrement"]);
            exit;
        }

    }

    public function status()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $donnees = json_decode(file_get_contents("php://input"), true);
        $email = $donnees['email'] ?? null;

        if (!$email) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => "Email requis"]);
            return;
        }

        $vendeurModel = new Vendeur();
        $vendeur = $vendeurModel->findByEmail($email);

        if ($vendeur) {
            echo json_encode([
                'success' => true,
                'statut' => $vendeur['statut']
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => "Vendeur non trouvé"]);
        }
    }

    public function getStatusByEmail()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['email'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Email requis']);
            return;
        }

        $vendeurModel = new Vendeur();
        $vendeur = $vendeurModel->findByEmail($data['email']);

        if ($vendeur) {
            echo json_encode([
                'success' => true,
                'nom' => $vendeur['nom'],
                'prenom' => $vendeur['prenom'],
                'statut' => $vendeur['statut'],
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Aucun vendeur trouvé avec cet email.']);
        }
    }

    public function index() {
    echo json_encode(['message' => 'Bienvenue sur l’API vendeur']);
    }

    public function getAllVendors()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $vendeurModel = new Vendeur();
        $vendeurs = $vendeurModel->getAll();

        echo json_encode([
            'success' => true,
            'data' => $vendeurs
        ]);

        exit;
    }


    public function updateStatus()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: POST");
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || !isset($data['statut'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'ID et statut requis']);
            return;
        }

        $vendeurModel = new Vendeur();
        $success = $vendeurModel->updateStatus($data['id'], $data['statut']);

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => "Échec de la mise à jour"]);
        }
    }

}
?>