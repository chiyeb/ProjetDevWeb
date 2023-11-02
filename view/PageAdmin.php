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
    <div class="admin-page">
        <?php
            require_once '../control/connectbd_controller.php';
            session_start();
            $connectbd = new \control\connectbd_controller();
            $pdo =$connectbd->connectbd();

        $userId = $_SESSION['id'] ;
        $query = "SELECT is_admin FROM user WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['is_admin'] == 1) {?>
            <section class="creer-cat">
                <h1>Ajouter une catégorie</h1>
                <form method="POST" action="../control/admin_controller.php">
                    <label for="nom_cat">Catégorie: </label>
                    <input type="text" name="nom_cat" id="nom_cat" required>
                    <br>
                    <label for="description">Description :</label>
                    <textarea name="description" id="description" rows="4" cols="50" required></textarea>
                    <br>
                    <input type="submit" name="creer_cat" value="Créer">
                </form>
            </section>
            <section class="ban-user">
                <h1>Bannir un utilisateur</h1>
                <form method="POST" action="../control/admin_controller.php">
                    <label for="id_user">Id utilisateur : </label>
                    <input type="text" name="id_user" id="id_user" required>
                    <br>
                    <input type="submit" name="ban" value="Bannir">
                </form>
                <?php
                if (isset($_POST['id_user']))
                ?>
            </section>
        <?php } else {
            echo "<p class='error'>Erreur vous n'êtes pas autorisé à accéder à cette page</p>";
        }?>
    </div>
</div>
</body>
</html>


