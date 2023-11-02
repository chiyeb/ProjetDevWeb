<!DOCTYPE html>
<html lang="fr">

<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/formulaire.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>

<body>

<header>
    <div class="navbar">
        <img src="../images/Y.png" class="logo">
        <div class="toggle_back">
            <i class="fa-solid fa-arrow-left" style="color: #ffffff;"></i>
        </div>
        <div class="toggle_btn">
            <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
        </div>


    </div>


    <div class="dropmenu">
        <div class="menu-item">
            <i class="fa-solid fa-house"></i>
            <a class="btn-menu" href="../PagePrincipal/accueil.php">Accueil</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-bolt"></i>
            <a class="btn-menu" href="pour-toi.php">Tendance</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-message"></i>
            <a class="btn-menu" href="../MsgPriv/msgpriv.php">Messages</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-user"></i>
            <a class="btn-menu" href="../Profil/AfficherProfil.php">Profile</a>
        </div>
        <div class="menu-item">
            <i class="fa-solid fa-envelope"></i>
            <a class="btn-menu" href="../Contact/formulaire.php">Nous Contacter</a>
        </div>
    </div>


</header>



<section>
    <h1 class="form-title">Nous Contacter</h1>
    <form method="POST" action="Contact.php">

        <label>Nom</label>
        <input type="text" name="nom" placeholder="Indiquez votre nom"><br>

        <label>Prénom</label>
        <input type="text" name="prenom" placeholder="Indiquez votre prénom"><br>

        <label>Email</label>
        <input type="email" name="email" placeholder="Indiquez votre adresse mail"><br>

        <textarea name="Message" placeholder=" Votre message "></textarea>

        <button id="submit-btn" type="submit">Envoyer</button>

    </form>
</section>


<script>
    const toggleBtn = document.querySelector('.toggle_btn');
    const toggleBtnIcon = document.querySelector('.toggle_btn i');
    const dropMenu = document.querySelector('.dropmenu');
    const retour = document.querySelector('.toggle_back')

    retour.onclick = function() {
        window.location.href = "../view/accueil.php";
    }

    toggleBtn.onclick = function () {
        dropMenu.classList.toggle('open');
        const isOpen = dropMenu.classList.contains('open')

        toggleBtnIcon.classList = isOpen
            ? 'fa-solid fa-xmark'
            : 'fa-solid fa-bars'
    }



</script>



</body>

</html>