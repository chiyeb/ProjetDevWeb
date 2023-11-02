<!doctype html>
<html lang="fr">
<head>
    <title>Y</title>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
<form action="../control/user_controller.php" method="post">
    <div class="icon">
    <img src="../images/Y_noir.png" class="logo">
    </div>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>

    <div class="label-bar">
    <label class="label">Adresse e-mail</label>
    </div>

    <div class="login-bar">
        <i class="fa-solid fa-envelope"></i>
        <input type="text" name="email" placeholder="Adresse e-mail">
     </div>

    <div class="label-bar">
    <label class="label">Mot de passe</label>
    </div>
    <div class="login-bar">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="Mot de passe">
    </div>

    <span class="span"><a href="../view/mot_de_passe_oublie.php">Mot de passe oublié ?</a></span>

    <input class="submit" type="submit" value="Se connecter">

    <span class="span">Vous n'avez pas de compte ? <a href="view/Inscription.php"> S'inscrire </a></span>

</form>
</body>
</html>
