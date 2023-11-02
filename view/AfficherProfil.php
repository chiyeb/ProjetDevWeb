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
    <link rel="stylesheet" href="../css/stylesProfil.css">
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

    <div class="all-pages">
    <div class="user-info">
        <?php
        require_once "../control/connectbd_controller.php";
        require_once "../control/user_controller.php";
        $connectbd = new \control\connectbd_controller();
        $pdo = $connectbd->connectbd();
        if (isset($_SESSION['email']) && isset($_SESSION['username'])&&isset($_SESSION['id'])){
        $email = $_SESSION['email'];
        $username = $_SESSION['username'];
        $id = $_SESSION['id'];
        $usercontroller = new \control\user_controller();
        $imageLink = $usercontroller->getImage($id);
        if ($imageLink!==null){
            echo "<div class='menu-user'>
                
                        <img src='" . $imageLink . "' alt='Image de Profil' class='profile-image'>
                  <p><span class='username'>$username</span></p>
                  </div>";

        }else{
            echo "<div class='menu-user'>
                  <i class='fa-regular fa-circle-user'></i>
                  <p><span class='username'>$username</span></p>
                  </div>";
        }
        echo "<form action='../control/user_controller.php' method='post' enctype='multipart/form-data'>
    <div class='label-profil'>
    <i class='fa-solid fa-download'></i>
    <label for='image'>Télécharger une image de profil </label>
    </div>
    <input  class='file' type='file' name='image' id='image'>
    <input  class='submit' type='submit' ' value='Télécharger'>
</form>";

        echo "<div class='menu-mail'>
                  <i class='fa-regular fa-envelope'></i>
                  <p class='profil-email'>$email</p>
                  </div>";

        $stmt = $pdo->prepare("SELECT date_inscription FROM user WHERE id = '$id'");
        $stmt->execute();
        $rowins = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rowins){
            $dateInscription = $rowins['date_inscription']; // Accédez à la clé "date_inscription" du tableau
            echo "<div class='menu-join'>
                      <i class='fa-regular fa-calendar-days'></i>
                      <p class='join'>Rejoint le : $dateInscription </p>
                      </div>";
        }
        else{
            echo "<p>Erreur lors de la récupération de la date d'inscription, veuillez <a href='formulaire.php'>nous contacter</a></a></p>";
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE auteur_post = '$id'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
        if ($result['is_admin'] == 1) {
            echo "<div class='menu-admin'>
                       <i class='fa-solid fa-screwdriver-wrench'></i>
                       <p class='admin'>Admin</p>
                       </div>";
        }?>
        <div class="menu-mdp">
            <i class="fa-solid fa-lock"></i>
            <a class="mdp-menu" href="changer_mdp.php">Changer mot de passe</a>
        </div>
        <div class="menu-chg-email">
            <i class="fa-solid fa-gear"></i>
            <a class="chg-menu" href="changer_email.php">Changer email</a>
        </div>
    </div><?php

    }
    else{
        header("Location: ../Log&Inscr/connexion");
    }
    ?>
    <section class="post-principal">
        <div class="title-hist">
        <i class="fa-solid fa-folder-open"></i>
        <h1>Historique de Post</h1>
        </div>
        <?php
        try {
            require_once "../control/connectbd_controller.php";
            $connectbd = new \control\connectbd_controller();
            $pdo = $connectbd->connectbd();
            // Requête SQL pour récupérer les publications de l'utilisateur
            $queryPost = 'SELECT p.id_post, p.titre_post, p.message_post, p.date_post, p.auteur_post, c.libelle_cat FROM posts p INNER JOIN categorie c ON p.categorie_post = c.id_cat WHERE p.auteur_post = :id ORDER BY p.date_post DESC';
            $stmt = $pdo->prepare($queryPost);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Affichage des publications
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='post-container'>";
                if ($row['auteur_post'] == $id) {
                    echo "<span class='delete-post' data-post-id='" . $row['id_post'] . "'>&times;</span>";
                }
                echo "<h3 class='title-post'>" . $row['titre_post'] . "</h3>";
                echo "<p class='author-post'>" . $row['auteur_post'] . "</p>";
                echo "<p class='date-post'>" . $row['date_post'] . "</p>";
                echo "<p class='cat-post'>" . $row['libelle_cat'] . "</p>";
                echo "<p class='msg-post'>" . $row['message_post'] . "</p>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }?>
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

        <div class="cat-post">
            <i class="fa-solid fa-folder-open"></i>
            <a class="post-cat" href="cat-post.php">Historique de post</a>
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


