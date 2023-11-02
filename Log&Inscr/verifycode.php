<?php
require_once 'sql-login.php';
require 'verify.php';
$codevalid = $_POST['code'];
$nvmdp = $_POST['mdp'];

$con = dbconnect();

// Vérifier si le code correspond au reset_token dans la base de données
$sql = "SELECT id FROM user WHERE reset_token = :reset_token";
$stmt = $con->prepare($sql);
$stmt->bindParam(':reset_token', $codevalid);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $userId = $row['id'];
    $sqlupdate = "UPDATE user SET password = :nouveauMotDePasse WHERE id = :idUtilisateur";
    $stmt = $con->prepare($sqlupdate);
    $stmt->bindParam(':nouveauMotDePasse', $nvmdp, PDO::PARAM_STR);
    $stmt->bindParam(':idUtilisateur', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Mot de passe mis à jour avec succès.";
        $suprreset = "UPDATE user SET reset_token = NULL, reset_expiry = NULL WHERE id = :id";
        $stmt = $con->prepare($suprreset);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

    } else {
        echo "Erreur lors de la mise à jour du mot de passe.";
    }
} else {
    echo "Code de vérification invalide.";
}
?>
