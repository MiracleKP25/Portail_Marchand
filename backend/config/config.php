<?php

class Database
{
    public static function getConnection()
    {
        try {
            return new PDO('mysql:host=localhost;dbname=portail_marchand;charset=utf8', 'root', '');
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }
}
?>