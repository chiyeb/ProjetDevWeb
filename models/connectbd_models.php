<?php

namespace models;

use PDO;
use PDOException;

class connectbd_models
{
    public function conn(){
        $db_host = "mysql-ysite.alwaysdata.net";
        $db_name = "ysite_allbd";
        $db_user = "ysite_lucas";
        $db_pass = "lucasysite";
        try {
            $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            // Configurez les options PDO si nécessaire
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        return "impossible de se connecter à la bd";
    }
    public function conn1(){
        $db_host = "mysql-ysite.alwaysdata.net";
        $db_name = "ysite_allbd";
        $db_user = "ysite_chiheb";
        $db_pass = "chihebysite";
        try {
            $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            // Configurez les options PDO si nécessaire
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        return "impossible de se connecter à la bd";
    }
}