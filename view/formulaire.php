<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
?>
<!doctype html>
<html lang="fr">
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/formulaire.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Formulaire</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <?php require_once "scripts.php" ?>
</head>
<body>

<header>
    <div class="icon">
        <img src="../images/Y.png" class="logo">
    </div>

    <div class="search-bar">
        <input type="text" placeholder="Rechercher">
    </div>
    <div class="btn-user">
        <?php
        require_once "../control/user_controller.php";
        $usercontroller = new \control\user_controller();
        $imageLink = $usercontroller->getImage($_SESSION['id']);
        if ($imageLink!==null){
            echo "<img src='" . $imageLink . "' alt='Image de Profil' class='logo-image'>";

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

        <?php
        if (isset($_SESSION['username'])) {
            // L'utilisateur est connecté, vous pouvez afficher les informations de l'utilisateur
            $username = $_SESSION['username'];
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



<div class="post-form">

    <h1 class="form-title">Nous Contacter</h1>

    <form method="POST" action="../control/contact_controller.php">
        <?php if (isset($_GET['error'])) { ?>
            <p class="error">
                <?php echo $_GET['error']; ?>
            </p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success">
                <?php echo $_GET['success']; ?>
            </p>
        <?php } ?>
        <label>Nom</label>
        <input type="text" name="nom" placeholder="Indiquez votre nom"><br>

        <label>Prénom</label>
        <input type="text" name="prenom" placeholder="Indiquez votre prénom"><br>

        <label>Email</label>
        <input type="email" name="email" placeholder="Indiquez votre adresse mail"><br>

        <textarea name="Message" placeholder=" Votre message "></textarea>

        <button name="envoyer" type="submit">Envoyer</button>

    </form>
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