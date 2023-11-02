x@<!doctype html>
<html lang="fr">
<head>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Y</title>
    <link rel="stylesheet" type="text/css" href="../css/sighup.css">
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
        <a href="../view/Inscription.php" class="creation">Créer un compte</a>
        <a href="../view/mot_de_passe_oublie.php" class="oublier">Mot de pass oublié ?</a>
    </form>
</body>
</html>