<?php

require_once './config/config.php';

class VendeurModel
{
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


    public function save()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('
            INSERT INTO vendeurs 
            (nom, prenom, produits_vendus, deja_vendu_ailleurs, ou_vendu, toujours_actif, email, telephone, valeur_unitaire)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');
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
            return true;
         } else {
            return false;
         }
         
    }

   public function findByEmail($email)
    {
        $pdo = Database::getConnection(); // ← Connexion DB correcte
        $sql = "SELECT * FROM vendeurs WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        $vendeur = $stmt->fetch(PDO::FETCH_ASSOC);

        return $vendeur ?: null;
    }

    public function getAll()
    {
        $pdo = Database::getConnection(); // ← Connexion DB correcte
        $sql = "SELECT * FROM vendeurs"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $statut)
    {
        $pdo = Database::getConnection(); // ← Connexion DB correcte
        $stmt = $pdo->prepare("UPDATE vendeurs SET statut = :statut WHERE id = :id");
        return $stmt->execute([
            'statut' => $statut,
            'id' => $id
        ]);
    }

}
?>