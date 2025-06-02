<?php
// === Affichage des erreurs (utile en développement) ===
ini_set('display_errors', 1); // Affiche les erreurs à l’écran
ini_set('display_startup_errors', 1); // Affiche les erreurs de démarrage PHP
error_reporting(E_ALL); // Active tous les niveaux de rapports d’erreurs

// === Configuration CORS (Cross-Origin Resource Sharing) ===
header("Access-Control-Allow-Origin: *"); // Autorise toutes les origines (à restreindre en production)
header("Access-Control-Allow-Headers: Content-Type"); // Autorise l’en-tête Content-Type
header("Content-Type: application/json"); // Le contenu des réponses sera du JSON

// === Préflight pour les requêtes OPTIONS ===
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Réponse OK pour les préflights
    exit(); // Stoppe le script
}

// === Chargement de la configuration de la base de données ===
require_once __DIR__ . '/../config/config.php';

// === Chargement manuel des contrôleurs et modèles nécessaires ===
require_once __DIR__ . '/../app/controllers/VendeurController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

require_once './app/models/VendeurModel.php'; // ⚠️ Ce chemin est relatif à l’endroit d’exécution du script
require_once __DIR__ . '/../app/models/AdminModel.php';

// === Récupération de l’URL depuis le paramètre GET (ex: router.php?url=vendeur/store) ===
$url = $_GET['url'] ?? ''; // Si non défini, on met une chaîne vide

// === Routing Vendeur ===

// Route pour enregistrer un vendeur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/store') {
    $controller = new VendeurController();
    $controller->store();
    exit;
}

// Route pour récupérer tous les vendeurs
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/allvendors') {
    $controller = new VendeurController();
    $controller->getAllVendors();
    exit;
}

// Route pour obtenir le statut d'un vendeur par email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/status') {
    $controller = new VendeurController();
    $controller->getStatusByEmail();
    exit;
}

// Route pour mettre à jour le statut d'un vendeur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/updatestatus') {
    $controller = new VendeurController();
    $controller->updateStatus();
    exit;
}

// === Routing Admin ===

// Route pour créer un compte administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'admin/create') {
    $controller = new AdminController();
    $controller->createAdmin();
    exit;
}

// Route pour connecter un administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'admin/login') {
    $controller = new AdminController();
    $controller->login();
    exit;
}

// === Si aucune route ne correspond ===
http_response_code(404); // Code HTTP 404 Not Found
echo json_encode([
    'success' => false,
    'message' => 'Route inconnue'
]);
?>