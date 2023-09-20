<!doctype html>
<html lang="fr">
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
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


<nav>
    <div class="menu-item">
        <i class="fa-solid fa-house"></i>
        <a class="btn-menu" href="accueil.php">Accueil</a>
    </div>
    <div class="menu-item">
        <i class="fa-solid fa-bolt"></i>
        <a class="btn-menu" href="pour-toi.php">Tendance</a>
    </div>
    <div class="menu-item">
        <i class="fa-solid fa-user"></i>
        <a class="btn-menu" href="pour-toi.php">Profile</a>
    </div>
    <div class="menu-item">
        <i class="fa-solid fa-message"></i>
        <a class="btn-menu" href="formulaire.php">Nous Contacter</a>
    </div>
        <a href="Login%20et%20Inscription/connexion.php">se connetcer</a>
        <button class="btn-menu" id="post-button">Nouveau Post</button>
</nav>
//afficher les posts
<?php
// Inclure le fichier AffichagePosts.php pour utiliser la fonction afficherPosts
require 'AffichagePost.php';
// Appel de la fonction afficherPosts pour obtenir les posts
$posts = afficherPosts();

// Affichage des posts
foreach ($posts as $post) {
    echo "<div class='post-container'>";
    echo "<h3>" . $post['titre_posts'] . "</h3>";
    echo "<p>" . $post['message_posts'] . "</p>";
    echo "<p>Date : " . $post['date_posts'] . "</p>";
    echo "<p>Auteur : " . $post['auteur_posts'] . "</p>";
    echo "<p>Catégorie : " . $post['categorie_posts'] . "</p>";
    echo "</div>";
}
?>
</body>
</html>