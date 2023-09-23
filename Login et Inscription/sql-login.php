<?php
function dbconnect()
{
    $db_host = "mysql-ysite.alwaysdata.net";
    $db_name = "ysite_allbd";
    $db_user = "ysite_chiheb";
    $db_pass = "chihebysite";
    try {
        $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
// Configurez les options PDO si nécessaire
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();

    }
    return $db;
}