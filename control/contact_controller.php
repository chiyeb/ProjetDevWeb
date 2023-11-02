<?php

namespace control;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/contact_models.php';
use models\contact_models;
if (isset($_POST['envoyer'])) {
    $contact_controller = new contact_controller();
    $contact = $contact_controller->contact();
}

class contact_controller
{
    public function contact(){
        $contact_models = new contact_models();
        return $contact_models->contacter();
    }
}
