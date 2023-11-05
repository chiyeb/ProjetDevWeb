<?php
try {
    require '../control/connectbd_controller.php';
    session_start();
    $pdo = new PDO('mysql:host=mysql-ysite.alwaysdata.net;dbname=ysite_allbd', 'ysite_romain', 'romainysite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    die();
}

// Récupérer l'ID du post à supprimer depuis la requête GET
if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    // Utiliser une requête préparée pour supprimer le post de la base de données
    $sql = "DELETE FROM posts WHERE id_post = :postID";
    $stmt = $pdo->prepare($sql);

    // Liaison de la valeur de l'ID du post
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);

    // Exécution de la requête de suppression
    if ($stmt->execute()) {
        // La suppression s'est déroulée avec succès
        echo "Le post a bien été supprimer";
    } else {
        // Gestion des erreurs de suppression
        echo "Erreur lors de la suppression du post : " . $stmt->errorInfo()[2];
    }
} else {
    // Gérez le cas où l'ID du post n'est pas spécifié dans la requête.
    echo "ID du post non spécifié.";
}