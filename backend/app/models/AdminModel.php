<?php
// Inclusion du fichier de configuration pour accéder à la base de données
require_once __DIR__ . '/../../config/config.php';

// Définition de la classe AdminModel
class AdminModel {
    // Propriété privée pour stocker la connexion à la base de données
    private $db;

    // Constructeur appelé à la création d'un objet AdminModel
    public function __construct() {
        // On récupère la connexion à la base de données depuis la classe Database
        $this->db = Database::getConnection();
    }

    /**
     * Récupère un administrateur en fonction de son email
     *
     * @param string $email Email de l'admin recherché
     * @return array|false Les informations de l'admin ou false s'il n'existe pas
     */
    public function getAdminByEmail($email) {
        // Préparation de la requête SQL sécurisée avec un paramètre
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE email = ?");
        // Exécution de la requête avec l'email fourni
        $stmt->execute([$email]);
        // Retourne le résultat sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel administrateur avec un email et un mot de passe hashé
     *
     * @param string $email Email de l'admin
     * @param string $password Mot de passe déjà hashé
     * @return bool Résultat de l'exécution de la requête (true si succès, false sinon)
     */
    public function createAdmin($email, $password)
    {
        // Préparation d'une requête d'insertion avec des paramètres nommés
        $stmt = $this->db->prepare("INSERT INTO admin (email, password) VALUES (:email, :password)");
        // Liaison des valeurs aux paramètres
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // ici c'est déjà hashé
        // Exécution de la requête et retour du résultat
        return $stmt->execute();
    }

}
?>
