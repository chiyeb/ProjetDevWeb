<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    ?>
    <!doctype html>
    <html lang="fr">
    <head>
        <title>Accueil / Y</title>
        <link rel="stylesheet" type="text/css" href="home.css">
    </head>
    <body>
    <header>
        <h2 class="logo">Logo</h2>
        <nav class="navbar">
            <a href="#">Home</a>
            <a href="#">Post</a>
            <a href="#">Paramètre</a>
            <a href="#">Avis</a>
            <a href="connexion.php" class="deco">Déconnecter</a>
        </nav>
    </header>
    <main>
        <div class="wrapper">
        <form class="post" method="post">
            <label>
                <input type="text" name="post" placeholder="Quoi de neuf ?" />
            </label>
            <label>
                <button class="poster" type="submit">Poster</button>
            </label>
        </form>
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
        </div>
    </main>

    </body>
    </html>

    <?php
    }else  {
            header("Location: connexion.php");
             exit();
    }
    ?>