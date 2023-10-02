<!doctype html>
<html lang="fr">
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesProfil.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>Y</title>
</head>
<body>

<header>
    <div class="logo">Y</div>
    <div class="search-bar">
        <input type="text" placeholder="Rechercher">
    </div>
    <div class="btn">NOM</div>
</header>

<div class="wrapper">
    <nav>
        <div class="menu-item">
            <i class="fa-solid fa-house"></i>
            <a class="btn-menu" href="../PagePrincipal/accueil.php">Accueil</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-bolt"></i>
            <a class="btn-menu" href="pour-toi.php">Tendance</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-message"></i>
            <a class="btn-menu" href="../MsgPriv/msgpriv.php">Messages</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-user"></i>
            <a class="btn-menu" href="../Profil/AfficherProfil.php">Profile</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-envelope"></i>
            <a class="btn-menu" href="../Contact/formulaire.php">Nous Contacter</a>
        </div>
    </nav>
    <div class="user-info">
        <?php
        require '../Log&Inscr/sql-login.php';
        session_start();
        if (isset($_SESSION['email']) && isset($_SESSION['username'])&&isset($_SESSION['id'])){
            // L'utilisateur est connecté, vous pouvez afficher les informations de l'utilisateur
            $email = $_SESSION['email'];
            $username = $_SESSION['username'];
            $id = $_SESSION['id'];

            echo "<p>Email : <span class='email'>$email</span></p>";
            echo "<p>Nom d'utilisateur : <span class='username'>$username</span></p>";
            echo "<p>Votre ID (Il est unique, il sert à vous différencier des autres) : <span class='user-id'>$id</span></p>";
            echo "<p>Quelques statistiques :</p>";
            $nbtotaldepost = "SELECT COUNT(*) FROM posts WHERE auteur_post = '$id'";
            $stmt = dbconnect()->prepare($nbtotaldepost);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $count = $row['COUNT(*)'];
                echo "<p>Nombre total de posts : $count</p>";
            } if($count=0) {
                echo "<p>Vous n'avez posté aucun post...</p>";
            }
            $stmt = dbconnect()->prepare("SELECT date_inscription FROM user WHERE id = '$id'");
            $stmt->execute();
            $rowins = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rowins){
                $dateInscription = $rowins['date_inscription']; // Accédez à la clé "date_inscription" du tableau
                echo "<p>La date où vous nous avez rejoint (<3): $dateInscription</p>";
            }
            else{
                echo "<p>Erreur lors de la récupération de la date d'inscription, vueillez <a href='../Contact/formulaire.php'>nous contacter</a></a></p>";
            }
            echo "</div>";

        }
        else{
            header("Location: ../Log&Inscr/connexion");
        }
        ?>
    </div>

</body>
</html>


