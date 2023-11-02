<?php

namespace models;

use control\connectbd_controller;
use PDO;
require_once "../control/connectbd_controller.php";
class comment_models
{
    public $conn;
    public function __construct() {
        $this->conn = (new connectbd_controller())->connectbd1();
    }
    public function addComment($postId, $user, $commentText) {
        $date = date('Y-m-d H:i:s'); // Obtient la date et l'heure actuelles au format "Y-m-d H:i:s"
        $query = "INSERT INTO comments (idpere_com, texte_com, date_com, auteur_com) VALUES (:idpost, :texte_com, :date, :auteur_com)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idpost', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':texte_com', $commentText, PDO::PARAM_STR);
        $stmt->bindParam(':auteur_com', $user, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function getCommentsForPost($postId) {
        $query = "SELECT c.id_com, c.texte_com, c.date_com, u.username AS auteur_com
          FROM comments c
          INNER JOIN user u ON c.auteur_com = u.id
          WHERE c.idpere_com = :post_id
          ORDER BY c.date_com DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}