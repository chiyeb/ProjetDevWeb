<?php
session_start();
require "sql-login.php"; // Utilisez un fichier approprié pour la connexion PDO
$conn = dbconnect();
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $name = $_POST['username'];

    $user_data = 'email='. $email. '&username='. $name;

    if (empty($email)) {
        header("Location: Inscription.php?error=E-mail requis&$user_data");
        exit();
    } else if (empty($pass)) {
        header("Location: Inscription.php?error=Mot de passe requis&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: Inscription.php?error=Nom requis&$user_data");
        exit();
    } else {
        // Utilisez des requêtes préparées avec PDO pour éviter les injections SQL
        $sql = "SELECT * FROM user WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: Inscription.php?error=E-mail est deja pris, Essayez une autre&$user_data");
            exit();
        } else {
            $sql2 = "INSERT INTO user (email, password, username) VALUES (:email, :password, :username)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(':email', $email);
            $stmt2->bindParam(':password', $pass);
            $stmt2->bindParam(':username', $name);

            if ($stmt2->execute()) {
                header("Location: Inscription.php?success=Votre compte a bien ete cree avec succes");
                exit();
            } else {
                header("Location: Inscription.php?error=Une Erreur est survenue&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: Inscription.php");
    exit();
}
?>