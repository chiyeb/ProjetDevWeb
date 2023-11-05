<?php

use control\post_controller;

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
    <link rel="stylesheet" href="../css/cat-post.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Profil</title>
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

    <div class="all-pages">
        <div class="user-info">
            <!--        affiche les informations de l'utilisateur-->
            <?php
            require_once "../control/connectbd_controller.php";
            require_once "../control/user_controller.php";
            $connectbd = new \control\connectbd_controller();
            $usercontroller = new \control\user_controller();
            $pdo = $connectbd->connectbd();
            if (isset($_SESSION['email']) && isset($_SESSION['username'])&&isset($_SESSION['id'])){
            $id = $_SESSION['id'];
            $email =$usercontroller->getEmail($id);
            $username = $usercontroller->getUsername($id);
            $imageLink = $usercontroller->getImage($id);
            //        affiche sa photo de profil si il en a
            if ($imageLink!==null){
                echo "<div class='menu-user'>
                
                        <img src='" . $imageLink . "' alt='Image de Profil' class='profile-image'>
                  <p><span class='username'>$username</span></p>
                  </div>";

            }
            //si l'utilisateur n'as aucune photo de profil
            else{
                echo "<div class='menu-user'>
                  <i class='fa-regular fa-circle-user'></i>
                  <p><span class='username'>$username</span></p>
                  </div>";
            }
            //permet de télerchager une image de profil
            echo "<form action='../control/user_controller.php' method='post' enctype='multipart/form-data'>
    <div class='label-profil'>
    <i class='fa-solid fa-download'></i>
    <label for='image'>Télécharger une image de profil </label>
    </div>
    <input  class='file' type='file' name='image' id='image'>
    <input  class='submit' type='submit' ' value='Télécharger'>
</form>";
            //affiche l'e-mail
            echo "<div class='menu-mail'>
                  <i class='fa-regular fa-envelope'></i>
                  <p class='profil-email'>$email</p>
                  </div>";

            $stmt = $pdo->prepare("SELECT date_inscription FROM user WHERE id = '$id'");
            $stmt->execute();
            $rowins = $stmt->fetch(PDO::FETCH_ASSOC);
            //affiche la date d'inscription
            if ($rowins){
                $dateInscription = $rowins['date_inscription']; // Accédez à la clé "date_inscription" du tableau
                echo "<div class='menu-join'>
                      <i class='fa-regular fa-calendar-days'></i>
                      <p class='join'>Rejoint le : $dateInscription </p>
                      </div>";
            }
            //si une erreur est survenu dans la récupération de la date d'inscription
            else{
                echo "<p>Erreur lors de la récupération de la date d'inscription, veuillez <a href='formulaire.php'>nous contacter</a></a></p>";
            }
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE auteur_post = '$id'");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //affiche le nombre de post
            if ($row) {
                $count = $row['COUNT(*)'];
                echo "<div class='menu-post'>
                      <i class='fa-solid fa-paper-plane'></i>
                      <p class='nbPost'>Nombre de posts : $count</p>
                      </div>";
            } if($count=0) {
                echo "<p>Vous n'avez posté aucun post...</p>";
            }
            $query = "SELECT is_admin FROM user WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //affiche si l'utilisateur est admin ou pas
            if ($result['is_admin'] == 1) {
                echo "<div class='menu-admin'>
                       <i class='fa-solid fa-screwdriver-wrench'></i>
                       <p class='admin'>Admin</p>
                       </div>";
            }?>
            <!--        pour changer de mot de passe-->
            <div class="menu-mdp">
                <i class="fa-solid fa-lock"></i>
                <a class="mdp-menu" href="changer_mdp.php">Changer de mot de passe</a>
            </div>
            <!--        pour changer d'e-mail -->
            <div class="menu-chg-email">
                <i class="fa-solid fa-gear"></i>
                <a class="chg-menu" href="changer_email.php">Changer d'email</a>
            </div>

            <div class="menu-chg-username">
                <i class="fa-solid fa-user"></i>
                <a class="username-menu" href="changer_username.php">Changer de pseudo</a>
            </div>
        </div>
        <section class="post-principal"id="post">
            <div class="title-hist">
                <i class="fa-solid fa-folder-open"></i>
                <h1>Historique de Post</h1>
            </div>
            <?php
            require_once "../control/connectbd_controller.php";
            require_once "../control/post_controller.php";
            require_once "../control/like_controller.php";
            $postcontroller = new post_controller();
            $posts = $postcontroller->getPostProfil($_SESSION['id']);

            // Affichage des publications
            if (!empty($posts)) {
                foreach (array_reverse($posts) as $post) {
                    echo "<div class='post-container' id='post-comment' onclick=''>";
                    if (($post->getAuteurId() == $_SESSION['id']) | ($result['is_admin'] == 1)) {
                        echo "<span class='delete-post' data-post-id='" . $post->getIdPost() . "'>&times;</span>";
                    }
                    echo "<div class='important'>";
                    if (($post->getImportant() == 1)) {
                        echo "<p class ='important'><i class='fa-solid fa-triangle-exclamation'></i>IMPORTANT</p>";
                    }
                    echo "</div>";

                    echo "<div class='post-content'>";

                    //afficher photo de profil
                    $usercontroller = new \control\user_controller();
                    $imageLink = $usercontroller->getImage($post->getAuteurId());
                    // Afficher la photo de profil

                    if ($imageLink !== null) {
                        echo "<img class='img-profile' src='" . $imageLink . "' alt='Photo de profil de l'auteur'>";
                    }

                    echo "<div class='content'>";
                    echo "<div class='author-date'>";
//                    possibilité de cliquer sur le nom d'un utilisateur pour lui envoyer un message
                    echo "<a class='author-post' href='msgpriv.php?user=" . $post->getAuteur() . "'>" . $post->getAuteur() . "</a>";
                    echo "<p class='date-post'>" . $post->getDate() . "</p>";
                    echo "</div>";
                    echo "<div class='title-category'>";
                    echo "<h3 class='title-post'>" . $post->getTitre() . "</h3>";
                    echo "<p class='cat-poster'>" . $post->getCategorie() . "</p>";
                    echo "</div>";
                    //affiche l'image du post et le message
                    echo "<p class='msg-post post-text'>" . $post->getMessage() . "</p>";
                    if ($post->getImage() !== null) {
                        $imageLink = $post->getImage();
                        echo "<img class='img-post' src='" . $imageLink . "' alt='Image du post'>";
                    }
                    //affichge les likes
                    echo "<div class='like_and_comment'>";
                    echo "<div class='likes'>";
                    echo "<p class='like-post'>" . $post->getLikes() . "</p>";
                    echo "</div>";
                    //affiche les commentaire
                    echo "<div class='comments'> ";
                    echo "<a href='commentaire.php?post_id=" . $post->getIdPost() . "'><i class='fa-solid fa-comment'></i></a>";
                    echo "</div> ";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }}?>

        </section>

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


        <div class="cat-profil">
            <i class="fa-solid fa-user-lock"></i>
            <a class="profil-cat" href="AfficherProfil.php">Profil</a>

        </div>
    </div>

    <script>
        // Récupérez tous les éléments avec la classe 'delete-post'
        const deleteButtons = document.querySelectorAll('.delete-post');

        // Parcourez chaque bouton de suppression et ajoutez un gestionnaire d'événement de clic
        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                // Récupérez l'ID du post à supprimer à partir de l'attribut 'data-post-id'
                const postID = event.target.getAttribute('data-post-id');

                // Confirmez la suppression avec l'utilisateur (vous pouvez utiliser la fonction confirm() pour cela)

                const confirmation = confirm('Êtes-vous sûr de vouloir supprimer ce post ?');

                // Si l'utilisateur confirme la suppression, redirigez-le vers le script PHP de suppression avec l'ID du post
                if (confirmation) {
                    window.location.href = 'supprimer_post.php?id=' + postID;
                }
            });
        });

    </script>

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


        const btnProfilTel = document.querySelector('.cat-profil')

        btnProfilTel.onclick = function () {
            window.location.href = "../view/AfficherProfil.php"
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


