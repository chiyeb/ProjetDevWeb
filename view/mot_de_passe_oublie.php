<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" type="text/css" href="../css/mdp_oublie.css">
</head>
<body>
<div class="icon">
    <img src="../images/Y_noir.png" class="logo">
</div>

<form action="../Log&Inscr/mdp_oublie/envoyer_mail_reset.php" method="post">
    <h2>Mot de passe oublié</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>
    <label for="email">Adresse e-mail :</label>
    <div class="mdp-bar">
        <i class="fa-solid fa-envelope"></i>
        <input type="text" name="email" placeholder="Adresse e-mail">
    </div>
    <button class="submit" type="submit">Envoyer</button>
</form>
</body>
</html>
