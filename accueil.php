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
        <i class="fa-solid fa-message"></i>
        <a class="btn-menu" href="../MsgPriv/msgpriv.php">Messages</a>
    </div>
    <div class="menu-item">
        <i class="fa-solid fa-user"></i>
        <a class="btn-menu" href="pour-toi.php">Profile</a>
    </div>
    <div class="menu-item">
        <i class="fa-solid fa-envelope"></i>
        <a class="btn-menu" href="../Contact/formulaire.php">Nous Contacter</a>
    </div>


        <button class="btn-menu" id="post-button">Nouveau Post</button>
</nav>
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-button">&times;</span>
        <form class="post-style" action="../Post/creer_post.php" method="post">
            <input type="hidden" name="id_post" value="<?php echo uniqid(); ?>">

            <label class="style-post-label" for="titre">Titre :</label>
            <input class="input-style" type="text" id="titre" name="titre_post" required><br><br>

            <label class="style-post-label" for="message">Message :</label>
            <textarea class="input-style"  id="message" name="message_post" rows="4" cols="50" required></textarea><br><br>

            <input class="input-style"  type="hidden" name="date_post" value="<?php echo date('Y-m-d'); ?>">

            <label class="style-post-label" for="auteur">Auteur :</label>
            <input class="input-style"  type="text" id="auteur" name="auteur_post" required><br><br>

            <label class="style-post-label" for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie_post" required>
                <option value="Technologie">Technologie</option>
            </select><br><br>

            <input class="submit-button" type="submit" value="Créer le Post">
        </form>
    </div>
</div>
<script src="script.js"></script>
<?php
// Inclure le fichier AffichagePosts.php pour utiliser la fonction afficherPosts
require '../Post/AffichagePost.php';
// Appel de la fonction afficherPosts pour obtenir les posts
$posts = afficherPosts();

// Affichage des posts
foreach ($posts as $post) {
    echo "<h3>" . $post->getTitre() . "</h3>";
    echo "<p>" . $post->getMessage() . "</p>";
    echo "<p>Date : " . $post->getDate() . "</p>";
    echo "<p>Auteur : " . $post->getAuteur() . "</p>";
    echo "<p>Catégorie : " . $post->getCategorie() . "</p>";
}
?>

</body>
</html>
