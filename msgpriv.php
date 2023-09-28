<!DOCTYPE html>
<html>
<head>
    <title>Boîte de réception</title>
</head>
<body>
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
</body>
</html>