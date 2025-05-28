<?php

// Gérer les requêtes préflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once './config/config.php';
require_once './core/App.php';
require_once './core/Controller.php';
require_once './core/Model.php';

// Instanciation de l'application
$app = new App();

// Route POST /vendeur/store
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['url']) && $_GET['url'] === 'vendeur/store') {
    require_once './app/controllers/VendeurController.php';
    $controller = new VendeurController();
    $controller->store();
}

// Route GET /vendeur/status
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['url']) && $_GET['url'] === 'vendeur/status') {
    require_once './app/controllers/VendeurController.php';
    $controller = new VendeurController();
    $controller->getStatusByEmail();
}

// ✅ Route POST /admin/login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['url']) && $_GET['url'] === 'admin/login') {
    require_once './app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->login();
}

// ✅ Route GET /admin/vendeurs
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['url']) && $_GET['url'] === 'admin/vendeurs') {
    require_once './app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->vendeurs();
}

// ✅ Route POST /admin/statut/{id}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['url']) && str_starts_with($_GET['url'], 'admin/statut/')) {
    $id = intval(basename($_GET['url']));
    require_once './app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->statut($id);
}

// ✅ Route GET /admin/logout
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['url']) && $_GET['url'] === 'admin/logout') {
    require_once './app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->logout();
}



?>