<?php
session_start();
?>
<!doctype html>
<html lang="fr">
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/stylesAdmin.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="icon" type="image/png" href="../images/Y.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>


<header>
    <div class="icon">
        <img src="../images/Y.png" class="logo">
    </div>

    <div class="title-admin">
        <i class="fa-solid fa-lock"></i>
        <h1>Admin</h1>
    </div>

    <div class="btn-user">
        <!--        affiche l'image de profil de l'utilisateur -->
        <?php
        require_once "../control/user_controller.php";
        $usercontroller = new \control\user_controller();
        $imageLink = $usercontroller->getImage($_SESSION['id']);
        if ($imageLink!==null){
            echo "<div class='logo-user'>
            <img src='" . $imageLink . "' alt='Image de Profil' class='logo-image'>
            </div>";
        }else{
            echo "<i class='fa-regular fa-user'></i>";
        }
        ?>
    </div>

    <div class="dropmenu">
        <div class="close">
            <i class="fa-solid fa-x"></i>
        </div>

        <div class="drop-logo">
            <img src="../images/Y.png" class="logo">
        </div>
        <!--        affiche les informations de l'utilisateur-->
        <?php
        require_once "../control/user_controller.php";
        if (isset($_SESSION['username'])) {
            // L'utilisateur est connecté,affiche les informations de l'utilisateur
            $username = $usercontroller->getUsername($_SESSION['id']);
            echo "<div class='dropmenu-item'>
                  <i class='fa-solid fa-circle-user'></i>
                  <p><span class='drop-user'>$username</span></p>
                  </div>";
        }
        ?>


        <div class="dropmenu-item">
            <i class="fa-solid fa-message"></i>
            <a class="btn-dropmenu" href="../view/msgpriv.php">Messages</a>
        </div>
        <div class="dropmenu-item">
            <i class="fa-solid fa-user"></i>
            <a class="btn-dropmenu" href="../view/AfficherProfil.php">Profil</a>
        </div>
        <div class="dropmenu-item-last">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <a href="../control/user_controller.php?logout=1" class="btn-dropmenu">Se deconnecter</a>
        </div>
    </div>

</header>

<div class="wrapper">
    <nav>
        <div class="menu-item">
            <div class="menu-item-home">
                <i class="fa-solid fa-house"    ></i>
                <a class="btn-menu" href="../view/accueil.php">Accueil</a>
            </div>
            <div class="menu-item-msg">
                <i class="fa-solid fa-message"></i>
                <a class="btn-menu" href="../view/msgpriv.php">Messages</a>
            </div>
            <div class="menu-item-profil">
                <i class="fa-solid fa-user"></i>
                <a class="btn-menu" href="../view/AfficherProfil.php">Profil</a>
            </div>
            <div class="menu-item-contact">
                <i class="fa-solid fa-envelope"></i>
                <a class="btn-menu" href="../view/formulaire.php">Nous Contacter</a>
            </div>
        </div>
    </nav>

    <div class="admin-page">
        <?php
            require_once '../control/connectbd_controller.php';
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
                <form method="POST" action="../control/admin_controller.php">
                    <div class="add-cat">
                        <i class="fa-solid fa-address-book"></i>
                        <h1>Ajouter une catégorie</h1>
                    </div>
                    <label for="nom_cat">Catégorie</label>
                    <input type="text" name="nom_cat" id="nom_cat" required>
                    <br>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" cols="50" required></textarea>
                    <br>
                    <input type="submit" name="creer_cat" value="Créer">
                </form>
            </section>
            <section class="ban-user">

                <form method="POST" action="../control/admin_controller.php">
                    <div class="title-ban">
                        <i class="fa-solid fa-ban"></i>
                        <h1>Bannir un utilisateur</h1>
                    </div>
                    <div class="user-ban">
                    <i class="fa-solid fa-users"></i>
                    <label for="id_user">Id utilisateur</label>
                    </div>
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
    <div class="menu-item-bar">
        <div class="menu-item-home-bar">
            <i class="fa-solid fa-house"></i>
        </div>
        <div class="menu-item-msg-bar">
            <i class="fa-solid fa-message"></i>
        </div>
        <div class="menu-item-profil-bar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="menu-item-contact-bar">
            <i class="fa-solid fa-envelope"></i>

        </div>
    </div>
<script>
    const btnClose = document.querySelector('.close');
    const btnUser = document.querySelector('.btn-user');
    const toggleBtnIcon = document.querySelector('.btn-user i');
    const dropMenu = document.querySelector('.dropmenu');
    const retour = document.querySelector('.icon')
    const btnHome = document.querySelector('.menu-item-home')
    const btnMsg = document.querySelector('.menu-item-msg')
    const btnProfil = document.querySelector('.menu-item-profil')
    const btnContact = document.querySelector('.menu-item-contact')

    const btnHomeBar = document.querySelector('.menu-item-home-bar')
    const btnMsgBar = document.querySelector('.menu-item-msg-bar')
    const btnProfilBar = document.querySelector('.menu-item-profil-bar')
    const btnContactBar = document.querySelector('.menu-item-contact-bar')



    btnUser.addEventListener('click' , ()=> {
        dropMenu.classList.toggle('drop-list')
    })

    btnClose.addEventListener('click' , ()=> {
        dropMenu.classList.toggle('drop-list')
    })

    retour.onclick = function () {
        window.location.href = "../view/accueil.php";
    }

    /* Bouton menu Telephone */
    btnHome.onclick = function () {
        window.location.href = "../view/accueil.php";
    }
    btnMsg.onclick = function () {
        window.location.href = "../view/msgpriv.php";
    }
    btnProfil.onclick = function () {
        window.location.href = "../view/AfficherProfil.php";
    }
    btnContact.onclick = function () {
        window.location.href = "../view/formulaire.php";
    }

    /* Bouton menu Telephone en bas */
    btnHomeBar.onclick = function () {
        window.location.href = "../view/accueil.php";
    }
    btnMsgBar.onclick = function () {
        window.location.href = "../view/msgpriv.php";
    }
    btnProfilBar.onclick = function () {
        window.location.href = "../view/AfficherProfil.php";
    }
    btnContactBar.onclick = function () {
        window.location.href = "../view/formulaire.php";
    }


</script>
</body>
</html>


