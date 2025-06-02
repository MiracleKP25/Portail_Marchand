<?php
// Autorise les requêtes venant de n'importe quelle origine (CORS)
header("Access-Control-Allow-Origin: *");

// Autorise les méthodes HTTP acceptées par l'API (CORS)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Autorise certains en-têtes pour les requêtes (CORS)
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// (Doublon optionnel) Ajoute d'autres en-têtes autorisés, dont Origin et X-Auth-Token
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');

// Si la requête est une requête "pré-vol" (OPTIONS), on renvoie un 200 OK immédiatement
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Code HTTP 200 (OK)
    exit(); // Arrête l'exécution du script
}

// Récupère l’URI demandée dans la requête (ex: /vendeur/allvendors)
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Construit le chemin du fichier potentiel dans le dossier "public"
$requested = __DIR__ . '/public' . $uri;

// Si l'URI n'est pas "/" (page racine) et que le fichier existe physiquement, le serveur le sert directement (ex: image, CSS, JS)
if ($uri !== '/' && file_exists($requested)) {
    return false; // Laisse PHP retourner ce fichier sans passer par index.php
}

// Sinon, redirige toutes les requêtes vers index.php (front controller)
require_once __DIR__ . '/public/index.php';
?>
