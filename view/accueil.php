<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
include ('scripts.php');
?>
<!doctype html>
<html lang="fr">
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/accueil.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Un réseau social de microblogging où vous pouvez partager des pensées, des actualités et des informations avec le monde. Suivez vos amis, découvrez des tendances, et participez à des conversations en temps réel. Restez connecté avec ce réseau social rapide et dynamique.">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Y</title>
    <?php require_once "scripts.php"?>
</head>
<body>
<!--
<script>
    function darkMode() {
        var element = document.body;
        element.classList.toggle("dark-mode");
    }
</script>

-->
<header>
    <div class="icon">
        <img src="../images/Y.png" class="logo">
    </div>
    <!--Affiche la photo de profil de l'utilisateur-->
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
<!--menu de droite quand on clique sur l'image de profil de l'utilisateur-->
    <div class="dropmenu">

        <div class="close-drop">
            <i class="fa-solid fa-x"></i>
        </div>

        <div class="drop-logo">
            <img src="../images/Y.png" class="logo">
        </div>
<!--permet d'afficher son pseudo-->
        <?php
        if (isset($_SESSION['username'])) {
            $username = $usercontroller->getUsername($_SESSION['id']);
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
<!--nav de droite-->
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

<!--vérifie si l'utilisateur est un admin, si il l'est le bouton "admin" s'affiche.-->
        <?php
        use control\post_controller;
        try {
            require_once '../control/connectbd_controller.php';
            $connectbd = new \control\connectbd_controller();
        } catch (PDOException $e) {
            echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
            die();
        }
        $userId = $_SESSION['id'] ;
        $pdo = $connectbd->connectbd();
        $query = "SELECT is_admin FROM user WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['is_admin'] == 1) {?>
            <div class="menu-item-admin">
                <i class="fa-solid fa-lock"></i>
                <a class="btn-menu" href="PageAdmin.php">Admin</a>
            </div><?php
        }?>
        </div>

        <button class="btn-menu" id="post-button"><i class="fa-solid fa-pen-to-square"></i><p class="text-button">Nouveau Post</p></button>

    </nav>

<!--créer un nouveau Post-->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="title-and-close">
            <p class="title">Nouveau Post </p>
            <span class="close" id="close-button">&times;</span>
            </div>
            <form class="post-style" action="../control/post_controller.php" method="post" enctype="multipart/form-data">
                <?php if (isset($_GET['errorPost'])) { ?>
                    <p class="errorPost"><?php echo $_GET['errorPost']; ?></p>
                <?php } ?>
                <label class="style-post-label" for="titre">Titre </label>
                <input class="input-style" type="text" id="titre" name="titre_post" required><br><br>
                <label class="style-post-label" for="message">Message </label>
                <textarea class="input-style"  id="message" name="message_post" rows="4" cols="50" required></textarea><br><br>

                    <span id="message-error" style="color: red;"></span> <!-- Affichage de l'erreur -->
                <input class="input-style"  type="hidden" name="date_post" value="<?php echo date('Y-m-d H:i:s'); ?>">
                <label class="style-post-label" for="categorie">Catégorie </label>
<!--sélecteur de catégories, affiche toutes les catégories présent dans la Base de données-->
                <select id="categorie" name="categorie_post" required>
                    <?php
                    require_once "../control/connectbd_controller.php";
                    $connectbd = new \control\connectbd_controller();
                    $pdo = $connectbd->connectbd();
                    $sql = "SELECT libelle_cat FROM categorie";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $libelle_cat = $row['libelle_cat'];
                        echo "<option value='$libelle_cat'>$libelle_cat</option>";
                    }
                    ?>
                </select><br><br>
                <label class="style-post-label" for="image">Image </label>
                <input class="choose-img" type="file" name="image">
                <div class="important-all">
                <label class='important' for="important">Important ?</label>
                <input type="checkbox" name="important" id="important" value="1">
                </div>
                <input class="submit-button post-button" type="submit" value="Créer le Post" name="Envoyer">
            </form>
        </div>
    </div>

    <section class="post-principal" id="post">
        <div class="post-search">
            <button id="post-button-cat" class="cat-drop-menu-search"><i class="fa-solid fa-bars"></i></button>
            <form class="post-style" action="accueil.php" method="post">
                <input type="text" placeholder="Rechercher un post" name="recherche_post">
                <button class="post-button" name="rechercher_post" type="submit"><i class="fa-solid fa-magnifying-glass"></i><p>Rechercher</p></button>
            </form>
            <button class="post-button reset-filter" id="reset_filtres"><i class="fa-solid fa-rotate"></i><p>Réinitialiser les filtres</p></button>

        </div>

        <div id="modal-cat" class="modal-cat">
            <div class="modal-content-cat">
                <div class="title-and-close">
                    <p class="title">Catégorie</p>
                    <span class="close-cat" id="close-button-cat">&times;</span>
                </div>
                <div class="categorie-menu">
                <?php require_once "../control/recherche_controller.php";
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
                </div>
            </div>
        </div>

<!--script pour reset les filtres (redirige l'utilisateur vers la page accueil.php)-->
        <script>
            const resetFilter = document.getElementById('reset_filtres');
            resetFilter.addEventListener('click', () => {
                window.location.href = 'accueil.php';
            });

        </script>
        <!--Afficher les posts, les likes, les croix pour supprimer...-->
        <?php
        $selectedCategory = isset($_GET['cat']) ? $_GET['cat'] : null;
        require_once "../control/post_controller.php";
        require_once "../control/like_controller.php";
        require_once "../control/recherche_controller.php";
        require_once "../control/comment_controller.php";
        require_once "../control/user_controller.php";
        $postcontroller = new post_controller();

        $recherche_controller = new \control\recherche_controller();
        $posts = $recherche_controller->rechercher_post($selectedCategory);
        if (!empty($posts)){
            foreach (array_reverse($posts) as $post) {
                echo "<div class='post-container' id='post-comment' onclick=''>";
                if (($post->getAuteurId() == $userId) | ($result['is_admin'] == 1)) {
                    echo "<span class='delete-post' data-post-id='" . $post->getIdPost() . "'>&times;</span>";
                }
                echo "<div class='important'>";
                if(($post->getImportant() == 1)){
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
                echo "<p class='cat-post'>" . $post->getCategorie() . "</p>";
                echo "</div>";

                echo "<p class='msg-post post-text'>" . $post->getMessage() . "</p>";
                if ($post->getImage()!==null){
                    $imageLink = $post->getImage();
                    echo "<img class='img-post' src='" . $imageLink . "' alt='Image du post'>";
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

                echo "<div class='comments'> ";
                echo "<a href='commentaire.php?post_id=" . $post->getIdPost() . "'><i class='fa-solid fa-comment'></i></a>";
                echo "<p class='like-post'>" . $post->getNbCom() . "</p>";
                echo "</div> ";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
<!--script pour supprimer les posts-->
        <script>
            const deleteButtons = document.querySelectorAll('.delete-post');
            deleteButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const postID = event.target.getAttribute('data-post-id');
                    const confirmation = confirm('Êtes-vous sûr de vouloir supprimer ce post ?');
                    if (confirmation) {
                        // Crée un objet XMLHttpRequest
                        const xhr = new XMLHttpRequest();

                        // Définis la méthode et l'URL de la requête
                        xhr.open('GET', `../control/user_controller.php?suprId=${postID}`, true);

                        // gère la réponse
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // La suppression est terminée, recharge la page d'accueil
                                window.location.href = 'accueil.php';
                            } else {
                                //si probleme
                            }
                        };

                        // Envoye la requête
                        xhr.send();
                    }
                });
            });


        </script>

        <button class="btn-menu-simple" id="post-button-simple"><i class="fa-solid fa-pen-to-square"></i><p class="text-button">Nouveau Post</p></button>


    </section>

    <aside class="right-aside">
        <form class="right-post-search" action="accueil.php" method="post">
            <input type="text" placeholder="Rechercher une catégorie" name="recherche_cat">
            <button class="post-button" name="rechercher_cat" type="submit">Rechercher</button>
        </form>

        <section class="categorie">

            <button id="post-button-cat2" class="cat-drop-menu"><i class="fa-solid fa-bars"></i></button>

            <!-- Afficher les différentes catégories-->
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
            <div class="user-search">
            <div class="search-bar">
                <form id="searchFormUser" action="accueil.php" method="post">
                    <input id="searchUser" type="text" name="rechercherUnUtilisateur" placeholder="Rechercher un utilisateur">
                    <button name="rechercherUnUtilisateurSumbit" class="post-button" id="post-button-user">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <p>Rechercher</p>
                    </button>
                </form>
            </div>
            </div>
            <!--    afficher les suggestions-->
            <div class="suggest-user">
            <?php
            if (isset($_POST['rechercherUnUtilisateurSumbit'])){
                $recherche_controller = new \control\recherche_controller();
                $users = $recherche_controller->rechercher_user($_POST['rechercherUnUtilisateur']);
            }
            else{
                require_once "../control/suggestion_controller.php";
                $suggcontrol = new \control\suggestion_controller();
                $users = $suggcontrol->recupererSuggestion();
            }
            ?>
            <?php
            if (!empty($users)) {
                echo "<ul>";
                foreach ($users as $suggestion) {
                    $username = $suggestion['username'];
                    $image = $suggestion['image_profil'];
                    echo "<li class='suggestion-item'>";
                    if ($image !== null) {
                        echo "<a class='img-user' href='../view/msgpriv.php?user=" . $username . "'>";
                        echo "<img class='img-profil-suggestion' src='$image' alt='Image de $username'></img>";
                        echo "<span class='username-suggestion'>$username</span>";
                        echo "</a>";
                    } else {
                        echo "<a class='img-user' href='../view/msgpriv.php?user=" . $username . "'>";
                        echo "<i class='fa-solid fa-user user-icon'></i>";
                        echo "<span class='username-suggestion'>$username</span>";
                        echo "</a>";
                    }
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "Aucun utilisateurs n'a été trouvée.";
            }
            ?>
            </div>

        </section>
    </aside>
</div>
    <div class="menu-item-bar">
        <div class="menu-item-home-bar">
            <a href="../view/accueil.php"><i class="fa-solid fa-house"></i></a>
        </div>
        <div class="menu-item-msg-bar">
            <a href="../view/msgpriv.php"><i class="fa-solid fa-message"></i></a>
        </div>
        <div class="menu-item-profil-bar">
            <a href="../view/AfficherProfil.php"><i class="fa-solid fa-user"></i></a>
        </div>
        <div class="menu-item-contact-bar">
            <a href="../view/formulaire.php"><i class="fa-solid fa-envelope"></i></a>
        </div>
    </div>
<script>
    const btnClose = document.querySelector('.close-drop');
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
    const btnAdmin = document.querySelector('.menu-item-admin')


    btnUser.addEventListener('click' , ()=> {
        dropMenu.classList.toggle('drop-list')
    })

    btnClose.addEventListener('click' , ()=> {
        dropMenu.classList.toggle('drop-list')
    })


    retour.onclick = function () {
        window.location.href = "../view/accueil.php";
    }

    btnAdmin.onclick = function () {
        window.location.href = "../view/PageAdmin.php"
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
<script src="script.js"></script>

</body>
</html>