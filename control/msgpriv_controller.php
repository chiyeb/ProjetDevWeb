<?php

namespace control;

use models\message_model;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/message_model.php';



class msgpriv_controller
{
    //gère l'affichage des messages privé
    public function afficherMsg(){
        $messages_affichage = new message_model();
        return $messages_affichage->afficherMsgPrv();
    }
    //gère la création d'un message
    public function creerMsg(){
        $message_cree = new message_model();
        $message_cree->creer_msg();

    }
}
//gère le cas où un utilisateur à envoyé un message
if (isset($_POST['Envoyer'])){
    $msgpriv_controller = new msgpriv_controller();
    $msgpriv_controller->creerMsg();
}