<?php
// Activation des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoriser CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Préflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Charger la config
require_once __DIR__ . '/../config/config.php';

// Charger manuellement les fichiers nécessaires
require_once __DIR__ . '/../app/controllers/VendeurController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once './app/models/VendeurModel.php';

require_once __DIR__ . '/../app/models/AdminModel.php';

// Récupération de l'URL
$url = $_GET['url'] ?? '';

// Routes Vendeur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/store') {
    $controller = new VendeurController();
    $controller->store();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/allvendors') {
    $controller = new VendeurController();
    $controller->getAllVendors();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/status') {
    $controller = new VendeurController();
    $controller->getStatusByEmail();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/updatestatus') {
    $controller = new VendeurController();
    $controller->updateStatus();
    exit;
}

// Routes Admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'admin/create') {
    $controller = new AdminController();
    $controller->createAdmin();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'admin/login') {
    $controller = new AdminController();
    $controller->login();
    exit;
}

// Si aucune route ne correspond
http_response_code(404);
echo json_encode(['success' => false, 'message' => 'Route inconnue']);
