<?php
try {
    require '../control/connectbd_controller.php';    session_start();
    $pdo = new PDO('mysql:host=mysql-ysite.alwaysdata.net;dbname=ysite_allbd', 'ysite_romain', 'romainysite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    die();
}
// Récupération des données du formulaire
$nouveauMotDePasse = $_POST['nouveau_mot_de_passe'];
$confirmationMotDePasse = $_POST['confirmation_mot_de_passe'];

// Est-ce que les mots de passe correspondes ?
if ($nouveauMotDePasse === $confirmationMotDePasse) {
    $mdpCrypter = password_hash($nouveauMotDePasse, PASSWORD_ARGON2ID);

    $idUtilisateur = $_SESSION['id'];

    $sql = "UPDATE user SET password = :mdpCrypter WHERE id = :id";
    $stmt = $pdo->prepare($sql);

// Liaison des paramètres
    $stmt->bindParam(':mdpCrypter', $mdpCrypter, PDO::PARAM_STR);
    $stmt->bindParam(':id', $idUtilisateur, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Le mot de passe a été mis à jour avec succès.";
        //header("Location: index.php");
    } else {
        echo "Erreur lors de la mise à jour du mot de passe.";
    }
}else {
// Les mots de passe ne correspondent pas, affichez un message d'erreur
    echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
}
?>
