<?php

namespace models;

use control\connectbd_controller;
use PDO;
require_once "../control/connectbd_controller.php";
class suggestion_models
{
    public $conn;

    public function __construct() {
        $this->conn = (new connectbd_controller())->connectbd();
    }
    //fonction pour récupérer les suggestion
    public function recupSuggest(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //on sélectionne au hasard 3 utilisateurs
        $query = "SELECT * FROM user WHERE id != :id ORDER BY RAND() LIMIT 3";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT); // Assurez-vous que :id est correctement défini ici
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}