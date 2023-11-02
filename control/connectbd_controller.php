<?php

namespace control;

use models\connectbd_models;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/connectbd_models.php';
class connectbd_controller
{
    public function connectbd(){
        $connectbd = new connectbd_models();
        return $connectbd->conn();
    }
    public function connectbd1(){
        $connectbd = new connectbd_models();
        return $connectbd->conn1();
    }
}