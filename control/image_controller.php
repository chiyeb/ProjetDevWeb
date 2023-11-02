<?php

namespace control;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/image_models.php';
use models\image_models;
class image_controller
{
    public function uploadImg(){
        return $imgmodel = (new image_models())->uploadImg();

    }
}