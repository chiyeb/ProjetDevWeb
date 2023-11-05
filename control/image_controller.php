<?php

namespace control;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/image_models.php';
use models\image_models;
class image_controller
{
    //gère le télerchargement d'une image sur imgur
    public function uploadImg(){
        return $imgmodel = (new image_models())->uploadImg();

    }
}