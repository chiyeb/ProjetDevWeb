<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Y</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form action="sighup.php" method="post" class="form">
    <h2>Inscription</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>

    <label for="email" class="label">Email</label>
    <input type="email" name="email" placeholder="Adresse e-mail"><br>


    <label for="username" class="label">Nom d'utilisateur</label>
    <input type="text" name="username" placeholder="Utilisateur"><br>


    <label for="password" class="label">Mot de passe</label>
    <input type="password" name="password" placeholder="Mot de passe"><br>

    <input class="submit" type="submit" value="S'enregistrer">
    <span class="span">Déjà un compte ? <a href="../index.php">Connectez-vous</a></span>
</form>
</body>
</html>