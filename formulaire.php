<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>

<div class="container">
    <h1 class="form-title">Nous Contactez</h1>
    <form method="POST" action="Contact.php">
    <div class="form-group">
        <input type="text" name="nom" placeholder="Indiquez votre nom"><br>
        <input type="text" name="Prenom" placeholder="Indiquez votre Prenom"><br>
        <input type="email" name="email" placeholder="Indiquez votre adresse mail"><br>
    </div>
    <div class="form-group">
        <textarea name="Message" placeholder="Votre message"></textarea>
    </div>
    <div class="form-group" >
        <input id="submit-btn" type="submit" name="submit" value="Envoyer">
    </div>
    </form>
</div>

</body>
</html>
