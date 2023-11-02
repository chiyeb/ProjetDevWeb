<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" type="text/css" href="../css/sighup.css">
</head>
<body>
<h2>Mot de passe oublié</h2>
<form action="envoyer_mail_reset.php" method="post">
    <label for="email">Adresse e-mail :</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Envoyer</button>
</form>
</body>
</html>
