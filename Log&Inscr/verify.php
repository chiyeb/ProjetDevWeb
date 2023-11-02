<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Vérification</title>
    <link rel="stylesheet" type="text/css" href="mdp_oublie/verifystyles.css">
</head>
<body>
<div class="container">
    <h1>Entrez votre code de vérification reçu par e-mail</h1>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <form action="mdp_oublie/verifycode.php" method="post">
        <input type="text" name="code" placeholder="Code de vérification">
        <input type="password" name="mdp" placeholder="Nouveau mot de passe">
        <button type="submit">Valider</button>
    </form>
</div>
</body>
</html>
