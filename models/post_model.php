<?php

namespace models;

use control\connectbd_controller;
use control\image_controller;
use models\Post;
use PDO;
use PDOException;
require 'Post.php';
class post_model
{
    public $conn;

    public function __construct() {
        $this->conn = (new connectbd_controller())->connectbd1();
    }
    //fonction pour récupérer les posts d'un utilisateur donnée pour la page profil
    public function getPostProfil($user)
    {
        //requête SQL pour récupérer tout les posts grâce à l'id de l'utilisateur
        $sql = "SELECT * FROM posts where auteur_post = :user";
        $requete = $this->conn->prepare($sql);
        $requete->bindParam(':user', $user, PDO::PARAM_STR);;
        $requete->execute();
        if ($requete->rowCount() > 0) {
            $posts = []; // Tableau pour stocker les objets "posts"
            // boucle pour parcourir les résultats
            while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                // Crée un objet "Post" pour chaque ligne de résultat
                $post = new Post(
                    $row['id_post'],
                    $row['titre_post'],
                    $row['message_post'],
                    $row['date_post'],
                    $row['auteur_post'],
                    $row['categorie_post'],
                    $row['likes'],
                    $row['important'],
                    $row['image_post']
                );
                // Ajoute l'objet "Post" au tableau des posts
                $posts[] = $post;
            }
            return $posts;
        }
        }
    //récupère le dernier ID de Post.
    public function lastId($pdo)
    {
        $stmt = $pdo->prepare("SELECT MAX(id_post) FROM posts");
        $stmt->execute();
        $lastId = $stmt->fetchColumn();

        // Incrémente le dernier ID de 1
        $nextId = $lastId + 1;

        return $nextId;
    }
    //récupère tout les posts stocké dans la base de donnée.
    public function GetPostAll($categorie)
    {
        //si aucune catégorie n'as été sélectionné par l'utilisateur
        if ($categorie !== null) {
            $querycat = "SELECT id_cat FROM categorie WHERE libelle_cat = :libelle_cat";
            $stmt = $this->conn->prepare($querycat);
            $stmt->bindParam(':libelle_cat', $categorie, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $cat_id = $result['id_cat'];
            $sql = "SELECT * FROM posts WHERE categorie_post = :cat_id";
            $requete = $this->conn->prepare($sql);
            $requete->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
            $requete->execute();
        }
        //si une catégorie à été sélectionné par l'utilisateur
        else {
            $sql = "SELECT * FROM posts";
            $requete = $this->conn->prepare($sql);
            $requete->execute();
        }
        if ($requete) {
            if ($requete->rowCount() > 0) {
                $posts = []; // Tableau pour stocker les objets "posts"
                // boucle pour parcourir les résultats
                while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                    // Crée un objet "Post" pour chaque ligne de résultat
                    $post = new Post(
                        $row['id_post'],
                        $row['titre_post'],
                        $row['message_post'],
                        $row['date_post'],
                        $row['auteur_post'],
                        $row['categorie_post'],
                        $row['likes'],
                        $row['important'],
                        $row['image_post']
                    );
                    // Ajoute l'objet "Post" au tableau des posts
                    $posts[] = $post;
                }
                return $posts;
            } else {
                echo "Aucun résultat trouvé.";
            }
        } else {
            echo "Catégorie non trouvée.";
        }
    }
    //récupère le post pour quand on est sur la page commentaire.php
    public function get_post_recherche_comment($resultats)
    {
        if (is_array($resultats) && !empty($resultats)) {
            // Crée un objet "Post" pour chaque ligne de résultat
            $post = new Post(
                $resultats['id_post'],
                $resultats['titre_post'],
                $resultats['message_post'],
                $resultats['date_post'],
                $resultats['auteur_post'],
                $resultats['categorie_post'],
                $resultats['likes'],
                $resultats['important'],
                $resultats['image_post']
            );
            // Ajoutez l'objet "Post" au tableau des posts
            $posts[] = $post;
        }
        else{
            echo "aucun résultat trouvé";
        }
        return $posts;


    }
    //récupère les posts pour une recherche donnée par l'utilisateur
    public function get_post_recherche($resultats)
    {
        $posts = [];  // Crée un tableau vide pour stocker les objets Post
        if (is_array($resultats) && !empty($resultats)) {
            $count = count($resultats);
            foreach($resultats as $resultat){
                // Crée un objet "Post" pour chaque ligne de résultat
                $post = new Post(
                    $resultat['id_post'],
                    $resultat['titre_post'],
                    $resultat['message_post'],
                    $resultat['date_post'],
                    $resultat['auteur_post'],
                    $resultat['categorie_post'],
                    $resultat['likes'],
                    $resultat['important'],
                    $resultat['image_post']
                );

                // Ajoute l'objet "Post" au tableau des posts
                $posts[] = $post;
            }
        } else {
            echo "Aucun résultat trouvé";
        }

        return $posts;
    }


//fonction pour créer un post
    public function creerPost()
    {
        require_once "../control/image_controller.php";

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //récupère l'entrée de l'utilisateur dans le formulaire
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_post = $this->lastId($this->conn);
            $titre_post = $_POST["titre_post"];
            $message_post = $_POST["message_post"];
            $date_post = $_POST["date_post"];
            $auteur_post = $_SESSION['id'];
            $categorie_post = $_POST["categorie_post"];
            //vérifie si l'utilisateur à mit son Post comme "important"
            $important = $_POST["important"] ?? 0;
            //vérifie si l'utilisateur à télerchargé une image
            if (isset($_FILES['image'])){
                $control = new image_controller();
                $img = $control->uploadImg();
            }
            // Obtenenir l'ID de la catégorie
            $querycat = "SELECT id_cat FROM categorie WHERE libelle_cat = :libelle_cat";
            $stmt = $this->conn->prepare($querycat);
            $stmt->bindParam(':libelle_cat', $categorie_post, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $id_cat = $result['id_cat'];
                // Insére les données dans la table posts
                $query = "INSERT INTO posts (id_post, titre_post, message_post, date_post, auteur_post, categorie_post, important, image_post)
                                  VALUES (:id_post, :titre_post, :message_post, :date_post, :auteur_post, :id_cat, :important, :img)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                $stmt->bindParam(':titre_post', $titre_post, PDO::PARAM_STR);
                $stmt->bindParam(':message_post', $message_post, PDO::PARAM_STR);
                $stmt->bindParam(':date_post', $date_post, PDO::PARAM_STR);
                $stmt->bindParam(':auteur_post', $auteur_post, PDO::PARAM_INT);
                $stmt->bindParam(':id_cat', $id_cat, PDO::PARAM_INT);
                $stmt->bindParam(':important', $important, PDO::PARAM_BOOL);
                $stmt->bindParam(':img', $img, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                echo "Catégorie non trouvée.";
            }
            header("Location: ../view/accueil.php");
        }

    }
}