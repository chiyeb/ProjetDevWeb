<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "sql-login.php"; // Utilisez un fichier approprié pour la connexion PDO
$conn = dbconnect();

function sendMail($email,$v_code) {
    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    $mail = newPHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail .com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'ysite13090@gmail.com';                     //SMTP username
        $mail->Password   = 'Ysiteweb13';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ysite@gmail.com', 'Y');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email de Verification de Y';
        $mail->Body    = "Merci pour le register
        Clicker sur le lien pour verifier votre adresse email
        <a href='ysite.alwaysdata.net/emailverfiy/verify.php?email=$email&v_code=$v_code'>Verify</a>";


        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $name = $_POST['username'];

    $user_data = 'email='. $email. '&username='. $name;
    $v_code=bin2hex(random_bytes(16));
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
            $sql2 = "INSERT INTO user (email, password, username,verification_code, is_verified) VALUES (:email, :password, :username, '$v_code','0')";
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
