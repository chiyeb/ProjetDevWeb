<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["Prenom"];
    $email = $_POST["email"];
    $message = $_POST["Message"];

    // Adresse e-mail de destination
    $destinataire = "ysite@alwaysdata.net";

    // Sujet de l'e-mail
    $sujet = "Nouveau message de $nom $prenom";

    // Corps de l'e-mail
    $contenu = "Nom: $nom\n";
    $contenu .= "Prénom: $prenom\n";
    $contenu .= "E-mail: $email\n";
    $contenu .= "Message:\n$message";

    // En-têtes de l'e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Envoi de l'e-mail
    if (mail($destinataire, $sujet, $contenu, $headers)) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'envoi de votre message.";
    }
}

