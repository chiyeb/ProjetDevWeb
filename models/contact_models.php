<?php

namespace models;

class contact_models
{
    //permet d'envoyer un message (de contacter les admins de Y)
    public function contacter(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $message = $_POST["Message"];
            if (empty($nom)){
                header("Location: ../view/formulaire.php?error=Indiquez votre nom");
                exit();
            }
            if (empty($prenom)){
                header("Location: ../view/formulaire.php?error=Indiquez votre prenom");
                exit();
            }
            if (empty($email)){
                header("Location: ../view/formulaire.php?error=Indiquez votre e-mail");
                exit();
            }
            if (empty($message)){
                header("Location: ../view/formulaire.php?error=Indiquez un message");
                exit();
            }
            // Adresse e-mail de destination
            $destinataire = "ysite@alwaysdata.net";

            // Sujet de l'e-mail de l'utilisateur
            $sujetUtilisateur = "Confirmation de réception de votre message";

            // Corps de l'e-mail de l'utilisateur
            $contenuUtilisateur = "Cher $prenom $nom,\n\n";
            $contenuUtilisateur .= "Nous avons bien reçu votre message et nous le traiterons dès que possible.\n";
            $contenuUtilisateur .= "Voici un récapitulatif de votre message :\n\n";
            $contenuUtilisateur .= "Nom: $nom\n";
            $contenuUtilisateur .= "Prénom: $prenom\n";
            $contenuUtilisateur .= "E-mail: $email\n";
            $contenuUtilisateur .= "Message:\n$message";

            // En-têtes de l'e-mail de l'utilisateur
            $headersUtilisateur = "From: $destinataire\r\n";

            // Envoi de l'e-mail de confirmation à l'utilisateur
            mail($email, $sujetUtilisateur, $contenuUtilisateur, $headersUtilisateur);

            // Sujet de l'e-mail à destination de l'administrateur
            $sujetAdmin = "Nouveau message de $nom $prenom";

            // Corps de l'e-mail à destination de l'administrateur
            $contenuAdmin = "Nom: $nom\n";
            $contenuAdmin .= "Prénom: $prenom\n";
            $contenuAdmin .= "E-mail: $email\n";
            $contenuAdmin .= "Message:\n$message";

            // En-têtes de l'e-mail à destination de l'administrateur
            $headersAdmin = "From: $email\r\n";

            // Envoi de l'e-mail à destination de l'administrateur
            if (mail($destinataire, $sujetAdmin, $contenuAdmin, $headersAdmin)) {
                header("Location: ../view/formulaire.php?success=Votre message à bien été envoyé");
                exit();
            } else {
                echo "Une erreur s'est produite lors de l'envoi de votre message.";
            }
        }



    }
}