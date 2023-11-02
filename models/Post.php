<?php

namespace models;
use PDO;
use PDOException;
use control\connectbd_controller;
require_once '../control/connectbd_controller.php';

class Post
{
    public $likes;
    public $id_post;
    public $titre;
    public $message;
    public $date;
    public $auteur;
    public $categorie;
    public $conn;
    public $important;
    public $image;

    public function __construct($id_post, $titre, $message, $date, $auteur, $categorie, $likes, $important, $image)
    {
        $this->conn = (new connectbd_controller())->connectbd();
        $this->likes = $likes;
        $this->id_post = $id_post;
        $this->titre = $titre;
        $this->message = $message;
        $this->date = $date;
        $this->auteur = $auteur;
        $this->categorie = $categorie;
        $this->important = $important;
        $this->image = $image;
    }

    public function getIdPost()
    {
        return $this->id_post;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getDate()
    {
        return $this->date;
    }
    public function getImage(){
        return $this->image;
    }

    public function getAuteurId(){
        return $this->auteur;
    }
    public function getAuteur()
    {

        $stmt =$this->conn->prepare("SELECT username FROM user WHERE id = :iduser");
        $stmt->bindParam(':iduser', $this->auteur, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['username'];
        } else {
            return "Utilisateur inconnu au bataillon"; // Handle the case when the category is not found
        }
    }

    public function getCategorie()
    {
        $catid = $this->categorie;
        $stmt = $this->conn->prepare("SELECT libelle_cat FROM categorie WHERE id_cat = :catid");
        $stmt->bindParam(':catid', $catid, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['libelle_cat'];
        } else {
            return "Catégorie inconnue"; // Handle the case when the category is not found
        }
    }
    public function getLikes(){
        return $this->likes;
    }

    public  function getImportant(){
        return $this->important;
    }
}

?>