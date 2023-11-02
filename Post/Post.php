<?php
class Post {
    public $titre;
    public $message;
    public $date;
    public $auteur;
    public $categorie;

    public function __construct($titre, $message, $date, $auteur, $categorie) {
        $this->titre = $titre;
        $this->message = $message;
        $this->date = $date;
        $this->auteur = $auteur;
        $this->categorie = $categorie;
    }
    public function getTitre() {
        return $this->titre;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getDate() {
        return $this->date;
    }

    public function getAuteur() {
        return $this->auteur;
    }
        public function getCategorie() {
            $catid = $this->categorie;
            $stmt = dbconnect()->prepare("SELECT libelle_cat FROM categorie WHERE id_cat = :catid");
            $stmt->bindParam(':catid', $catid, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['libelle_cat'];
            } else {
                return "Catégorie inconnue"; // Handle the case when the category is not found
            }
        }
}
?>