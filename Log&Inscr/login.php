<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'sql-login.php'; // Utilisez un fichier approprié pour la connexion PDO
$conn = dbconnect();

if (isset($_POST['email']) && isset($_POST['password'])){

    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (empty($email)) {
        header("Location: ../index.php?error=E-mail requis");
        exit();
    } else if (empty($pass)) {
        header("Location: ../index.php?error=Mot de passe requis");
        exit();
    } else {
        // Utilisez des requêtes préparées avec PDO pour éviter les injections SQL
        $sql = "SELECT * FROM user WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Vérifier le mot de passe saisi par rapport au mot de passe haché dans la base de données
            $hashedPassword = $row['password'];
            if (password_verify($pass, $hashedPassword)) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                if ($row['is_verified']=== 0){
                    header("Location: ../index.php?error=Vérifier votre adresse e-mail avant de vous connecter. ");
                    exit();
                }
                header("Location: ../view/accueil.php");
                exit();
            } else {
                header("Location: ../index.php?error=E-mail ou Mot de passe Incorrect");
                exit();
            }
        } else {
            header("Location: ../index.php?error=E-mail ou Mot de passe Incorrect");
            exit();
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>