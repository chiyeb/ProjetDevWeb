<?php

namespace models;

use control\connectbd_controller;
use PDO;
use PDOException;
require_once '../control/connectbd_controller.php';

class like_models
{
    public $conn;

    public function __construct() {
        $this->conn = (new connectbd_controller())->connectbd();
    }
//fonction pour ajouter un like à une publication pour un utilisateur donnée
    public function addLike($user_id, $post_id)
    {
        //on insère le like dans la base de donnée
        $sql = "INSERT INTO likes (id_user, id_post) 
              VALUES (:user_id, :post_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header('Location: ../view/accueil.php');
        } else {
            echo "Erreur : " . $stmt->errorInfo()[2];
        }
    }
    //si l'utilisateur re-clique sur le like qu'il à mit, le like s'enlève
    public function unlike($user_id, $post_id) {
        $sql = "DELETE FROM likes WHERE id_user = :user_id AND id_post = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header('Location: ../view/accueil.php');
        } else {
            echo "Erreur : " . $stmt->errorInfo()[2];
        }
    }
    //vérifier si une publication à été liké pour un utilisateur donnée
    public function isLiked($user_id, $post_id){
        $sql = "SELECT id_like from likes where id_user = :user_id and id_post = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0){
            return false;
        }
        else{
            return true;
        }
    }

}
