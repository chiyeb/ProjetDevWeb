<?php

namespace models;
require 'Message.php';
namespace models;
use control\connectbd_controller;
use PDO;
use PDOException;
require_once '../control/connectbd_controller.php';

class message_model
{
    public $conn;

    public function __construct() {
        $this->conn = (new connectbd_controller())->connectbd();
    }
    //fonction permettant d'afficher les messages privé d'un utilisateur donnée
    public function afficherMsgPrv()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //on récupère l'utilisateur connecté
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            //on sélectionne les messages de cet utilisateur avec les autres
            $sql = "SELECT id_message, sender_id, receiver_id, message, date_msg FROM messages WHERE sender_id = :id OR receiver_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            //  si la requête s'est exécutée avec succès
            if ($stmt) {
                $messages = []; // Tableau pour stocker les objets "posts"

                // boucle pour parcourir les résultats
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Crée un objet "Message" pour chaque ligne de résultat
                    $message = new Message(
                        $row['id_message'],
                        $row['sender_id'],
                        $row['receiver_id'],
                        $row['message'],
                        $row['date_msg']
                    );

                    // Ajoute l'objet "Message" au tableau des posts
                    $messages[] = $message;
                }
            } else {
                // Gére les erreurs en fonction de la connexion à la base de données
                echo "Erreur lors de l'exécution de la requête SQL : " . $this->conn->errorInfo()[2];
            }
            // Ferme la connexion à la base de données
            $conn = null;
            return $messages;
        }
    }
    //récupère le dernier "ID" de message
    public function lastId($pdo) {
        $stmt = $pdo->prepare("SELECT MAX(id_message) FROM messages");
        $stmt->execute();
        $lastId = $stmt->fetchColumn();

        // Incrémente le dernier ID de 1
        $nextId = $lastId + 1;

        return $nextId;
    }
    //fonction qui permet de créer un message
    public function creer_msg()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //récupère l'utilisateur connecté
        if (isset($_SESSION['id'])) {
            $user_id = $_SESSION['id'];
            try {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $receiver = $_POST["receiver"];
                    $message = $_POST["message"];
                    $id_message = $this->lastId($this->conn);
                    //on récupère l'id de l'utilisateur à qui on veut envoyer un message
                    $stmt = $this->conn->prepare("SELECT id FROM user WHERE username = :username");
                    $stmt->bindParam(':username', $receiver);
                    $stmt->execute();
                    $receiver_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
                    if ($stmt->rowCount() === 0) {
                        header("Location: ../view/msgpriv.php?error=L'utilisateur n'existe pas");
                        exit();
                    }
                    $date_msg = date('Y-m-d H:i:s');
                    //on insère le message dans la base de donnée.
                    $stmt = $this->conn->prepare("INSERT INTO messages (id_message,sender_id, receiver_id, message, date_msg) VALUES (:id_message,:sender_id, :receiver_id, :message, :date_msg)");
                    $stmt->bindParam(':id_message', $id_message);
                    $stmt->bindParam(':sender_id', $user_id);
                    $stmt->bindParam(':receiver_id', $receiver_id);
                    $stmt->bindParam(':message', $message);
                    $stmt->bindParam(':date_msg', $date_msg);

                    if ($stmt->execute()) {
                        header('Location: ../view/msgpriv.php');
                    }
                }

            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
    }
}