<?php

// Inclusion du fichier de configuration (connexion à la base de données)
require_once './config/config.php';

// Déclaration de la classe VendeurModel
class VendeurModel
{
    // Propriétés publiques qui représentent les colonnes de la table "vendeurs"
    public $nom;
    public $prenom;
    public $produits;
    public $dejaVendu;
    public $lieuVente;
    public $actifAilleurs;
    public $email;
    public $telephone;
    public $valeur;
    public $statut;

    /**
     * Enregistre un nouveau vendeur dans la base de données
     *
     * @return bool true si l'insertion réussit, false sinon
     */
    public function save()
    {
        // Récupération de la connexion à la base de données
        $pdo = Database::getConnection();

        // Préparation de la requête SQL d'insertion
        $stmt = $pdo->prepare('
            INSERT INTO vendeurs 
            (nom, prenom, produits_vendus, deja_vendu_ailleurs, ou_vendu, toujours_actif, email, telephone, valeur_unitaire)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');

        // Exécution de la requête avec les valeurs de l'objet
        if (
            $stmt->execute([
                $this->nom,
                $this->prenom,
                $this->produits,
                $this->dejaVendu,
                $this->lieuVente,
                $this->actifAilleurs,
                $this->email,
                $this->telephone,
                $this->valeur,
            ])
        ) {
            return true; // Insertion réussie
        } else {
            return false; // Échec
        }
    }

    /**
     * Recherche un vendeur par son email
     *
     * @param string $email L'adresse email à rechercher
     * @return array|null Les données du vendeur ou null s'il n'existe pas
     */
    public function findByEmail($email)
    {
        $pdo = Database::getConnection(); // Connexion DB
        $sql = "SELECT * FROM vendeurs WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR); // Liaison de l'email

        $stmt->execute(); // Exécution de la requête
        $vendeur = $stmt->fetch(PDO::FETCH_ASSOC); // Récupération du résultat

        return $vendeur ?: null; // Retourne null si aucun vendeur trouvé
    }

    /**
     * Récupère tous les vendeurs de la base de données
     *
     * @return array Liste des vendeurs
     */
    public function getAll()
    {
        $pdo = Database::getConnection(); // Connexion DB
        $sql = "SELECT * FROM vendeurs"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau de vendeurs
    }

    /**
     * Met à jour le statut d'un vendeur par son ID
     *
     * @param int $id L'ID du vendeur
     * @param string $statut Le nouveau statut (ex: "Validé", "Rejeté", etc.)
     * @return bool true si la mise à jour réussit
     */
    public function updateStatus($id, $statut)
    {
        $pdo = Database::getConnection(); // Connexion DB
        $stmt = $pdo->prepare("UPDATE vendeurs SET statut = :statut WHERE id = :id");

        return $stmt->execute([
            'statut' => $statut,
            'id' => $id
        ]); // Retourne true si la requête a réussi
    }

}
?>
