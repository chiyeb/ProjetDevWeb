<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Création de Post</title>
</head>
<body>
<h1>Créer un Nouveau Post</h1>
<form action="creer_post.php" method="post">
    <input type="hidden" name="id_post" value="<?php echo uniqid(); ?>">

    <label for="titre">Titre :</label>
    <input type="text" id="titre" name="titre_post" required><br><br>

    <label for="message">Message :</label>
    <textarea id="message" name="message_post" rows="4" cols="50" required></textarea><br><br>

    <input type="hidden" name="date_post" value="<?php echo date('Y-m-d'); ?>">

    <label for="auteur">Auteur :</label>
    <input type="text" id="auteur" name="auteur_post" required><br><br>

    <label for="categorie">Catégorie :</label>
    <select id="categorie" name="categorie_post" required>
        <option value="Technologie">Technologie</option>
        <option value="Actualités">Actualités</option>
        <option value="Voyages">Voyages</option>
        <option value="Autre">Autre</option>
    </select><br><br>

    <input type="submit" value="Créer le Post">
</form>
</body>
</html>