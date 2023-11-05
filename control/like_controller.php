<?php

namespace control;
use models\like_models;

//namespace control;
use models\post_model;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/like_models.php';
class like_controller
{
    //gère l'ajout d'un like
    public function liker_post(){
        session_start();
        $like_model = new like_models();
        $like_model->addLike($_SESSION['id'], $_POST['post_id']);
    }
    //gère la suppression d'un like
    public function unliker_post(){
        session_start();
        $like_model = new like_models();
        $like_model->unlike($_SESSION['id'], $_POST['post_id']);
    }
    //vérifie si un utilisateur à aimé un post
    public function is_liked($id){
        $post_model = new like_models();
        return $post_model->isLiked($_SESSION['id'],$id);
    }
}
//gère le cas où l'utilisateur à aimé un post
if (isset($_POST['like'])) {

    require_once "../models/like_models.php";
    $like_controller = new \control\like_controller();
    $liker = $like_controller->liker_post();
}
//gère le cas où l'utilisateur à enlevé son j'aime sur un post
if (isset($_POST['unlike'])) {

    require_once "../models/like_models.php";
    $like_controller = new \control\like_controller();
    $liker = $like_controller->unliker_post();
}