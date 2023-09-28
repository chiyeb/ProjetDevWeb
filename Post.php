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
}
?>