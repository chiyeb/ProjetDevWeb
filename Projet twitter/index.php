<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>

<div class="container">
    <H1>Nous Contactez</H1>
    <form method="POST" action="Contact.php">
        <input type="text" name="nom"
        placeholder="Indiquez votre nom"><br>
        <input type="text" name="Prenom"
        placeholder="Indiquez votre Prenom"><br>
        <input type="email" name="email"
        placeholder="Indiquez votre adresse mail"><br>
        <textarea name="Message" placeholder="Votre message"></textarea>

    <input type="submit" name="submit" value="Envoyer"><br>
    </form>

</div>

</body>
</html>