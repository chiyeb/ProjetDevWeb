<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" type="text/css" href="../../css/sighup.css">
</head>
<body>
<h2>Réinitialisation du mot de passe</h2>
<form action="process_reset_password.php" method="post">
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <label for="password">Nouveau mot de passe :</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Réinitialiser le mot de passe</button>
</form>

</body>
</html>
