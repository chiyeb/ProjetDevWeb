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
// Fonction pour ajouter une nouvelle catégorie.
    public function ajouter_cat($nomCategorie, $descriptionCategorie)
    {
        // Requête SQL pour obtenir l'ID maximum de la table "categorie".
        $pdo = $this->conn;
        $query = "SELECT MAX(id_cat) AS max_id FROM categorie";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxId = ($row['max_id']) ? $row['max_id'] + 1 : 1;
        // Requête SQL pour insérer une nouvelle catégorie dans la table "categorie".
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


    // Fonction pour supprimer (bannir) un utilisateur grâce à son "username"
    public function supr_utilisateur($username)
    {
        $pdo = $this->conn;

        // Vérifiez si l'utilisateur existe avant de le supprimer
        $checkQuery = "SELECT username FROM user WHERE username = :username";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':username', $username, PDO::PARAM_STR); // Utilisez PDO::PARAM_STR pour une chaîne
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            // L'utilisateur existe on le supprime de la base de données
            $deleteQuery = "DELETE FROM user WHERE username = :username";
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->bindParam(':username', $username, PDO::PARAM_STR); // Utilisez PDO::PARAM_STR pour une chaîne
            if ($deleteStmt->execute()) {
                echo "L'utilisateur a été supprimé avec succès.";
            } else {
                echo "Erreur lors de la suppression de l'utilisateur.";
            }
        } else {
            // L'utilisateur n'existe pas affiche un message d'erreur
            echo "L'utilisateur avec le pseudo: $username n'existe pas.";
        }
    }
}

