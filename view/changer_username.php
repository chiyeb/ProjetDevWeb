<!DOCTYPE html>
<html>
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <title>Changer l'E-mail</title>
    <link rel="icon" type="image/png" href="../images/Y.png">
    <link rel="stylesheet" type="text/css" href="../css/chg-username.css">
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

<form method="post" action="../control/user_controller.php">
    <h2>Changer le pseudo</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>
    <label for="nouveauUsername">Nouveau Pseudo :</label>
    <div class="chg-username">
    <i class="fa-regular fa-envelope"></i>
    <input  class="user-bar" type="text" name="nouveauUsername" placeholder="Nouveau pseudo" required>
    </div>
    <input class="submit" type="submit" name="changerUsername">
</form>

<script>
    const btnExit = document.querySelector('.exit-arrow')

    btnExit.onclick = function () {
        window.location.href ="../view/AfficherProfil.php";
    }
</script>
</body>
</html>
