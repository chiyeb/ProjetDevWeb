<?php

namespace control;
use models\contact_models;
//namespace control;
use models\post_model;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/post_model.php';

class post_controller
{
    //gère l'affichage des posts en fonction de la catégorie sélectionné
    //(gère le cas si une catégorie est sélectionné ou pas dans le model)
    public function afficher_post($categorie){
        $post_model = new post_model();
        return $post_model->GetPostAll($categorie);
    }
    //gère la création d'un post
    public function creer_post(){
        $post_model = new post_model();
        $post_model->creerPost();
    }
    //gère l'affichage des posts à partir de la recherche d'un utilisateur
    public function afficher_post_recherche($requete){
        $post_model = new post_model();
        return $post_model->get_post_recherche($requete);
    }
    //gère la récupération des posts d'un utilisateur pour la page profil
    public function getPostProfil($user){
        $postmodel = new post_model();
        return $postmodel->getPostProfil($user);
    }
    //gère la récupération d'un post pour la page commentaire.php
    public function afficher_post_recherche_comment($requete){
        $post_model = new post_model();
        return $post_model->get_post_recherche_comment($requete);
    }
    //récupère les commentaires d'un post
    public function getCommentsForPost($id){
        $postmodel = new post_model();
        return $postmodel->getCommentsForPost($id);
    }
}
//gère le cas où un utilisateur veut envoyer un post
if (isset($_POST['Envoyer'])) {
    require_once "../models/post_model.php";
    $post_controller = new \control\post_controller();
    $post_controller->creer_post();
}