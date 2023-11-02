<?php

namespace control;

use models\message_model;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/message_model.php';

if (isset($_POST['Envoyer'])){
    $msgpriv_controller = new msgpriv_controller();
    $msgpriv_controller->creerMsg();
}

class msgpriv_controller
{
    public function afficherMsg(){
        $messages_affichage = new message_model();
        return $messages_affichage->afficherMsgPrv();
    }
    public function creerMsg(){
        $message_cree = new message_model();
        $message_cree->creer_msg();

    }
}