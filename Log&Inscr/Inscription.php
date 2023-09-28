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
<form action="sighup.php" method="post">
    <h2>Inscription</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>

    <label>Adresse e-mail</label>
    <?php if (isset($_GET['error'])) { ?>
        <input type="email" name="email" placeholder="Adresse e-mail" value="<?php echo $_GET['error']; ?>"><br>
    <?php } else{ ?>
        <input type="email" name="email" placeholder="Adresse e-mail"><br>
    <?php  } ?>


    <label>Utilisateur</label>
    <?php if (isset($_GET['error'])) { ?>
        <input type="text" name="username" placeholder="Utilisateur" value="<?php echo $_GET['error']; ?>"><br>
    <?php } else{ ?>
        <input type="text" name="username" placeholder="Utilisateur"><br>
    <?php  } ?>


    <label>Mot de passe</label>
    <input type="password" name="password" placeholder="Mot de passe"><br>

    <button type="submit">S'inscrire</button>
    <a href="../index.php" class="creation">Déjà un compte ? Connectez-vous</a>
</form>
</body>
</html>