<?php
class AccueilController extends Controller {
    public function index() {

        // Si la requête attend du JSON (ex: depuis Axios), on retourne un JSON
        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            echo json_encode([
                'routes' => [
                    ['method' => 'POST', 'path' => '/vendeur/store', 'description' => 'Soumettre une nouvelle demande d’adhésion'],
                    ['method' => 'GET', 'path' => '/vendeur/status/votre@email.com', 'description' => 'Vérifier le statut via l’e-mail'],
                    ['method' => 'POST', 'path' => '/admin/login', 'description' => 'Connexion de l’administrateur'],
                    ['method' => 'GET', 'path' => '/admin/vendeurs', 'description' => 'Lister tous les vendeurs (admin seulement)'],
                    ['method' => 'POST', 'path' => '/admin/statut/{id}', 'description' => 'Changer le statut d’un vendeur'],
                    ['method' => 'GET', 'path' => '/admin/logout', 'description' => 'Déconnexion de l’administrateur'],
                ]
            ]);
            return;
        }

        echo '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Documentation API - Portail Marchand</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f0fdf4;
                    margin: 0;
                    padding: 2rem;
                    color: #065f46;
                }
                h1 {
                    color: #047857;
                }
                h2 {
                    margin-top: 2rem;
                    color: #065f46;
                }
                .endpoint {
                    background: #ffffff;
                    padding: 1rem;
                    margin: 1rem 0;
                    border-left: 5px solid #10b981;
                    box-shadow: 0 0 5px rgba(0,0,0,0.05);
                    border-radius: 8px;
                }
                .method {
                    font-weight: bold;
                    color: #064e3b;
                }
                .path {
                    font-family: monospace;
                    background: #ecfdf5;
                    padding: 0.2rem 0.5rem;
                    border-radius: 4px;
                }
            </style>
        </head>
        <body>
            <h1>📘 Documentation API - Portail Marchand</h1>
            <p>Bienvenue sur l’API du portail. Voici les routes disponibles :</p>

            <h2>🛍️ Vendeur</h2>

            <div class="endpoint">
                <span class="method">POST</span>
                <span class="path">/vendeur/store</span><br>
                Soumettre une nouvelle demande d’adhésion
            </div>

            <div class="endpoint">
                <span class="method">GET</span>
                <span class="path">/vendeur/status/votre@email.com</span><br>
                Vérifier le statut de sa demande via l’e-mail
            </div>

            <h2>🛠️ Admin</h2>

            <div class="endpoint">
                <span class="method">POST</span>
                <span class="path">/admin/login</span><br>
                Connexion de l’administrateur
            </div>

            <div class="endpoint">
                <span class="method">GET</span>
                <span class="path">/admin/vendeurs</span><br>
                Lister tous les vendeurs (admin seulement)
            </div>

            <div class="endpoint">
                <span class="method">POST</span>
                <span class="path">/admin/statut/{id}</span><br>
                Changer le statut d’un vendeur (admin seulement)
            </div>

            <div class="endpoint">
                <span class="method">GET</span>
                <span class="path">/admin/logout</span><br>
                Déconnexion de l’administrateur
            </div>
        </body>
        </html>
        ';
    }
}

?>