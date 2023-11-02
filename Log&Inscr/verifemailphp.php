<?php
session_start();
require_once 'sql-login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = $_POST['token'];

    $conn = dbconnect();
    $verifcode = "SELECT * FROM user WHERE verification_code= :token AND email = :email";
    $stmt = $conn->prepare($verifcode);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $sql = "UPDATE user SET is_verified = true, verification_code = NULL WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        header("Location: verifemail.php?success=Votre Email a été validé");
        exit();
    } else {
        header("Location: verifemail.php?error=Code de validation incorrect");
    }
}
