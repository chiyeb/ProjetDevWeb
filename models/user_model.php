<?php

namespace models;

use control\connectbd_controller;
use Exception;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;

class user_model
{
    public $conn;

    public function __construct()
    {
        $this->conn = (new connectbd_controller())->connectbd();
    }
    public function getEmail($id){
        $sql = "SELECT email FROM user where id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && isset($result['email'])) {
            return $result['email'];
        } else {
            return null;
        }
    }
    //fonction pour récupérer le username d'un utilisateur grâce à son id
    public function getUsername($id){
        $sql = "SELECT username FROM user where id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && isset($result['username'])) {
            return $result['username'];
        } else {
            return null;
        }
    }
    //fonction pour changer de pseudo
    public function changerUsername($username) {
        $sql = "SELECT username FROM user where username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Le nom d'utilisateur existe déjà, affiche un message d'erreur
            header("Location: ../view/changer_username.php?error= Le nom d'utilisateur existe déjà. Choisissez un autre nom d'utilisateur.");
        } else {
            // Le nom d'utilisateur est unique, procéde à la mise à jour
            $sql = "UPDATE user SET username = :newUsername WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':newUsername', $username);
            $stmt->bindParam(':id', $_SESSION['id']);
            $stmt->execute();

            header("Location: ../view/AfficherProfil.php");
        }
    }


    //Fonction de connexion, permet de vérifier si un mot de passe correspond à un mail
    public function check_account($email, $pass)
    {
        //si l'e-mail est vide, on redirige vers la page de connexion avec une erreur
        if (empty($email)) {
            header("Location: ../index.php?error=E-mail requis");
            exit();
            //si le mot de passe est vide, on redirige vers la page de connexion avec une erreur
        } else if (empty($pass)) {
            header("Location: ../index.php?error=Mot de passe requis");
            exit();
            //si tout est bon
        } else {
            //on sélectionne l'utilisateur ayant pour mail "$email"
            $sql = "SELECT * FROM user WHERE email=:email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //si un utilisateur à pour email "$email"
            if ($row) {
                // Vérifie le mot de passe saisi par rapport au mot de passe haché dans la base de données
                $hashedPassword = $row['password'];
                //vérifie si le mot de passe entré en clair correspond au mot de passe crypté de la base de donnée
                if (password_verify($pass, $hashedPassword)) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['id'] = $row['id'];
                    //si l'utilisateur n'as pas vérifié son adresse e-mail
                    if ($row['is_verified'] === 0) {
                        header("Location: ../index.php?error=Vérifier votre adresse e-mail avant de vous connecter. ");
                        exit();
                    }
                    //si tout est bon on redirige vers accueil.php
                    header("Location: ../view/accueil.php");
                    exit();
                } //si il y a une erreur dans l'email ou le mot de passe
                else {
                    header("Location: ../index.php?error=E-mail ou Mot de passe Incorrect");
                    exit();
                }
            } else {
                header("Location: ../index.php?error=E-mail ou Mot de passe Incorrect");
                exit();
            }
        }
    }

    //fonction pour changer son mot de passe après avoir reçu le mail de mot de passe oublié
    public function changerMdpOublier($code, $nvmdp)
    {
        //on sélectionne l'id de l'utilisateur ayant pour reset token le code entré par l'utilisateur
        $sql = "SELECT id FROM user WHERE reset_token = :reset_token";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':reset_token', $code);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //si il existe un utilisateur ayant pour reset token le code entré par l'utilisateur
        if ($row) {
            $hashed_password = password_hash($nvmdp, PASSWORD_DEFAULT);
            $userId = $row['id'];
            //on change son mot de passe par celui entré par l'utilisateur
            $sqlupdate = "UPDATE user SET password = :nouveauMotDePasse WHERE id = :idUtilisateur";
            $stmt = $this->conn->prepare($sqlupdate);
            $stmt->bindParam(':nouveauMotDePasse', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':idUtilisateur', $userId, PDO::PARAM_INT);
            //si la requête à bien été éxécuté
            if ($stmt->execute()) {
                //on enleve le reset token de l'utilisateur
                $suprreset = "UPDATE user SET reset_token = NULL WHERE id = :id";
                $stmt = $this->conn->prepare($suprreset);
                $stmt->bindParam(':id', $userId);
                $stmt->execute();
                header("Location: ../view/changerMdpOublier.php?success=Mot de passe changé.");
            } else {
                header("Location: ../view/changerMdpOublier.php?error=Impossible de changer le mot de passe.");
                exit();
            }
        } else {
            header("Location: ../view/changerMdpOublier.php?error=Code de vérification invalide");
            exit();
        }
    }

    //fonction pour récupérer l'image de profil d'un utilisateur donné
    public function getImage($user)
    {
        //on sélectionne l'image de profil de l'utilisateur "$user"
        $query = $this->conn->prepare("SELECT image_profil FROM user WHERE id = :user_id");
        $query->bindParam(":user_id", $user, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result && isset($result['image_profil'])) {
            return $result['image_profil'];
        } else {
            return null;
        }
    }

    //fonction pour insérer une image de profil à un utilisateur
    public function insertImageProfil($id, $image)
    {
        //on update l'utilisateur pour entré le lien de l'image dans la colonne "image_profil" à partir de son id
        $query = $this->conn->prepare("UPDATE user SET image_profil = :image_profil WHERE id = :user_id");
        $query->bindParam(":image_profil", $image, PDO::PARAM_STR);
        $query->bindParam(":user_id", $id, PDO::PARAM_INT);

        $query->execute();
        $db = null;
    }

    //fonction pour initier une demande de réinitialisation de mot de passe
    public function mdpOublier($email)
    {
        $reset_token = random_int(10000, 99999); // Génére un token de réinitialisation
        //on sélectionne l'utilisateur contenant l'email "$email"
        $sql = "SELECT * FROM user WHERE email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //si un utilisateur existe on lui ajoute le code "$resettoken"
        if ($row) {
            // Stocker le token et l'heure d'expiration dans la base de données
            $sql = "UPDATE user SET reset_token=:token WHERE email=:email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':token', $reset_token);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            // Envoyer l'e-mail
            $this->sendMailMdpOublier($email, $reset_token);
        }
    }

    //envoie un mail pour mot de passer oublié
    function sendMailMdpOublier($email, $reset_token)
    {
        require '../Log&Inscr/PHPMailer/PHPMailer.php';
        require '../Log&Inscr/PHPMailer/SMTP.php';
        require '../Log&Inscr/PHPMailer/Exception.php';
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp-ysite.alwaysdata.net';                   // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                     // Enable SMTP authentication
            $mail->Username = 'ysite@alwaysdata.net';                   // SMTP username
            $mail->Password = 'ysitemail13';                           // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable implicit TLS encryption
            $mail->Port = 587;                                          // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->setFrom('ysite@alwaysdata.net', 'Y-Mailer');
            $mail->addAddress($email);
            $mail->isHTML(true);                                       // Set email format to HTML
            $mail->Subject = 'Y - Mot de passe oublié ';
            $verificationLink = "<a href='https://ysite.alwaysdata.net/view/changerMdpOublier.php?token=$reset_token'>Verifier</a>";
            $mail->Body = "Cliquez sur le lien et entrez le code suivant : $reset_token $verificationLink";
            $mail->send();
            header("Location: ../view/mot_de_passe_oublie.php?success=E-mail envoyé avec succès !");
        } catch (Exception $e) {
            exit();
        }
    }
    public function checkEmail($email){
        $sql = "SELECT email FROM user where email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getCodeConfirm($email){
        $sql = "SELECT verification_code FROM user where email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['verification_code'];
        } else {
            return null;
        }
    }
    public function renvoyerMail($email){
        $verification_code = $this->getCodeConfirm($email);
        //si l'utilisateur veut changer d'e-mail
        require_once '../Log&Inscr/PHPMailer/PHPMailer.php';
        require_once '../Log&Inscr/PHPMailer/SMTP.php';
        require_once '../Log&Inscr/PHPMailer/Exception.php';
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp-ysite.alwaysdata.net';                   // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                     // Enable SMTP authentication
            $mail->Username = 'ysite@alwaysdata.net';                   // SMTP username
            $mail->Password = 'ysitemail13';                           // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable implicit TLS encryption
            $mail->Port = 587;                                          // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->setFrom('ysite@alwaysdata.net', 'Y-Mailer');
            $mail->addAddress($email);
            $mail->isHTML(true);                                       // Set email format to HTML
            $mail->Subject = 'Y - Confirmation de votre adresse mail';
            $verificationLink = "<a href='https://ysite.alwaysdata.net/view/verifemail.php?email=$email&vcode=$verification_code'>Verifier</a>";
            $mail->Body = "Cliquez sur le lien et entrez le code suivant : $verification_code $verificationLink";
            $mail->send();
        } catch (Exception $e) {
            exit();
        }
    }
    //envoie un mail selon la situation, si on  s'inscrit ou si on change d'e-mail
    function sendMail($email, $v_code)
    {
        //si l'utilisateur veut changer d'e-mail
        if ($email === null && $v_code === null) {
            $v_code = random_int(10000, 99999);
            $sql = "UPDATE user SET reset_token = :code WHERE id = :idUtilisateur";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':code', $v_code, PDO::PARAM_STR);
            $stmt->bindParam(':idUtilisateur', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            $nouvelEmail = $_POST['nouvel_email'];
        }

        require_once '../Log&Inscr/PHPMailer/PHPMailer.php';
        require_once '../Log&Inscr/PHPMailer/SMTP.php';
        require_once '../Log&Inscr/PHPMailer/Exception.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp-ysite.alwaysdata.net';                   // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                     // Enable SMTP authentication
            $mail->Username = 'ysite@alwaysdata.net';                   // SMTP username
            $mail->Password = 'ysitemail13';                           // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable implicit TLS encryption
            $mail->Port = 587;                                          // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->setFrom('ysite@alwaysdata.net', 'Y-Mailer');

            if ($email === null) {
                $mail->addAddress($nouvelEmail);
            } else {
                $mail->addAddress($email);
            }

            $mail->isHTML(true);                                       // Set email format to HTML
            $mail->Subject = 'Y - Confirmation de votre adresse mail';
            if ($email === null) {
                // Lien pour le cas où email et v_code sont vides
                $verificationLink = "<a href='https://ysite.alwaysdata.net/view/verife_new_mail.php?email=$nouvelEmail&vcode=$v_code'>Verifier</a>";
            } else {
                // Lien pour les autres cas
                $verificationLink = "<a href='https://ysite.alwaysdata.net/view/verifemail.php?email=$email&vcode=$v_code'>Verifier</a>";
            }

            $mail->Body = "Cliquez sur le lien et entrez le code suivant : $v_code $verificationLink";
            $mail->send();
        } catch (Exception $e) {
            exit();
        }
    }

    //fonction pour inscrire un utilisateur
    public function inscription($name, $pass, $email, $user_data)
    {
        $v_code = random_int(10000, 99999);
        $mail = "SELECT * FROM user WHERE email=:email";
        $mailverify = $this->conn->prepare($mail);
        $mailverify->bindParam(':email', $email);
        $mailverify->execute();

        $usernameunique = "SELECT * FROM user WHERE username=:username";
        $usernameverify = $this->conn->prepare($usernameunique);
        $usernameverify->bindParam(':username', $name);
        $usernameverify->execute();
        //si le'-mail est déjà pris
        if ($mailverify->rowCount() > 0) {
            header("Location: ../view/Inscription.php?error=E-mail déjà pris&$user_data");
            exit();
        }
        //si le nom d'utilisateur est déjà pris
        if ($usernameverify->rowCount() > 0) {
            header("Location: ../view/Inscription.php?error=Username déjà pris&$user_data");
            exit();
        } else {
            //si tout est bon, on insert un nouvel utilisateur dans la base de donnée
            $sql2 = "INSERT INTO user (email, password, username,date_inscription ,verification_code, is_verified) VALUES (:email, :password, :username, NOW(),'$v_code','0')";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(':email', $email);
            $stmt2->bindParam(':password', $pass);
            $stmt2->bindParam(':username', $name);

            //si tout est bon on redirige l'utilisateur vers la page de vérification d'adresse mail
            if ($stmt2->execute()) {
                $this->sendMail($email, $v_code);
                header("Location: ../view/verifemail.php?success=Inscription réussis, entrez le code reçu par mail.&email=$email");
                exit();

            } //sinon, si un problème est survenu on le redirige vers la page d'insription avec une erreur
            else {
                header("Location: ../view/Inscription.php?error=Problème de connexion, veuillez réessayer plus tard.");
                exit();
            }
        }
    }

    //fonction pour confirmer un e-mail
    public function confirmMail($token, $email)
    {
        //sélectionne l'utilisateur ayant pour mail "$email" et pour code de vérificaiton "$token"
        $verifcode = "SELECT * FROM user WHERE email = :email AND verification_code = :token";
        $stmt = $this->conn->prepare($verifcode);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //si tout est bon, on met is verified à true et verificaiton code à null
        if ($row) {
            $sql = "UPDATE user SET is_verified = true, verification_code = NULL WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            //on redirige l'utilisateur vers la page de login
            header("Location: ../view/login.php?success=Votre Email a été validé, vous pouvez vous connecter.");
            exit();
        } //sinon on redirige l'utilisateur vers la page de verification de mail avec une erreur
        else {
            header("Location: ../view/verifemail.php?error=Code de validation incorrect");
        }
    }

    // Fonction pour changer l'adresse e-mail de l'utilisateur
    public function changerMail()
    {
        // On récupère le nouvel e-mail et le token
        $nouvelEmail = $_POST['nouvel_email'];
        $token = $_POST['token'];
        // On obtient l'identifiant de l'utilisateur actuellement connecté depuis la session
        $idUtilisateur = $_SESSION['id'];

        // On vérifie si le token correspond à l'utilisateur dans la base de données
        $sqlVerification = "SELECT reset_token FROM user WHERE id = :idUtilisateur";
        $stmtVerification = $this->conn->prepare($sqlVerification);
        $stmtVerification->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmtVerification->execute();
        $row = $stmtVerification->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['reset_token'] === $token) {
            // Si la vérification réussit, on met à jour l'e-mail de l'utilisateur et on réinitialise le token
            $sql = "UPDATE user SET email = :nouvelEmail, reset_token = NULL WHERE id = :idUtilisateur";
            $stmt = $this->conn->prepare($sql);

            // Liaison des paramètres
            $stmt->bindParam(':nouvelEmail', $nouvelEmail, PDO::PARAM_STR);
            $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);

            if (!empty($nouvelEmail)) {
                if ($stmt->execute()) {
                    // Redirection en cas de succès
                    header("Location: ../view/verife_new_mail.php?success=Votre Email a été validé");
                } else {
                    // Redirection en cas d'erreur lors de la mise à jour
                    header("Location: ../view/verife_new_mail.php?error=Erreur lors de la vérification, veuillez nous contacter.");
                }
            } else {
                // Redirection en cas de champ d'e-mail vide
                header("Location: ../view/verife_new_mail.php?error=Mail vide");
            }
        } else {
            // Redirection en cas de code de validation incorrect
            header("Location: ../view/verife_new_mail.php?error=Code de validation incorrect");
        }
    }

    // Fonction pour changer le mot de passe
    public function changerMdp()
    {
        // On récupère le nouveau mot de passe et la confirmation depuis les données POST
        $nouveauMotDePasse = $_POST['nouveau_mot_de_passe'];
        $confirmationMotDePasse = $_POST['confirmation_mot_de_passe'];

        // On vérifie si les mots de passe correspondent
        if ($nouveauMotDePasse === $confirmationMotDePasse) {
            // Si les mots de passe correspondent, on crypte le nouveau mot de passe
            $mdpCrypter = password_hash($nouveauMotDePasse, PASSWORD_ARGON2ID);

            // On obtient l'identifiant de l'utilisateur actuellement connecté depuis la session
            $idUtilisateur = $_SESSION['id'];

            // On met à jour le mot de passe dans la base de données
            $sql = "UPDATE user SET password = :mdpCrypter WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            // Liaison des paramètres
            $stmt->bindParam(':mdpCrypter', $mdpCrypter, PDO::PARAM_STR);
            $stmt->bindParam(':id', $idUtilisateur, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // En cas de succès, on affiche un message
                echo "Le mot de passe a été mis à jour avec succès.";
            } else {
                // En cas d'erreur lors de la mise à jour, on affiche un message d'erreur
                echo "Erreur lors de la mise à jour du mot de passe.";
            }
        } else {
            // Si les mots de passe ne correspondent pas, on affiche un message d'erreur
            echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
        }
    }

    // Fonction qui permet de supprimer un post grâce à son identifiant
    public function suprPost($id)
    {
        // On prépare la requête de suppression en utilisant l'identifiant du post
        $sql = "DELETE FROM posts WHERE id_post = :postID";
        $stmt = $this->conn->prepare($sql);
        // On lie l'identifiant du post en paramètre
        $stmt->bindParam(':postID', $id, PDO::PARAM_INT);
        // On exécute la requête de suppression
        if ($stmt->execute()) {
            exit();
        } else {
            // En cas d'erreur lors de la suppression, on affiche un message d'erreur
            echo "Erreur lors de la suppression du post veuillez nous contacter.";
        }
    }
}
