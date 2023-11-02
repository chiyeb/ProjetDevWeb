<?php

namespace control;
use models\like_models;
if (isset($_POST['like'])) {

    require_once "../models/like_models.php";
    $like_controller = new \control\like_controller();
    $liker = $like_controller->liker_post();
}

if (isset($_POST['unlike'])) {

    require_once "../models/like_models.php";
    $like_controller = new \control\like_controller();
    $liker = $like_controller->unliker_post();
}
//namespace control;
use models\post_model;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/like_models.php';
class like_controller
{
    public function liker_post(){
        session_start();
        $like_model = new like_models();
        return $like_model->addLike($_SESSION['id'], $_POST['post_id']);
    }
    public function unliker_post(){
        session_start();
        $like_model = new like_models();
        $like_model->unlike($_SESSION['id'], $_POST['post_id']);
    }
    public function is_liked($id){
        $post_model = new like_models();
        return $post_model->isLiked($_SESSION['id'],$id);
    }
}