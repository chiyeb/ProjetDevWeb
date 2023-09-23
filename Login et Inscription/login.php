    <?php
    session_start();
    require 'sql-login.php'; // Utilisez un fichier approprié pour la connexion PDO
    $conn = dbconnect();

    if (isset($_POST['email']) && isset($_POST['password'])){

        $email = $_POST['email'];
        $pass = $_POST['password'];

        if (empty($email)) {
            header("Location: index.php?error=E-mail requis");
            exit();
        } else if (empty($pass)) {
            header("Location: index.php?error=Mot de passe requis");
            exit();
        } else {
            // Utilisez des requêtes préparées avec PDO pour éviter les injections SQL
            $sql = "SELECT * FROM user WHERE email=:email AND password=:password";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $pass);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
                exit();
            } else {
                header("Location: index.php?error=E-mail ou Mot de passe Incorrect");
                exit();
            }
        }
    } else {
        header("Location: index.php");
        exit();
    }
    ?>
