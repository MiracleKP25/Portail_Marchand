<?php

// Déclaration de la classe Database
class Database
{
    // Méthode statique pour obtenir une connexion à la base de données
    public static function getConnection()
    {
        try {
            // Création d'une instance PDO (connexion à MySQL)
            return new PDO('mysql:host=localhost;dbname=portail_marchand;charset=utf8', 'root', '');
        } catch (PDOException $e) {
            // En cas d’erreur, afficher un message d’erreur et arrêter le script
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }
}
?>
