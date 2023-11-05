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
    <title>Changer de mot de passe</title>
    <link rel="stylesheet" type="text/css" href="../css/chg-mdp.css">
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
        <h2>Changer le mot de passe</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>
        <div class="mdp-chg">
        <i class="fa-solid fa-lock"></i>
            <i class="fa-solid fa-eye-slash"></i>
            <input class="password-bar" type="password" name="nouveau_mot_de_passe" placeholder="Nouveau mot de passe" required>
        </div>
        <div class="mdp-chg">
            <i class="fa-solid fa-lock"></i>
            <i class="fa-solid fa-eye-slash"></i>
        <input  class="password-barre" type="password" name="confirmation_mot_de_passe"  placeholder="Confirmez le mot de passe" required>
        </div>
        <input class="submit" type="submit" value="Changer le mot de passe" name="changermdp">
    </form>

<script>
    const btnExit = document.querySelector('.exit-arrow')


    const showHide = document.querySelector(".fa-eye-slash")
    const inputMdp = document.querySelector(".password-bar")

    showHide.addEventListener("click", ()=> {
        if(inputMdp.type ==="password") {
            inputMdp.type = "text";
            showHide.classList.replace("fa-eye-slash","fa-eye");
        }else {
            inputMdp.type = "password";
            showHide.classList.replace("fa-eye","fa-eye-slash");
        }
    });

    const showHide1= document.querySelector(".fa-eye-slash")
    const inputMdp1 = document.querySelector(".password-barre")

    showHide1.addEventListener("click", ()=> {
        if(inputMdp1.type ==="password") {
            inputMdp1.type = "text";
            showHide1.classList.replace("fa-eye-slash","fa-eye");
        }else {
            inputMdp1.type = "password";
            showHide1.classList.replace("fa-eye","fa-eye-slash");
        }
    });


    btnExit.onclick = function () {
        window.location.href ="../view/AfficherProfil.php";
    }
</script>
</body>
</html>
