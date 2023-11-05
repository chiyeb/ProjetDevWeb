<?php

namespace control;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/contact_models.php';
use models\contact_models;


class contact_controller
{
    //gère l'envoie du mail de contact
    public function contact(){
        $contact_models = new contact_models();
        $contact_models->contacter();
    }
}
//gère le cas où l'utilisateur nous contacte
if (isset($_POST['envoyer'])) {
    $contact_controller = new contact_controller();
    $contact = $contact_controller->contact();
}