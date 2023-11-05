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
    <title>Confirmation de l'e-mail</title>
    <link rel="icon" type="image/png" href="../images/Y.png">
    <link rel="stylesheet" type="text/css" href="../css/verifystyles.css">
</head>
<header>
    <div class="exit-arrow">
        <i class="fa-solid fa-arrow-left"></i>
    </div>
</header>
<body>
<div class="icon">
    <img src="../images/Y_noir.png" class="logo">
</div>
<div class="container">

<form action="../control/user_controller.php" method="post">
    <h2>Changer de mot de passe</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>
    <label for="token" class="label">Code de vérification</label>
    <div class="code-bar">
        <i class="fa-solid fa-certificate"></i>
        <input type="text" id="token" name="tokenConfirmMdpOublier" placeholder="Code de véfication" required value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">
    </div>
    <label for="token" class="label">Nouveau mot de passe</label>
    <div class="code-bar">
        <i class="fa-solid fa-certificate"></i>
        <input type="password" id="token" name="mdpConfirmMdpOublier" placeholder="Nouveau mot de passe" required>
    </div>
    <button class="submit" type="submit">Confirmer</button>

</form>
</div>
</body>
</html>
