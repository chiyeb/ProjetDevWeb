<?php

namespace control;
use models\contact_models;
if (isset($_POST['Envoyer'])) {
    require_once "../models/post_model.php";
    $post_controller = new \control\post_controller();
    $contact = $post_controller->creer_post();
}
//namespace control;
use models\post_model;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/post_model.php';

class post_controller
{
    public function afficher_post($categorie){
        $post_model = new post_model();
        return $post_model->GetPostAll($categorie);
    }
    public function creer_post(){
        $post_model = new post_model();
        $post_model->creerPost();
    }
    public function afficher_post_recherche($requete){
        $post_model = new post_model();
        return $post_model->get_post_recherche($requete);
    }
    public function getCommentsForPost($id){
        $postmodel = new post_model();
        $comment = $postmodel->getCommentsForPost($id);
        return $comment;
    }
}