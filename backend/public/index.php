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

$app = new App();

// Route spécifique POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['url']) && $_GET['url'] === 'vendeur/store') {
    require_once './app/controllers/VendeurController.php';
    $controller = new VendeurController();
    $controller->store();
}

// Route spécifique GET
if (isset($url) && $url[0] === 'vendeur' && $url[1] === 'status') {
    require_once '../app/controllers/VendeurController.php';
    $controller = new VendeurController();
    $controller->getStatusByEmail();
   
}


?>