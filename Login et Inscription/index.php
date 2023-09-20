<!doctype html>
<html lang="fr">
<head>
    <title>Y</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="login.php" method="post">
        <h2>Connexion</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <label>Adresse e-mail</label>
        <input type="text" name="email" placeholder="Adresse e-mail">

        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe">

        <button type="submit">Se Connecter</button>
        <a href="Inscription.php" class="creation">Créer un compte</a>
        <a href="" class="oublier">Mot de pass oublié ?</a>
    </form>
</body>
</html>