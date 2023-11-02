<?php

// traitement_reset.php

// Incluez le fichier sql-login.php pour la connexion à la base de données
require_once 'sql-login.php';

// Vérifiez si les paramètres email, token et nouveau mot de passe sont présents dans le formulaire
if (isset($_POST['email']) && isset($_POST['token']) && isset($_POST['new_password'])) {
    // TODO: Ajoutez le code pour mettre à jour le mot de passe dans la base de données ici

    // Exemple : Mettez à jour le mot de passe dans la base de données
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    $conn = dbconnect();
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "UPDATE user SET password=:password WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo 'Mot de passe réinitialisé avec succès.';
} else {
    echo 'Paramètres manquants.';
}

