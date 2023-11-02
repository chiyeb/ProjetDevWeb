<?php
session_start();
require_once '../sql-login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Vérifier que le token et l'e-mail sont valides
    // Comparer le token et l'e-mail avec ceux enregistrés en base de données

    // ...
    $conn=dbconnect();

    // Mettre à jour le mot de passe dans la base de données
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE user SET password=:password WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Rediriger l'utilisateur vers une page de confirmation
    header('Location: mot_de_passe_reinitialise.php');
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>
