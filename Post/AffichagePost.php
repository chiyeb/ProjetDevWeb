    <?php
    function afficherPosts(){
    require '../Log&Inscr/sql-login.php'; // Utilisez un fichier approprié pour la connexion PDO
    require 'Post.php'; // Incluez la classe Post

    $conn = dbconnect();

    $sql = "SELECT titre_post, message_post, date_post, auteur_post, categorie_post FROM posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Vérifiez si la requête s'est exécutée avec succès
    if ($stmt) {
        $posts = []; // Tableau pour stocker les objets "posts"

        // Utilisez une boucle pour parcourir les résultats
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Créez un objet "Post" pour chaque ligne de résultat
            $post = new Post(
                $row['titre_post'],
                $row['message_post'],
                $row['date_post'],
                $row['auteur_post'],
                $row['categorie_post']
            );

            // Ajoutez l'objet "Post" au tableau des posts
            $posts[] = $post;
        }

    } else {
        // Gérez les erreurs ici en fonction de la connexion à la base de données
        echo "Erreur lors de l'exécution de la requête SQL : " . $conn->errorInfo()[2];
    }
        // Fermez la connexion à la base de données
        $conn = null;
    return $posts;
    }
    ?>
