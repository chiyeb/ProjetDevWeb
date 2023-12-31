<!doctype html>
<html lang="fr">
<head>

    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../images/Y.png">
    <meta name="description" content="Page d'inscription du réseau social Y">
    <link rel="stylesheet" type="text/css" href="../css/sighup.css">
    <title>Y</title>
</head>
<body>
<form action="../control/user_controller.php" method="post" class="form">
    <div class="icon">
        <img src="../images/Y_noir.png" class="logo">
    </div>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>

    <label for="email" class="label">Email</label>

    <div class="login-bar">
        <i class="fa-solid fa-envelope"></i>
        <input type="text" name="emailInscr" placeholder="Adresse e-mail">
    </div>


    <label for="username" class="label">Nom d'utilisateur</label>

    <div class="login-bar">
        <p id="passwordError" class="error" style="display: none;"></p>
    <i class="fa-solid fa-user"></i>
    <input type="text" name="usernameInscr" placeholder="Utilisateur">
    </div>
    <label for="password" class="label">Mot de passe</label>

    <div class="login-bar">
        <i class="fa-solid fa-lock"></i>
        <i class="fa-solid fa-eye-slash"></i>
        <input class="password-bar" type="password" name="passwordInscr" placeholder="Mot de passe">
    </div>

    <input class="submit" type="submit" value="S'INSCRIRE">
    <span class="span">Déjà un compte ? <a href="../index.php">Connectez-vous</a></span>
</form>

<script>
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
</script>

</body>
</html>