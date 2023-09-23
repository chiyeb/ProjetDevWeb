<?php
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
//dans le formulaire pour créer un post il faudra mettre les différentes valeurs comme ci dessous
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $id_post=$_POST["id_post"];
    $titre_post=$_POST["titre_post"];
    $message_post=$_POST["message_post"];
    $date_post =$_POST["date_post"];
    $auteur_post=$_POST["auteur_post"];
    $categorie_post=$_POST["categorie_post"];
    $query = "INSERT INTO posts (id_post,titre_post,message_post, date_post,auteur_post,categorie_post) VALUES (:id_post, :titre_post, :message_post, :date_post , :auteur_post, :categorie_post)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->bindParam(':titre_post', $titre_post, PDO::PARAM_STR);
    $stmt->bindParam(':message_post', $message_post, PDO::PARAM_STR);
    $stmt->bindParam(':date_post', $date_post, PDO::PARAM_STR);
    $stmt->bindParam(':auteur_post', $auteur_post, PDO::PARAM_INT);
    $stmt->bindParam(':categorie_post', $titre_post, PDO::PARAM_STR);
    $stmt->execute();
}
?>