<?php

namespace models;

use control\connectbd_controller;
use PDO;
use PDOException;
require_once '../control/connectbd_controller.php';

class admin_models
{
    public $conn;

    public function __construct()
    {
        $this->conn = (new connectbd_controller())->connectbd();
    }

    public function aouter_cat($nomCategorie, $descriptionCategorie)
    {
        $pdo = $this->conn;
        $query = "SELECT MAX(id_cat) AS max_id FROM categorie";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxId = ($row['max_id']) ? $row['max_id'] + 1 : 1;

        $insertQuery = "INSERT INTO categorie (id_cat, libelle_cat, descript_cat) VALUES (:id, :nom, :description)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':id', $maxId, PDO::PARAM_INT);
        $insertStmt->bindParam(':nom', $nomCategorie, PDO::PARAM_STR);
        $insertStmt->bindParam(':description', $descriptionCategorie, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            echo "Nouvelle catégorie ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la catégorie.";
        }
    }

    public function supr_utilisateur($username)
    {
        $pdo = $this->conn;

        // Vérifiez si l'utilisateur existe avant de le supprimer
        $checkQuery = "SELECT username FROM user WHERE username = :username";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':username', $username, PDO::PARAM_STR); // Utilisez PDO::PARAM_STR pour une chaîne
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            // L'utilisateur existe, on le supprime de la base de données
            $deleteQuery = "DELETE FROM user WHERE username = :username";
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->bindParam(':username', $username, PDO::PARAM_STR); // Utilisez PDO::PARAM_STR pour une chaîne
            if ($deleteStmt->execute()) {
                echo "L'utilisateur a été supprimé avec succès.";
            } else {
                echo "Erreur lors de la suppression de l'utilisateur.";
            }
        } else {
            // L'utilisateur n'existe pas, affichez un message d'erreur
            echo "L'utilisateur avec le pseudo: $username n'existe pas.";
        }
    }
}

