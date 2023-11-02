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

    public function check_account($email, $pass)
    {
        if (empty($email)) {
            header("Location: ../index.php?error=E-mail requis");
            exit();
        } else if (empty($pass)) {
            header("Location: ../index.php?error=Mot de passe requis");
            exit();
        } else {
            // Utilisez des requêtes préparées avec PDO pour éviter les injections SQL
            $sql = "SELECT * FROM user WHERE email=:email";
            $stmt = $this->conn->prepare($sql);
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
                    if ($row['is_verified'] === 0) {
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
    }

    public function getImage($user)
    {
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

    public function insertImageProfil($id, $image)
    {
        $query = $this->conn->prepare("UPDATE user SET image_profil = :image_profil WHERE id = :user_id");
        $query->bindParam(":image_profil", $image, PDO::PARAM_STR);
        $query->bindParam(":user_id", $id, PDO::PARAM_INT);

        $query->execute();
        $db = null;
    }

    function sendMail($email, $v_code)
    {
        if ($email === null && $v_code === null) {
            $v_code = random_int(10000, 99999);
            $sql = "UPDATE user SET reset_token = :code WHERE id = :idUtilisateur";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':code', $v_code, PDO::PARAM_STR);
            $stmt->bindParam(':idUtilisateur', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            $nouvelEmail = $_POST['nouvel_email'];
        }

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

            if ($email === null) {
                $mail->addAddress($nouvelEmail);
            } else {
                $mail->addAddress($email);
            }

            $mail->isHTML(true);                                       // Set email format to HTML
            $mail->Subject = 'Y - Confirmation de votre adresse mail';
            if ($email === null) {
                // Lien pour le cas où email et v_code sont vides
                $verificationLink = "<a href='https://ysite.alwaysdata.net/view/verife_new_mail.php'>Verifier</a>";
            } else {
                // Lien pour les autres cas
                $verificationLink = "<a href='https://ysite.alwaysdata.net/view/verifemail.php?email='$email>Verifier</a>";
            }

            $mail->Body = "Cliquer sur le lien et entrez le code suivant : $v_code $verificationLink";
            $mail->send();
            echo 'L\'email a bien été envoyé';
        } catch (Exception $e) {
            exit();
        }
    }


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

        if ($mailverify->rowCount() > 0) {
            header("Location: ../view/Inscription.php?error=E-mail déjà pris&$user_data");
            exit();
        }
        if ($usernameverify->rowCount() > 0) {
            header("Location: ../view/Inscription.php?error=Username déjà pris&$user_data");
            exit();
        } else {
            $sql2 = "INSERT INTO user (email, password, username,date_inscription ,verification_code, is_verified) VALUES (:email, :password, :username, NOW(),'$v_code','0')";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(':email', $email);
            $stmt2->bindParam(':password', $pass);
            $stmt2->bindParam(':username', $name);


            if ($stmt2->execute()) {
                $this->sendMail($email, $v_code);
                header("Location: ../view/verifemail.php?success=Inscription réussis, entrez le code reçu par mail.&email=$email");
                exit();

            } else {
                header("Location: ../view/Inscription.php?error=Problème de connexion, veuillez réessayer plus tard.");
                exit();
            }
        }
}
        public function confirmMail($token, $email){
            $verifcode = "SELECT * FROM user WHERE email = :email AND verification_code = :token";
            $stmt = $this->conn->prepare($verifcode);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($email);
            var_dump($token);
            if ($row) {
                $sql = "UPDATE user SET is_verified = true, verification_code = NULL WHERE email = :email";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                header("Location: ../view/login.php?success=Votre Email a été validé, vous pouvez vous connecter.");
                exit();
            } else {
                header("Location: ../view/verifemail.php?error=Code de validation incorrect");
            }
        }
        public function changerMail(){
            $nouvelEmail = $_POST['nouvel_email'];
            $token = $_POST['token'];
            $idUtilisateur = $_SESSION['id'];
            $sqlVerification = "SELECT reset_token FROM user WHERE id = :idUtilisateur";
            $stmtVerification = $this->conn->prepare($sqlVerification);
            $stmtVerification->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
            $stmtVerification->execute();
            $row = $stmtVerification->fetch(PDO::FETCH_ASSOC);

            if ($row && $row['reset_token'] === $token) {
                $sql = "UPDATE user SET email = :nouvelEmail, reset_token = NULL WHERE id = :idUtilisateur";
                $stmt = $this->conn->prepare($sql);

                // Liaison des paramètres
                $stmt->bindParam(':nouvelEmail', $nouvelEmail, PDO::PARAM_STR);
                $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);

                if (!empty($nouvelEmail)) {
                    if ($stmt->execute()) {

                        header("Location: ../view/verifemail.php?success=Votre Email a été validé");
                    } else {
                        header("Location: ../view/verifemail.php?error=Erreur lors de la vérification, veuillez nous contacter.");
                    }
                } else {
                    header("Location: ../view/verifemail.php?error=Mail vide");
                }
            } else {
                header("Location: ../view/verifemail.php?error=Code de validation incorrect");;
            }

        }
        public function changerMdp(){
            $nouveauMotDePasse = $_POST['nouveau_mot_de_passe'];
            $confirmationMotDePasse = $_POST['confirmation_mot_de_passe'];

            if ($nouveauMotDePasse === $confirmationMotDePasse) {
                $mdpCrypter = password_hash($nouveauMotDePasse, PASSWORD_ARGON2ID);

                $idUtilisateur = $_SESSION['id'];

                $sql = "UPDATE user SET password = :mdpCrypter WHERE id = :id";
                $stmt = $this->conn->prepare($sql);

                $stmt->bindParam(':mdpCrypter', $mdpCrypter, PDO::PARAM_STR);
                $stmt->bindParam(':id', $idUtilisateur, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo "Le mot de passe a été mis à jour avec succès.";
                } else {
                    echo "Erreur lors de la mise à jour du mot de passe.";
                }
            }else {
                echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
            }
        }
        public function suprPost($id){
            $sql = "DELETE FROM posts WHERE id_post = :postID";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':postID', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                exit();
            } else {
                echo "Erreur lors de la suppression du post veuillez nous contacter.";
            }
        }
    }