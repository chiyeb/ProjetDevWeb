<!DOCTYPE html>
<html>
<head>
    <script src="https://kit.fontawesome.com/2310277d03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesMsg.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="stylesProfil.css">
    <title>Boîte de réception</title>
</head>
<body>
<header>
    <div class="logo">Y</div>
    <div class="search-bar">
        <input type="text" placeholder="Rechercher">
    </div>
    <div class="btn">NOM</div>
</header>

<div class="wrapper">
    <nav>
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
    </nav>

    <div class="user-msg">
        <h1>Boîte de réception</h1>

        <!-- Formulaire pour envoyer un message -->
        <h2>Envoyer un message :</h2>
        <form method="POST" action="phpmsgpv.php">
            <label for="receiver_id">Destinataire(Username):</label>
            <input type="text" name="receiver_id" id="receiver_id" required>
            <br>
            <label for="message">Message :</label>
            <textarea name="message" id="message" rows="4" cols="50" required></textarea>
            <br>
            <input type="submit" value="Envoyer">
        </form>
    </div>
</body>
</html>