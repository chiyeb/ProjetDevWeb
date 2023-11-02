    <?php


    session_start();

    use PHPMailer\PHPMailer\PHPMailer;


    require "sql-login.php"; // Utilisez un fichier approprié pour la connexion PDO
    $conn = dbconnect();

    function sendMail($email,$v_code) {
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';
        require 'PHPMailer/Exception.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       ='smtp-ysite.alwaysdata.net';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'ysite@alwaysdata.net';                     //SMTP username
            $mail->Password   = 'ysitemail13';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->setFrom('ysite@alwaysdata.net', 'Y-Mailer');
            $mail->addAddress($email);

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = ' Y - Confirmation de votre adresse mail';
            $mail->Body    = "Merci pour votre inscription!
            Cliquer sur le lien et entrez le code suivant : $v_code
            <a href='https://ysite.alwaysdata.net/Log&Inscr/verifemail.php'>Verifier</a>";
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {

        $email = $_POST['email'];
        //$pass = $_POST['password'];
        $pass = password_hash($_POST['password'], PASSWORD_ARGON2ID);
        $name = $_POST['username'];

        $user_data = 'email='. $email. '&username='. $name;

        $v_code=bin2hex(random_bytes(16));

        //$crytp_password = password_hash($pass, PASSWORD_ARGON2ID);

        if (empty($email)) {
            header("Location: ../view/Inscription.php?error=E-mail requis&$user_data");
            exit();
        } else if (empty($pass)) {
            header("Location: ../view/Inscription.php?error=Mot de passe requis&$user_data");
            exit();
        } else if (empty($name)) {
            header("Location: ../view/Inscription.php?error=Nom requis&$user_data");
            exit();
        }
        else {
            $mail = "SELECT * FROM user WHERE email=:email";
            $mailverify = $conn->prepare($mail);
            $mailverify->bindParam(':email', $email);
            $mailverify->execute();

            $usernameunique = "SELECT * FROM user WHERE username=:username";
            $usernameverify = $conn->prepare($usernameunique);
            $usernameverify->bindParam(':username', $name);
            $usernameverify->execute();

            if ($mailverify->rowCount() > 0) {
                header("Location: ../view/Inscription.php?error=E-mail déjà pris&$user_data");
                exit();
            }
            if ($usernameverify->rowCount() > 0) {
                header("Location: ../view/Inscription.php?error=Username déjà pris&$user_data");
                exit();
            }
            else {
                $sql2 = "INSERT INTO user (email, password, username,date_inscription ,verification_code, is_verified) VALUES (:email, :password, :username, NOW(),'$v_code','0')";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bindParam(':email', $email);
                $stmt2->bindParam(':password', $pass);
                $stmt2->bindParam(':username', $name);


                if ($stmt2->execute()) {
                    sendMail($email, $v_code);
                    header("Location: ../view/Inscription.php?success=Votre compte a bien été créé avec succès veuillez confirmer votre e-mail.");
                    exit();

                } else {
                    header("Location: ../view/Inscription.php?error=test&$user_data");
                    exit();
                }
            }
        }
    } else {
        header("Location: Inscription.php");
        exit();
    }
    ?>
