<?php

namespace models;
use control\connectbd_controller;
use PDO;
require_once '../control/connectbd_controller.php';

class Message
{
    public $id;
    public $auteur;
    public $receveur;
    public $message;
    public $time;
    public $conn;

    public function __construct($id, $auteur, $receveur, $message, $time)
    {
        $this->conn = (new connectbd_controller())->connectbd();
        $this->id = $id;
        $this->auteur = $auteur;
        $this->receveur = $receveur;
        $this->message = $message;
        $this->time = $time;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuteur()
    {
        $stmt = $this->conn->prepare("SELECT username FROM user WHERE id = :iduser");
        $stmt->bindParam(':iduser', $this->auteur, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['username'];
        } else {
            return "Utilisateur inconnu au bataillon";
        }
    }

    public function getReceveur()
    {

        $stmt = $this->conn->prepare("SELECT username FROM user WHERE id = :iduser");
        $stmt->bindParam(':iduser', $this->receveur, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['username'];
        } else {
            return "Utilisateur inconnu au bataillon";
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getTime()
    {
        return $this->time;
    }
}

?>