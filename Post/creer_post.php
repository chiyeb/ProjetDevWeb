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
function lastId($pdo) {
    $stmt = $pdo->prepare("SELECT MAX(id_post) FROM posts");
    $stmt->execute();
    $lastId = $stmt->fetchColumn();

    // Incrémente le dernier ID de 1
    $nextId = $lastId + 1;

    return $nextId;
}
// Dans le formulaire pour créer un post, mettez les différentes valeurs comme ci-dessous
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_post = $_POST["id_post"];
    $id_post = lastId($db);
    $titre_post = $_POST["titre_post"];
    $message_post = $_POST["message_post"];
    $date_post = $_POST["date_post"];
    $auteur_post = $_POST["auteur_post"];
    $categorie_post = $_POST["categorie_post"];

    // Obtenez l'ID de la catégorie en utilisant une requête SELECT
    $querycat = "SELECT id_cat FROM categorie WHERE libelle_cat = :libelle_cat";
    $stmt = $db->prepare($querycat);
    $stmt->bindParam(':libelle_cat', $categorie_post, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $id_cat = $result['id_cat'];
        // Insérez les données dans la table des publications
        $query = "INSERT INTO posts (id_post, titre_post, message_post, date_post, auteur_post, categorie_post) 
                  VALUES (:id_post, :titre_post, :message_post, :date_post, :auteur_post, :categorie_post)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $stmt->bindParam(':titre_post', $titre_post, PDO::PARAM_STR);
        $stmt->bindParam(':message_post', $message_post, PDO::PARAM_STR);
        $stmt->bindParam(':date_post', $date_post, PDO::PARAM_STR);
        $stmt->bindParam(':auteur_post', $auteur_post, PDO::PARAM_INT);
        $stmt->bindParam(':categorie_post', $categorie_post, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../PagePrincipal/accueil.php");
        exit();

    } else {
        echo "Catégorie non trouvée.";
    }
}
?>
