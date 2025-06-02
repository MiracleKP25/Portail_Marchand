<?php
// J’importe le modèle du vendeur pour pouvoir interagir avec la base de données
require_once './app/models/VendeurModel.php';

// Je crée ma classe de contrôleur pour gérer toutes les actions liées aux vendeurs
class VendeurController
{
    // 🔹 Méthode pour enregistrer un nouveau vendeur dans la base
    public function store()
    {
        // 🔧 J'autorise le frontend (sur localhost:5173) à envoyer des requêtes ici (CORS)
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Content-Type: application/json");

        // 📩 Je récupère les données envoyées en JSON depuis le frontend
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // ❗ Si le JSON est vide ou mal formé, j’arrête tout
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Format JSON invalide']);
            exit;
        }

        // 🛑 (Optionnel) : je pourrais vérifier si tous les champs sont bien envoyés
        // foreach ($required as $field) {
        //     if (!isset($data[$field])) {
        //         http_response_code(400);
        //         echo json_encode(['success' => false, 'error' => "Le champ '$field' est requis."]);
        //         return;
        //     }
        // }

        // 📦 Je crée un objet vendeur et je remplis ses propriétés avec les données envoyées
        $vendeur = new VendeurModel();
        $vendeur->nom = htmlspecialchars($data['nom']);
        $vendeur->prenom = htmlspecialchars($data['prenom']);
        $vendeur->produits = htmlspecialchars($data['produits']);
        $vendeur->dejaVendu = htmlspecialchars($data['dejaVendu']);
        $vendeur->lieuVente = isset($data['lieuVente']) ? htmlspecialchars($data['lieuVente']) : 'Non défini';
        $vendeur->actifAilleurs = htmlspecialchars($data['actifAilleurs']);
        $vendeur->email = htmlspecialchars($data['email']);
        $vendeur->telephone = htmlspecialchars($data['telephone']);
        $vendeur->valeur = floatval($data['valeur']);
        $vendeur->statut = 'En attente'; // je fixe le statut de base à "En attente"

        // 💾 J'essaie de sauvegarder dans la base de données
        if ($vendeur->save()) {
            echo json_encode(['success' => true]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => "Erreur lors de l'enregistrement"]);
            exit;
        }
    }

    // 🔹 Méthode pour vérifier le statut d’un vendeur par email (ex : est-il accepté ?)
    public function status()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        // 📩 Je récupère les données envoyées
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // ❗ Si l’email n’est pas envoyé, j’arrête avec une erreur
        if (!isset($data['email'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => "Email requis"]);
            exit;
        }

        // 🔍 Je cherche le vendeur en base grâce à l’email
        $email = $data['email'];
        $vendeurModel = new VendeurModel();
        $vendeur = $vendeurModel->findByEmail($email);

        // ✅ Si je trouve un vendeur, j’envoie son statut
        if ($vendeur) {
            echo json_encode([
                'success' => true,
                'statut' => $vendeur['statut'],
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => "Aucun vendeur trouvé pour cet email"
            ]);
        }

        exit;
    }

    // 🔹 Variante : je récupère plus d’infos sur le vendeur (nom, prénom, statut) via email
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

        $vendeurModel = new VendeurModel();
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

    // 🔹 Petite route test pour m’assurer que l’API fonctionne bien
    public function index() {
        echo json_encode(['message' => 'Bienvenue sur l’API vendeur']);
    }

    // 🔹 Je récupère tous les vendeurs de la base (utile pour l’admin par exemple)
    public function getAllVendors()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $vendeurModel = new VendeurModel();
        $vendeurs = $vendeurModel->getAll();

        echo json_encode([
            'success' => true,
            'data' => $vendeurs
        ]);

        exit;
    }

    // 🔹 Je permets de modifier le statut d’un vendeur (ex : de "En attente" à "Validé")
    public function updateStatus()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: POST");
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);

        // ❗ Je vérifie que l’ID du vendeur et le nouveau statut sont bien envoyés
        if (!isset($data['id']) || !isset($data['statut'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'ID et statut requis']);
            return;
        }

        // 🔁 Je demande au modèle de mettre à jour le statut
        $vendeurModel = new VendeurModel();
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
