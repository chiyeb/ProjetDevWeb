<?php

use control\msgpriv_controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/cat-inbox.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boîte de réception</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
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
              <p><span class='username'>$username</span></p>
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
                <i class="fa-solid fa-house"></i>
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


    <div class="all-pages">
        <div class="user-msg">
            <!-- Formulaire pour envoyer un message -->
            <div class="title-msg">
                <i class="fa-solid fa-message"></i>
                <h1>Messages</h1>
            </div>
            <div class="msg-title">
                <h2>Envoyer un message</h2>
            </div>
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
            <form method="POST" action="../control/msgpriv_controller.php">

                <div class="dest">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <!--                Préremplis l'input si un utilisateur est cliqué dans les suggestions-->
                    <?php
                    $receiver = isset($_GET['user']) ? $_GET['user'] : "";
                    ?>
                    <input type="text" name="receiver" id="receiver" required placeholder="Rechercher des personnes"
                           value="<?php echo $receiver; ?>">
                </div>
                <br>

                <div class="msg-form">
                    <i class="fa-regular fa-message"></i>
                    <label for="message">Message</label>
                </div>

                <div class="form-msg">
                    <textarea name="message" id="message" rows="4" cols="50" required
                              placeholder="Votre message"></textarea>
                    <br>
                </div>
                <button type="submit" value="Envoyer" name="Envoyer">Envoyer</button>
            </form>
        </div>

        <div class="afficher-msg">
            <div class="inbox-title">
                <i class="fa-solid fa-inbox"></i>
                <h1>Boîte de réception</h1>
            </div>
            <!--        affiche les messages-->
            <?php
            require_once "../control/msgpriv_controller.php";
            require_once "../control/user_controller.php";
            $message_controller = new msgpriv_controller();
            $usecontroller = new \control\user_controller();

            $messages = $message_controller->afficherMsg(); // Passer null pour afficher tous les messages
            // Affichage des posts dans l'ordre inverse
            for ($i = count($messages) - 1; $i >= 0; $i--) {
                $message = $messages[$i];
                $imageAuteur = $usecontroller->getImage($message->getAuteurId());
                $imageReceveur = $usecontroller->getImage($message->getReceveurId());
                echo "<div class='messages'>";
                echo "<div class='msg-auteur'>";
                if ($imageAuteur !== NULL) {
                    echo "<img class='image-profil' src='$imageAuteur'>";
                } else {
                    echo "<i class='fa-regular fa-circle-user'></i>";
                }
                echo "<p class='auteurmsg'>" . $message->getAuteur() . "</p>";
                echo "</div>"; # afficher l'id de l'auteur

                echo "<div class='msg-receveur'>";

                if ($imageReceveur !== NULL) {
                    echo "<img class='image-profil' src='$imageReceveur'>";
                } else {
                    echo "<i class='fa-solid fa-at'></i>";
                }

                echo "<p class='receveurmsg'>" . $message->getReceveur() . "</p>";
                echo "</div>"; # afficher l'id de celui qui reçoit le message


                echo "<div class='msg-inbox'>
               <i class='fa-regular fa-message'></i>        
               <p class='message'>" . $message->getMessage() . "</p>
               </div>"; #afficher le msg

                echo "<div class='msg-temps'>
               <i class='fa-solid fa-hourglass-start''></i>
               <p class='tempmsg'>" . $message->getTime() . "</p>
               </div>";#afficher l'heure du msg
                echo "</div> <br>";
            }
            ?>
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

        <div class="cat-msg">
            <i class="fa-solid fa-paper-plane"></i>
            <a class="msg-cat" href="msgpriv.php">Envoyer un Message</a>
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



        const btnMessages = document.querySelector('.cat-msg')

        btnMessages.onclick = function () {
            window.location.href = "../view/msgpriv.php"
        }
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