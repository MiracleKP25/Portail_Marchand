<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Gérer les requêtes préflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once './config/config.php';
require_once './core/App.php';
require_once './core/Controller.php';
require_once './core/Model.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

// Instanciation de l'application
// $app = new App();

// Route POST /vendeur/store
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'vendeur/store') {
    require_once './app/controllers/VendeurController.php';
    $controller = new VendeurController();
    $controller->store();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['url'] === 'vendeur/allvendors') {
    require_once './app/controllers/VendeurController.php';
    $controller = new VendeurController();
    $controller->getAllVendors();
}

// Route GET /vendeur/status
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $url === 'vendeur/status') {
    require_once './app/controllers/VendeurController.php';
    $controller = new VendeurController();
    $controller->getStatusByEmail();
}

// router.php
if ($url == 'vendeur/updatestatus') {
    $controller = new VendeurController();
    $controller->updateStatus();
    return;
}


// Route POST /admin/login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'admin/login') {
    require_once './app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->login();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['url']) && $_GET['url'] === 'admin/create') {
    require_once './app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->createAdmin();
}

?>
