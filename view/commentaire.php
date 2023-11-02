<?php
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
    <link rel="stylesheet" href="../css/commentaire.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Y - Commentaire</title>
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
        <i class="fa-regular fa-user"></i>
    </div>

    <div class="dropmenu">

        <div class="close">
            <i class="fa-solid fa-x"></i>
        </div>

        <div class="drop-logo">
            <img src="../images/Y.png" class="logo">
        </div>

        <?php
        require '../Log&Inscr/sql-login.php';
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
            <a href="../view/login.php" class="btn-dropmenu">Se deconnecter</a>
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


    <section class="post-principal">
    <?php
    require_once "../control/post_controller.php";
    require_once "../control/like_controller.php";
    require_once "../control/recherche_controller.php";
    require_once "../control/comment_controller.php";
    require_once "../control/user_controller.php";
    $userId = $_SESSION['id'];
    if (isset($_GET['post_id'])) {
        $postId = $_GET['post_id'];
        $recherche_controller = new \control\recherche_controller();
        $posts = $recherche_controller->rechercher_post_for_comments($postId); // Supposons que vous avez une méthode pour obtenir un post par son ID
        foreach (array_reverse($posts) as $post) {
            echo "<div class='post-container' id='post-comment' onclick=''>";
            if (($post->getImportant() == 1)) {
                echo "<p class ='important'><i class='fa-solid fa-triangle-exclamation'></i>IMPORTANT</p>";
            }
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
            echo "<p class='cat-post'>" . $post->getCategorie() . "</p>";
            echo "</div>";
            echo "<p class='msg-post'>" . $post->getMessage() . "</p>";
            if ($post->getImage()!==null){
                $imageLink = $post->getImage();
                echo "<img src='" . $imageLink . "' alt='Image du post'>";
            }
            echo "<div class='like_and_comment'>";
            echo "<div class='likes'>";
            $likecontroller = new \control\like_controller();
            if ($likecontroller->is_liked($post->getIdPost()) === true) {
                echo "<form method='POST' action='../control/like_controller.php'>
                <input type='hidden' name='post_id' value='" . $post->getIdPost() . "'>
                <button type='submit' class='like-button' name='like'><i class='fa-solid fa-heart'></i></button>
                </form>";
            } else {
                echo "<form method='POST' action='../control/like_controller.php'>
                <input type='hidden' name='post_id' value='" . $post->getIdPost() . "'>
                <button type='submit' class='unlike-button' name='unlike'><i class='fa-solid fa-heart'></i></button>
                </form>";
            }
            echo "<p class='like-post'>" . $post->getLikes() . "</p>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
            echo "</div>";

            // Ajoutez un formulaire pour permettre aux utilisateurs de commenter ce post


            echo "</div>"; // Fermez la div du post

            echo "<div class='comment-form'>";
            
            echo "<form action='../control/comment_controller.php' method='post'>
                    <input type='hidden' name='post_id' value='" . $postId . "'>
                    <textarea name='commentaire' placeholder='Ajouter un commentaire'></textarea>
                    <button class='btn-menu' id='post-button' type='submit' name='submit_comment'>Commenter</button>
                  </form>";

            echo "</div>";
            // Affichez les commentaires liés à ce post (vous devrez également adapter cette partie selon votre structure de données)
            $comment_controller = new comment_controller();
            $comments = $comment_controller->getCommentsForPost($postId); // Supposons que vous avez une méthode pour obtenir les commentaires pour un post donné

            foreach ($comments as $comment) {
                echo "<div class='comment-container'>";
                echo "<div class='comment-author-date'>";
                echo "<a class='comment-author' href='msgpriv.php?user=" . $comment['auteur_com'] . "'>" . $comment['auteur_com'] . "</a>";
                echo "<p class='comment-date'>" . $comment['date_com'] . "</p>";
                echo "</div>";
                echo "<p class='comment-msg'>" . $comment['texte_com'] . "</p>";
                echo "</div>";
            }

        }
    }


    ?>
    </section>

    <aside class="right-aside">
        <form class="post-style" action="accueil.php" method="post">
            <input type="text" placeholder="Rechercher une catégorie" name="recherche_cat">
            <button name="rechercher_cat" type="submit">Rechercher</button>
        </form>
        <section class="categorie">
            <!--            Afficher les différentes catégories-->
            <?php
            require_once "../control/recherche_controller.php";
            if (isset($_POST['rechercher_cat'])){
                $recherche_controller_cat = new \control\recherche_controller();
                $categories = $recherche_controller_cat->rechercher_cat();
            }
            else{
                $recherche_controller_cat = new \control\recherche_controller();
                $categories = $recherche_controller_cat->rechercher_cat();
            }
            ?>
            <?php
            if (count($categories)>0){foreach ($categories as $categorie): ?>
                <a href="accueil.php?cat=<?php echo $categorie['libelle_cat']; ?>"><i class="fa-solid fa-hashtag hashtag-icon"></i><?php echo $categorie['libelle_cat']; ?></a>
            <?php endforeach; }
            else{
                echo "aucune catégories trouvé";
            }
            ?>
        </section>
        <section class="suggestion section-divider">

            <h2>Et si vous parliez avec ?</h2>
            <!--    afficher les suggestions-->
            <?php
            require_once "../control/suggestion_controller.php";
            $suggcontrol = new \control\suggestion_controller();
            $suggestions = $suggcontrol->recupererSuggestion();
            ?>
            <?php
            if (!empty($suggestions)) {
                echo "<ul>";
                foreach ($suggestions as $suggestion) {
                    $username = $suggestion['username'];
                    echo "<li><a href='../view/msgpriv.php?user=" . $username . "'><i class='fa-solid fa-user user-icon'></i>" . $username . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "Aucune suggestion n'a été trouvée.";
            }
            ?>

        </section>
    </aside>




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