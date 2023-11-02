<?php
use PHPMailer\PHPMailer\PHPMailer;

session_start();
require_once '../sql-login.php';

function sendResetEmail($email, $resetLink, $resetToken) {
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/SMTP.php';
    require '../PHPMailer/Exception.php';
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp-ysite.alwaysdata.net';  // Remplacez par votre serveur SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ysite@alwaysdata.net';  // Remplacez par votre adresse e-mail
        $mail->Password   = 'ysitemail13';  // Remplacez par votre mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('ysite@alwaysdata.net', 'Y');  // Remplacez par votre nom
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation du mot de passe';
        $mail->Body = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href='$resetLink'>Réinitialiser le mot de passe</a> et entrez ce code de vérification : $resetToken";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $conn = dbconnect();
    $reset_token = bin2hex(random_bytes(16));  // Générer un token de réinitialisation

    // Vérifier si l'e-mail existe dans la base de données
    $sql = "SELECT * FROM user WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $reset_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));  // Expire dans 1 heure
        // Stocker le token et l'heure d'expiration dans la base de données
        $sql = "UPDATE user SET reset_token=:token, reset_expiry=:expiry WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $reset_token);
        $stmt->bindParam(':expiry', $reset_expiry);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Envoyer un e-mail avec le lien de réinitialisation
        $reset_link = "http://ysite.alwaysdata.net/Log&Inscr/verify.php?token=$reset_token";

        // Envoyer l'e-mail
        if (sendResetEmail($email, $reset_link, $reset_token)) {
            echo 'E-mail de réinitialisation envoyé avec succès.';
        } else {
            echo 'Erreur lors de l\'envoi de l\'e-mail de réinitialisation.';
        }
    } else {
        echo "L'adresse e-mail n'est pas enregistrée.";
    }
} else {
    echo "Veuillez fournir une adresse e-mail.";
}
?>
