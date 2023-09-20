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
            <a href="index.php" class="deco">Déconnecter</a>
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
        </div>
    </main>
    </body>
    </html>

    <?php
    }else  {
            header("Location: accueil.php");
             exit();
    }
    ?>